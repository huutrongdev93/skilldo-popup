<div class="salebanner-component-7 widgetBg">
    <div class="main-salebanner widgetBackgroundImage">
        <div class="group">
            <div class="widgetTitle"><div>{{$config['style7_title1']}}</div></div>
            <div class="widgetBigTitle">{{$config['style7_title2']}}</div>
            <div class="widgetDescription">{{$config['style7_content']}}</div>
            <a class="btn widgetButton" href="{{$config['style7_btn_url']}}" target="_top">{{$config['style7_btn_txt']}}</a>
        </div>
    </div>
    <a target="_blank" href="https://fff.com.vn" class="widgetPowerBy widgetPowerByDark"></a>
</div>
<style>
    .popup-alert .modal-dialog {
        width: 900px!important;
        max-width: 100%!important;
    }
    .salebanner-component-7 {
        width: 900px;
        height: 472px;
        background-image: url('{{Template::imgLink($config['style7_popup_bg'])}}');
        border-radius: 10px;
        display: inline-flex;
        text-align: center;
        align-items: center;
        justify-content: flex-end;
        background-size: cover;
        position: relative;
        overflow: hidden;
    }
    .salebanner-component-7 .main-salebanner {
        width: 380px;
        text-align: center;
        z-index: 999;
        height: 380px;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-right: 86px;
        background-image: url('http://cdn.sikido.vn/images/popup/salebanner-7-2.png');
    }
    .salebanner-component-7 .group {
        width: 300px;
    }
    .salebanner-component-7 .widgetTitle {
        font-size: 20px; line-height: 25px;
        color: {{$config['style7_title1_color']}}!important;
    }

    .salebanner-component-7 .widgetBigTitle {
        font-size: 99px; line-height: 99px;
        color: {{$config['style7_title2_color']}}!important;
    }
    .salebanner-component-7 .widgetDescription {
        font-size: 17px;
        margin: 20px 0;
        color: {{$config['style7_content_color']}}!important;

    }
    .salebanner-component-7  .widgetButton {
        text-align: center;
        border-radius: 20px;
        padding: 5px 35px;
        border: none;
        cursor: pointer;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 18px;
        font-weight: 400;
        text-decoration: none;
        color: {{$config['style7_btn_color']}}!important;
        background-color: {{$config['style7_btn_bg']}}!important;
    }
    @media (max-width: 600px) {
        .popup-alert .modal-dialog {
            width: 360px!important;
            max-width: 100%!important;
        }
        .salebanner-component-7 {
            width: 360px;
            height: 360px;
        }
        .salebanner-component-7 .main-salebanner {
            width: 360px;
            height: 360px;
            margin-right: 0;
            background-size: cover;
        }
    }
    @media (max-width: 400px) {
        .popup-alert .modal-dialog {
            width: 100%!important;
            max-width: 100%!important;
        }
        .salebanner-component-7 {
            width: 100%!important;
        }
        .salebanner-component-7 .main-salebanner {
            width: 100%!important;
        }
    }

</style>