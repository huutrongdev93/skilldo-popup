<?php
namespace Popup\Styles;

use Popup\Presets\PopupPresetBuilder as PB;
use Popup\Presets\PopupPresetLayout as PL;

/**
 * Mẫu 8 — form thu thập email bên trái, ảnh minh hoạ bên phải.
 */
class PopupStyle8 extends PopupStyleBase
{
    public function key(): string
    {
        return 'style8';
    }

    public function image(): string
    {
        return asset('popup::images/demo-style8.png');
    }

    public function preset(): array
    {
        return [
            'frame' => [
                'width'   => 800,
                'padding' => 0,
                'radius'  => 6,
            ],
            'rows' => [
                PL::split([
                    PB::heading($this->config('title1'), [
                        'color'  => $this->config('title1_color'),
                        'size'   => 22,
                        'weight' => 700,
                        'align'  => 'center',
                        'mb'     => 10,
                    ]),
                    PB::textEditor($this->config('content'), [
                        'color' => $this->config('content_color'),
                        'align' => 'center',
                        'mb'    => 18,
                    ]),
                    PB::form((array) $this->config('form', []), $this->config('btn_txt'), [
                        'buttonStyle' => [
                            'color'      => $this->config('btn_color'),
                            'background' => $this->config('btn_bg'),
                            'radius'     => 4,
                        ],
                        'fieldBg' => '#f1f1f1',
                    ]),
                ], $this->config('popup_bg'), [
                    'contentWidth' => '60%',
                    'contentBg'    => '#ffffff',
                    'padding'      => ['top' => 34, 'right' => 28, 'bottom' => 34, 'left' => 28],
                    'label'        => 'Đăng ký nhận tin',
                ]),
            ],
        ];
    }

    protected function configDefault(): array
    {
        return [
            'title1' => 'Trợ giúp qua điện thoại',
            'title1_color' => 'rgb(214, 97, 97)',
            'content' => 'Nhận ngay 2.000.000 VNĐ cho dịch vụ Tắm Trắng Phi Thuyền Hồng Ngoại',
            'content_color' => 'rgb(34, 34, 34)',
            'btn_txt' => 'Nhận mã ngay',
            'btn_color' => '#fff',
            'btn_bg' => 'rgb(214, 97, 97)',
            'popup_bg' => 'http://cdn.sikido.vn/images/popup/contactform-1.jpg',
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
