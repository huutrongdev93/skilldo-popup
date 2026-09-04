<?php
namespace Popup\Styles;

use Popup\Presets\PopupPresetBuilder as PB;
use Popup\Presets\PopupPresetLayout as PL;
use SkillDo\Cms\Support\Url;

/**
 * Mẫu 4 — ảnh bên trái, nội dung + giá bên phải.
 */
class PopupStyle4 extends PopupStyleBase
{
    public function key(): string
    {
        return 'style4';
    }

    public function image(): string
    {
        return asset('popup::images/demo-style4.png');
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
                PL::split([
                    PB::heading($this->config('title1'), [
                        'color'  => $this->config('title1_color'),
                        'size'   => 16,
                        'weight' => 500,
                        'mb'     => 4,
                    ]),
                    PB::heading($this->config('title2'), [
                        'tag'    => 'h3',
                        'color'  => $this->config('title2_color'),
                        'size'   => 34,
                        'weight' => 800,
                        'mb'     => 12,
                    ]),
                    PB::textEditor($this->config('content'), [
                        'color' => $this->config('content_color'),
                        'mb'    => 14,
                    ]),
                    PB::heading($this->config('price'), [
                        'color'  => $this->config('title2_color'),
                        'size'   => 40,
                        'weight' => 800,
                        'mb'     => 16,
                    ]),
                    PB::button($this->config('btn_txt'), $this->config('btn_url'), [
                        'color'      => $this->config('btn_color'),
                        'background' => $this->config('btn_bg'),
                        'radius'     => 8,
                    ]),
                ], $this->config('popup_bg'), [
                    'imageSide'    => 'left',
                    'contentWidth' => '55%',
                    'contentBg'    => '#ffffff',
                    'padding'      => ['top' => 40, 'right' => 34, 'bottom' => 40, 'left' => 34],
                    'label'        => 'Khuyến mãi',
                ]),
            ],
        ];
    }

    protected function configDefault(): array
    {
        return [
            'title1'         => 'Dịch vụ trọn gói',
            'title1_color'   => 'rgb(140, 138, 139)',
            'title2'         => 'Rộn Ràng Đón Xuân',
            'title2_color'   => 'rgb(98, 187, 122)',
            'content'        => 'Hưởng ngay ưu đãi liệu trình massage thư giãn với tinh dầu thảo mộc',
            'content_color'  => 'rgb(140, 138, 139)',
            'price'          => '399k',
            'btn_txt'        => 'Mua ngay',
            'btn_color'      => '#000',
            'btn_bg'         => 'yellow',
            'btn_url'        => Url::base(),
            'popup_bg'       => 'http://cdn.sikido.vn/images/popup/salebanner-4.jpg',
        ];
    }
}
