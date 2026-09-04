<?php
namespace Popup\Modules\Admin\Popups;

use Popup\Enum\PopupStatus;
use Popup\Models\Popup;
use Popup\Services\BuilderSectionService;
use Popup\Styles\PopupStyle;
use SkillDo\Cms\FormAdmin\FormAdmin;
use SkillDo\Cms\Support\Admin;
use SkillDo\Cms\Support\Language;
use SkillDo\Http\Request;
use SkillDo\Validate\Rule;

class PopupForm
{
    static function fields(FormAdmin $form): FormAdmin
    {
        $form->setModel(Popup::class);

        $language = Language::list();

        $languageOptions = array_map(function ($lang) {
            return $lang['label'];
        }, $language);

        $form->leftBottom()
            ->addGroup('info', 'Thông tin')
            ->text('name', [
                'label' => 'Tên popup',
                'validations' => Rule::make()->notEmpty()
            ]);

        $form->right()
            ->addGroup('setting', 'Cấu hình chung')
            ->radio('status', PopupStatus::options()->pluck('label', 'value')->toArray(), ['label' => 'Hiển thị'])
            ->radio('locale', $languageOptions, [
                'label' => 'Ngôn ngữ hiển thị',
                'value' => Language::default()
            ])
            ->checkbox('show',
                [
                    'all' => 'Tất cả các trang',
                    'home_index' => 'Trang chủ',
                    'post_index' => 'Trang danh sách bài viết',
                    'post_detail' => 'Trang bài viết chi tiết',
                    'page_detail' => 'Trang nội dung',
                    'products_index' => 'Trang danh sách sản phẩm',
                    'products_detail' => 'Trang chi tiết sản phẩm',
                ], ['label' => 'Vị trí hiển thị', 'value' => ['all']])
            ->select('loop',
                [
                    'only' => 'Chỉ hiển thị một lần',
                    'refresh' => 'Hiển thị lại khi F5 (refresh trang)',
                    'loop' => 'Hiển thị lặp lại',
                ],
                ['label' => 'Lặp lại', 'value' => 'only'])
            ->number('time_delay',
                [
                    'label' => 'Thời gian delay (giây)',
                    'start' => 6,
                    'value' => 10
                ])
            ->number('time_loop',
                [
                    'label' => 'Thời gian lặp lại (phút)',
                    'start' => 6,
                    'value' => 1
                ]);

        return $form;
    }

    static function buttons(FormAdmin $form, $object = null): FormAdmin
    {
        $buttons = [];

        $view = request()->segment(3);

        if($view === 'add')
        {
            $buttons[] = Admin::button('save', ['type' => 'submit']);
            $buttons[] = Admin::button('back', [
                'href' => route('admin.popup.index'),
                'class'     => 'btn-back-to-redirect',
                'data-redirect' => 'admin_table_popup_list',
            ]);
        }

        if($view === 'edit')
        {
            $buttons[] = Admin::button('save');

            //Mọi popup đều sửa nội dung bằng trình dựng kéo thả
            if(!empty($object))
            {
                $buttons[] = Admin::button('blue', [
                    'href'    => route('admin.popup.builder', ['id' => $object->popup_id]),
                    'text'    => 'Thiết kế',
                    'icon'    => '<i class="fa-duotone fa-solid fa-pen-ruler"></i>',
                    'tooltip' => 'Mở trình dựng kéo thả',
                ]);
            }

            $buttons[] = Admin::button('add', ['href' => route('admin.popup.add'), 'text' => '', 'tooltip' => trans('button.add')]);
            $buttons[] = Admin::button('back', ['href' => route('admin.popup.index'), 'text' => '', 'tooltip' => trans('button.back')]);
        }

        $buttons = apply_filters('popup_form_buttons', $buttons);

        return $form->setButtons($buttons);
    }

    static function metabox($object): void
    {
        echo view('popup::admin/popup/metabox', [
            'styles' => PopupStyle::getInstance()->all(),
            'active' => $object->template ?? ''
        ]);
    }

    static function beforeSave($insertData, Request $request)
    {
        /*
         * popup_key CHỈ sinh khi thêm mới.
         *
         * Trước đây mỗi lần lưu lại sinh key mới, mà key chính là khoá localStorage
         * `popup_shown_popup_{key}` của PopupScheduler -> mọi khách đã xem popup
         * "chỉ hiện một lần" lại thấy nó hiện lại sau mỗi lần admin sửa vặt.
         */
        $id = (int) $request->input('id');

        if(empty($id) || empty(Popup::find($id)))
        {
            $insertData['popup_key'] = uniqid().md5('key-popup'.time());
        }

        if($request->has('settings'))
        {
            $settings = $request->input('settings');

            if(empty($settings) || !is_array($settings))
            {
                $settings = [];
            }

            $settings['show'] = $request->input('show');

            $insertData['settings'] = $settings;
        }

        return $insertData;
    }
}