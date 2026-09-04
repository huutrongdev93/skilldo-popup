<?php

use Illuminate\Support\Str;
use Popup\Services\BuilderSectionService;
use SkillDo\Cms\Element\Element;
use SkillDo\Cms\Support\Cms;
use SkillDo\Cms\Support\Theme;

/**
 * Form thu thập thông tin đặt trong popup.
 *
 * Khác FormElement của theme (chỉ render form, chưa có nơi nhận dữ liệu): element
 * này gửi về `Popup\Ajax\Web\PopupAjax::submitBuilder` và ghi vào bảng
 * `popups_submission` — đúng bảng mà trang "Thống kê gửi Popup" đang đọc.
 *
 * Danh sách field lưu trong `settings.fields` của chính widget; lúc nhận dữ liệu
 * server đọc lại từ cây builder theo `widget_id` chứ không tin dữ liệu client gửi.
 */
class PopupFormElement extends Element
{
    public function __construct()
    {
        parent::__construct('PopupFormElement', 'Form popup');

        $this->assets('assets/popup-form.css');

        $this->assets('assets/popup-form.js');

        $this->setTags('popup', 'form', 'lien-he');
    }

    public function icon(): string
    {
        return '<i class="fa-duotone fa-solid fa-rectangle-list"></i>';
    }

    public function category(): string
    {
        return 'popup';
    }

    public function form(): void
    {
        $this->tabs('generate')->adds(function (\SkillDo\Cms\Form\Form $form)
        {
            $form->addGroup(function (\SkillDo\Cms\Form\Form $form)
            {
                $form->formField('fields', [
                    'label' => 'Các trường thông tin',
                ]);

                $form->switch('labelShow', [
                    'label' => 'Hiển thị nhãn (Label)',
                    'value' => true,
                ])->display('inline');

            }, $this->groupFormBox('Trường dữ liệu', 'popupFormFields', true));

            $form->addGroup(function (\SkillDo\Cms\Form\Form $form)
            {
                $form->text('buttonText', [
                    'label'    => 'Nội dung nút gửi',
                    'value'    => 'Gửi thông tin',
                    'language' => true,
                ]);

                $form->fontIcon('buttonIcon', [
                    'label' => 'Icon nút gửi',
                ]);

            }, $this->groupFormBox('Nút gửi', 'popupFormButton'));

            $form->addGroup(function (\SkillDo\Cms\Form\Form $form)
            {
                $form->text('successMessage', [
                    'label'    => 'Thông báo khi gửi thành công',
                    'language' => true,
                ]);

                $form->switch('closeAfterSubmit', [
                    'label' => 'Đóng popup sau khi gửi',
                ])->display('inline');

                $form->number('closeDelay', [
                    'label' => 'Đóng sau (giây)',
                    'note'  => 'Chỉ dùng khi bật "Đóng popup sau khi gửi".',
                ])->display('inline');

            }, $this->groupFormBox('Sau khi gửi', 'popupFormSuccess'));
        });

        $this->tabs('style')->adds(function (\SkillDo\Cms\Form\Form $form)
        {
            $form->addGroup(function (\SkillDo\Cms\Form\Form $form)
            {
                $form->number('formGap', ['label' => 'Khoảng cách cột (px)', 'start' => 6]);

                $form->number('formRow', ['label' => 'Khoảng cách hàng (px)', 'start' => 6]);

            }, $this->groupFormBox('Bố cục', 'popupFormLayout', true));

            $form->addGroup(function (\SkillDo\Cms\Form\Form $form)
            {
                $form->color('fieldColor', ['label' => 'Màu chữ', 'start' => 6]);

                $form->color('fieldBg', ['label' => 'Màu nền ô nhập', 'start' => 6]);

                $form->spacing('fieldPadding', ['label' => 'Khoảng đệm ô nhập']);

                $form->border('fieldBorder', ['label' => 'Viền ô nhập']);

            }, $this->groupFormBox('Ô nhập', 'popupFormField'));

            $form->addGroup(function (\SkillDo\Cms\Form\Form $form)
            {
                $form->textBuilding('labelStyle')->popup(false);

            }, $this->groupFormBox('Nhãn', 'popupFormLabel'));

            $form->addGroup(function (\SkillDo\Cms\Form\Form $form)
            {
                $form->buttonBuilding('buttonStyle')->popup(false);

            }, $this->groupFormBox('Nút gửi', 'popupFormButtonStyle'));
        });

        parent::form();
    }

    public function widget(): void
    {
        $fields = (array)($this->options->fields ?? []);

        if(noItems($fields))
        {
            //Không có field nào -> widget cao 0px, trong trình dựng sẽ không còn chỗ bấm
            echo $this->empty();

            return;
        }

        Theme::view($this->getDir().'views/view', [
            'id'       => $this->id,
            'options'  => $this->options,
            'fields'   => $fields,
            'popupId'  => $this->popupId(),
        ]);
    }

    /**
     * Popup đang chứa element này.
     *
     * Ngoài site: `Popups::render()` đặt sẵn `popup_object` vào data-bag trước khi render.
     * Trong trình dựng: PopupReviewController cũng đặt, nhưng nếu thiếu thì suy từ key
     * section (`popup_12`) để form vẫn có id đúng khi xem thử.
     */
    protected function popupId(): int
    {
        $object = Cms::getData('popup_object');

        if(!empty($object) && !empty($object->popup_id))
        {
            return (int) $object->popup_id;
        }

        $section = Cms::getData('popup_section_key');

        return BuilderSectionService::popupId((string) $section);
    }

    public function cssBuilder(): string
    {
        $labelShow = $this->options->labelShow ?? true;

        $this->cssVariables('--popup-form-label-display', (!empty($labelShow)) ? 'block' : 'none');

        $this->cssVariables('--popup-form-gap', ($this->options->formGap ?? 15).'px');

        $this->cssVariables('--popup-form-row', ($this->options->formRow ?? 15).'px');

        if(!empty($this->options->fieldColor))
        {
            $this->cssVariables('--popup-form-color', $this->options->fieldColor);
        }

        if(!empty($this->options->fieldBg))
        {
            $this->cssVariables('--popup-form-field-bg', $this->options->fieldBg);
        }

        if(!empty($this->options->fieldPadding))
        {
            $this->cssSelector('.form-control', [
                'data'  => $this->options->fieldPadding,
                'style' => 'spacing',
            ]);
        }

        if(!empty($this->options->fieldBorder))
        {
            $this->cssSelector('.form-control', [
                'data'  => $this->options->fieldBorder,
                'style' => 'border',
            ]);
        }

        if(!empty($this->options->labelStyle))
        {
            $this->cssSelector('.form-group label', [
                'data'  => $this->options->labelStyle,
                'style' => 'text',
            ]);
        }

        if(!empty($this->options->buttonStyle))
        {
            $this->cssSelector('button[type="submit"]', [
                'data'  => $this->options->buttonStyle,
                'style' => 'button',
            ]);
        }

        return $this->cssBuild();
    }

    public function default(): void
    {
        $this->options->fields = $this->options->fields ?? [
            'field_'.Str::random(5).uniqid() => [
                'name'         => 'fullname',
                'label'        => 'Họ và tên',
                'type'         => 'text',
                'placeholder'  => 'Nhập họ và tên của bạn',
                'required'     => true,
                'column'       => 100,
                'columnTablet' => 100,
                'columnMobile' => 100,
            ],
            'field_'.Str::random(5).uniqid() => [
                'name'         => 'phone',
                'label'        => 'Số điện thoại',
                'type'         => 'tel',
                'placeholder'  => 'Nhập số điện thoại của bạn',
                'required'     => true,
                'column'       => 100,
                'columnTablet' => 100,
                'columnMobile' => 100,
            ],
            'field_'.Str::random(5).uniqid() => [
                'name'         => 'email',
                'label'        => 'Email',
                'type'         => 'email',
                'placeholder'  => 'Nhập email của bạn',
                'required'     => false,
                'column'       => 100,
                'columnTablet' => 100,
                'columnMobile' => 100,
            ],
        ];

        $defaults = [
            'labelShow'        => true,
            'buttonText'       => 'Gửi thông tin',
            'successMessage'   => 'Đăng ký thành công. Chúng tôi sẽ liên hệ với bạn sớm nhất!',
            'closeAfterSubmit' => 0,
            'closeDelay'       => 2,
            'formGap'          => 15,
            'formRow'          => 15,
        ];

        foreach ($defaults as $key => $value)
        {
            $this->options->{$key} = $this->options->{$key} ?? $value;
        }
    }
}
