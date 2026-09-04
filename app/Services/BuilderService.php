<?php
namespace Popup\Services;

use Popup\Models\Popup;
use SkillDo\Http\Request;

/**
 * Các hook nối popup với Page Builder (đăng ký ở bootstrap/config.php).
 *
 * Tách khỏi BuilderSectionService: chỗ kia là thao tác dữ liệu, chỗ này là chính sách
 * (khi nào tạo section, ai được kéo thả, khuôn nào hiện ở đâu).
 */
class BuilderService
{
    /**
     * Sau khi lưu popup: dựng sẵn nội dung của mẫu đang chọn vào trình kéo thả.
     *
     * Popup đã có thiết kế riêng thì `seed()` bỏ qua — đổi mẫu KHÔNG tự ghi đè công sức
     * người dùng, muốn lấy lại mẫu thì bấm "Áp dụng lại mẫu" (PopupAjax::applyPreset).
     */
    public static function afterSavePopup($id, Request $request, $insertData = [], $dataOutside = []): void
    {
        $object = Popup::find($id);

        if(empty($object)) return;

        BuilderSectionService::seed($object);
    }

    /**
     * Xoá popup thì xoá luôn section builder, nháp, lịch sử và file bundle.
     * $data là id hoặc mảng id (ActionAjax::delete gửi cả hai dạng).
     */
    public static function beforeDeletePopup($data, Request $request): void
    {
        foreach ((array) $data as $id)
        {
            $id = (int) $id;

            if(empty($id)) continue;

            BuilderSectionService::delete($id);
        }
    }

    /**
     * Mở quyền thêm mới nội dung — CHỈ trong màn hình dựng popup và khung xem thử
     * của nó. Không tự giới hạn là mở quyền cho cả builder giao diện.
     */
    public static function permissions(array $permissions): array
    {
        if(!static::isPopupBuilderRequest()) return $permissions;

        $permissions['canAddRow'] = 1;

        $permissions['canAddColumn'] = 1;

        $permissions['canDragElement'] = 1;

        return $permissions;
    }

    protected static function isPopupBuilderRequest(): bool
    {
        $request = request();

        if(empty($request)) return false;

        $prefix = trim((string) config('cms.admin.prefix', 'admin'), '/');

        return $request->is($prefix.'/popup/builder/*') || $request->is('review/popup');
    }

    /**
     * Khuôn của popup không thuộc danh sách khuôn trang của theme.
     */
    public static function hideLayouts($layouts)
    {
        if(noItems($layouts)) return $layouts;

        $keep = fn($layout) => ($layout->element ?? '') !== BuilderSectionService::ELEMENT;

        //Giữ nguyên kiểu dữ liệu gốc: nơi gọi có thể là Collection, có thể là mảng
        if(is_object($layouts) && method_exists($layouts, 'filter'))
        {
            return $layouts->filter($keep)->values();
        }

        return array_values(array_filter((array) $layouts, $keep));
    }
}
