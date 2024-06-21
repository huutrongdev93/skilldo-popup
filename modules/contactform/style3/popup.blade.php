<div class="js_popup_contactform contactform-style-3 widgetBackgroundImage">
    <div class="cick-to-call-header-img widgetBackground ">
        {!!Template::img($config['style3_popup_bg'])!!}
    </div>
    <div class="js_popup_contactform__success formStep2 hiddenAll">
        <div class="success-check animated bounce">
            <img class="images-check" src="https://themes.trazk.com/004/contactform/master/images/other-icon/success-check.png" alt="">
        </div>
        <p class="thanks">Cảm ơn bạn đã để lại thông tin</p>
    </div>
    <form class="js_popup_contactform__form main-salebanner formStep1">
        <input type="hidden" name="style" value="style3">
        <div class="widgetTitle">
            {{$config['style3_title1']}}
        </div>
        <div class="widgetDescription">
            {{$config['style3_content']}}
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
            <button type="submit" class="button-send font-button-send widgetButton widgetBuble">{!! !empty($config['style3_btn_txt']) ? $config['style3_btn_txt'] : '<i class="fas fa-gift" id="bubble-icon"></i>' !!}</button>
        </div>
    </form>
</div>
<style>
    .popup-alert .modal-dialog {
        width: 480px!important;
        max-width: 100%!important;
    }
    .contactform-style-3 {
        width: 100%;
        min-height: 350px;
        border-radius: 10px;
        text-align: center;
        align-items: center;
        justify-content: center;
        background-size: cover;
        overflow: hidden;
        background-color: #fff;
    }
    .cick-to-call-header-img {
        height: 319px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .contactform-style-3 .main-salebanner {
        background-color: {{$config['style3_popup_color']}};
        overflow: hidden;padding:20px 10px 10px 10px;
    }
    .contactform-style-3 .widgetTitle {
        margin-bottom: 8px;
        line-height: 24px;
        color: {{$config['style3_title1_color']}};
        font-weight: 700;
        text-align: center;
        overflow: hidden;
        text-overflow: ellipsis;
        -webkit-line-clamp: 2;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        font-size: 22px;
    }
    .contactform-style-3 .widgetDescription {
        font-size: 1.3rem;
        font-weight: 400;
        margin: 20px 0;
        margin-top: 0;
        width: 100%;
        color:{{$config['style3_content_color']}};
    }
    .contactform-style-3 .form-email {
        display: flex;
        width: 260px;
        justify-content: center;
        margin: 0 auto;
        margin-top: 10px;
        margin-bottom: 10px;
        background-color: #fff;
        border-radius: 5px;
    }
    .contactform-style-3 .banner-input-object {
        background: #fff;
        border: none;
        padding: 10px 20px;
        width: 100%;
        border-radius: 5px;
        margin-right: 10px;
    }
    .contactform-style-3 .widgetButton {
        display: inline-block;
        text-align: center;
        align-items: flex-start;
        font-size: 14px;
        border-radius: 5px;
        padding: 0 15px;
        border: none;
        cursor: pointer;
        color: {{$config['style3_btn_color']}};
        background-color: {{$config['style3_btn_bg']}};
    }
    .contactform-style-3 .js_popup_contactform__success {
        width: 60%;
        margin: 1.5rem;
        justify-content: center;
        text-align: center;
        display: none;
    }
    .contactform-style-3 .js_popup_contactform__success .thanks { color: #333; padding: 20px 0 40px 0; margin: 0 auto;}
    .contactform-style-3 .js_popup_contactform__success .images-check {
        height: 110px;
        padding-top: 40px;
    }
    .contactform-style-3.success .js_popup_contactform__form {
        display: none;
    }
    .contactform-style-3.success .js_popup_contactform__success {
        display: block;
    }
</style>