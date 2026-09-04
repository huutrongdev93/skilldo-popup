<div class="popup-style-1">
    <div class="popup-grid position-relative">
        <div class="popup-column-left">
            <div class="popup-column-left-wrapper p-4">
                <div class="content-1">{{ $popup->config('title1')}}</div>
                <div class="content-2">{{ $popup->config('title2')}}</div>
                <div class="content-3">{{ $popup->config('content')}}</div>
                <a class="button-send btn btn-effect-default" href="{{ $popup->config('btn_url')}}">
                    <i class="fab fa-telegram-plane" id="bubble-icon"></i>
                    <span style="margin-left:2px;" class="widgetBubbleText" id="field-content_bubble_text">{{ $popup->config('btn_txt')}}</span>
                </a>
            </div>
        </div>
        <div class="popup-column-right"></div>
    </div>
</div>
<style>
    .popup-style-1
    {
        width: 100%;
        border-radius:10px;
        display:inline-flex;
        text-align:center;
        align-items:center;
        justify-content:flex-start;
        position:relative;
        overflow:hidden;
        z-index: 0;
    }

    .popup-style-1 .popup-grid
    {
        display:flex;
        flex-wrap:nowrap;
        width:100%;
        height:470px;
    }

    .popup-style-1 .popup-column-left
    {
        flex:1 auto;
        width:300px;
        height:470px;
        text-align:left;
        display:flex;
        justify-content:center;
        align-items:center;
        background-color:{{ $popup->config('popup_color') }};
        line-height: 30px;
        color:#fff;
        z-index: 1;
    }

    .popup-style-1 .popup-column-right
    {
        width: calc(100% - 300px);
        background-image:url('{!! Image::source($popup->config('popup_bg'))->link() !!}');
        background-size:cover;
    }

    .popup-style-1 .content-1 {
        font-size: 1rem;
        color:{{$popup->config('title1_color')}};
        margin-bottom:-10px;
    }

    .popup-style-1 .content-2
    {
        font-size: 2.5rem; line-height: 2.8rem;
        margin: 20px 0;  font-weight: bold;
        color:{{$popup->config('title2_color')}};
    }
    .popup-style-1 .content-3
    {
        color:{{$popup->config('content_color')}};
    }
    .popup-style-1 .button-send
    {
        background-color:{{$popup->config('btn_bg')}};
        border-radius:10px;padding:5px 25px;border:none;cursor:pointer;width:fit-content;
        font-size:14px;
        color:{{$popup->config('btn_color')}};
    }
    .popup-style-1 .button-send:before
    {
        background-color:{{$popup->config('btn_bg')}};
    }

    @media(max-width:360px)
    {
        .popup-style-1 .button-send
        {
            height:20px;
            font-size:10px!important;
            border-radius:5px!important
        }
    }

    .popup-style-1 .content-1, .popup-style-1 .content-2, .popup-style-1 .content-3
    {
        width:fit-content
    }
    .popup-style-1 .content-3
    {
        margin-bottom:16px; margin-top:16px
    }

    @media(max-width:600px)
    {
        .popup-style-1 .popup-column-left
        {
            background-color:transparent;
        }
        .popup-style-1 .popup-column-right
        {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #0000006b;
            background-blend-mode: color;
        }
    }
</style>
