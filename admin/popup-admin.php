<?php
Class PopupAdmin {
    static function register($tabs) {
        $tabs['popup'] = [
            'group' => 'marketing',
            'label' => 'Popup Quảng Cáo',
            'description' => 'Quản lý popup quảng cáo, khuyến mãi',
            'callback' => 'PopupAdmin::render',
            'icon' => '<i class="fad fa-mailbox"></i>',
        ];
        return $tabs;
    }
    static function render(\SkillDo\Http\Request $request): void {

        $view = $request->input('view');

        if(empty($view)) $view = 'general';

        $tabs = Popup::tool();

        Plugin::view(POPUP_NAME, 'admin/views/tabs', ['view' => $view, 'tabs' => $tabs]);

        call_user_func($tabs[$view]['callback'], $tabs[$view], $view);
    }
    static function general(): void
    {
        Plugin::view(POPUP_NAME, 'admin/views/popup-general');
    }
    static function save(\SkillDo\Http\Request $request): void {

        $module = $request->input('key');

        if($module == 'general') {
            $config = [
                'active'        => $request->input('active'),
                'show'          => $request->input('show'),
                'loop'          => $request->input('loop'),
                'time_delay'    => (int)$request->input('time_delay'),
                'time_loop'     => (int)$request->input('time_loop'),
                'contactform_input'     => $request->input('contactform_input'),
                'contactform_required'  => $request->input('contactform_required'),
            ];

            Option::update('popup_config', $config);

        }
        else if($module == 'default') {

            popup_default::admin_config_save($request);
        }
        else {

            if(method_exists('popup_'.$module, 'admin_config_save')) {

                $module = 'popup_'.$module;

                $module::admin_config_save($request);
            }
        }
    }
}

add_filter('skd_system_tab', 'PopupAdmin::register', 50);

add_filter('admin_system_popup_save', 'PopupAdmin::save', 50);
