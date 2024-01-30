<?php
function popup_contactform_style3_register($style) {
    $style['popup_contactform_style3'] = ['label' => 'Style 1'];
    return $style;
}
add_filter('popup_contactform_style', 'popup_contactform_style3_register');

class popup_contactform_style3 {
    static public function admin_demo() {
        Template::img(Url::base(Path::plugin( POPUP_NAME ).'/assets/images/contactform/demo-style3.png'));
    }
    static public function admin_config($key = '') {
        $config = static::config();
        include_once 'popup-admin-config.php';
    }
    static public function config($key = '') {
        $config = option::get('popup_contactform_config');
        if(!have_posts($config)) $config = [];
        if(!isset($config['style3_title1'])) $config['style3_title1'] = 'Đăng ký theo dõi';
        if(!isset($config['style3_title1_color'])) $config['style3_title1_color'] = '#fff';
        if(!isset($config['style3_content'])) $config['style3_content'] = 'Nhận ngay thông tin nóng';
        if(!isset($config['style3_content_color'])) $config['style3_content_color'] = '#fff';
        if(!isset($config['style3_btn_txt'])) $config['style3_btn_txt'] = 'Nhận mã ngay';
        if(!isset($config['style3_btn_color'])) $config['style3_btn_color'] = '#fff';
        if(!isset($config['style3_btn_bg'])) $config['style3_btn_bg'] = 'rgb(214, 97, 97)';
        if(!isset($config['style3_popup_bg'])) $config['style3_popup_bg'] = 'http://cdn.sikido.vn/images/popup/contactform-3.png';
        if(!isset($config['style3_popup_color'])) $config['style3_popup_color'] = '#90BB25';
        if(!empty($key)) {
            if(isset($config[$key])) return $config[$key];
            return '';
        }
        return $config;
    }
    static public function admin_config_save($result) {
        $config = static::config();
        $config['style3_title1']       = Request::Post('style3_title1');
        $config['style3_title1_color'] = Request::Post('style3_title1_color');
        $config['style3_content']      = Request::Post('style3_content');
        $config['style3_content_color']= Request::Post('style3_content_color');
        $config['style3_btn_txt']      = Request::Post('style3_btn_txt');
        $config['style3_btn_color']    = Request::Post('style3_btn_color');
        $config['style3_btn_bg']       = Request::Post('style3_btn_bg');
        $config['style3_popup_bg']     = FileHandler::handlingUrl(Request::Post('style3_popup_bg'));
        $config['style3_popup_color']  = Request::Post('style3_popup_color');
        if(Language::hasMulti()) {
            foreach (Language::list() as $key => $lang) {
                if($key == Language::default()) continue;
                $config['style3_title1_'.$key]     = Request::Post('style3_title1_'.$key);
                $config['style3_content_'.$key]    = Request::Post('style3_content_'.$key);
                $config['style3_btn_txt_'.$key]    = Request::Post('style3_btn_txt_'.$key);
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
            $config['style3_title1'] = (!empty($config['style3_title1_'.$language_current])) ? $config['style3_title1_'.$language_current] : $config['style3_title1'];
            $config['style3_content'] = (!empty($config['style3_content_'.$language_current])) ? $config['style3_content_'.$language_current] : $config['style3_content'];
            $config['style3_btn_txt'] = (!empty($config['style3_btn_txt_'.$language_current])) ? $config['style3_btn_txt_'.$language_current] : $config['style3_btn_txt'];
        }
        include_once 'popup.php';
    }
}