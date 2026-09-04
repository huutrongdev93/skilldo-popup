<?php
namespace Popup\Services;

use Popup\Models\Popup;

Class DeactivatorService
{
    public static function uninstall(): void
    {
        //Gỡ luôn phần builder của từng popup (section, nháp, lịch sử, bundle)
        foreach (Popup::where('template', BuilderSectionService::TEMPLATE)->get() as $popup)
        {
            BuilderSectionService::delete((int) $popup->popup_id);
        }

        BuilderSectionService::clearElementCache();

        schema()->drop('popups');
        schema()->drop('popups_submission');
    }
}