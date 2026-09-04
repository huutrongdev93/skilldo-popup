<?php
namespace Popup\Services;

use Popup\Models\PopupSubmission;
use SkillDo\Cache\Cache;
use SkillDo\Cms\Menu\AdminMenu;

class AdminService
{
    static function navigation(): void
    {
        $count =  (int)Cache::remember('popup_submission_new', config('cms.cache_time.default'), function()
        {
            return PopupSubmission::where('status', 'new')->count();
        });

        AdminMenu::addSub('marketing', 'popup-submission', 'Thống kê gửi Popup', route('admin.popup.submission.index'), [
            'count' => $count
        ]);
    }

    static function popupSubmissionUpdate(): void
    {
        $count = (int)Cache::remember('popup_submission_new', config('cms.cache_time.default'), function()
        {
            return PopupSubmission::where('status', 'new')->count();
        });

        if(!empty($count))
        {
            PopupSubmission::where('status', 'new')->update([
                'status' => 'read'
            ]);

            Cache::delete('popup_submission_new');
        }
    }

    static function system($tabs)
    {
        $tabs['popup'] = [
            'group'         => 'marketing',
            'label'         => 'Popup Quảng Cáo',
            'description'   => 'Quản lý popup quảng cáo, khuyến mãi',
            'href'          => route('admin.popup.index', absolute: true),
            'icon'          => '<i class="fad fa-mailbox"></i>',
            'form'          => false
        ];
        return $tabs;
    }
}