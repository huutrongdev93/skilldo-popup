<div class="js_popup_contact_form contactform-style-2 widgetBackgroundImage">
    <div class="js_popup_contactform__form main-salebanner formStep1">
        <input type="hidden" name="style" value="style2">
        <div class="widgetTitle">
            {{$config['title1']}}
        </div>
        <div class="widgetDescription">
            {{$config['content']}}
        </div>
        @if(!empty($form) && $form instanceof \SkillDo\Cms\Form\Form)
            {!! $form->open() !!}
            {!! $form->html() !!}
            <button type="submit" class="btn banner-button widgetButton className">{{ $config['btn_txt'] }}</button>
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
    .contactform-style-2 {
        width: 100%;
        min-height: 350px;
        background: url('{!!Template::imgLink($config['popup_bg'])!!}') center right no-repeat;
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
    .contactform-style-2 .widgetDescription {
        font-size: 1.3rem;
        text-align: left;
        font-weight: 400;
        margin: 0 0 20px;
        width: 100%;
        color:{{$config['content_color']}};
    }
    .contactform-style-2 .form-control {
        background: #fff;
        border: none;
        padding: 10px 20px;
        width: 100%;
        border-radius: 5px;
        margin-right: 10px;
    }
    .contactform-style-2 .widgetButton {
        font-size: 14px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        color: {{$config['btn_color']}};
        background-color: {{$config['btn_bg']}};
        padding: 10px 42px;
        display: block;
        width: 100%;
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