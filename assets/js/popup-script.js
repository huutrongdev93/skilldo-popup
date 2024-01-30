$(function () {
    const popupCookieTypeName = 'popup_cookie_type';
    const popupCookieTimeName = 'popup_cookie_time';
    const popupID = '#modal-popup-alert';

    function popup_reset() {

        let popupTypeOld = getCookie(popupCookieTypeName);

        if(popupTypeOld !== popupType) {
            document.cookie = popupCookieTimeName +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
            document.cookie = popupCookieTypeName +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
            setCookie(popupCookieTypeName, popupType, 365*24*60*60);
        }
    }

    function popup_render() {

        popup_reset();

        console.log('model');

        if(getCookie(popupCookieTimeName) === '') {
            if(popupTimeDelay !== 0) {
                setTimeout( function () {
                    $(popupID).modal('show');
                }, popupTimeDelay*1000);
            }
            else {
                $(popupID).modal('show');
            }
        }

        if(popupType === 'loop') {
            if(getCookie(popupCookieTimeName) === '') {
                let d = new Date();
                d.setTime(d.getTime() + (popupTimeLoop *60*1000));
                let expires = "expires=" + d.toUTCString();
                document.cookie = popupCookieTimeName + "=" + popupTimeLoop + ";" + expires + ";path=/";
            }
        }

        if(popupType === 'only') {
            setCookie(popupCookieTimeName, popupType, 365*24*60*60);
        }
    }

    popup_render();

    setInterval(popup_render, 1000);

    $('.js_popup_contactform__form').submit(function () {
        let popup   = $(this).closest('.js_popup_contactform');
        let data    = $(this).serializeJSON();
        data.action = 'popup_ajax_contactform_submit';
        $jqxhr = $.post(ajax, data, function () { }, 'json').done(function (response) {
            show_message(response.message, response.status);
            if (response.status === 'success') {
                popup.addClass('success')
            }
        });
        $jqxhr.fail(function (response) {});
        $jqxhr.always(function (response) { });
        return false;
    });
});