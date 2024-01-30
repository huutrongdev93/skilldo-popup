<?php
/**
Plugin name     : Marketing - Pop-up
Plugin class    : popup
Plugin uri      : https://sikido.vn
Description     : Pop-up được xem là hình thức quảng cáo phổ biến với chi phí thấp đem lại nhiều hiệu quả. Bên cạnh đó, có thể xem pop-up như một call-to-action (nút kêu gọi hành động) mạnh mẽ.
Author          : SKDSoftware Dev Team
Version         : 1.3.0
*/
const POPUP_NAME = 'popup';

class popup {

    private $name = 'popup';

    function __construct() {
        add_action('init', array($this, 'load_assets'));
        add_action('admin_init', array($this, 'add_admin_menu'));
        add_action('cle_footer', array($this, 'render'));
        add_action('cle_header', array($this, 'localize_script'), 50);
        add_action('cle_header', array($this, 'renderConfig'), 50);
    }

    //active plugin
    public function active() {}

    //Gở bỏ plugin
    public function uninstall() {}
    
    public function add_admin_menu() {
        $count = (int)Option::get('popup_contactform_new', 0);
        AdminMenu::addSub('marketing','popup_contactform','Khách đăng ký popup', 'post?post_type=popup_contactform', ['count' => $count]);
    }

    public function load_assets() {
        Template::asset()->location('header')->add('popup', Path::plugin( POPUP_NAME ).'/assets/css/popup-style.css', ['minify' => true]);
        Template::asset()->location('footer')->add('footer', Path::plugin( POPUP_NAME ).'/assets/js/popup-script.js', ['minify' => true]);
    }

    public function localize_script() {
        $config = static::config();
        if(!empty($config['active'])) {
            $page = Template::getPage();
            if(in_array('all', $config['show']) || in_array($page, $config['show'])) {
                ?>
                <script type='text/javascript'>
                    /* <![CDATA[ */
                    <?php
                    foreach ($config as $key => $value) {
                        if(!arr::accessible($value)) echo "popup_".$key." = '".$value."';";
                    }
                    if(method_exists('popup_'.$config['active'], 'localize_script')) {
                        $active = 'popup_'.$config['active'];
                        $active::localize_script();
                    }
                    ?> /* ]]> */
                </script>
                <?php
            }
        }
    }

    public function render() {
        $config = static::config();
        if(!empty($config['active']) && method_exists('popup_'.$config['active'], 'render')) {
            $page = Template::getPage();
            if(in_array('all', $config['show']) || in_array($page, $config['show'])) {
                $active = 'popup_'.$config['active'];
                include_once 'modules/html-popup.php';
            }
        }
    }

    static public function tool() {
        $popup_style = [
            'general' => [
                'label' => 'Cấu hình',
                'callback' => 'PopupAdmin::general'
            ],
            'default' => [
                'label' => 'Mặc định',
                'callback' => 'admin_page_popup_default'
            ],
            'contactform' => [
                'label' => 'Popup thông tin liên hệ',
                'callback' => 'admin_page_popup_contactform'
            ],
            'salebanner' => [
                'label' => 'Popup quảng cáo sản phẩm',
                'callback' => 'admin_page_popup_salebanner'
            ]
        ];
        return $popup_style;
    }

    static public function config($key = '') {
        $default = [
            'active' => 'default',
            'show'  => ['home'],
            'loop'  => 'loop_time',
            'time_delay' => 1,
            'time_loop' => 1,
            'contactform_input' => ['email'],
            'contactform_required' => ['email'],
        ];
        $config = option::get('popup_config', array_merge([], $default));
        if(empty($config)) $config = $default;
        if(!empty($key)) {
            if(isset($config[$key])) return $config[$key];
            if(isset($default[$key])) return $default[$key];
        }
        return $config;
    }

    static public function renderConfig() {
        $config = static::config();
        if(!empty($config['active']) && method_exists('popup_'.$config['active'], 'render')) {
            ?>
            <script type='text/javascript' defer>
                /* <![CDATA[ */
                popupType       = '<?= popup::config('loop');?>';
                popupTimeDelay  = <?= popup::config('time_delay');?>;
                popupTimeLoop   = <?= popup::config('time_loop');?>;
                /* ]]> */
            </script>
            <?php

        }
    }
}

new popup();

include 'modules/default/default.php';
include 'modules/salebanner/salebanner.php';
include 'modules/contactform/contactform.php';

if(Admin::is()) {
    include 'admin/popup-admin.php';
}