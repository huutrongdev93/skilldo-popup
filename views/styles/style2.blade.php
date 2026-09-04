<div class="popup-style-2 widgetBackgroundImage">
    <div class="salebanner-group-content">
        <div class="salebanner-header-cus ">
            <div class="salebanner-group-title">
                <div class="salebanner-name widgetTitle">
                    {{$config['title']}}
                </div>
                <div class="salebanner-desc widgetDescription">
                    {{$config['content']}}
                </div>
            </div>
        </div>
        <div class="salebanner-group-descreption-5 sale-banner-button">
            <a class="btn btn-effect-default widgetButton" href="{{$config['btn_url']}}" target="_top">
                {{$config['btn_txt']}}
            </a>
        </div>
    </div>
</div>

<style>
    .popup-style-2 {
        width: 100%;
        height: 351px;
        background-image: url('{!!Template::imgLink($config['popup_bg'])!!}');
        border-radius: 10px;
        padding: 40px 50px;
        background-size: 150%;
        background-position: left;
        background-position-y: 50%;
        position: relative;
    }
    .popup-style-2 .salebanner-group-content {
        text-align: left;
        height: auto;
        font-weight: bold;
        line-height: 35px;
    }
    .popup-style-2 .salebanner-name {
        font-size: 35px;
        color:{{$config['title_color']}};
    }
    .popup-style-2 .salebanner-desc {
        font-size: 14px;
        margin: 20px 0;
        color:{{$config['content_color']}};
        font-weight: 400;
    }
    .popup-style-2 .btn {
        text-align: left;
        cursor: pointer;
        text-decoration: none;
        font-weight: 400;
        border-radius: 5px;
        padding: 11px 17px;
        color:{{$config['btn_color']}};
        background-color:{{ (!empty($config['btn_bg'])) ? $config['btn_bg'] : 'var(--theme-color)'}};
        font-size: 15px;
    }
    .popup-style-2 .btn:before {
        background-color: {{ (!empty($config['btn_bg'])) ? $config['btn_bg'] : 'var(--theme-color)'}};
    }
</style>