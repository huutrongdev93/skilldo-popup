<div class="salebanner-component-5 widgetBackgroundImage">
    <div class="main-salebanner">
        <div class="group">
            <div class="widgetTitle">{{$config['style5_title1']}}</div>
            <div class="widgetBigTitle">{{$config['style5_title2']}}</div>
            <div class="widgetDescription">{{$config['style5_content']}}</div>
            <a class="btn widgetButton" href="{{$config['style5_btn_url']}}" target="_top">{{$config['style5_btn_txt']}}</a>
        </div>
    </div>
</div>
<style>
    .popup-alert .modal-dialog {
        width: 337px!important;
        max-width: 100%!important;
    }
    .salebanner-component-5 {
        width: 337px;
        height: 600px;
        border-radius: 10px;
        background-color: #fff;
        position: relative;
        background-image: url('{{Template::imgLink($config['style5_popup_bg'])}}');
        display: inline-flex;
        text-align: center;
        align-items: center;
        justify-content: center;
        background-size: cover;
        overflow: hidden;
    }
    .main-salebanner {
        width: 296px;
        height: 213px;
        margin-right: 0;
        margin-left: 0;
        margin-top: 43px;
        background-size: cover;
    }
    .salebanner-component-5 .widgetTitle {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        top: 169px;
        height: 61px;
        width: 306px;
        letter-spacing: 2px;
        font-family: "Dancing Script";
        font-size: 33px;
        color: {{$config['style5_title1_color']}}!important;
    }
    .salebanner-component-5 .widgetBigTitle {
        white-space: nowrap;
        text-overflow: ellipsis;
        position: absolute;
        top: 43%;
        left: 50%;
        transform: translateX(-50%);
        bottom: 118px;
        height: 121px;
        width: 80%;
        letter-spacing: 9px;
        font-family: Anton;
        font-size: 90px; font-weight: bold;
        color: {{$config['style5_title2_color']}}!important;
    }
    .salebanner-component-5 .widgetDescription {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        top: 56%;
        width: 241px;
        height: 60px;
        font-family: Mali;
        font-size: 18px;
        color: {{$config['style5_content_color']}}!important;

    }
    .salebanner-component-5  .widgetButton {
        text-align: center;
        border-radius: 20px;
        padding: 10px 30px;
        border: none;
        cursor: pointer;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        position: absolute;
        right: 50%;
        transform: translateX(50%);
        bottom: 25%;
        font-size: 18px;
        font-weight: 400;
        text-decoration: none;
        color: {{$config['style5_btn_color']}}!important;
        background-color: {{$config['style5_btn_bg']}}!important;
    }
</style>