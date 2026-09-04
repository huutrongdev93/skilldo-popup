@php
    /*
     * Khung xem thử popup trong trình dựng.
     *
     * Mô phỏng đúng cảnh popup thật: nền tối (lớp phủ) + khung trắng giới hạn chiều
     * rộng theo cấu hình. Bên trong vẫn là partial `builder-review-single` của core
     * để giữ nguyên chrome builder (nút thêm hàng, kéo thả, context menu).
     */
    $width      = (int)($config['width'] ?? 700);
    $padding    = (int)($config['padding'] ?? 0);
    $radius     = (int)($config['radius'] ?? 8);
    $background = $config['background'] ?? '#ffffff';
    $overlay    = $config['overlay'] ?? 'rgba(0, 0, 0, 0.5)';
    $bgImage    = $config['backgroundImage'] ?? '';
    $position   = $config['position'] ?? 'center';
    $closeShow  = !empty($config['closeShow']);
    $closeColor = $config['closeColor'] ?? '#333333';
    $edge       = (int)($config['edgeSpacing'] ?? 30);

    $align = match ($position) {
        'top'    => 'flex-start',
        'bottom' => 'flex-end',
        default  => 'center',
    };

    $justify = match ($position) {
        'left'  => 'flex-start',
        'right' => 'flex-end',
        default => 'center',
    };
@endphp
<!DOCTYPE html>
<html>
    {!! Theme::resources('common/head') !!}
    <body class="popup-builder-review">
        <div id="td-outer-wrap">
            <div class="wrapper">
                <div class="popup-review-stage">
                    <div class="popup-review-box">
                        @if($closeShow)
                            <span class="popup-review-close">&times;</span>
                        @endif
                        {!! \SkillDo\Cms\Support\Admin::partial('builder-review-single', [
                            'builder'     => $builder,
                            'sectionId'   => $sectionId,
                            'sections'    => $sections,
                            'style'       => $style,
                            'cssWidth'    => $cssWidth,
                            'script'      => $script,
                            'headerClass' => '',
                            'elementCss'  => $elementCss,
                            'settings'    => [],
                        ]) !!}
                    </div>
                </div>
            </div>
        </div>
        <style>
            body.popup-builder-review {
                background: {!! $overlay !!};
                min-height: 100vh;
            }
            .popup-review-stage {
                display: flex;
                align-items: {!! $align !!};
                justify-content: {!! $justify !!};
                min-height: 100vh;
                /* cùng khoảng cách mép với ngoài site để xem thử không lệch */
                padding: {!! $edge !!}px 15px;
            }
            .popup-review-box {
                position: relative;
                width: 100%;
                max-width: {!! $width !!}px;
                padding: {!! $padding !!}px;
                border-radius: {!! $radius !!}px;
                background-color: {!! $background !!};
                @if(!empty($bgImage))
                background-image: url('{!! Image::source($bgImage)->link() !!}');
                background-size: cover;
                background-position: center;
                @endif
                box-shadow: 0 10px 40px rgba(0,0,0,.25);
            }
            /* Vùng dựng phải cao tối thiểu để còn kéo element vào khi popup đang trống */
            .popup-review-box .builder-main,
            .popup-review-box .wrapper-review {
                min-height: 120px;
            }
            .popup-review-close {
                position: absolute;
                top: 8px;
                right: 12px;
                z-index: 5;
                font-size: 26px;
                line-height: 1;
                color: {!! $closeColor !!};
                cursor: default;
            }
        </style>
    </body>
</html>
