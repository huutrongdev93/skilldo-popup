<?php
Ajax::admin('Popup\Ajax\Admin\PopupAjax::config');
Ajax::admin('Popup\Ajax\Admin\PopupAjax::applyPreset');

/*
| Form trong popup do KHÁCH VÃNG LAI gửi -> phải đăng ký ở nhóm client.
|
| Trước đây `submit` đăng ký bằng Ajax::admin: AjaxController chỉ tra nhóm admin khi
| người gửi đã đăng nhập và có quyền `loggin_admin`, nên mọi lượt đăng ký của khách
| đều rơi vào "ajax action not found".
*/
Ajax::client('Popup\Ajax\Web\PopupAjax::submit');
Ajax::client('Popup\Ajax\Web\PopupAjax::submitBuilder');
