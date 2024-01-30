<div class="salebanner-component-1 content_header_background_color-2 widgetBackgroundImage" >
    <div class="main-salebanner widgetBgContent">
        <div class="group">
            <div class="content-salebanner-1 widgetTitle"><?php echo $config['title1'];?></div>
            <div class="content-salebanner-2 widgetBigTitle"><?php echo $config['title2'];?></div>
            <div class="content-salebanner-3 widgetDescription"><?php echo $config['content'];?></div>
            <a class="button-send btn btn-effect-default widgetButton widgetBuble" href="<?php echo $config['btn_url'];?>">
                <i class="fab fa-telegram-plane" id="bubble-icon"></i>
                <span style="margin-left:2px;" class="widgetBubbleText" id="field-content_bubble_text"><?php echo $config['btn_txt'];?></span>
            </a>
        </div>
    </div>
</div>
<style>
    .salebanner-component-1 {
        width: 100%;
        background-image:url('<?php echo Template::imgLink($config['popup_bg']);?>');
        border-radius:10px;
        display:inline-flex;text-align:center;
        align-items:center;
        justify-content:flex-start;background-size:cover;position:relative;overflow:hidden;z-index: 0;
    }

    @media(max-width:360px){
        .salebanner-component-1{
            height:200px
        }
    }
    .salebanner-component-1 .main-salebanner {
        width:300px;
        text-align:left;z-index:999;height:470px;
        display:flex;
        justify-content:center;align-items:center;
        background-color:<?php echo $config['popup_color'];?>;
        line-height: 30px;
        color:#fff;
    }
    .salebanner-component-1 .content-salebanner-1 {
        font-size: 20px;
        color:<?php echo $config['title1_color'];?>;
        margin-bottom:-10px;
    }
    .salebanner-component-1 .content-salebanner-2 {
        font-size: 2.3em;
        margin: 20px 0; line-height: 40px; font-weight: bold;
        color:<?php echo $config['title2_color'];?>;
    }
    .salebanner-component-1 .content-salebanner-3 {
        color:<?php echo $config['content_color'];?>;
    }
    .salebanner-component-1 .button-send {
        background-color:<?php echo $config['btn_bg'];?>;
        border-radius:10px;padding:5px 25px;border:none;cursor:pointer;width:fit-content;
        font-size:14px;
        color:<?php echo $config['btn_color'];?>;
    }
    .salebanner-component-1 .button-send:before {
        background-color:<?php echo $config['btn_bg'];?>;
    }
    @media(max-width:360px){
        .salebanner-component-1 .button-send {
            height:20px;
            font-size:10px!important;
            border-radius:5px!important
        }
    }

    .salebanner-component-1 .content-salebanner-1, .salebanner-component-1 .content-salebanner-2, .salebanner-component-1 .content-salebanner-3{
        width:fit-content
    }
    .salebanner-component-1 .content-salebanner-3{
        margin-bottom:16px;margin-top:16px
    }
    .salebanner-component-1 .group{ width:210px }

    @media(max-width:400px){
        .salebanner-component-1 .main-salebanner { width:100%; height: auto; background-color: rgba(0,0,0,0.5); }
        .salebanner-component-1 .group{ width:100%; padding:40px 20px; }
    }
</style>
