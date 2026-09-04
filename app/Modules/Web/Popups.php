<?php
namespace Popup\Modules\Web;

use Popup\Enum\PopupStatus;
use Popup\Models\Popup;
use Popup\Styles\PopupStyle;
use SkillDo\Cms\Support\Cms;
use SkillDo\Cms\Support\Theme;

class Popups
{
    /**
     * Danh sách popup đủ điều kiện hiển thị ở trang hiện tại.
     *
     * Tính một lần cho mỗi request: `AssetsService` cần nó ở lúc dựng thẻ <head>
     * (nạp bundle CSS/JS của popup builder), còn `render()` cần ở cuối trang.
     */
    protected static ?array $matched = null;

    public static function matched(): array
    {
        if(static::$matched !== null) return static::$matched;

        $popups = Popup::where('status', PopupStatus::RUN->value)->get();

        $page = Theme::getPage();

        $matched = [];

        foreach ($popups as $object)
        {
            $show = $object->settings['show'] ?? [];

            if(!is_array($show)) $show = [];

            /*
             * Không chọn trang nào -> hiện mọi trang (giữ đúng hành vi cũ).
             */
            if(noItems($show) || in_array('all', $show) || in_array($page, $show))
            {
                $matched[] = $object;
            }
        }

        return static::$matched = $matched;
    }

    static function render(): void
    {
        foreach (static::matched() as $object)
        {
            $popup = PopupStyle::getInstance()->get($object->template);

            if(empty($popup)) continue;

            $popup->setObject($object);

            /*
             * Element trong popup builder (PopupFormElement) đọc popup đang render
             * từ data-bag để biết gửi dữ liệu về popup nào.
             */
            Cms::setData('popup_object', $object);

            echo view('popup::popup', [
                'key'   => $object->popup_key,
                'popup' => $popup
            ]);
        }

        Cms::setData('popup_object', null);
    }
}
