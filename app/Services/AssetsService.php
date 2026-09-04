<?php
namespace Popup\Services;

use Popup\Modules\Web\Popups;
use SkillDo\Cms\Support\Theme;
use SkillDo\Cms\Template\Assets\AssetPosition;

class AssetsService
{
    static function web(AssetPosition $header, AssetPosition $footer): void
    {
        $header->add('popup', asset('popup::css/popup-style.css'))->minify();
        $footer->add('popup', asset('popup::js/popup-script.js'))->minify();

        static::builderAssets($header, $footer);
    }

    /**
     * Bundle CSS/JS của các popup dựng bằng kéo thả đang hiển thị ở trang này.
     *
     * Bundle do lần Xuất bản gần nhất trong trình dựng sinh ra
     * (BuilderAjax::save -> ThemeLayout::build). Nếu chưa có (popup vừa import,
     * vừa xoá cache minify…) thì dựng tại chỗ.
     */
    protected static function builderAssets(AssetPosition $header, AssetPosition $footer): void
    {
        foreach (Popups::matched() as $object)
        {
            $id = (int) $object->popup_id;

            //Popup chưa chuyển sang kéo thả vẫn dùng CSS của blade mẫu cũ
            if(noItems(BuilderSectionService::content($id))) continue;

            $bundle = BuilderSectionService::bundle($id);

            if(!Theme::template()->bundleExists($bundle))
            {
                BuilderSectionService::build($id);
            }

            if(!Theme::template()->bundleExists($bundle)) continue;

            $header->add('popup-'.$id.'-style', Theme::template()->bundleUrl($bundle))->afterMinify();

            if(Theme::template()->bundleExists($bundle, 'js'))
            {
                $footer->add('popup-'.$id.'-script', Theme::template()->bundleUrl($bundle, 'js'))->afterMinify();
            }
        }
    }
}
