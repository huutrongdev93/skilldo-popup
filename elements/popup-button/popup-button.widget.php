<?php

use SkillDo\Cms\Element\Element;
use SkillDo\Cms\Support\Theme;

/**
 * Nút bấm trong popup (có liên kết thì là <a>, không thì là <button>).
 * Xem `PopupHeadingElement` để biết vì sao plugin tự mang bộ element cơ bản.
 */
class PopupButtonElement extends Element
{
    public function __construct()
    {
        parent::__construct('PopupButtonElement', 'Nút bấm popup');

        $this->assets('assets/popup-button.css');

        $this->setTags('popup', 'button', 'nut');
    }

    public function icon(): string
    {
        return '<i class="fa-duotone fa-solid fa-hand-pointer"></i>';
    }

    public function category(): string
    {
        return 'popup';
    }

    public function form(): void
    {
        $this->tabs('generate')->adds(function (\SkillDo\Cms\Form\Form $form)
        {
            $form->text('text', ['label' => 'Chữ trên nút', 'language' => true]);

            $form->fontIcon('icon', ['label' => 'Icon']);

            $form->text('link', ['label' => 'Liên kết (bỏ trống nếu chỉ để đóng popup)']);

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
            'tag'     => (!empty($this->options->link)) ? 'a' : 'button',
        ]);
    }

    public function cssBuilder(): string
    {
        $this->cssSelector('.popup-button', [
            'data'  => $this->options->style ?? [],
            'style' => 'button',
        ]);

        return $this->cssBuild();
    }

    public function default(): void
    {
        $defaults = [
            'text'     => 'Xem ngay',
            'link'     => '',
            'icon'     => '',
            'position' => 'start',
        ];

        foreach ($defaults as $key => $value)
        {
            $this->options->{$key} = $this->options->{$key} ?? $value;
        }
    }
}
