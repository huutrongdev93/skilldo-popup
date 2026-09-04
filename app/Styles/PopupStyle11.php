<?php
namespace Popup\Styles;

use Popup\Presets\PopupPresetBuilder as PB;
use Popup\Presets\PopupPresetLayout as PL;

/**
 * Mẫu 11 — quảng cáo sản phẩm: form bên trái, ảnh sản phẩm bên phải trên nền tối.
 */
class PopupStyle11 extends PopupStyleBase
{
    public function key(): string
    {
        return 'style11';
    }

    public function image(): string
    {
        return asset('popup::images/demo-style11.png');
    }

    public function preset(): array
    {
        return [
            'frame' => [
                'width'   => 920,
                'padding' => 0,
                'radius'  => 10,
            ],
            'rows' => [
                PL::split([
                    PB::heading($this->config('title1'), [
                        'color'  => $this->config('title1_color'),
                        'size'   => 26,
                        'weight' => 700,
                        'mb'     => 12,
                    ]),
                    PB::textEditor($this->config('content'), [
                        'color' => $this->config('content_color'),
                        'mb'    => 18,
                    ]),
                    PB::form((array) $this->config('form', []), $this->config('btn_txt'), [
                        'buttonStyle' => [
                            'color'      => $this->config('btn_color'),
                            'background' => $this->config('btn_bg'),
                            'radius'     => 4,
                        ],
                        'fieldBg' => '#ffffff',
                    ]),
                ], $this->config('popup_sp'), [
                    'contentWidth' => '55%',
                    'padding'      => ['top' => 40, 'right' => 34, 'bottom' => 40, 'left' => 34],
                    'rowBg'        => [
                        'image' => $this->config('popup_bg'),
                        'size'  => 'cover',
                    ],
                    'label'        => 'Giới thiệu sản phẩm',
                ]),
            ],
        ];
    }

    protected function configDefault(): array
    {
        return [
            'title1' => 'Apple Watch Thế Hệ Mới Nhất 40mm',
            'title1_color' => '#fff',
            'content' => 'Đồng hồ thông minh là một sản phẩm công nghệ được nhiều người ưa chuộng bởi sự tiện lợi và hữu ích mà thiết bị mang lại.',
            'content_color' => '#fff',
            'btn_txt' => 'Nhận mã ngay',
            'btn_color' => '#fff',
            'btn_bg' => 'rgb(214, 97, 97)',
            'popup_bg' => 'http://cdn.sikido.vn/images/popup/contactform-4-1.png',
            'popup_sp' => 'http://cdn.sikido.vn/images/popup/contactform-4-2.png',
            'form' => [
                [
                    'label'     => 'Email liên hệ',
                    'type'      => 'email',
                    'required'  => '1',
                ]
            ]
        ];
    }
}
