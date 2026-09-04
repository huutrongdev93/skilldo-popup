<?php
namespace Popup\Styles;

use Popup\Presets\PopupPresetBuilder as PB;
use Popup\Presets\PopupPresetLayout as PL;

/**
 * Mẫu 12 — hộp quà phía trên, ưu đãi % lớn, form email và nút "Không, cảm ơn".
 */
class PopupStyle12 extends PopupStyleBase
{
    public function key(): string
    {
        return 'style12';
    }

    public function image(): string
    {
        return asset('popup::images/demo-style12.png');
    }

    public function preset(): array
    {
        return [
            'frame' => [
                'width'      => 480,
                'padding'    => 0,
                'radius'     => 12,
                'background' => '#ffffff',
            ],
            'rows' => [
                PL::plain([
                    PB::image(asset('popup::images/style12/gift-box.png'), [
                        'align' => 'center',
                        'width' => 55,
                        'mb'    => 10,
                    ]),
                    PB::heading($this->config('title1'), [
                        'color'  => $this->config('title1_color'),
                        'size'   => 20,
                        'weight' => 600,
                        'align'  => 'center',
                        'mb'     => 2,
                    ]),
                    PB::heading($this->config('title2'), [
                        'tag'    => 'h3',
                        'color'  => $this->config('title2_color'),
                        'size'   => 50,
                        'weight' => 800,
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
                    PB::close('Không, cảm ơn', [
                        'position'   => 'center',
                        'color'      => '#8a8a8a',
                        'background' => 'transparent',
                        'padding'    => ['top' => 8, 'right' => 8, 'bottom' => 0, 'left' => 8],
                    ]),
                ], [
                    'padding' => ['top' => 30, 'right' => 40, 'bottom' => 26, 'left' => 40],
                    'label'   => 'Ưu đãi',
                ]),
            ],
        ];
    }

    protected function configDefault(): array
    {
        return [
            'title1' => 'Tiết kiệm đến',
            'title1_color' => '#000',
            'title2' => '30%',
            'title2_color' => '#EF4B4B',
            'content' => 'cho phiếu thanh toán lần sau của bạn',
            'content_color' => '#000',
            'btn_txt' => 'Nhận mã ngay',
            'btn_color' => '#fff',
            'btn_bg' => '#EF4B4B',
            'form' => [
                [
                    'label'     => 'Email nhân khuyến mãi',
                    'type'      => 'email',
                    'required'  => '1',
                ]
            ]
        ];
    }
}
