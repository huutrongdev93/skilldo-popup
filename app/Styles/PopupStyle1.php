<?php
namespace Popup\Styles;

use Popup\Presets\PopupPresetBuilder as PB;
use Popup\Presets\PopupPresetLayout as PL;

/**
 * Mẫu 1 — nội dung nền tối bên trái, ảnh bên phải.
 */
class PopupStyle1 extends PopupStyleBase
{
    public function key(): string
    {
        return 'style1';
    }

    public function image(): string
    {
        return asset('popup::images/demo-style1.png');
    }

    public function preset(): array
    {
        return [
            'frame' => [
                'width'      => 820,
                'padding'    => 0,
                'radius'     => 10,
                'background' => $this->config('popup_color', '#000'),
            ],
            'rows' => [
                PL::split([
                    PB::heading($this->config('title1'), [
                        'color'     => $this->config('title1_color'),
                        'size'      => 16,
                        'weight'    => 500,
                        'transform' => 'uppercase',
                        'mb'        => 4,
                    ]),
                    PB::heading($this->config('title2'), [
                        'tag'    => 'h3',
                        'color'  => $this->config('title2_color'),
                        'size'   => 46,
                        'weight' => 800,
                        'mb'     => 14,
                    ]),
                    PB::textEditor($this->config('content'), [
                        'color' => $this->config('content_color'),
                        'mb'    => 18,
                    ]),
                    PB::button($this->config('btn_txt'), $this->config('btn_url'), [
                        'color'      => $this->config('btn_color'),
                        'background' => $this->config('btn_bg'),
                        'radius'     => 8,
                    ]),
                ], $this->config('popup_bg'), [
                    'contentWidth' => '45%',
                    'contentBg'    => $this->config('popup_color'),
                    'padding'      => ['top' => 40, 'right' => 34, 'bottom' => 40, 'left' => 34],
                    'label'        => 'Khuyến mãi',
                ]),
            ],
        ];
    }

    protected function configDefault(): array
    {
        return [
            'title1'        => 'SUMMER',
            'title1_color'  => '#fff',
            'title2'        => 'SALE',
            'title2_color'  => '#fff',
            'content'       => '+ Giảm 50% tất cả sản phẩm &amp; Miễn phí ship cho lần đặt hàng tiếp theo',
            'content_color' => '#fff',
            'btn_txt'       => 'Mua ngay',
            'btn_color'     => '#fff',
            'btn_bg'        => 'yellow',
            'btn_url'       => 'https://sikido.vn',
            'popup_color'   => '#000',
            'popup_bg'      => 'http://cdn.sikido.vn/images/popup/salebanner-1.png',
        ];
    }
}
