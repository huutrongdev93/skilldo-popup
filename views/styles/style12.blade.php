<div class="js_popup_contact_form contactform-style-5 widgetBackgroundImage">
    <div class="banner-header banner-image widgetBackgroundImage" style="background-color: transparent; background-image: url('{!! asset('popup::images/style12/gift-box.png') !!}');"></div>
    <div class="js_popup_contactform__form main-salebanner formStep1">
        <input type="hidden" name="style" value="style5">
        <div class="widgetTitle">
            {{$config['title1']}}
        </div>
        <div class="widgetTitleBig">
            {{$config['title2']}}
        </div>
        <div class="widgetDescription">
            {{$config['content']}}
        </div>
        @if(!empty($form) && $form instanceof \SkillDo\Cms\Form\Form)
            {!! $form->open() !!}
            {!! $form->html() !!}
            <button type="submit" class="btn w-100 button-send font-button-send widgetButton">{{ $config['btn_txt'] }}</button>
            {!! $form->close() !!}
        @endif
    </div>
    <div class="js_popup_contactform__success formStep2 hiddenAll">
        <div class="success-check animated bounce">
            <img class="images-check" src="{!! asset('popup::images/success-check.png') !!}" alt="">
        </div>
        <p class="thanks">Cảm ơn bạn đã để lại thông tin</p>
    </div>
</div>
<style>
    #popup_{!! $popup->popupKey() !!} .modal-dialog {
        width: 480px!important;
        max-width: 100%!important;
    }
    #popup_{!! $popup->popupKey() !!} .modal-content { background-color: transparent; box-shadow: none;}
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
        color: {{$config['title1_color']}};
    }
    .contactform-style-5 .widgetTitleBig {
        font-size: 74px; line-height: 80px;
        font-weight: 700;
        color: {{$config['title2_color']}};
    }
    .contactform-style-5 .widgetDescription {
        font-size: 14px;
        padding: 5px 35px;
        font-weight: 500;
        text-align: center;
        color:{{$config['content_color']}};
    }
    .contactform-style-5 .form-control {
        background: #fff;
        width: 100%;
        border-radius: 40px;
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
        padding: 10px 20px;
        margin-bottom: 50px;
        border: none;
        cursor: pointer;
        color: {{$config['btn_color']}};
        background-color: {{$config['btn_bg']}};
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