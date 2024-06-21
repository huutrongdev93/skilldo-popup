<div class="js_popup_contactform contactform-style-4 widgetBackgroundImage">
    <form class="js_popup_contactform__form main-salebanner formStep1">
        <input type="hidden" name="style" value="style4">
        <div class="widgetTitle">
            {{$config['style4_title1']}}
        </div>
        <div class="widgetDescription">
            {{$config['style4_content']}}
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
            <button type="submit" class="button-send font-button-send widgetButton widgetBuble">{!! !empty($config['style4_btn_txt']) ? $config['style4_btn_txt'] : '<i class="fas fa-gift" id="bubble-icon"></i>' !!}</button>
        </div>
    </form>
    <div class="img-background widgetBackgroundImage"></div>
    <div class="js_popup_contactform__success formStep2 hiddenAll">
        <div class="success-check animated bounce">
            <img class="images-check" src="https://themes.trazk.com/004/contactform/master/images/other-icon/success-check.png" alt="">
        </div>
        <p class="thanks">Cảm ơn bạn đã để lại thông tin</p>
    </div>

</div>
<style>
    .popup-alert .modal-dialog {
        width: 920px!important;
        max-width: 100%!important;
    }
    .contactform-style-4 {
        height: 480px;
        width: 920px;
        margin: auto;
        position: relative;
        display: flex;
        background-size: cover;
        background-image: url('{!!Template::imgLink($config['style4_popup_bg'])!!}');
        background-color: #ffffff;
        font-family: 'Quicksand', sans-serif;
    }
    .contactform-style-4 .main-salebanner {
        width: 60%;
        margin: 3rem;
        margin-right: 0;
    }
    .contactform-style-4 .form-email {
        display: flex;
        justify-content: center;
        margin: 0 auto;
        margin-top: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
    }
    .contactform-style-4 .banner-input-object {
        background: #fff;
        border: none;
        padding: 10px 20px;
        width: 100%;
        border-radius: 5px;
        margin-right: 10px;
        opacity: .4;
    }
    .contactform-style-4 .widgetButton {
        display: inline-block;
        text-align: center;
        align-items: flex-start;
        font-size: 14px;
        border-radius: 5px;
        padding: 0 15px;
        border: none;
        cursor: pointer;
        color: {{$config['style4_btn_color']}};
        background-color: {{$config['style4_btn_bg']}};
    }
    .contactform-style-4 .widgetTitle {
        font-size: 35px; line-height: 55px; font-weight: bold;
        width: 500px;
        overflow: hidden;
        text-overflow: ellipsis;
        -webkit-line-clamp: 2;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        color: {{$config['style4_title1_color']}};
    }
    .contactform-style-4 .widgetDescription {
        font-size: 15px;
        line-height: 25px;
        padding-right: 5rem;
        padding-bottom: 1.1rem;
        margin-top: 30px;
        margin-bottom: 10px;
        width: 500px;
        overflow: hidden;
        text-overflow: ellipsis;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        color:{{$config['style4_content_color']}};
    }

    .contactform-style-4 .img-background {
        margin: auto;
        height: 100%;
        width: 100%;
        background-size: contain;
        background-position: center;
        background-repeat: no-repeat;
        background-image: url('{!!Template::imgLink($config['style4_popup_sp'])!!}');
    }

    .contactform-style-4 .js_popup_contactform__success {
        width: 60%;
        margin: 1.5rem;
        justify-content: center;
        text-align: center;
        display: none;
    }
    .contactform-style-4 .js_popup_contactform__success .thanks { color: #333; padding: 20px 0 40px 0; }
    .contactform-style-4 .js_popup_contactform__success .images-check {
        height: 110px;
        padding-top: 40px;
    }
    .contactform-style-4.success .js_popup_contactform__form {
        display: none;
    }
    .contactform-style-4.success .js_popup_contactform__success {
        display: block;
    }
    @media(max-width: 600px) {
        .contactform-style-4 { display: block; width: 100%;height: 600px; }
        .contactform-style-4 .main-salebanner,
        .contactform-style-4 .js_popup_contactform__success {
            width: 100%;
        }
        .contactform-style-4 .main-salebanner {
            margin: 0; padding:10px;
        }
        .contactform-style-4 .widgetTitle {
            font-size: 30px; max-width: 100%;
        }
        .contactform-style-4 .widgetDescription {
            max-width: 100%; margin-top: 10px;
        }
        .contactform-style-4 .img-background {
            height: 280px;
        }
    }
</style>