<?php
function popup_contactform_style5_register($style) {
    $style['popup_contactform_style5'] = ['label' => 'Style 1'];
    return $style;
}
add_filter('popup_contactform_style', 'popup_contactform_style5_register');

class popup_contactform_style5 {
    static public function admin_demo() {
        Template::img(Url::base(Path::plugin( POPUP_NAME ).'/assets/images/contactform/demo-style5.png'));
    }
    static public function admin_config($key = '') {
        $config = static::config();
        include_once 'popup-admin-config.php';
    }
    static public function config($key = '') {
        $config = option::get('popup_contactform_config');
        if(!have_posts($config)) $config = [];
        if(!isset($config['style5_title1'])) $config['style5_title1'] = 'Tiết kiệm đến';
        if(!isset($config['style5_title1_color'])) $config['style5_title1_color'] = '#000';
        if(!isset($config['style5_title2'])) $config['style5_title2'] = '30%';
        if(!isset($config['style5_title2_color'])) $config['style5_title2_color'] = '#EF4B4B';
        if(!isset($config['style5_content'])) $config['style5_content'] = 'cho phiếu thanh toán lần sau của bạn';
        if(!isset($config['style5_content_color'])) $config['style5_content_color'] = '#000';
        if(!isset($config['style5_btn_txt'])) $config['style5_btn_txt'] = 'Nhận mã ngay';
        if(!isset($config['style5_btn_color'])) $config['style5_btn_color'] = '#fff';
        if(!isset($config['style5_btn_bg'])) $config['style5_btn_bg'] = '#EF4B4B';
        if(!empty($key)) {
            if(isset($config[$key])) return $config[$key];
            return '';
        }
        return $config;
    }
    static public function admin_config_save($result) {
        $config = static::config();
        $config['style5_title1']       = Request::Post('style5_title1');
        $config['style5_title1_color'] = Request::Post('style5_title1_color');
        $config['style5_title2']       = Request::Post('style5_title2');
        $config['style5_title2_color'] = Request::Post('style5_title2_color');
        $config['style5_content']      = Request::Post('style5_content');
        $config['style5_content_color']= Request::Post('style5_content_color');
        $config['style5_btn_txt']      = Request::Post('style5_btn_txt');
        $config['style5_btn_color']    = Request::Post('style5_btn_color');
        $config['style5_btn_bg']       = Request::Post('style5_btn_bg');
        if(Language::hasMulti()) {
            foreach (Language::list() as $key => $lang) {
                if($key == Language::default()) continue;
                $config['style5_title1_'.$key]     = Request::Post('style5_title1_'.$key);
                $config['style5_title2_'.$key]     = Request::Post('style5_title2_'.$key);
                $config['style5_content_'.$key]    = Request::Post('style5_content_'.$key);
                $config['style5_btn_txt_'.$key]    = Request::Post('style5_btn_txt_'.$key);
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
            $config['style5_title1'] = (!empty($config['style5_title1_'.$language_current])) ? $config['style5_title1_'.$language_current] : $config['style5_title1'];
            $config['style5_title2'] = (!empty($config['style5_title2_'.$language_current])) ? $config['style5_title2_'.$language_current] : $config['style5_title2'];
            $config['style5_content'] = (!empty($config['style5_content_'.$language_current])) ? $config['style5_content_'.$language_current] : $config['style5_content'];
            $config['style5_btn_txt'] = (!empty($config['style5_btn_txt_'.$language_current])) ? $config['style5_btn_txt_'.$language_current] : $config['style5_btn_txt'];
        }
        include_once 'popup.php';
    }
}