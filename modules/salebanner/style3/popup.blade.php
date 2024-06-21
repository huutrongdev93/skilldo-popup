<div class="salebanner-component-3 widgetBackgroundImage">
    <div class="banner-infoSale widgetBgInfo">
        <div class="banner-infoText">
            <p class="text-info widgetMore">{{$config['style3_title3']}}</p>
        </div>
    </div>
    <div class="banner-text">
        <div class="text-title">
            <div class="text-title1 widgetTitle">{{$config['style3_title1']}}</div>
            <div class="text-title2 widgetBigTitle">{{$config['style3_title2']}}</div>
        </div>
        <div class="text-des widgetDescription">{{$config['style3_content']}}</div>
        <div class="button-link widgetLink">
            <a href="{{$config['style3_btn_url']}}" class="btn button-href widgetButton" target="_top">{{$config['style3_btn_txt']}}</a>

        </div>
    </div>
</div>
<style>
    .popup-alert .modal-dialog {
        width: 600px!important;
        max-width: 100%!important;
    }
    .salebanner-component-3 {
        background-image: url('{{Template::imgLink($config['style3_popup_bg'])}}');
        width: 600px;
        height: 600px;
        margin: auto;
        background-size: cover;
        background-position: center;
        position: relative;
    }
    .salebanner-component-3 .banner-infoSale {
        position: absolute;
        top: 6%;
        right: 18%;
        width: 120px;
        height: 120px;
        background-size: cover;
        background-image: url(https://themes.trazk.com/004/salebanner/0234/images/product/heart-34.png);
    }
    .salebanner-component-3 .banner-infoText {
        width: 92%;
        height: 100%;
        padding: 1px;
        color: {{$config['style3_title3_color']}}!important;
        transform: rotate(20deg);
        display: flex;
        text-align: center;
        justify-content: center;
        font-size: 16px;
        align-items: center;
    }
    .salebanner-component-3 .banner-text {
        justify-content: center;
        align-items: center;
        text-align: center;
        width: 100%;
        height: 100%;
        margin: auto;
    }
    .salebanner-component-3 .text-title {
        font-size: 100px;
        line-height: 1;
        padding: 15rem 1rem 1rem;
    }
    .salebanner-component-3 .text-title1 {
        color: {{$config['style3_title1_color']}};
        font-size: 42px;
    }
    .salebanner-component-3 .text-title2 {
        color: {{$config['style3_title2_color']}};
    }
    .salebanner-component-3 .text-des {
        padding: 1rem 5rem;
        color: {{$config['style3_content_color']}};
        font-size: 16px;
    }
    .salebanner-component-3 .button-href {
        padding: 5px 12px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 14px;
        color: {{$config['style3_btn_color']}};
        background-color: {{$config['style3_btn_bg']}};
    }
    @media(max-width:600px) {
        .salebanner-component-3 {
            width: 100%;
        }
        .salebanner-component-3 .banner-infoText p { font-size: 13px;}
        .salebanner-component-3 .text-des {
            padding: 15px 30px;
        }
    }
</style>