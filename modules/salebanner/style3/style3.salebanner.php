<?php
function popup_salebanner_style3_register($style) {
    $style['popup_salebanner_style3'] = ['label' => 'Style 2'];
    return $style;
}

add_filter('popup_salebanner_style', 'popup_salebanner_style3_register');

class popup_salebanner_style3 {
    static public function admin_demo() {
        Template::img(Url::base(Path::plugin( POPUP_NAME ).'/assets/images/salebanner/demo-style3.png'));
    }
    static public function admin_config($key = '') {
        $config = static::config();
        include_once 'popup-admin-config.php';
    }
    static public function config($key = '') {
        $config = option::get('popup_salebanner_config');
        if(!have_posts($config)) $config = [];
        if(!isset($config['style3_title1'])) $config['style3_title1'] = 'ƯU ĐÃI LỚN';
        if(!isset($config['style3_title1_color'])) $config['style3_title1_color'] = '#fff';
        if(!isset($config['style3_title2'])) $config['style3_title2'] = 'SALE';
        if(!isset($config['style3_title2_color'])) $config['style3_title2_color'] = '#fff';
        if(!isset($config['style3_title3'])) $config['style3_title3'] = 'GIẢM NGAY 70%';
        if(!isset($config['style3_title3_color'])) $config['style3_title3_color'] = '#fff';
        if(!isset($config['style3_content'])) $config['style3_content'] = 'Tặng ngay món quà đặc biệt cho các khách hàng mua đơn hàng có giá trị từ 500.000đ';
        if(!isset($config['style3_content_color'])) $config['style3_content_color'] = '#fff';
        if(!isset($config['style3_btn_txt'])) $config['style3_btn_txt'] = 'Xem ngay';
        if(!isset($config['style3_btn_color'])) $config['style3_btn_color'] = '#000';
        if(!isset($config['style3_btn_bg'])) $config['style3_btn_bg'] = 'yellow';
        if(!isset($config['style3_btn_url'])) $config['style3_btn_url'] = base_url();
        if(!isset($config['style3_popup_bg'])) $config['style3_popup_bg'] = 'http://cdn.sikido.vn/images/popup/salebanner-3.jpg';
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
        $config['style3_title2']       = Request::Post('style3_title2');
        $config['style3_title2_color'] = Request::Post('style3_title2_color');
        $config['style3_title3']       = Request::Post('style3_title3');
        $config['style3_title3_color'] = Request::Post('style3_title3_color');
        $config['style3_content']      = Request::Post('style3_content');
        $config['style3_content_color']= Request::Post('style3_content_color');
        $config['style3_btn_txt']      = Request::Post('style3_btn_txt');
        $config['style3_btn_color']    = Request::Post('style3_btn_color');
        $config['style3_btn_bg']       = Request::Post('style3_btn_bg');
        $config['style3_btn_url']      = Request::Post('style3_btn_url');
        $config['style3_popup_bg']     = FileHandler::handlingUrl(Request::Post('style3_popup_bg'));
        if(Language::hasMulti()) {
            foreach (Language::list() as $key => $lang) {
                if($key == Language::default()) continue;
                $config['style3_title1_'.$key]     = Request::Post('style3_title1_'.$key);
                $config['style3_title2_'.$key]     = Request::Post('style3_title2_'.$key);
                $config['style3_title3_'.$key]     = Request::Post('style3_title3_'.$key);
                $config['style3_content_'.$key]    = Request::Post('style3_content_'.$key);
                $config['style3_btn_txt_'.$key]    = Request::Post('style3_btn_txt_'.$key);
            }
        }
        Option::update('popup_salebanner_config', $config);
        return ['status' => 'success', 'message' => 'Lưu dữ liệu thành công.'];
    }

    static public function render() {
        $config = static::config();
        $language_current = Language::current();
        if (Language::default() != $language_current) {
            $config['style3_title1'] = (!empty($config['style3_title1_' . $language_current])) ? $config['style3_title1_' . $language_current] : $config['style3_title1'];
            $config['style3_title2'] = (!empty($config['style3_title2_' . $language_current])) ? $config['style3_title2_' . $language_current] : $config['style3_title2'];
            $config['style3_title3'] = (!empty($config['style3_title3_' . $language_current])) ? $config['style3_title3_' . $language_current] : $config['style3_title3'];
            $config['style3_content'] = (!empty($config['style3_content_' . $language_current])) ? $config['style3_content_' . $language_current] : $config['style3_content'];
            $config['style3_btn_txt'] = (!empty($config['style3_btn_txt_' . $language_current])) ? $config['style3_btn_txt_' . $language_current] : $config['style3_btn_txt'];
        }
        include_once 'popup.php';
    }
}