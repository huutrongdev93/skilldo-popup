<div class="js_popup_contactform contactform-style-1">
    <form class="js_popup_contactform__form banner-text formStep1 widgetBgRight">
        <input type="hidden" name="style" value="style1">
        <h1 class="banner-title widgetTitle">{{$config['title1']}}</h1>
        <p class="banner-des widgetDescription widgetDes">{{$config['content']}}</p>
        <?php if(in_array('email', $contactform_input)) {?>
        <div class="banner-input">
            <input type="email" name="email" class="banner-input-object banner-email displayBlock" placeholder="Email của bạn" {{(in_array('email', $contactform_required)) ? 'required' : ''}}>
        </div>
        <?php } ?>
        <?php if(in_array('phone', $contactform_input)) {?>
            <div class="banner-input">
                <input type="text" name="phone" class="banner-input-object banner-phone displayBlock" placeholder="Số điện thoại" {{(in_array('phone', $contactform_required)) ? 'required' : ''}}>>
            </div>
        <?php } ?>
        <?php if(in_array('note', $contactform_input)) {?>
            <div class="banner-input">
                <textarea name="note" class="banner-input-object banner-note displayBlock" rows="3" {{(in_array('note', $contactform_required)) ? 'required' : ''}}></textarea>
            </div>
        <?php } ?>
        <button type="submit" class="banner-button widgetButton className">{{$config['btn_txt']}}</button>
    </form>
    <div class="js_popup_contactform__success formStep2 hiddenAll">
        <div class="success-check animated bounce">
            <img class="images-check" src="https://themes.trazk.com/004/contactform/master/images/other-icon/success-check.png" alt="">
        </div>
        <p class="thanks">Cảm ơn bạn đã để lại thông tin</p>
    </div>
    <div class="banner-images-3 widgetBackgroundImage"></div>
</div>

<style>
    .contactform-style-1 {
        min-height: 320px;
        width: 100%;
        margin: auto;
        background-size: cover;
        position: relative;
        display: flex;
        border-radius: 5px;
        background-color: #fff;
    }
    .contactform-style-1 .banner-text {
        width: 60%;
        padding: 1.5rem;
        background-repeat: no-repeat;
        background-color: rgb(255, 255, 255);
        background-size: cover;
        background-position: left center;
    }
    .contactform-style-1 .banner-title {
        line-height: 24px;
        color: {{$config['title1_color']}};
        font-weight: 700;
        text-align: center;
        width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        -webkit-line-clamp: 2;
        height: 50px;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        font-size: 22px;
        background-color: transparent;
    }
    .contactform-style-1 .banner-des {
        font-size: 1.3rem;
        text-align: left;
        font-weight: 400;
        margin: 0 0 20px;
        width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        -webkit-line-clamp: 2;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        color:{{$config['content_color']}};
    }
    .contactform-style-1 .banner-input {
        position: relative;
        display: flex;
        flex-wrap: wrap;
    }
    .contactform-style-1 .banner-input-object {
        background: #eee;
        padding: 10px;
        display: block;
        font-size: 16px;
        width: 100%;
        text-align: center;
        font-weight: 600;
        outline: none;
        border: 1px solid #eee;
        margin-bottom: 10px;
    }
    .contactform-style-1 .banner-button {
        font-size: 17.3px;
        font-weight: 600;
        padding: 10px 42px;
        margin-top: 7px;
        border: none;
        color: {{$config['btn_color']}};
        width: 100%;
        cursor: pointer;
        background-color: {{$config['btn_bg']}};
    }
    .contactform-style-1 .js_popup_contactform__success {
        width: 60%;
        margin: 1.5rem;
        justify-content: center;
        text-align: center;
        display: none;
    }
    .contactform-style-1 .js_popup_contactform__success .thanks { color: #333; padding: 20px 0 40px 0; }
    .contactform-style-1 .js_popup_contactform__success .images-check {
        height: 110px;
        padding-top: 40px;
    }
    .contactform-style-1 .banner-images-3 {
        position: relative;
        right: 0;
        height: 100%;min-height: 320px;
        bottom: auto;
        top: 0;
        width: 40%;
        left: auto;
        background: #222;
        display: inline-block;
        background: url('{!!Template::imgLink($config['popup_bg'])!!}') center right no-repeat;
        background-size: cover;
    }
    .contactform-style-1.success .js_popup_contactform__form {
        display: none;
    }
    .contactform-style-1.success .js_popup_contactform__success {
        display: block;
    }
    @media(max-width: 600px) {
        .contactform-style-1 { display: block; }
        .contactform-style-1 .banner-text { width: 100%;}
        .contactform-style-1 .banner-des { height: auto; }
        .contactform-style-1 .banner-images-3 { width: 100%;}
    }
</style>