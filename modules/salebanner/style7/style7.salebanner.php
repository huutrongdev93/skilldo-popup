<?php
function popup_salebanner_style7_register($style) {
    $style['popup_salebanner_style7'] = ['label' => 'Style 5'];
    return $style;
}
add_filter('popup_salebanner_style', 'popup_salebanner_style7_register');

class popup_salebanner_style7 {
    static public function admin_demo() {
        Template::img(Url::base(Path::plugin( POPUP_NAME ).'/assets/images/salebanner/demo-style7.png'));
    }
    static public function admin_config($key = '') {
        $config = static::config();
        include_once 'popup-admin-config.php';
    }
    static public function config($key = '') {
        $config = option::get('popup_salebanner_config');
        if (!have_posts($config)) $config = [];
        if (!isset($config['style7_title1'])) $config['style7_title1'] = 'Về nhà ăn Tết - Sale bằng hết';
        if (!isset($config['style7_title1_color'])) $config['style7_title1_color'] = '#fff';
        if (!isset($config['style7_title2'])) $config['style7_title2'] = 'SALE';
        if (!isset($config['style7_title2_color'])) $config['style7_title2_color'] = '#FFC107';
        if (!isset($config['style7_content'])) $config['style7_content'] = 'Giảm giá lên đến 25% cho sản phẩm & nhiều quà tặng hấp dẫn';
        if (!isset($config['style7_content_color'])) $config['style7_content_color'] = '#fff';
        if (!isset($config['style7_btn_txt'])) $config['style7_btn_txt'] = 'Xem ngay';
        if (!isset($config['style7_btn_color'])) $config['style7_btn_color'] = '#FFC107';
        if (!isset($config['style7_btn_bg'])) $config['style7_btn_bg'] = '#FC0E56';
        if (!isset($config['style7_btn_url'])) $config['style7_btn_url'] = base_url();
        if (!isset($config['style7_popup_bg'])) $config['style7_popup_bg'] = 'http://cdn.sikido.vn/images/popup/salebanner-7.png';
        if (!empty($key)) {
            if (isset($config[$key])) return $config[$key];
            return '';
        }
        return $config;
    }
    static public function admin_config_save($result) {
        $config = static::config();
        $config['style7_title1'] = Request::Post('style7_title1');
        $config['style7_title1_color'] = Request::Post('style7_title1_color');
        $config['style7_title2'] = Request::Post('style7_title2');
        $config['style7_title2_color'] = Request::Post('style7_title2_color');
        $config['style7_content'] = Request::Post('style7_content');
        $config['style7_content_color'] = Request::Post('style7_content_color');
        $config['style7_btn_txt'] = Request::Post('style7_btn_txt');
        $config['style7_btn_color'] = Request::Post('style7_btn_color');
        $config['style7_btn_bg'] = Request::Post('style7_btn_bg');
        $config['style7_btn_url'] = Request::Post('style7_btn_url');
        $config['style7_popup_bg'] = FileHandler::handlingUrl(Request::Post('style7_popup_bg'));
        if (Language::hasMulti()) {
            foreach (Language::list() as $key => $lang) {
                if ($key == Language::default()) continue;
                $config['style7_title1_' . $key] = Request::Post('style7_title1_' . $key);
                $config['style7_title2_' . $key] = Request::Post('style7_title2_' . $key);
                $config['style7_content_' . $key] = Request::Post('style7_content_' . $key);
                $config['style7_btn_txt_' . $key] = Request::Post('style7_btn_txt_' . $key);
            }
        }
        Option::update('popup_salebanner_config', $config);
        return ['status' => 'success', 'message' => 'Lưu dữ liệu thành công.'];
    }

    static public function render() {
        $config = static::config();
        $language_current = Language::current();
        if (Language::default() != $language_current) {
            $config['style7_title1'] = (!empty($config['style7_title1_' . $language_current])) ? $config['style7_title1_' . $language_current] : $config['style7_title1'];
            $config['style7_title2'] = (!empty($config['style7_title2_' . $language_current])) ? $config['style7_title2_' . $language_current] : $config['style7_title2'];
            $config['style7_content'] = (!empty($config['style7_content_' . $language_current])) ? $config['style7_content_' . $language_current] : $config['style7_content'];
            $config['style7_btn_txt'] = (!empty($config['style7_btn_txt_' . $language_current])) ? $config['style7_btn_txt_' . $language_current] : $config['style7_btn_txt'];
        }
        include_once 'popup.php';
    }
}