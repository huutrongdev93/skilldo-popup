<div class="salebanner-component-4">
    <div class="salebanner-area-image widgetBackgroundImage">
    </div>
    <div class="salebanner-group-content">
        <div class="salebanner-header-cus">
            <div class="salebanner-group-title">
                <div class="salebanner-content-mini widgetTitle">
                    {{$config['style4_title1']}}
                </div>
                <div class="salebanner-name widgetBigTitle">
                    {{$config['style4_title2']}}
                </div>
                <div class="salebanner-desc widgetDescription">
                    {{$config['style4_content']}}
                </div>
            </div>
        </div>
        <div class="salebanner-group-descreption">
            <div class="salebanner-price widgetPrice">{{$config['style4_price']}}</div>
            <div class="salebanner-box-chat">
                <a class="btn content_link widgetButton" href="" target="_top">
                    {{$config['style4_btn_txt']}}
                </a>
            </div>
        </div>

    </div>
</div>

<style>
    .popup-alert .modal-dialog {
        width: 400px!important;
        max-width: 100%!important;
    }
    .salebanner-component-4 {
        width: 400px;
        height: auto;
        border-radius: 10px;
        background-color: #fff;
        position: relative;
    }
    .salebanner-component-4 .salebanner-area-image {
        background-image: url('{{Template::imgLink($config['style4_popup_bg'])}}');
        height: 170px;
        border-radius: 10px 10px 0 0;
        background-size: cover;
        background-position-y: -15px;
    }
    .salebanner-component-4 .salebanner-group-content {
        text-align: center; height: auto;
    }
    .salebanner-component-4 .salebanner-content-mini {
        display: flex;
        justify-content: center;
        padding-top: 25px;
        text-align: center;
        color: {{$config['style4_title1_color']}}!important;
        width: auto;
        font-size: 16px;
    }
    .salebanner-component-4 .salebanner-name {
        text-align: center;
        color: {{$config['style4_title2_color']}}!important;
        margin: 15px 0;
        font-weight: 700;
        font-size: 34px;
    }
    .salebanner-component-4 .salebanner-desc {
        padding-top: 11px;
        padding-bottom: 20px;
        margin: 0 auto;
        text-align: center;
        color: {{$config['style4_content_color']}}!important;
        width: 341px;

    }
    .salebanner-component-4 .salebanner-group-descreption {
        display: flex;
        justify-content: center;
        margin-bottom: 30px;
        margin-top: 8px;
    }
    .salebanner-component-4 .salebanner-price {
        width: auto;
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #fff;
        border-radius: 5px;
        font-size: 19px;
        border: 1px solid #e1e1e1;
        padding: 10px;
        margin-right: 10px;
        font-weight: bolder;
    }
    .salebanner-component-4 .salebanner-box-chat {
        width: 112px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 5px;
        font-size: 19px;
        cursor: pointer;
    }
    .salebanner-component-4  .btn {
        font-size: 16px;
        text-align: left;
        cursor: pointer;
        text-decoration: none;
        color: {{$config['style4_btn_color']}}!important;
        font-weight: 400;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 5px;
        background-color: {{$config['style4_btn_bg']}}!important;
    }
    @media(max-width:600px) {
        .salebanner-component-4 {
            width: 100%;
        }
    }
    @media(max-width:400px) {
        .salebanner-component-4 .salebanner-name {
            font-size: 25px;
        }
        .salebanner-component-4 .salebanner-desc {
            width:100%;
        }
    }
</style>