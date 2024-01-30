<?php
Class PopupAdmin {
    static function register($tabs) {
        $tabs['popup'] = [
            'label' => 'Popup Quảng Cáo',
            'description' => 'Quản lý popup quảng cáo, khuyến mãi',
            'callback' => 'PopupAdmin::render',
            'icon' => '<i class="fad fa-mailbox"></i>',
        ];
        return $tabs;
    }
    static function render(): void {

        $view = Request::get('view');

        if(empty($view)) $view = 'general';

        $tabs = popup::tool();

        Plugin::partial(POPUP_NAME, 'admin/views/tabs', ['view' => $view, 'tabs' => $tabs]);

        call_user_func($tabs[$view]['callback'], $tabs[$view], $view);
    }
    static function general() {
        Plugin::partial(POPUP_NAME, 'admin/views/popup-general');
    }
    static function save($result) {

        $module = trim(Request::post('key'));

        if($module == 'general') {
            $config = [
                'active'        => Request::post('active'),
                'show'          => Request::post('show'),
                'loop'          => Request::post('loop'),
                'time_delay'    => (int)Request::post('time_delay'),
                'time_loop'     => (int)Request::post('time_loop'),
                'contactform_input'     => Request::post('contactform_input'),
                'contactform_required'  => Request::post('contactform_required'),
            ];
            Option::update('popup_config', $config);

            $result['status']  = 'success';

            $result['message'] = __('Lưu dữ liệu thành công');
        }
        else if($module == 'default') {

            $result = popup_default::admin_config_save($result);
        }
        else {

            if(method_exists('popup_'.$module, 'admin_config_save')) {

                $module = 'popup_'.$module;

                $result = $module::admin_config_save($result);
            }
        }

        return $result;
    }
}

add_filter('skd_system_tab', 'PopupAdmin::register', 50);

add_filter('system_popup_save', 'PopupAdmin::save', 50);
