<?php
function popup_salebanner_style6_register($style) {
    $style['popup_salebanner_style6'] = ['label' => 'Style 5'];
    return $style;
}
add_filter('popup_salebanner_style', 'popup_salebanner_style6_register');

class popup_salebanner_style6 {
    static public function admin_demo() {
        Template::img(Url::base(Path::plugin( POPUP_NAME ).'/assets/images/salebanner/demo-style6.png'));
    }
    static public function admin_config($key = '') {
        $config = static::config();
        include_once 'popup-admin-config.php';
    }
    static public function config($key = '') {
        $config = option::get('popup_salebanner_config');
        if (!have_posts($config)) $config = [];
        if (!isset($config['style6_title1'])) $config['style6_title1'] = 'TẾT SALE HẾT';
        if (!isset($config['style6_title1_color'])) $config['style6_title1_color'] = 'rgb(255, 0, 0)';
        if (!isset($config['style6_title2'])) $config['style6_title2'] = 'SALE';
        if (!isset($config['style6_title2_color'])) $config['style6_title2_color'] = '#fff';
        if (!isset($config['style6_content'])) $config['style6_content'] = '50%';
        if (!isset($config['style6_content_color'])) $config['style6_content_color'] = '#fff';
        if (!isset($config['style6_btn_txt'])) $config['style6_btn_txt'] = 'Mua sắm ngay';
        if (!isset($config['style6_btn_color'])) $config['style6_btn_color'] = 'rgb(255, 0, 0)';
        if (!isset($config['style6_btn_bg'])) $config['style6_btn_bg'] = '#FFE500';
        if (!isset($config['style6_btn_url'])) $config['style6_btn_url'] = base_url();
        if (!empty($key)) {
            if (isset($config[$key])) return $config[$key];
            return '';
        }
        return $config;
    }
    static public function admin_config_save($result) {
        $config = static::config();
        $config['style6_title1'] = Request::Post('style6_title1');
        $config['style6_title1_color'] = Request::Post('style6_title1_color');
        $config['style6_title2'] = Request::Post('style6_title2');
        $config['style6_title2_color'] = Request::Post('style6_title2_color');
        $config['style6_content'] = Request::Post('style6_content');
        $config['style6_content_color'] = Request::Post('style6_content_color');
        $config['style6_btn_txt'] = Request::Post('style6_btn_txt');
        $config['style6_btn_color'] = Request::Post('style6_btn_color');
        $config['style6_btn_bg'] = Request::Post('style6_btn_bg');
        $config['style6_btn_url'] = Request::Post('style6_btn_url');
        if (Language::hasMulti()) {
            foreach (Language::list() as $key => $lang) {
                if ($key == Language::default()) continue;
                $config['style6_title1_' . $key] = Request::Post('style6_title1_' . $key);
                $config['style6_title2_' . $key] = Request::Post('style6_title2_' . $key);
                $config['style6_content_' . $key] = Request::Post('style6_content_' . $key);
                $config['style6_btn_txt_' . $key] = Request::Post('style6_btn_txt_' . $key);
            }
        }
        Option::update('popup_salebanner_config', $config);
        return ['status' => 'success', 'message' => 'Lưu dữ liệu thành công.'];
    }

    static public function render() {
        $config = static::config();
        $language_current = Language::current();
        if (Language::default() != $language_current) {
            $config['style6_title1'] = (!empty($config['style6_title1_' . $language_current])) ? $config['style6_title1_' . $language_current] : $config['style6_title1'];
            $config['style6_title2'] = (!empty($config['style6_title2_' . $language_current])) ? $config['style6_title2_' . $language_current] : $config['style6_title2'];
            $config['style6_content'] = (!empty($config['style6_content_' . $language_current])) ? $config['style6_content_' . $language_current] : $config['style6_content'];
            $config['style6_btn_txt'] = (!empty($config['style6_btn_txt_' . $language_current])) ? $config['style6_btn_txt_' . $language_current] : $config['style6_btn_txt'];
        }
        include_once 'popup.php';
    }
}