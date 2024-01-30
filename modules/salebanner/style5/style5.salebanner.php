<?php
function popup_salebanner_style5_register($style) {
    $style['popup_salebanner_style5'] = ['label' => 'Style 5'];
    return $style;
}
add_filter('popup_salebanner_style', 'popup_salebanner_style5_register');

class popup_salebanner_style5 {
    static public function admin_demo() {
        Template::img(Url::base(Path::plugin( POPUP_NAME ).'/assets/images/salebanner/demo-style5.png'));
    }
    static public function admin_config($key = '') {
        $config = static::config();
        include_once 'popup-admin-config.php';
    }
    static public function config($key = '') {
        $config = option::get('popup_salebanner_config');
        if (!have_posts($config)) $config = [];
        if (!isset($config['style5_title1'])) $config['style5_title1'] = 'Valentine\'s Day';
        if (!isset($config['style5_title1_color'])) $config['style5_title1_color'] = '#FC0E56';
        if (!isset($config['style5_title2'])) $config['style5_title2'] = 'SALE';
        if (!isset($config['style5_title2_color'])) $config['style5_title2_color'] = '#FC0E56';
        if (!isset($config['style5_content'])) $config['style5_content'] = 'Giảm 60% tất cả sản phẩm';
        if (!isset($config['style5_content_color'])) $config['style5_content_color'] = '#FC0E56';
        if (!isset($config['style5_btn_txt'])) $config['style5_btn_txt'] = 'Xem ngay';
        if (!isset($config['style5_btn_color'])) $config['style5_btn_color'] = '#fff';
        if (!isset($config['style5_btn_bg'])) $config['style5_btn_bg'] = '#FC0E56';
        if (!isset($config['style5_btn_url'])) $config['style5_btn_url'] = base_url();
        if (!isset($config['style5_popup_bg'])) $config['style5_popup_bg'] = 'http://cdn.sikido.vn/images/popup/salebanner-5.png';
        if (!empty($key)) {
            if (isset($config[$key])) return $config[$key];
            return '';
        }
        return $config;
    }
    static public function admin_config_save($result) {
        $config = static::config();
        $config['style5_title1'] = Request::Post('style5_title1');
        $config['style5_title1_color'] = Request::Post('style5_title1_color');
        $config['style5_title2'] = Request::Post('style5_title2');
        $config['style5_title2_color'] = Request::Post('style5_title2_color');
        $config['style5_content'] = Request::Post('style5_content');
        $config['style5_content_color'] = Request::Post('style5_content_color');
        $config['style5_btn_txt'] = Request::Post('style5_btn_txt');
        $config['style5_btn_color'] = Request::Post('style5_btn_color');
        $config['style5_btn_bg'] = Request::Post('style5_btn_bg');
        $config['style5_btn_url'] = Request::Post('style5_btn_url');
        $config['style5_popup_bg'] = FileHandler::handlingUrl(Request::Post('style5_popup_bg'));
        if (Language::hasMulti()) {
            foreach (Language::list() as $key => $lang) {
                if ($key == Language::default()) continue;
                $config['style5_title1_' . $key] = Request::Post('style5_title1_' . $key);
                $config['style5_title2_' . $key] = Request::Post('style5_title2_' . $key);
                $config['style5_content_' . $key] = Request::Post('style5_content_' . $key);
                $config['style5_btn_txt_' . $key] = Request::Post('style5_btn_txt_' . $key);
            }
        }
        Option::update('popup_salebanner_config', $config);
        return ['status' => 'success', 'message' => 'Lưu dữ liệu thành công.'];
    }

    static public function render() {
        $config = static::config();
        $language_current = Language::current();
        if (Language::default() != $language_current) {
            $config['style5_title1'] = (!empty($config['style5_title1_' . $language_current])) ? $config['style5_title1_' . $language_current] : $config['style5_title1'];
            $config['style5_title2'] = (!empty($config['style5_title2_' . $language_current])) ? $config['style5_title2_' . $language_current] : $config['style5_title2'];
            $config['style5_content'] = (!empty($config['style5_content_' . $language_current])) ? $config['style5_content_' . $language_current] : $config['style5_content'];
            $config['style5_btn_txt'] = (!empty($config['style5_btn_txt_' . $language_current])) ? $config['style5_btn_txt_' . $language_current] : $config['style5_btn_txt'];
        }
        include_once 'popup.php';
    }
}