<?php
foreach (glob(Path::plugin(POPUP_NAME).'/modules/salebanner/*', GLOB_ONLYDIR) as $foldername) {
    foreach (glob($foldername.'/*.salebanner.php') as $filename) {
        include_once $filename;
    }
}

function admin_page_popup_salebanner() {
    include 'html-salebanner.php';
}

class popup_salebanner {

    static public function style() {
        return apply_filters('popup_salebanner_style', []);
    }

    public static function admin_config_save($result) {
        $object_key = trim(Request::post('popup_style'));
        if(method_exists($object_key, 'admin_config_save')) {
            Option::update('popup_salebanner_active', $object_key);
            return $object_key::admin_config_save($result);
        }
        return $result;
    }

    public static function render() {
        $active = Option::get('popup_salebanner_active');
        if(method_exists($active, 'render')) $active::render();
    }
}