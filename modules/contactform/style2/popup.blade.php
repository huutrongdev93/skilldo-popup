<div class="js_popup_contactform contactform-style-2 widgetBackgroundImage">
    <form class="js_popup_contactform__form main-salebanner formStep1">
        <input type="hidden" name="style" value="style2">
        <div class="widgetTitle">
            {{$config['style2_title1']}}
        </div>
        <div class="widgetDescription">
            {{$config['style2_content']}}
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
            <button type="submit" class="button-send font-button-send widgetButton widgetBuble">{!! !empty($config['style2_btn_txt']) ? $config['style2_btn_txt'] : '<i class="fas fa-gift" id="bubble-icon" style="color: rgb(255, 255, 255);"></i>' !!}</button>
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
    .contactform-style-2 {
        width: 100%;
        min-height: 350px;
        background: url('{!!Template::imgLink($config['style2_popup_bg'])!!}') center right no-repeat;
        border-radius: 10px;
        display: inline-flex;
        text-align: center;
        align-items: center;
        justify-content: center;
        background-size: cover;
        overflow: hidden;
    }
    .contactform-style-2 .main-salebanner {
        width: 370px;
        z-index: 999;
    }
    .contactform-style-2 .widgetTitle {
        margin-bottom: 8px;
        line-height: 24px;
        color: {{$config['style2_title1_color']}};
        font-weight: 700;
        text-align: center;
        overflow: hidden;
        text-overflow: ellipsis;
        -webkit-line-clamp: 2;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        font-size: 22px;
    }
    .contactform-style-2 .widgetDescription {
        font-size: 1.3rem;
        text-align: left;
        font-weight: 400;
        margin: 20px 0;
        margin-top: 0;
        width: 100%;
        color:{{$config['style2_content_color']}};
    }
    .contactform-style-2 .form-email {
        display: flex;
        width: 280px;
        justify-content: center;
        margin: 0 auto;
        margin-top: 20px;
        height: 40px;
    }
    .contactform-style-2 .banner-input-object {
        background: #fff;
        border: none;
        padding: 10px 20px;
        width: 100%;
        border-radius: 5px;
        margin-right: 10px;
    }
    .contactform-style-2 .widgetButton {
        display: inline-block;
        text-align: center;
        align-items: flex-start;
        font-size: 14px;
        border-radius: 5px;
        padding: 0 15px;
        border: none;
        cursor: pointer;
        color: {{$config['style2_btn_color']}};
        background-color: {{$config['style2_btn_bg']}};
    }
    .contactform-style-2 .js_popup_contactform__success {
        width: 60%;
        margin: 1.5rem;
        justify-content: center;
        text-align: center;
        display: none;
    }
    .contactform-style-2 .js_popup_contactform__success .thanks { color: #333; padding: 20px 0 40px 0; }
    .contactform-style-2 .js_popup_contactform__success .images-check {
        height: 110px;
        padding-top: 40px;
    }
    .contactform-style-2.success .js_popup_contactform__form {
        display: none;
    }
    .contactform-style-2.success .js_popup_contactform__success {
        display: block;
    }
    @media(max-width: 600px) {
        .contactform-style-2 .widgetDescription {
            padding:10px;
        }
    }
</style>