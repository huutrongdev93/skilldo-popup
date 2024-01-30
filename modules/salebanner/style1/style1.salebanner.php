<?php
function popup_salebanner_style1_register($style) {
    $style['popup_salebanner_style1'] = ['label' => 'Style 1'];
    return $style;
}
add_filter('popup_salebanner_style', 'popup_salebanner_style1_register');

class popup_salebanner_style1 {
    static public function admin_demo() {
        Template::img(Url::base(Path::plugin( POPUP_NAME ).'/assets/images/salebanner/demo-style1.png'));
    }
    static public function admin_config($key = '') {
        $config = static::config();
        include_once 'popup-admin-config.php';
    }
    static public function config($key = '') {
        $config = option::get('popup_salebanner_config');
        if(!have_posts($config))            $config = [];
        if(!isset($config['title1']))       $config['title1'] = 'SUMMER';
        if(!isset($config['title1_color'])) $config['title1_color'] = '#fff';
        if(!isset($config['title2']))       $config['title2'] = 'SALE';
        if(!isset($config['title2_color'])) $config['title2_color'] = '#fff';
        if(!isset($config['content']))      $config['content'] = '+ Giảm 50% tất cả sản phẩm &amp; Miễn phí ship cho lần đặt hàng tiếp theo';
        if(!isset($config['content_color'])) $config['content_color'] = '#fff';
        if(!isset($config['btn_txt']))      $config['btn_txt'] = 'Mua ngay';
        if(!isset($config['btn_color']))    $config['btn_color'] = '#fff';
        if(!isset($config['btn_bg']))       $config['btn_bg'] = 'yellow';
        if(!isset($config['btn_url']))      $config['btn_url'] = 'https://sikido.vn';
        if(!isset($config['popup_color']))  $config['popup_color'] = '#000';
        if(!isset($config['popup_bg']))     $config['popup_bg'] = 'http://cdn.sikido.vn/images/popup/salebanner-1.png';
        if(!empty($key)) {
            if(isset($config[$key])) return $config[$key];
            return '';
        }
        return $config;
    }
    static public function admin_config_save($result) {
        $config = static::config();
        $config['title1']           = Request::Post('title1');
        $config['title1_color']     = Request::Post('title1_color');
        $config['title2']           = Request::Post('title2');
        $config['content']          = Request::Post('content');
        $config['content_color']    = Request::Post('content_color');
        $config['btn_txt']          = Request::Post('btn_txt');
        $config['btn_color']        = Request::Post('btn_color');
        $config['btn_bg']           = Request::Post('btn_bg');
        $config['btn_url']          = Request::Post('btn_url');
        $config['popup_color']      = Request::Post('popup_color');
        $config['popup_bg']         = FileHandler::handlingUrl(Request::Post('popup_bg'));
        if(Language::hasMulti()) {
            foreach (Language::list() as $key => $lang) {
                if($key == Language::default()) continue;
                $config['title1_'.$key]     = Request::Post('title1_'.$key);
                $config['title2_'.$key]     = Request::Post('title2_'.$key);
                $config['content_'.$key]    = Request::Post('content_'.$key);
                $config['btn_txt_'.$key]    = Request::Post('btn_txt_'.$key);
            }
        }
        Option::update('popup_salebanner_config', $config);
        return ['status' => 'success', 'message' => 'Lưu dữ liệu thành công.'];
    }
    static public function render() {
        $config = static::config();
        $language_current = Language::current();
        if(Language::default() != $language_current) {
            $config['title1'] = (!empty($config['title1_'.$language_current])) ? $config['title1_'.$language_current] : $config['title1'];
            $config['title2'] = (!empty($config['title2_'.$language_current])) ? $config['title2_'.$language_current] : $config['title2'];
            $config['content'] = (!empty($config['content_'.$language_current])) ? $config['content_'.$language_current] : $config['content'];
            $config['btn_txt'] = (!empty($config['btn_txt_'.$language_current])) ? $config['btn_txt_'.$language_current] : $config['btn_txt'];
        }
        include_once 'popup.php';
    }
}