<?php

use SkillDo\Cms\Element\Element;
use SkillDo\Cms\Support\Theme;

/**
 * Đoạn văn bản trong popup (soạn thảo WYSIWYG).
 * Xem `PopupHeadingElement` để biết vì sao plugin tự mang bộ element cơ bản.
 */
class PopupTextElement extends Element
{
    public function __construct()
    {
        parent::__construct('PopupTextElement', 'Văn bản popup');

        $this->assets('assets/popup-text.css');

        $this->setTags('popup', 'text', 'noi-dung');
    }

    public function icon(): string
    {
        return '<i class="fa-duotone fa-solid fa-align-left"></i>';
    }

    public function category(): string
    {
        return 'popup';
    }

    public function form(): void
    {
        $this->tabs('generate')->adds(function (\SkillDo\Cms\Form\Form $form)
        {
            $form->wysiwyg('content', ['label' => 'Nội dung', 'language' => true]);
        });

        $this->tabs('style')->adds(function (\SkillDo\Cms\Form\Form $form)
        {
            $form->textBuilding('textStyle')->popup(false);
        });

        parent::form();
    }

    public function widget(): void
    {
        if(empty(trim(strip_tags((string)($this->options->content ?? ''), '<img><br><hr>'))))
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
        $this->cssSelector('.popup-text', [
            'data'  => $this->options->textStyle ?? [],
            'style' => 'text',
        ]);

        return $this->cssBuild();
    }

    public function default(): void
    {
        $this->options->content = $this->options->content ?? 'Nhập nội dung bạn muốn thông báo tới khách hàng.';
    }
}
