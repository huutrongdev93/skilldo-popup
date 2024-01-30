<div class="salebanner-component-6 widgetBackgroundImage">
    <div class="group-content">
        <div class="widgetTitle"><?php echo $config['style6_title1'];?></div>
        <div class="widgetBigTitle"><?php echo $config['style6_title2'];?></div>
        <div class="position-percent">
            <div class="widgetDescription"><?php echo $config['style6_content'];?></div>
        </div>
        <a class="btn widgetButton" href="<?php echo $config['style6_btn_url'];?>" target="_top"><?php echo $config['style6_btn_txt'];?></a>
    </div>
</div>
<style>
    .popup-alert .modal-dialog {
        width: 420px!important;
        max-width: 100%!important;
    }
    .salebanner-component-6 {
        width: 420px;
        height: 500px;
        border-radius: 10px;
        position: relative;
        background-color: rgb(255, 0, 0);
        background-image: url('http://cdn.sikido.vn/images/popup/salebanner-6.png');
        display: inline-flex;
        text-align: center;
        align-items: center;
        justify-content: center;
        background-size: cover;
        overflow: hidden;
    }
    .group-content {
        width: 256px;
        margin-left: 9px;
        height: 350px;
        position: relative;
        display: flex;
        justify-content: center;
        top: 10px;
    }
    .salebanner-component-6 .widgetTitle {
        position: absolute;
        font-size: 23px; line-height: 27px;
        font-weight: 600;
        top: 75px;
        width: 170px;
        color: <?php echo $config['style6_title1_color'];?>!important;
    }
    .salebanner-component-6 .widgetBigTitle {
        position: absolute;
        transform: rotate(-90deg);
        width: 91px;
        top: 172px;
        left: 13px;
        height: 35px;
        font-size: 22px;
        color: <?php echo $config['style6_title2_color'];?>!important;
    }
    .position-percent {
        left: 79px;
        width: 136px;
        top: 141px;
        height: 89px;
        position: absolute;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .salebanner-component-6 .widgetDescription {
        top: 156px;
        left: 112px;
        font-size: 40px;
        color: <?php echo $config['style6_content_color'];?>!important;

    }
    .salebanner-component-6  .widgetButton {
        border-radius: 25px;
        border: none;
        cursor: pointer;
        min-width: 220px;
        padding: 10px 30px;
        bottom: -16px;
        position: absolute;
        outline: none;
        color: <?php echo $config['style6_btn_color'];?>!important;
        background-color: <?php echo $config['style6_btn_bg'];?>!important;
    }
    @media(max-width:600px) {
        .salebanner-component-6 {
            width: 100%;
            background-size: 100%;
        }
        .salebanner-component-6 .widgetBigTitle {
            top: 127px;
            left: 23px;
            height: 35px;
            font-size: 19px;
        }
        .position-percent {
            left: 77px;
            top: 100px;
            height: 89px;
        }
        .salebanner-component-6 .widgetButton { width: 53px; }
    }
</style>