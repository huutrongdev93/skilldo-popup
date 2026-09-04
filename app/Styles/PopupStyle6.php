<?php
namespace Popup\Styles;

use Popup\Presets\PopupPresetBuilder as PB;
use Popup\Presets\PopupPresetLayout as PL;
use SkillDo\Cms\Support\Url;

/**
 * Mẫu 6 — banner Tết nền đỏ, chữ căn giữa.
 */
class PopupStyle6 extends PopupStyleBase
{
    const BACKGROUND = 'http://cdn.sikido.vn/images/popup/salebanner-6.png';

    public function key(): string
    {
        return 'style6';
    }

    public function image(): string
    {
        return asset('popup::images/demo-style6.png');
    }

    public function preset(): array
    {
        return [
            'frame' => [
                'width'   => 420,
                'padding' => 0,
                'radius'  => 10,
            ],
            'rows' => [
                PL::banner([
                    PB::heading($this->config('title1'), [
                        'color'  => $this->config('title1_color'),
                        'size'   => 30,
                        'weight' => 800,
                        'align'  => 'center',
                        'mb'     => 6,
                    ]),
                    PB::heading($this->config('title2'), [
                        'tag'    => 'h3',
                        'color'  => $this->config('title2_color'),
                        'size'   => 52,
                        'weight' => 800,
                        'align'  => 'center',
                        'mb'     => 6,
                    ]),
                    PB::heading($this->config('content'), [
                        'color'  => $this->config('content_color'),
                        'size'   => 44,
                        'weight' => 800,
                        'align'  => 'center',
                        'mb'     => 20,
                    ]),
                    PB::button($this->config('btn_txt'), $this->config('btn_url'), [
                        'color'      => $this->config('btn_color'),
                        'background' => $this->config('btn_bg'),
                        'position'   => 'center',
                        'radius'     => 30,
                    ]),
                ], [
                    'color'   => $this->config('popup_color', 'rgb(255, 0, 0)'),
                    'image'   => $this->config('popup_bg', static::BACKGROUND),
                    'padding' => ['top' => 60, 'right' => 40, 'bottom' => 60, 'left' => 40],
                    'label'   => 'Khuyến mãi',
                ]),
            ],
        ];
    }

    protected function configDefault(): array
    {
        return [
            'title1' => 'TẾT SALE HẾT',
            'title1_color' => 'rgb(255, 0, 0)',
            'title2' => 'SALE',
            'title2_color' => '#fff',
            'content' => '50%',
            'content_color' => '#fff',
            'btn_txt' => 'Mua sắm ngay',
            'btn_color' => 'rgb(255, 0, 0)',
            'btn_bg' => '#FFE500',
            'btn_url' => Url::base(),
            'popup_color' => 'rgb(255, 0, 0)',
            'popup_bg' => self::BACKGROUND,
        ];
    }
}
