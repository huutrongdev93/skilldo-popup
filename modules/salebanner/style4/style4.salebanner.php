<?php
function popup_salebanner_style4_register($style) {
    $style['popup_salebanner_style4'] = ['label' => 'Style 2'];
    return $style;
}

add_filter('popup_salebanner_style', 'popup_salebanner_style4_register');

class popup_salebanner_style4 {
    static public function admin_demo() {
        Template::img(Url::base(Path::plugin( POPUP_NAME ).'/assets/images/salebanner/demo-style4.png'));
    }
    static public function admin_config($key = '') {
        $config = static::config();
        include_once 'popup-admin-config.php';
    }
    static public function config($key = '') {
        $config = option::get('popup_salebanner_config');
        if (!have_posts($config)) $config = [];
        if (!isset($config['style4_title1'])) $config['style4_title1'] = 'Dịch vụ trọn gói';
        if (!isset($config['style4_title1_color'])) $config['style4_title1_color'] = 'rgb(140, 138, 139)';
        if (!isset($config['style4_title2'])) $config['style4_title2'] = 'Rộn Ràng Đón Xuân';
        if (!isset($config['style4_title2_color'])) $config['style4_title2_color'] = 'rgb(98, 187, 122)';
        if (!isset($config['style4_content'])) $config['style4_content'] = 'Hưởng ngay ưu đãi liệu trình massage thư giãn với tinh dầu thảo mộc';
        if (!isset($config['style4_content_color'])) $config['style4_content_color'] = 'rgb(140, 138, 139)';
        if (!isset($config['style4_price'])) $config['style4_price'] = '399k';
        if (!isset($config['style4_btn_txt'])) $config['style4_btn_txt'] = 'Mua ngay';
        if (!isset($config['style4_btn_color'])) $config['style4_btn_color'] = '#000';
        if (!isset($config['style4_btn_bg'])) $config['style4_btn_bg'] = 'yellow';
        if (!isset($config['style4_btn_url'])) $config['style4_btn_url'] = base_url();
        if (!isset($config['style4_popup_bg'])) $config['style4_popup_bg'] = 'http://cdn.sikido.vn/images/popup/salebanner-4.jpg';
        if (!empty($key)) {
            if (isset($config[$key])) return $config[$key];
            return '';
        }
        return $config;
    }
    static public function admin_config_save($result) {
        $config = static::config();
        $config['style4_title1'] = Request::Post('style4_title1');
        $config['style4_title1_color'] = Request::Post('style4_title1_color');
        $config['style4_title2'] = Request::Post('style4_title2');
        $config['style4_title2_color'] = Request::Post('style4_title2_color');
        $config['style4_content'] = Request::Post('style4_content');
        $config['style4_content_color'] = Request::Post('style4_content_color');
        $config['style4_price'] = Request::Post('style4_price');
        $config['style4_btn_txt'] = Request::Post('style4_btn_txt');
        $config['style4_btn_color'] = Request::Post('style4_btn_color');
        $config['style4_btn_bg'] = Request::Post('style4_btn_bg');
        $config['style4_btn_url'] = Request::Post('style4_btn_url');
        $config['style4_popup_bg'] = FileHandler::handlingUrl(Request::Post('style4_popup_bg'));
        if (Language::hasMulti()) {
            foreach (Language::list() as $key => $lang) {
                if ($key == Language::default()) continue;
                $config['style4_title1_' . $key] = Request::Post('style4_title1_' . $key);
                $config['style4_title2_' . $key] = Request::Post('style4_title2_' . $key);
                $config['style4_content_' . $key] = Request::Post('style4_content_' . $key);
                $config['style4_btn_txt_' . $key] = Request::Post('style4_btn_txt_' . $key);
            }
        }
        Option::update('popup_salebanner_config', $config);
        return ['status' => 'success', 'message' => 'Lưu dữ liệu thành công.'];
    }

    static public function render() {
        $config = static::config();
        $language_current = Language::current();
        if (Language::default() != $language_current) {
            $config['style4_title1'] = (!empty($config['style4_title1_' . $language_current])) ? $config['style4_title1_' . $language_current] : $config['style4_title1'];
            $config['style4_title2'] = (!empty($config['style4_title2_' . $language_current])) ? $config['style4_title2_' . $language_current] : $config['style4_title2'];
            $config['style4_content'] = (!empty($config['style4_content_' . $language_current])) ? $config['style4_content_' . $language_current] : $config['style4_content'];
            $config['style4_btn_txt'] = (!empty($config['style4_btn_txt_' . $language_current])) ? $config['style4_btn_txt_' . $language_current] : $config['style4_btn_txt'];
        }
        include_once 'popup.php';
    }
}