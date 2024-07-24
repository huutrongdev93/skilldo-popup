<?php
const POPUP_NAME = 'popup';

class popup {

    private string $name = 'popup';

    function __construct() {
        add_action('theme_custom_assets', array($this, 'assets'), 10, 2);
        add_action('admin_init', array($this, 'add_admin_menu'));
        add_action('cle_footer', array($this, 'render'));
        add_action('cle_header', array($this, 'localize_script'), 50);
        add_action('cle_header', array($this, 'renderConfig'), 50);
    }

    //active plugin
    public function active() {}

    //Gở bỏ plugin
    public function uninstall() {}
    
    public function add_admin_menu(): void
    {
        $count = (int)Option::get('popup_contactform_new', 0);
        AdminMenu::addSub('marketing','popup_contactform','Khách đăng ký popup', 'post?post_type=popup_contactform', ['count' => $count]);
    }

    public function assets(AssetPosition $header, AssetPosition $footer): void
    {
        $header->add('popup', Path::plugin( POPUP_NAME ).'/assets/css/popup-style.css', ['minify' => true]);
        $footer->add('footer', Path::plugin( POPUP_NAME ).'/assets/js/popup-script.js', ['minify' => true]);
    }

    public function localize_script(): void
    {
        $config = static::config();
        if(!is_array( $config['show']))  $config['show'] = (array) $config;
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

    public function render(): void
    {
        $config = static::config();
        if(!empty($config['active'])&& method_exists('popup_'.$config['active'], 'render')) {

            $page = Template::getPage();

            if(!is_array($config['show'])) $config['show'] = (array) $config['show'];

            if(in_array('all', $config['show']) || in_array($page, $config['show'])) {
                
                $active = 'popup_'.$config['active'];

                Plugin::view(POPUP_NAME, 'modules/html-popup', ['active' => $active]);
            }
        }
    }

    static function tool(): array
    {
        return [
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
    }

    static function config($key = '') {
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

    static function renderConfig(): void
    {
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