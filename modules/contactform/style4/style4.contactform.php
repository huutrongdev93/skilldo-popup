<?php
function popup_contactform_style4_register($style) {
    $style['popup_contactform_style4'] = ['label' => 'Style 1'];
    return $style;
}
add_filter('popup_contactform_style', 'popup_contactform_style4_register');

class popup_contactform_style4 {
    static public function admin_demo() {
        Template::img(Url::base(Path::plugin( POPUP_NAME ).'/assets/images/contactform/demo-style4.png'));
    }
    static public function admin_config($key = '') {
        $config = static::config();
        include_once 'popup-admin-config.php';
    }
    static public function config($key = '') {
        $config = option::get('popup_contactform_config');
        if(!have_posts($config)) $config = [];
        if(!isset($config['style4_title1'])) $config['style4_title1'] = 'Apple Watch Thế Hệ Mới Nhất 40mm';
        if(!isset($config['style4_title1_color'])) $config['style4_title1_color'] = '#fff';
        if(!isset($config['style4_content'])) $config['style4_content'] = 'Đồng hồ thông minh là một sản phẩm công nghệ được nhiều người ưa chuộng bởi sự tiện lợi và hữu ích mà thiết bị mang lại.';
        if(!isset($config['style4_content_color'])) $config['style4_content_color'] = '#fff';
        if(!isset($config['style4_btn_txt'])) $config['style4_btn_txt'] = 'Nhận mã ngay';
        if(!isset($config['style4_btn_color'])) $config['style4_btn_color'] = '#fff';
        if(!isset($config['style4_btn_bg'])) $config['style4_btn_bg'] = 'rgb(214, 97, 97)';
        if(!isset($config['style4_popup_bg'])) $config['style4_popup_bg'] = 'http://cdn.sikido.vn/images/popup/contactform-4-1.png';
        if(!isset($config['style4_popup_sp'])) $config['style4_popup_sp'] = 'http://cdn.sikido.vn/images/popup/contactform-4-2.png';
        if(!empty($key)) {
            if(isset($config[$key])) return $config[$key];
            return '';
        }
        return $config;
    }
    static public function admin_config_save($result) {
        $config = static::config();
        $config['style4_title1']       = Request::Post('style4_title1');
        $config['style4_title1_color'] = Request::Post('style4_title1_color');
        $config['style4_content']      = Request::Post('style4_content');
        $config['style4_content_color']= Request::Post('style4_content_color');
        $config['style4_btn_txt']      = Request::Post('style4_btn_txt');
        $config['style4_btn_color']    = Request::Post('style4_btn_color');
        $config['style4_btn_bg']       = Request::Post('style4_btn_bg');
        $config['style4_popup_bg']     = FileHandler::handlingUrl(Request::Post('style4_popup_bg'));
        $config['style4_popup_sp']     = FileHandler::handlingUrl(Request::Post('style4_popup_sp'));
        if(Language::hasMulti()) {
            foreach (Language::list() as $key => $lang) {
                if($key == Language::default()) continue;
                $config['style4_title1_'.$key]     = Request::Post('style4_title1_'.$key);
                $config['style4_content_'.$key]    = Request::Post('style4_content_'.$key);
                $config['style4_btn_txt_'.$key]    = Request::Post('style4_btn_txt_'.$key);
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
            $config['style4_title1'] = (!empty($config['style4_title1_'.$language_current])) ? $config['style4_title1_'.$language_current] : $config['style4_title1'];
            $config['style4_content'] = (!empty($config['style4_content_'.$language_current])) ? $config['style4_content_'.$language_current] : $config['style4_content'];
            $config['style4_btn_txt'] = (!empty($config['style4_btn_txt_'.$language_current])) ? $config['style4_btn_txt_'.$language_current] : $config['style4_btn_txt'];
        }
        include_once 'popup.php';
    }
}