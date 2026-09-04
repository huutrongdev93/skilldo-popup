<div class="js_popup_contact_form contactform-style-3 widgetBackgroundImage">
    <div class="click-to-call-header-img widgetBackground ">
        {!! Image::source($config['popup_bg'], $popup->object()->name)->html() !!}
    </div>
    <div class="js_popup_contactform__success formStep2 hiddenAll">
        <div class="success-check animated bounce">
            <img class="images-check" src="{!! asset('popup::images/success-check.png') !!}" alt="">
        </div>
        <p class="thanks">Cảm ơn bạn đã để lại thông tin</p>
    </div>
    <div class="js_popup_contactform__form main-salebanner formStep1">
        <input type="hidden" name="style" value="style3">
        <div class="widgetTitle">
            {{$config['title1']}}
        </div>
        <div class="widgetDescription">
            {{$config['content']}}
        </div>
        @if(!empty($form) && $form instanceof \SkillDo\Cms\Form\Form)
            {!! $form->open() !!}
            {!! $form->html() !!}
            <button type="submit" class="btn w-100 widgetButton className">{{ $config['btn_txt'] }}</button>
            {!! $form->close() !!}
        @endif
    </div>
</div>
<style>
    #popup_{!! $popup->popupKey() !!} .modal-dialog {
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
    .click-to-call-header-img {
        height: 319px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .contactform-style-3 .main-salebanner {
        background-color: {{$config['popup_color']}};
        overflow: hidden;padding:20px 10px 10px 10px;
    }
    .contactform-style-3 .widgetTitle {
        margin-bottom: 8px;
        line-height: 24px;
        color: {{$config['title1_color']}};
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
        color:{{$config['content_color']}};
    }

    .contactform-style-3 .form-control {
        background: #fff;
        border: none;
        padding: 10px 20px;
        width: 100%;
        border-radius: 5px;
    }
    .contactform-style-3 .widgetButton {
        font-size: 14px;
        border-radius: 5px;
        color: {{$config['btn_color']}};
        background-color: {{$config['btn_bg']}};
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