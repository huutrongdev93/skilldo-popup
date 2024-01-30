<?php
function popup_contactform_style2_register($style) {
    $style['popup_contactform_style2'] = ['label' => 'Style 1'];
    return $style;
}
add_filter('popup_contactform_style', 'popup_contactform_style2_register');

class popup_contactform_style2 {
    static public function admin_demo() {
        Template::img(Url::base(Path::plugin( POPUP_NAME ).'/assets/images/contactform/demo-style2.png'));
    }
    static public function admin_config($key = '') {
        $config = static::config();
        include_once 'popup-admin-config.php';
    }
    static public function config($key = '') {
        $config = option::get('popup_contactform_config');
        if(!have_posts($config)) $config = [];
        if(!isset($config['style2_title1'])) $config['style2_title1'] = 'Trợ giúp qua điện thoại';
        if(!isset($config['style2_title1_color'])) $config['style2_title1_color'] = 'rgb(214, 97, 97)';
        if(!isset($config['style2_content'])) $config['style2_content'] = 'Nhận ngay 2.000.000 VNĐ cho dịch vụ Tắm Trắng Phi Thuyền Hồng Ngoại';
        if(!isset($config['style2_content_color'])) $config['style2_content_color'] = 'rgb(34, 34, 34)';
        if(!isset($config['style2_btn_txt'])) $config['style2_btn_txt'] = 'Nhận mã ngay';
        if(!isset($config['style2_btn_color'])) $config['style2_btn_color'] = '#fff';
        if(!isset($config['style2_btn_bg'])) $config['style2_btn_bg'] = 'rgb(214, 97, 97)';
        if(!isset($config['style2_popup_bg'])) $config['style2_popup_bg'] = 'http://cdn.sikido.vn/images/popup/contactform-2.png';
        if(!empty($key)) {
            if(isset($config[$key])) return $config[$key];
            return '';
        }
        return $config;
    }
    static public function admin_config_save($result) {
        $config = static::config();
        $config['style2_title1']       = Request::Post('style2_title1');
        $config['style2_title1_color'] = Request::Post('style2_title1_color');
        $config['style2_content']      = Request::Post('style2_content');
        $config['style2_content_color']= Request::Post('style2_content_color');
        $config['style2_btn_txt']      = Request::Post('style2_btn_txt');
        $config['style2_btn_color']    = Request::Post('style2_btn_color');
        $config['style2_btn_bg']       = Request::Post('style2_btn_bg');
        $config['style2_popup_bg']     = FileHandler::handlingUrl(Request::Post('style2_popup_bg'));
        if(Language::hasMulti()) {
            foreach (Language::list() as $key => $lang) {
                if($key == Language::default()) continue;
                $config['style2_title1_'.$key]     = Request::Post('style2_title1_'.$key);
                $config['style2_content_'.$key]    = Request::Post('style2_content_'.$key);
                $config['style2_btn_txt_'.$key]    = Request::Post('style2_btn_txt_'.$key);
            }
        }
        Option::update('popup_contactform_config', $config);
        return ['status' => 'success', 'message' => 'Lưu dữ liệu thành công.'];
    }
    static public function render() {
        $config = static::config();
        $contactform_input = popup::config('contactform_input');
        $contactform_required = popup::config('contactform_required');
        $language_current = Language::current();
        if(Language::default() != $language_current) {
            $config['style2_title1'] = (!empty($config['style2_title1_'.$language_current])) ? $config['style2_title1_'.$language_current] : $config['style2_title1'];
            $config['style2_content'] = (!empty($config['style2_content_'.$language_current])) ? $config['style2_content_'.$language_current] : $config['style2_content'];
            $config['style2_btn_txt'] = (!empty($config['style2_btn_txt_'.$language_current])) ? $config['style2_btn_txt_'.$language_current] : $config['style2_btn_txt'];
        }
        include_once 'popup.php';
    }
}