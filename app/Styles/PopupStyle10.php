<?php
namespace Popup\Styles;

use Popup\Presets\PopupPresetBuilder as PB;
use Popup\Presets\PopupPresetLayout as PL;

/**
 * Mẫu 10 — ảnh minh hoạ phía trên, form đăng ký phía dưới.
 */
class PopupStyle10 extends PopupStyleBase
{
    public function key(): string
    {
        return 'style10';
    }

    public function image(): string
    {
        return asset('popup::images/demo-style10.png');
    }

    public function preset(): array
    {
        return [
            'frame' => [
                'width'      => 480,
                'padding'    => 0,
                'radius'     => 10,
                'background' => $this->config('popup_color', '#ffffff'),
            ],
            'rows' => [
                PL::plain([
                    PB::image($this->config('popup_bg'), ['align' => 'center', 'width' => 100]),
                ], [
                    'padding' => [],
                    'label'   => 'Hình ảnh',
                ]),
                PL::plain([
                    PB::heading($this->config('title1'), [
                        'color'  => $this->config('title1_color'),
                        'size'   => 24,
                        'weight' => 700,
                        'align'  => 'center',
                        'mb'     => 8,
                    ]),
                    PB::textEditor($this->config('content'), [
                        'color' => $this->config('content_color'),
                        'align' => 'center',
                        'mb'    => 16,
                    ]),
                    PB::form((array) $this->config('form', []), $this->config('btn_txt'), [
                        'buttonStyle' => [
                            'color'      => $this->config('btn_color'),
                            'background' => $this->config('btn_bg'),
                            'radius'     => 30,
                        ],
                        'fieldBg' => '#ffffff',
                    ]),
                ], [
                    'padding' => ['top' => 24, 'right' => 30, 'bottom' => 30, 'left' => 30],
                    'label'   => 'Đăng ký nhận tin',
                ]),
            ],
        ];
    }

    protected function configDefault(): array
    {
        return [
            'title1' => 'Đăng ký theo dõi',
            'title1_color' => '#fff',
            'content' => 'Nhận ngay thông tin nóng',
            'content_color' => '#fff',
            'btn_txt' => 'Nhận mã ngay',
            'btn_color' => '#fff',
            'btn_bg' => 'rgb(214, 97, 97)',
            'popup_bg' => 'http://cdn.sikido.vn/images/popup/contactform-3.png',
            'popup_color' => '#90BB25',
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
