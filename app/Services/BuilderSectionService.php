<?php
namespace Popup\Services;

use Popup\Models\Popup;
use Popup\Styles\PopupStyle;
use SkillDo\Cache\Cache;
use SkillDo\Cms\Element\ElementBuilder;
use SkillDo\Cms\Models\ElementBuilderSection;
use SkillDo\Cms\Support\Theme;
use SkillDo\Support\Path;

/**
 * Cầu nối giữa một popup và Page Builder.
 *
 * Mỗi popup kiểu "builder" gắn với ĐÚNG MỘT bản ghi `element_builder_sections`:
 *
 *      type    = 'layout'   (5 loại section mà JS builder hiểu, xem BUILDER.md §1)
 *      key     = 'popup_{popup_id}'
 *      element = 'popup'    (quyết định nhóm element hiện trong sidebar)
 *      scope   = ''         (giống layout do BuilderAjax::createLayout tạo)
 *
 * Dùng lại type `layout` là có chủ đích: toàn bộ đường nạp/lưu/nháp/lịch sử của
 * core chạy sẵn mà không phải sửa một dòng JS nào (bundle admin đã obfuscate).
 */
class BuilderSectionService
{
    const TYPE = 'layout';

    /** Giá trị cột `element`, cũng chính là scope element trong elements.json */
    const ELEMENT = 'popup';

    const TEMPLATE = 'builder';

    public static function key(int|string $popupId): string
    {
        return 'popup_'.$popupId;
    }

    /**
     * Id popup suy ngược từ key section ('popup_12' -> 12). 0 nếu không phải key popup.
     */
    public static function popupId(string $key): int
    {
        if(!str_starts_with($key, 'popup_')) return 0;

        return (int) substr($key, 6);
    }

    public static function section(int|string $popupId): ?ElementBuilderSection
    {
        return ElementBuilderSection::where('key', static::key($popupId))
            ->where('type', static::TYPE)
            ->first();
    }

    /**
     * Tạo section nếu chưa có, đồng bộ tên khi popup đổi tên.
     */
    public static function ensure(Popup $popup): ?ElementBuilderSection
    {
        $id = (int) $popup->popup_id;

        if(empty($id)) return null;

        $key = static::key($id);

        $name = $popup->name ?: ('Popup #'.$id);

        $section = static::section($id);

        if(!empty($section))
        {
            if($section->name !== $name)
            {
                ElementBuilderSection::where('id', $section->id)->update(['name' => $name]);

                ElementBuilder::forgetSection($key, static::TYPE);
            }

            return $section;
        }

        ElementBuilderSection::create([
            'type'      => static::TYPE,
            'key'       => $key,
            'scope'     => '',
            'taxonomy'  => '',
            'element'   => static::ELEMENT,
            'name'      => $name,
            'setting'   => [],
            'builder'   => [],
        ]);

        ElementBuilder::forgetSection($key, static::TYPE);

        return static::section($id);
    }

    /**
     * Dựng sẵn nội dung cho popup từ preset của mẫu đang chọn.
     *
     * Chạy khi lưu popup và khi chuyển đổi popup cũ: mẫu nào cũng cho ra một cây builder
     * để người dùng kéo thả chỉnh lại. Popup đã có nội dung thì KHÔNG đụng tới,
     * trừ khi $force (nút "Áp dụng lại mẫu").
     *
     * @return bool đã ghi preset hay chưa
     */
    public static function seed(Popup $popup, bool $force = false): bool
    {
        $section = static::ensure($popup);

        if(empty($section)) return false;

        $id = (int) $popup->popup_id;

        if(!$force && hasItems(static::content($id))) return false;

        $style = PopupStyle::getInstance()->get($popup->template);

        if(empty($style)) return false;

        $style->setObject($popup);

        $preset = $style->preset();

        $rows = $preset['rows'] ?? [];

        //Mẫu "Tự thiết kế" cố ý không có preset -> để trang trắng
        if(noItems($rows)) return false;

        $rows = static::keepAvailableWidgets($rows);

        if(noItems($rows)) return false;

        /*
         * Ghi đè khung: seed chỉ chạy khi popup CHƯA có nội dung, lúc đó khung đang là
         * giá trị mặc định của form (700px…) chứ không phải lựa chọn của người dùng —
         * mẫu phải quyết định kích thước ban đầu, nếu không mẫu 480px nào cũng ra 700px.
         */
        static::applyFrame($popup, $preset['frame'] ?? [], true);

        ElementBuilderSection::where('key', static::key($id))
            ->where('type', static::TYPE)
            ->update(['builder' => $rows]);

        //Ghi thẳng vào model nên phải xoá memoize trước khi build bundle (BUILDER.md §5.7)
        ElementBuilder::forgetSection(static::key($id), static::TYPE);

        static::build($id);

        return true;
    }

    /**
     * Bỏ khỏi preset những widget mà site KHÔNG có element tương ứng.
     *
     * Element của theme được tải theo nhu cầu từ kho, còn plugin thì có thể bị gỡ bớt file.
     * `ElementBuilder::builderColum()` gặp element không tồn tại thì lặng lẽ bỏ qua, để lại
     * một widget rỗng không nội dung mà vẫn chiếm chỗ trong cây — người dùng thấy popup
     * thủng lỗ và không hiểu vì sao. Lọc ngay lúc seed cho cây luôn sạch.
     *
     * Preset chuẩn chỉ dùng element `Popup*` đi kèm plugin nên hàm này gần như không cắt gì;
     * nó là lưới an toàn cho preset do plugin khác thêm vào qua filter sau này.
     */
    protected static function keepAvailableWidgets(array $rows): array
    {
        $manager = \SkillDo\Cms\Element\ElementManager::getInstance();

        $exists = [];

        $available = function (string $type) use ($manager, &$exists): bool
        {
            if($type === 'layout_row') return true;

            if(!isset($exists[$type])) $exists[$type] = !empty($manager->getElement($type));

            return $exists[$type];
        };

        $filterColumns = function (array $columns) use (&$filterColumns, $available): array
        {
            foreach ($columns as $keyColumn => $column)
            {
                $widgets = [];

                foreach (($column['widgets'] ?? []) as $widget)
                {
                    $type = $widget['type'] ?? '';

                    if(!$available($type)) continue;

                    if($type === 'layout_row')
                    {
                        $widget['inner_cols'] = $filterColumns($widget['inner_cols'] ?? []);
                    }

                    $widgets[] = $widget;
                }

                $columns[$keyColumn]['widgets'] = $widgets;
            }

            return $columns;
        };

        foreach ($rows as $keyRow => $row)
        {
            $rows[$keyRow]['columns'] = $filterColumns($row['columns'] ?? []);
        }

        return $rows;
    }

    /**
     * Cấu hình khung (rộng, bo góc, nền…) của mẫu ghi vào `popups.settings`.
     *
     * Chỉ điền khoá CHƯA có để không đè lên thứ người dùng đã chỉnh; `$force` thì ghi đè.
     */
    protected static function applyFrame(Popup $popup, array $frame, bool $force = false): void
    {
        if(noItems($frame)) return;

        $settings = $popup->settings;

        if(!is_array($settings)) $settings = [];

        $changed = false;

        foreach ($frame as $key => $value)
        {
            if(!$force && isset($settings[$key])) continue;

            $settings[$key] = $value;

            $changed = true;
        }

        if(!$changed) return;

        Popup::insert([
            'popup_id' => (int) $popup->popup_id,
            'settings' => $settings,
        ]);

        $popup->settings = $settings;
    }

    /**
     * Cây builder đã lưu của popup (mảng row).
     */
    public static function content(int|string $popupId): array
    {
        $section = ElementBuilder::layout(static::key($popupId));

        if(empty($section['content']) || !is_array($section['content'])) return [];

        return $section['content'];
    }

    /**
     * Xoá sạch dấu vết builder của một popup: section, nháp, lịch sử, file bundle.
     */
    public static function delete(int|string $popupId): void
    {
        $key = static::key($popupId);

        ElementBuilderSection::where('key', $key)->where('type', static::TYPE)->delete();

        \SkillDo\Cms\Models\ElementBuilderDraft::where('key_section', $key)->delete();

        \SkillDo\Cms\Models\ElementBuilderHistories::where('key_section', $key)->delete();

        ElementBuilder::forgetSection($key, static::TYPE);

        // Tên file bundle có kèm vân tay base path (Template::bundleName) nên xoá bằng glob.
        $dir = dirname(Path::view(Theme::template()->bundleStoragePath(static::bundle($popupId))));

        foreach (['css', 'js'] as $ext)
        {
            foreach (glob($dir.DIRECTORY_SEPARATOR.static::bundle($popupId).'*.min.'.$ext) ?: [] as $file)
            {
                @unlink($file);
            }
        }
    }

    /**
     * Tên bundle CSS/JS mà core sinh ra khi bấm Xuất bản
     * (`ThemeLayout::build()` -> 'layout-'.md5($key)).
     */
    public static function bundle(int|string $popupId): string
    {
        return 'layout-'.md5(static::key($popupId));
    }

    /**
     * Dựng lại bundle CSS/JS của popup.
     *
     * Lặp đúng việc `Theme\Builders\ThemeLayout::build()` làm, nhưng không gọi thẳng
     * class của theme để plugin còn chạy được trên theme không có class đó.
     */
    public static function build(int|string $popupId): void
    {
        $content = static::content($popupId);

        if(noItems($content)) return;

        $assets = ElementBuilder::buildAssets('', $content);

        Theme::template()->bundlePut(static::bundle($popupId), 'css', $assets['css']);

        Theme::template()->bundlePut(static::bundle($popupId), 'js', $assets['js']);
    }

    /**
     * Tìm một widget trong cây builder theo id (duyệt cả hàng lồng và element container).
     *
     * Dùng khi cần đọc lại cấu hình do người dựng đặt — ví dụ danh sách field của
     * PopupFormElement lúc nhận dữ liệu gửi lên: KHÔNG tin dữ liệu client gửi kèm.
     */
    public static function findWidget(int|string $popupId, string $widgetId, string $type = ''): array
    {
        return static::searchWidget(static::content($popupId), $widgetId, $type);
    }

    protected static function searchWidget(array $rows, string $widgetId, string $type): array
    {
        foreach ($rows as $row)
        {
            if(empty($row['columns']) || !is_array($row['columns'])) continue;

            $found = static::searchColumns($row['columns'], $widgetId, $type);

            if(hasItems($found)) return $found;
        }

        return [];
    }

    protected static function searchColumns(array $columns, string $widgetId, string $type): array
    {
        foreach ($columns as $column)
        {
            if(empty($column['widgets']) || !is_array($column['widgets'])) continue;

            foreach ($column['widgets'] as $widget)
            {
                if(($widget['type'] ?? '') === 'layout_row')
                {
                    $found = static::searchColumns($widget['inner_cols'] ?? [], $widgetId, $type);

                    if(hasItems($found)) return $found;

                    continue;
                }

                if(($widget['id'] ?? '') !== $widgetId) continue;

                if(!empty($type) && ($widget['type'] ?? '') !== $type) continue;

                return $widget;
            }
        }

        return [];
    }

    /**
     * Danh sách field (đã chuẩn hoá) của một widget PopupFormElement trong cây builder.
     *
     * KHÔNG đọc thẳng $widget['settings']['fields']: builder chỉ lưu những gì người dùng
     * ĐÃ đụng tới, nên element vừa kéo vào mà chưa mở form cấu hình có `settings` rỗng —
     * ngoài site nó vẫn hiện 3 field mặc định vì lúc render Element::default() mới điền vào.
     * Ở đây dựng lại đúng instance đó để server thấy cùng bộ field mà khách nhìn thấy.
     */
    public static function formFields(array $widget): array
    {
        $element = \SkillDo\Cms\Element\ElementManager::getInstance()->getElement($widget['type'] ?? '');

        if(empty($element) || !is_object($element)) return [];

        $element->setOption((object)($widget['settings'] ?? []));

        if(method_exists($element, 'default')) $element->default();

        $fields = (array)($element->options->fields ?? []);

        if(noItems($fields)) return [];

        return \SkillDo\Cms\Template\Template::formFieldToFields($fields);
    }

    /**
     * Xoá cache danh sách element — bắt buộc sau khi thêm/bớt file elements.json
     * (ElementManager::jsonData() cache 24h dưới khoá `theme_elements`).
     */
    public static function clearElementCache(): void
    {
        Cache::delete('theme_elements');
    }
}
