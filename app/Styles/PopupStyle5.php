<?php
namespace Popup\Styles;

use Popup\Presets\PopupPresetBuilder as PB;
use Popup\Presets\PopupPresetLayout as PL;
use SkillDo\Cms\Support\Url;

/**
 * Mẫu 5 — banner dọc (khổ đứng), ảnh nền, chữ căn giữa.
 */
class PopupStyle5 extends PopupStyleBase
{
    public function key(): string
    {
        return 'style5';
    }

    public function image(): string
    {
        return asset('popup::images/demo-style5.png');
    }

    public function preset(): array
    {
        return [
            'frame' => [
                'width'   => 360,
                'padding' => 0,
                'radius'  => 10,
            ],
            'rows' => [
                PL::banner([
                    PB::heading($this->config('title1'), [
                        'color'  => $this->config('title1_color'),
                        'size'   => 26,
                        'weight' => 700,
                        'align'  => 'center',
                        'mb'     => 4,
                    ]),
                    PB::heading($this->config('title2'), [
                        'tag'    => 'h3',
                        'color'  => $this->config('title2_color'),
                        'size'   => 56,
                        'weight' => 800,
                        'align'  => 'center',
                        'mb'     => 12,
                    ]),
                    PB::textEditor($this->config('content'), [
                        'color' => $this->config('content_color'),
                        'align' => 'center',
                        'mb'    => 18,
                    ]),
                    PB::button($this->config('btn_txt'), $this->config('btn_url'), [
                        'color'      => $this->config('btn_color'),
                        'background' => $this->config('btn_bg'),
                        'position'   => 'center',
                        'radius'     => 30,
                    ]),
                ], [
                    'image'   => $this->config('popup_bg'),
                    'padding' => ['top' => 220, 'right' => 30, 'bottom' => 40, 'left' => 30],
                    'label'   => 'Khuyến mãi',
                ]),
            ],
        ];
    }

    protected function configDefault(): array
    {
        return [
            'title1' => 'Valentine\'s Day',
            'title1_color' => '#FC0E56',
            'title2' => 'SALE',
            'title2_color' => '#FC0E56',
            'content' => 'Giảm 60% tất cả sản phẩm',
            'content_color' => '#FC0E56',
            'btn_txt' => 'Xem ngay',
            'btn_color' => '#fff',
            'btn_bg' => '#FC0E56',
            'btn_url' => Url::base(),
            'popup_bg' => 'http://cdn.sikido.vn/images/popup/salebanner-5.png',
        ];
    }
}
