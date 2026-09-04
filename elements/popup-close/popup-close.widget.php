<?php

use SkillDo\Cms\Element\Element;
use SkillDo\Cms\Support\Theme;

/**
 * Nút đóng popup ("Để sau", "Không, cảm ơn"…).
 *
 * Chỉ cần class `js-popup-close` — xử lý đóng nằm trong assets/js/popup-script.js
 * của plugin, dùng chung cho mọi popup.
 */
class PopupCloseElement extends Element
{
    public function __construct()
    {
        parent::__construct('PopupCloseElement', 'Nút đóng popup');

        $this->setTags('popup', 'close', 'dong');
    }

    public function icon(): string
    {
        return '<i class="fa-duotone fa-solid fa-rectangle-xmark"></i>';
    }

    public function category(): string
    {
        return 'popup';
    }

    public function form(): void
    {
        $this->tabs('generate')->adds(function (\SkillDo\Cms\Form\Form $form)
        {
            $form->text('text', [
                'label'    => 'Chữ trên nút',
                'language' => true,
            ]);

            $form->fontIcon('icon', ['label' => 'Icon']);

            $form->tab('position', ['label' => 'Vị trí'])->options([
                'start'  => '<i class="fa-thin fa-align-left"></i>&nbsp;Trái',
                'center' => '<i class="fa-thin fa-align-center"></i>&nbsp;Giữa',
                'end'    => 'Phải&nbsp; <i class="fa-thin fa-align-right"></i>',
            ]);
        });

        $this->tabs('style')->adds(function (\SkillDo\Cms\Form\Form $form)
        {
            $form->buttonBuilding('style')->popup(false);
        });

        parent::form();
    }

    public function widget(): void
    {
        Theme::view($this->getDir().'views/view', [
            'options' => $this->options,
        ]);
    }

    public function cssBuilder(): string
    {
        $this->cssSelector('.js-popup-close', [
            'data'  => $this->options->style ?? [],
            'style' => 'button',
        ]);

        return $this->cssBuild();
    }

    public function default(): void
    {
        $defaults = [
            'text'     => 'Để sau',
            'icon'     => '',
            'position' => 'center',
        ];

        foreach ($defaults as $key => $value)
        {
            $this->options->{$key} = $this->options->{$key} ?? $value;
        }
    }
}
