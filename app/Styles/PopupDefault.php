<?php
namespace Popup\Styles;

use Popup\Presets\PopupPresetBuilder as PB;
use Popup\Presets\PopupPresetLayout as PL;
use SkillDo\Cms\Support\Language;

/**
 * Mẫu cơ bản — chỉ tiêu đề + nội dung, để người dùng tự dựng tiếp trong trình kéo thả.
 */
class PopupDefault extends PopupStyleBase
{
    public function key(): string
    {
        return 'default';
    }

    public function image(): string
    {
        return asset('popup::images/demo-default.png');
    }

    public function preset(): array
    {
        return [
            'frame' => [
                'width'   => 640,
                'padding' => 0,
                'radius'  => 8,
            ],
            'rows' => [
                PL::plain([
                    PB::heading($this->localized('title', 'Tiêu đề popup của bạn'), [
                        'tag'    => 'h4',
                        'size'   => 24,
                        'weight' => 700,
                        'align'  => 'center',
                        'mb'     => 12,
                    ]),
                    PB::textEditor($this->localized('description', 'Nhập nội dung bạn muốn thông báo tới khách hàng.'), [
                        'align' => 'center',
                    ]),
                ], [
                    'padding' => ['top' => 34, 'right' => 34, 'bottom' => 34, 'left' => 34],
                    'label'   => 'Nội dung',
                ]),
            ],
        ];
    }

    /**
     * Mẫu này lưu tiêu đề / nội dung theo từng ngôn ngữ (`['vi' => '…', 'en' => '…']`).
     * Preset chỉ dựng được một chuỗi nên lấy ngôn ngữ hiện tại, thiếu thì lấy ngôn ngữ
     * mặc định, thiếu nữa thì lấy giá trị đầu tiên có nội dung.
     */
    protected function localized(string $key, string $fallback): string
    {
        $value = $this->config($key);

        if(is_string($value) && $value !== '') return $value;

        if(!is_array($value) || noItems($value)) return $fallback;

        foreach ([Language::current(), Language::default()] as $locale)
        {
            if(!empty($value[$locale])) return (string) $value[$locale];
        }

        foreach ($value as $item)
        {
            if(!empty($item) && is_string($item)) return $item;
        }

        return $fallback;
    }

    protected function configDefault(): array
    {
        return [
            'title'             => [],
            'description'       => [],
            'style'             => [],
            'titleStyle'        => [],
        ];
    }
}
