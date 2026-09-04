@php
    /*
     * Popup dựng bằng kéo thả.
     *
     * Nội dung là cây builder của section `popup_{id}`; CSS/JS của nó nằm trong bundle
     * `layout-{md5(key)}` do lần Xuất bản gần nhất sinh ra (AssetsService nạp bundle này).
     * Ở đây chỉ dựng khung: kích thước, vị trí, nền, lớp phủ, nút đóng.
     */
    use SkillDo\Cms\Element\ElementBuilder;

    $content = $rows ?? [];

    $key        = $popup->popupKey();
    $width      = (int)($config['width'] ?? 700);
    $padding    = (int)($config['padding'] ?? 0);
    $radius     = (int)($config['radius'] ?? 8);
    $background = $config['background'] ?? '#ffffff';
    $bgImage    = $config['backgroundImage'] ?? '';
    $overlay    = $config['overlay'] ?? '';
    $position   = $config['position'] ?? 'center';
    $closeShow  = !empty($config['closeShow']);
    $closeSide  = $config['closePosition'] ?? 'inside';
    $closeColor = $config['closeColor'] ?? '#333333';
    $animation  = $config['animation'] ?? 'fade';

    //Khoảng cách tối thiểu từ popup tới mép màn hình (nút đóng đặt ngoài khung cần chỗ để hiện)
    $edge = (int)($config['edgeSpacing'] ?? 30);

    if($closeSide === 'outside' && $edge < 50) $edge = 50;

    $modalId = 'popup_'.$key;
@endphp
<div class="popup-builder popup-builder-{!! $animation !!} popup-builder-close-{!! $closeSide !!}">
    @if(hasItems($content))
        {!! ElementBuilder::render($content) !!}
    @endif
</div>
<style>
    /*
     * Khung popup — căn bằng flex NGAY TRÊN .modal-dialog, đúng cách `.modal-dialog-centered`
     * của Bootstrap làm.
     *
     * KHÔNG gắn layout vào `.show`: lúc đóng, Bootstrap gỡ `.show` TRƯỚC rồi mới chạy fade 300ms
     * rồi mới `display:none`. Quy tắc phụ thuộc `.show` biến mất ngay từ đầu hiệu ứng nên popup
     * rơi về layout mặc định — người dùng thấy nó nhảy lên góc trên bên trái rồi mới mờ đi.
     * Cách này cũng không cần `!important` chọi với inline style của Bootstrap.
     */
    #{!! $modalId !!} .modal-dialog {
        width: {!! $width !!}px;
        max-width: calc(100% - 24px);
        display: flex;
        align-items: {!! $position === 'top' ? 'flex-start' : ($position === 'bottom' ? 'flex-end' : 'center') !!};
        min-height: calc(100% - {!! $edge * 2 !!}px);
        @if($position === 'left')
        margin: {!! $edge !!}px auto {!! $edge !!}px 12px;
        @elseif($position === 'right')
        margin: {!! $edge !!}px 12px {!! $edge !!}px auto;
        @else
        margin: {!! $edge !!}px auto;
        @endif
    }
    #{!! $modalId !!} .modal-content {
        width: 100%;
    }
    /*
     * Hiệu ứng mở/đóng theo cấu hình. Bootstrap mặc định luôn trượt lên 50px
     * (.modal.fade .modal-dialog { transform: translate(0,-50px) }) nên chọn "Mờ dần"
     * mà popup vẫn nhích lên lúc đóng — trông như bị kéo đi chỗ khác rồi mới tắt.
     */
    #{!! $modalId !!}.modal.fade .modal-dialog {
        transition: transform .3s ease-out, opacity .3s linear;
        @if($animation === 'zoom')
        transform: scale(.92);
        @elseif($animation === 'slide')
        transform: translate(0, -50px);
        @else
        transform: none;
        @endif
    }
    #{!! $modalId !!}.modal.show .modal-dialog {
        transform: none;
    }
    @media (prefers-reduced-motion: reduce) {
        #{!! $modalId !!}.modal.fade .modal-dialog {
            transition: none;
            transform: none;
        }
    }
    @media (max-width: 575.98px) {
        #{!! $modalId !!} .modal-dialog {
            margin: {!! max(10, (int)($edge / 2)) !!}px 10px;
            min-height: calc(100% - {!! max(10, (int)($edge / 2)) * 2 !!}px);
            max-width: calc(100% - 20px);
        }
    }
    #{!! $modalId !!} .modal-content {
        border: none;
        border-radius: {!! $radius !!}px;
        background-color: {!! $background !!};
        @if(!empty($bgImage))
        background-image: url('{!! Image::source($bgImage)->link() !!}');
        background-size: cover;
        background-position: center;
        @endif
        overflow: hidden;
    }
    #{!! $modalId !!} .modal-body {
        padding: {!! $padding !!}px;
        max-height: calc(100vh - {!! $edge * 2 + 20 !!}px);
        overflow-y: auto;
    }
    @if(!empty($overlay))
    #{!! $modalId !!} + .modal-backdrop.show,
    #{!! $modalId !!}.modal {
        --popup-overlay: {!! $overlay !!};
    }
    #{!! $modalId !!}.modal {
        background-color: var(--popup-overlay);
    }
    @endif
    #{!! $modalId !!} .modal-content button.close {
        @if(!$closeShow)
        display: none;
        @else
        color: {!! $closeColor !!};
        opacity: 1;
        background-color: transparent;
        @if($closeSide === 'outside')
        top: -44px;
        right: 0;
        color: #fff;
        @endif
        @endif
    }
    #{!! $modalId !!} .popup-builder .build-row {
        width: 100%;
    }
</style>
