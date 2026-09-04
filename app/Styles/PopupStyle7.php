<?php
namespace Popup\Styles;

use Popup\Presets\PopupPresetBuilder as PB;
use Popup\Presets\PopupPresetLayout as PL;
use SkillDo\Cms\Support\Url;

/**
 * Mẫu 7 — banner ngang lớn, ảnh nền, nội dung dồn về bên phải.
 */
class PopupStyle7 extends PopupStyleBase
{
    public function key(): string
    {
        return 'style7';
    }

    public function image(): string
    {
        return asset('popup::images/demo-style7.png');
    }

    public function preset(): array
    {
        return [
            'frame' => [
                'width'   => 900,
                'padding' => 0,
                'radius'  => 10,
            ],
            'rows' => [
                PL::banner([
                    PB::heading($this->config('title1'), [
                        'color'  => $this->config('title1_color'),
                        'size'   => 24,
                        'weight' => 700,
                        'align'  => 'center',
                        'mb'     => 6,
                    ]),
                    PB::heading($this->config('title2'), [
                        'tag'    => 'h3',
                        'color'  => $this->config('title2_color'),
                        'size'   => 52,
                        'weight' => 800,
                        'align'  => 'center',
                        'mb'     => 12,
                    ]),
                    PB::textEditor($this->config('content'), [
                        'color' => $this->config('content_color'),
                        'align' => 'center',
                        'mb'    => 20,
                    ]),
                    PB::button($this->config('btn_txt'), $this->config('btn_url'), [
                        'color'      => $this->config('btn_color'),
                        'background' => $this->config('btn_bg'),
                        'position'   => 'center',
                        'radius'     => 30,
                    ]),
                ], [
                    'image'       => $this->config('popup_bg'),
                    'columnWidth' => '45%',
                    'align'       => 'right',
                    'padding'     => ['top' => 45, 'right' => 40, 'bottom' => 45, 'left' => 20],
                    'label'       => 'Khuyến mãi',
                ]),
            ],
        ];
    }

    protected function configDefault(): array
    {
        return [
            'title1' => 'Về nhà ăn Tết - Sale bằng hết',
            'title1_color' => '#fff',
            'title2' => 'SALE',
            'title2_color' => '#FFC107',
            'content' => 'Giảm giá lên đến 25% cho sản phẩm & nhiều quà tặng hấp dẫn',
            'content_color' => '#fff',
            'btn_txt' => 'Xem ngay',
            'btn_color' => '#FFC107',
            'btn_bg' => '#FC0E56',
            'btn_url' => Url::base(),
            'popup_bg' => 'http://cdn.sikido.vn/images/popup/salebanner-7.png',
        ];
    }
}
