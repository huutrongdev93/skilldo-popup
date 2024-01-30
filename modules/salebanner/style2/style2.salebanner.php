<?php
function popup_salebanner_style2_register($style) {
    $style['popup_salebanner_style2'] = ['label' => 'Style 2'];
    return $style;
}
add_filter('popup_salebanner_style', 'popup_salebanner_style2_register');

class popup_salebanner_style2 {
    static public function admin_demo() {
        Template::img(Url::base(Path::plugin( POPUP_NAME ).'/assets/images/salebanner/demo-style2.png'));
    }
    static public function admin_config($key = '') {
        $config = static::config();
        include_once 'popup-admin-config.php';
    }
    static public function config($key = '') {
        $config = option::get('popup_salebanner_config');
        if(!have_posts($config)) $config = [];
        if(!isset($config['style2_title'])) $config['style2_title'] = 'Bộ Sưu Tập Mới '.date('Y');
        if(!isset($config['style2_title_color'])) $config['style2_title_color'] = '#fff';
        if(!isset($config['style2_content'])) $config['style2_content'] = 'Thiết kế mới kết hợp giữa sneaker và giày thể thao mang đến mẫu giày đáng mong đợi trong năm nay';
        if(!isset($config['style2_content_color'])) $config['style2_content_color'] = '#fff';
        if(!isset($config['style2_btn_txt'])) $config['style2_btn_txt'] = 'Xem ngay';
        if(!isset($config['style2_btn_color'])) $config['style2_btn_color'] = '#000';
        if(!isset($config['style2_btn_bg'])) $config['style2_btn_bg'] = 'yellow';
        if(!isset($config['style2_btn_url'])) $config['style2_btn_url'] = base_url();
        if(!isset($config['style2_popup_color'])) $config['style2_popup_color'] = '#000';
        if(!isset($config['style2_popup_bg'])) $config['style2_popup_bg'] = 'http://cdn.sikido.vn/images/popup/salebanner-2.jpeg';
        if(!empty($key)) {
            if(isset($config[$key])) return $config[$key];
            return '';
        }
        return $config;
    }
    static public function admin_config_save($result) {
        $config = static::config();
        $config['style2_title']       = Request::Post('style2_title');
        $config['style2_title_color']  = Request::Post('style2_title_color');
        $config['style2_content']      = Request::Post('style2_content');
        $config['style2_btn_txt']      = Request::Post('style2_btn_txt');
        $config['style2_btn_color']    = Request::Post('style2_btn_color');
        $config['style2_btn_bg']       = Request::Post('style2_btn_bg');
        $config['style2_btn_url']      = Request::Post('style2_btn_url');
        $config['style2_popup_color']  = Request::Post('style2_popup_color');
        $config['style2_popup_bg']     = FileHandler::handlingUrl(Request::Post('style2_popup_bg'));
        if(Language::hasMulti()) {
            foreach (Language::list() as $key => $lang) {
                if($key == Language::default()) continue;
                $config['style2_title_'.$key]     = Request::Post('style2_title_'.$key);
                $config['style2_content_'.$key]    = Request::Post('style2_content_'.$key);
                $config['style2_btn_txt_'.$key]    = Request::Post('style2_btn_txt_'.$key);
            }
        }
        Option::update('popup_salebanner_config', $config);
        return ['status' => 'success', 'message' => 'Lưu dữ liệu thành công.'];
    }
    static public function render() {
        $config = static::config();
        $language_current = Language::current();
        if(Language::default() != $language_current) {
            $config['style2_title'] = (!empty($config['style2_title_'.$language_current])) ? $config['style2_title_'.$language_current] : $config['style2_title'];
            $config['style2_content'] = (!empty($config['style2_content_'.$language_current])) ? $config['style2_content_'.$language_current] : $config['style2_content'];
            $config['style2_btn_txt'] = (!empty($config['style2_btn_txt_'.$language_current])) ? $config['style2_btn_txt_'.$language_current] : $config['style2_btn_txt'];
        }
        include_once 'popup.php';
    }
}