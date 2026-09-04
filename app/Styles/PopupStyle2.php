<?php
namespace Popup\Styles;

use Popup\Presets\PopupPresetBuilder as PB;
use Popup\Presets\PopupPresetLayout as PL;
use SkillDo\Cms\Support\Url;

/**
 * Mẫu 2 — ảnh nền ngang, nội dung nằm nửa trái.
 */
class PopupStyle2 extends PopupStyleBase
{
    public function key(): string
    {
        return 'style2';
    }

    public function image(): string
    {
        return asset('popup::images/demo-style2.png');
    }

    public function preset(): array
    {
        return [
            'frame' => [
                'width'   => 820,
                'padding' => 0,
                'radius'  => 10,
            ],
            'rows' => [
                PL::banner([
                    PB::heading($this->config('title'), [
                        'tag'    => 'h3',
                        'color'  => $this->config('title_color'),
                        'size'   => 35,
                        'weight' => 800,
                        'mb'     => 12,
                    ]),
                    PB::textEditor($this->config('content'), [
                        'color' => $this->config('content_color'),
                        'mb'    => 20,
                    ]),
                    PB::button($this->config('btn_txt'), $this->config('btn_url'), [
                        'color'      => $this->config('btn_color'),
                        'background' => $this->config('btn_bg') ?: '#ffffff',
                        'radius'     => 30,
                    ]),
                ], [
                    'image'         => $this->config('popup_bg'),
                    'color'         => $this->config('popup_color'),
                    'imagePosition' => 'left center',
                    'columnWidth'   => '60%',
                    'padding'       => ['top' => 45, 'right' => 30, 'bottom' => 45, 'left' => 50],
                    'label'         => 'Khuyến mãi',
                ]),
            ],
        ];
    }

    protected function configDefault(): array
    {
        return [
            'title'         => 'Bộ Sưu Tập Mới '.date('Y'),
            'title_color'   => '#fff',
            'content'       => 'Thiết kế mới kết hợp giữa sneaker và giày thể thao mang đến mẫu giày đáng mong đợi trong năm nay',
            'content_color' => '#fff',
            'btn_txt'       => 'Xem ngay',
            'btn_color'     => '#000',
            'btn_bg'        => '',
            'btn_url'       => Url::base(),
            'popup_color'   => '#000',
            'popup_bg'      => 'http://cdn.sikido.vn/images/popup/salebanner-2.jpeg',
        ];
    }
}
