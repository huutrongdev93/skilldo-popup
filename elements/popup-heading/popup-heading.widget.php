<?php

use SkillDo\Cms\Element\Element;
use SkillDo\Cms\Support\Theme;

/**
 * Tiêu đề trong popup.
 *
 * Vì sao plugin tự có element tiêu đề trong khi theme cũng có `HeadingElementStyle1`:
 * element của theme được **tải theo nhu cầu** từ kho (BuilderServiceAjax::download giải nén
 * vào `views/<theme>/elements/` rồi ghi vào `elements.json` của theme), nên một site thật
 * có thể chưa có element đó. Preset của mẫu popup mà trỏ vào element không tồn tại thì
 * `ElementManager::getElement()` trả null và widget render ra RỖNG — popup trắng trơn.
 * Bộ element `Popup*` này đi kèm plugin nên mẫu popup dựng được trên mọi site, mọi theme.
 */
class PopupHeadingElement extends Element
{
    public function __construct()
    {
        parent::__construct('PopupHeadingElement', 'Tiêu đề popup');

        $this->assets('assets/popup-heading.css');

        $this->setTags('popup', 'heading', 'tieu-de');
    }

    public function icon(): string
    {
        return '<i class="fa-duotone fa-solid fa-heading"></i>';
    }

    public function category(): string
    {
        return 'popup';
    }

    public function form(): void
    {
        $this->tabs('generate')->adds(function (\SkillDo\Cms\Form\Form $form)
        {
            $form->text('heading', ['label' => 'Nội dung tiêu đề', 'language' => true]);

            $form->tab('headingTag', ['label' => 'Loại thẻ'])->options([
                'p'  => 'p',
                'h1' => 'H1',
                'h2' => 'H2',
                'h3' => 'H3',
                'h4' => 'H4',
                'h5' => 'H5',
                'h6' => 'H6',
            ]);
        });

        $this->tabs('style')->adds(function (\SkillDo\Cms\Form\Form $form)
        {
            $form->textBuilding('headingStyle')->popup(false);
        });

        parent::form();
    }

    public function widget(): void
    {
        if(empty($this->options->heading))
        {
            echo $this->empty();

            return;
        }

        Theme::view($this->getDir().'views/view', [
            'options' => $this->options,
            'tag'     => $this->tag(),
        ]);
    }

    /**
     * Thẻ HTML hợp lệ cho tiêu đề — dữ liệu builder không được đi thẳng vào tên thẻ.
     */
    protected function tag(): string
    {
        $tag = (string)($this->options->headingTag ?? 'p');

        return in_array($tag, ['p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'], true) ? $tag : 'p';
    }

    public function cssBuilder(): string
    {
        $this->cssSelector('.popup-heading', [
            'data'  => $this->options->headingStyle ?? [],
            'style' => 'text',
        ]);

        return $this->cssBuild();
    }

    public function default(): void
    {
        $defaults = [
            'heading'    => 'Thêm tiêu đề của bạn',
            'headingTag' => 'p',
        ];

        foreach ($defaults as $key => $value)
        {
            $this->options->{$key} = $this->options->{$key} ?? $value;
        }
    }
}
