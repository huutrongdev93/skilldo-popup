<div class="js_popup_contactform contactform-style-5 widgetBackgroundImage">
    <div class="banner-header banner-image widgetBackgroundImage" style="background-color: transparent; background-image: url(&quot;https://themes.trazk.com/004/contactform/0218/images/popup/gift-box.png&quot;);"></div>
    <form class="js_popup_contactform__form main-salebanner formStep1">
        <input type="hidden" name="style" value="style5">
        <div class="widgetTitle">
            {{$config['style5_title1']}}
        </div>
        <div class="widgetTitleBig">
            {{$config['style5_title2']}}
        </div>
        <div class="widgetDescription">
            {{$config['style5_content']}}
        </div>
        <div class="form-email">
            <?php if(in_array('email', $contactform_input)) {?>
                <input type="email" name="email" class="banner-input-object banner-email displayBlock" placeholder="Email của bạn" {{(in_array('email', $contactform_required)) ? 'required' : ''}}>
            <?php } ?>
            <?php if(in_array('phone', $contactform_input)) {?>
                <input type="text" name="phone" class="banner-input-object banner-phone displayBlock" placeholder="Số điện thoại" {{(in_array('phone', $contactform_required)) ? 'required' : ''}}>
            <?php } ?>
            <?php if(in_array('note', $contactform_input)) {?>
                <textarea name="note" class="banner-input-object banner-note displayBlock" rows="3" {{(in_array('note', $contactform_required)) ? 'required' : ''}}></textarea>
            <?php } ?>
            <button type="submit" class="button-send font-button-send widgetButton widgetBuble">{!! !empty($config['style5_btn_txt']) ? $config['style5_btn_txt'] : '<i class="fas fa-gift" id="bubble-icon"></i>' !!}</button>
        </div>
    </form>
    <div class="js_popup_contactform__success formStep2 hiddenAll">
        <div class="success-check animated bounce">
            <img class="images-check" src="https://themes.trazk.com/004/contactform/master/images/other-icon/success-check.png" alt="">
        </div>
        <p class="thanks">Cảm ơn bạn đã để lại thông tin</p>
    </div>
</div>
<style>
    .popup-alert .modal-dialog {
        width: 480px!important;
        max-width: 100%!important;
    }
    .popup-alert .modal-content { background-color: transparent; box-shadow: none;}
    .contactform-style-5 {
        padding:100px 50px 20px 50px;
    }
    .contactform-style-5 .banner-image{
        position: absolute;
        top: -15px;
        z-index: 1;
        left: 0;
        width: 490px;
        height: 280px;
        background-size: cover;
        border-radius: 30px 30px 0 0;
    }
    .contactform-style-5 .main-salebanner {
        background: #fff;
        padding: 100px 20px 20px;
        border-radius: 20px;
        margin-top: 7rem;
        position: relative;
        box-shadow: 2px 2px 15px 1px #000;
        text-align: center;
        line-height: 35px;
    }
    .contactform-style-5 .widgetTitle {
        font-size: 20px;
        font-weight: 700;
        color: {{$config['style5_title1_color']}};
    }
    .contactform-style-5 .widgetTitleBig {
        font-size: 74px; line-height: 80px;
        font-weight: 700;
        color: {{$config['style5_title2_color']}};
    }
    .contactform-style-5 .widgetDescription {
        font-size: 14px;
        padding: 5px 35px;
        font-weight: 500;
        text-align: center;
        color:{{$config['style5_content_color']}};
    }
    .contactform-style-5 .form-email {
        width: 260px;
        justify-content: center;
        margin: 0 auto;
        margin-top: 10px;
        margin-bottom: 10px;
        background-color: #fff;
        border-radius: 5px;
    }
    .contactform-style-5 .banner-input-object {
        background: #fff;
        padding: 5px 20px;
        width: 100%;
        border-radius: 40px;
        margin-right: 10px;
        border:1px solid #ccc;
        margin-bottom: 10px;
        outline: none;
    }
    .contactform-style-5 .widgetButton {
        width: 100%;
        display: block;
        text-align: center;
        font-size: 14px;
        border-radius: 40px;
        padding: 5px 20px;
        margin-bottom: 50px;
        border: none;
        cursor: pointer;
        color: {{$config['style5_btn_color']}};
        background-color: {{$config['style5_btn_bg']}};
    }
    .contactform-style-5 .js_popup_contactform__success {
        margin: 1.5rem;
        justify-content: center;
        text-align: center;
        display: none;
        background: #fff;
        width: 100%;
        padding-top: 140px;
        border-radius: 10px;
    }
    .contactform-style-5 .js_popup_contactform__success .thanks { color: #333; padding: 20px 0 40px 0; }
    .contactform-style-5 .js_popup_contactform__success .images-check {
        height: 110px;
        padding-top: 40px;
    }
    .contactform-style-5.success .js_popup_contactform__form {
        display: none;
    }
    .contactform-style-5.success .js_popup_contactform__success {
        display: block;
    }
    @media(max-width: 600px) {
        .contactform-style-5 {
            padding: 0;
        }
        .contactform-style-5 .form-email {
            width: 210px;
        }
        .contactform-style-5 .main-salebanner {
            padding: 30px 10px 10px;
            margin-top: 4rem;
        }
        .contactform-style-5 .banner-image {
            left: 42px;
            width: 189px;
            height: 121px;
        }
    }
</style>