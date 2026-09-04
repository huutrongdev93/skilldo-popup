<?php
namespace Popup\Styles;

use Popup\Presets\PopupPresetBuilder as PB;
use Popup\Presets\PopupPresetLayout as PL;
use SkillDo\Cms\Support\Url;

/**
 * Mẫu 3 — banner vuông, ảnh nền hồng, chữ căn giữa ở nửa dưới.
 */
class PopupStyle3 extends PopupStyleBase
{
    public function key(): string
    {
        return 'style3';
    }

    public function image(): string
    {
        return asset('popup::images/demo-style3.png');
    }

    public function preset(): array
    {
        return [
            'frame' => [
                'width'   => 600,
                'padding' => 0,
                'radius'  => 10,
            ],
            'rows' => [
                PL::banner([
                    PB::heading($this->config('title3'), [
                        'color'     => $this->config('title3_color'),
                        'size'      => 18,
                        'weight'    => 700,
                        'align'     => 'center',
                        'transform' => 'uppercase',
                        'mb'        => 10,
                    ]),
                    PB::heading($this->config('title1'), [
                        'color'  => $this->config('title1_color'),
                        'size'   => 28,
                        'weight' => 700,
                        'align'  => 'center',
                        'mb'     => 2,
                    ]),
                    PB::heading($this->config('title2'), [
                        'tag'    => 'h3',
                        'color'  => $this->config('title2_color'),
                        'size'   => 64,
                        'weight' => 800,
                        'align'  => 'center',
                        'mb'     => 14,
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
                        'radius'     => 6,
                    ]),
                ], [
                    'image'   => $this->config('popup_bg'),
                    'padding' => ['top' => 150, 'right' => 60, 'bottom' => 60, 'left' => 60],
                    'label'   => 'Khuyến mãi',
                ]),
            ],
        ];
    }

    protected function configDefault(): array
    {
        return [
            'title1' => 'ƯU ĐÃI LỚN',
            'title1_color' => '#fff',
            'title2' => 'SALE',
            'title2_color' => '#fff',
            'title3' => 'GIẢM NGAY 70%',
            'title3_color' => '#fff',
            'content' => 'Tặng ngay món quà đặc biệt cho các khách hàng mua đơn hàng có giá trị từ 500.000đ',
            'content_color' => '#fff',
            'btn_txt' => 'Xem ngay',
            'btn_color' => '#000',
            'btn_bg' => 'yellow',
            'btn_url' => Url::base(),
            'popup_bg' => 'http://cdn.sikido.vn/images/popup/salebanner-3.jpg',
        ];
    }
}
