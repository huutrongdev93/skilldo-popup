<?php
function admin_page_popup_default() {
    $form = new Form();
    $form->add('popup_alert_title', 'textBuilding', ['label' => 'Tiêu đề', 'start' => 10], popup_default::config('title'));
    $form->add('popup_alert_title_color', 'color', ['label' => 'Màu tiêu đề', 'start' => 2], popup_default::config('title_color'));
    $form->add('popup_alert_background_image', 'image', ['label' => 'Hình nền popup', 'start' => 4], popup_default::config('background_image'));
    $form->add('popup_alert_background_color', 'color', ['label' => 'Màu nền popup', 'start' => 2], popup_default::config('background_color'));
    $form->add('popup_alert_padding_top_bottom', 'number', [
        'label' => 'Khoảng trống (Trên và dưới)', 'start' => 3,
        'note' => 'Khoảng trống nằm giữa nội dung và viền'
    ], popup_default::config('padding_top_bottom'));
    $form->add('popup_alert_padding_left_right', 'number', [
        'label' => 'Khoảng trống (Trái và phải)', 'start' => 3,
        'note' => 'Khoảng trống nằm giữa nội dung và viền'
    ], popup_default::config('padding_left_right'));
    $form->add('popup_alert_description', 'wysiwyg', [
        'label' => 'Nội dung popup', 'start' => 12,
    ], popup_default::config('description'));
    include FCPATH.Path::plugin( POPUP_NAME ).'/modules/default/views/popup-alert-config.php';
}

class popup_default {

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public static function config($key = '') {
        $default = [
            'title' => '',
            'description' => '',
            'background_color' => '',
            'background_image' => '',
            'title_color' => '',
        ];
        $config = option::get('popup_default', array_merge([], $default));
        if(empty($config)) $config = $default;
        if(!empty($key)) {
            if(isset($config[$key])) return $config[$key]; return '';
        }
        return $config;
    }

    public static function admin_config_save($result) {

        $config = [
            'title'             => trim(Request::post('popup_alert_title')),
            'description'       => Request::post('popup_alert_description', ['clear' => false]),
            'background_color'  => trim(Request::post('popup_alert_background_color')),
            'background_image'  => FileHandler::handlingUrl(trim(Request::post('popup_alert_background_image'))),
            'title_color'       => trim(Request::post('popup_alert_title_color')),
        ];

        option::update('popup_default', $config);

        return ['status' => 'success', 'message' => 'Lưu dữ liệu thành công.'];
    }

    public static function render() {
        $config = static::config();
        include 'views/popup.php';
    }
}