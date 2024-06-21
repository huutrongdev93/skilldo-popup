<div class="salebanner-component-2 widgetBackgroundImage">
    <div class="salebanner-group-content">
        <div class="salebanner-header-cus ">
            <div class="salebanner-group-title">
                <div class="salebanner-name widgetTitle">
                    {{$config['style2_title']}}
                </div>
                <div class="salebanner-desc widgetDescription">
                    {{$config['style2_content']}}
                </div>
            </div>
        </div>
        <div class="salebanner-group-descreption-5 sale-banner-button">
            <a class="btn btn-effect-default widgetButton" href="{{$config['style2_btn_url']}}" target="_top">
                {{$config['style2_btn_txt']}}
            </a>
        </div>
    </div>
</div>

<style>
    .salebanner-component-2 {
        width: 100%;
        height: 351px;
        background-image: url('{!!Template::imgLink($config['style2_popup_bg'])!!}');
        border-radius: 10px;
        padding: 40px 50px;
        background-size: 150%;
        background-position: left;
        background-position-y: 50%;
        position: relative;
    }
    .salebanner-component-2 .salebanner-group-content {
        text-align: left;
        height: auto;
        font-weight: bold;
        line-height: 35px;
    }
    .salebanner-component-2 .salebanner-name {
        font-size: 35px;
        color:{{$config['style2_title_color']}};
    }
    .salebanner-component-2 .salebanner-desc {
        font-size: 14px;
        margin: 20px 0;
        color:{{$config['style2_content_color']}};
        font-weight: 400;
    }
    .salebanner-component-2 .btn {
        text-align: left;
        cursor: pointer;
        text-decoration: none;
        font-weight: 400;
        border-radius: 5px;
        padding: 11px 17px;
        color:{{$config['style2_btn_color']}};
        background-color:{{$config['style2_btn_bg']}};
        font-size: 15px;
    }
    .salebanner-component-2 .btn:before {
        background-color:{{$config['style2_btn_bg']}};
    }
</style>