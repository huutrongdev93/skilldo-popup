<?php

use SkillDo\Cms\Element\Element;
use SkillDo\Cms\Support\Theme;

/**
 * Hình ảnh trong popup.
 * Xem `PopupHeadingElement` để biết vì sao plugin tự mang bộ element cơ bản.
 */
class PopupImageElement extends Element
{
    public function __construct()
    {
        parent::__construct('PopupImageElement', 'Hình ảnh popup');

        $this->assets('assets/popup-image.css');

        $this->setTags('popup', 'image', 'hinh-anh');
    }

    public function icon(): string
    {
        return '<i class="fa-duotone fa-solid fa-image"></i>';
    }

    public function category(): string
    {
        return 'popup';
    }

    public function form(): void
    {
        $this->tabs('generate')->adds(function (\SkillDo\Cms\Form\Form $form)
        {
            $form->image('img', ['label' => 'Hình ảnh']);

            $form->text('alt', ['label' => 'Alt', 'start' => 6]);

            $form->text('url', ['label' => 'Liên kết', 'start' => 6]);

            $form->tab('align', ['label' => 'Căn chỉnh'])->options([
                'start'  => '<i class="fa-thin fa-align-left"></i>&nbsp;Trái',
                'center' => '<i class="fa-thin fa-align-center"></i>&nbsp;Giữa',
                'end'    => 'Phải&nbsp; <i class="fa-thin fa-align-right"></i>',
            ]);
        });

        $this->tabs('style')->adds(function (\SkillDo\Cms\Form\Form $form)
        {
            $form->number('width', ['label' => 'Chiều rộng', 'start' => 8]);

            $form->tab('unitWidth', ['label' => 'Đơn vị', 'start' => 4])->options([
                '%'  => '%',
                'px' => 'px',
                'vw' => 'vw',
            ]);

            $form->boxBuilding('imgBox', ['label' => 'Khung ảnh'])->popup(false);
        });

        parent::form();
    }

    public function widget(): void
    {
        if(empty($this->options->img))
        {
            echo $this->empty();

            return;
        }

        Theme::view($this->getDir().'views/view', [
            'options' => $this->options,
        ]);
    }

    public function cssBuilder(): string
    {
        if(!empty($this->options->imgBox))
        {
            $this->cssSelector('.popup-image img', [
                'data'  => $this->options->imgBox,
                'style' => 'box',
            ]);
        }

        return $this->cssBuild();
    }

    public function default(): void
    {
        $defaults = [
            'align'     => 'center',
            'width'     => 100,
            'unitWidth' => '%',
        ];

        foreach ($defaults as $key => $value)
        {
            $this->options->{$key} = $this->options->{$key} ?? $value;
        }
    }
}
