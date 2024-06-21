<?php
function popup_salebanner_style2_register($style) {
    $style['popup_salebanner_style2'] = ['label' => 'Style 2'];
    return $style;
}
add_filter('popup_salebanner_style', 'popup_salebanner_style2_register');

class popup_salebanner_style2 {
    static public function admin_demo() {
        Template::img(Url::base(Path::plugin( POPUP_NAME ).'/assets/images/salebanner/demo-style2.png'));
    }
    static public function admin_config($key = ''): void
    {
        $config = static::config();
        $form = form();
        $form->text('style2_title', [
            'label' => 'Tiêu đề',
            'start' => 6
        ], $config['style2_title']);
        $form->color('style2_title_color', [
            'label' => 'Màu tiêu đề',
            'start' => 6
        ], $config['style2_title_color']);
        $form->textarea('style2_content', [
            'label' => 'Nội dung',
        ], $config['style2_content']);
        $form->color('style2_content_color', [
            'label' => 'Màu chữ nội dung',
            'start' => 12
        ], $config['style2_content_color']);
        $form->text('style2_btn_txt', [
            'label' => 'Chữ button',
            'start' => 4
        ], $config['style2_btn_txt']);
        $form->color('style2_btn_color', [
            'label' => 'Màu Chữ button',
            'start' => 4
        ], $config['style2_btn_color']);
        $form->color('style2_btn_bg', [
            'label' => 'Màu nền button',
            'start' => 4
        ], $config['style2_btn_bg']);
        $form->text('style2_btn_url', [
            'label' => 'Liên kết',
        ], $config['style2_btn_url']);
        $form->image('style2_popup_bg', [
            'label' => 'Hình nền popup',
            'start' => 12
        ], $config['style2_popup_bg']);

        if(Language::hasMulti()) {
            foreach (Language::list() as $key => $lang) {
                if($key == Language::default()) continue;
                $form->text('style2_title_'.$key, [
                    'label' => 'Tiêu đề ('.$lang['label'].')',
                    'start' => 12
                ], (isset($config['style2_title_'.$key])) ? $config['style2_title_'.$key] : '');
                $form->textarea('style2_content_'.$key, [
                    'label' => 'Nội dung ('.$lang['label'].')',
                    'start' => 12
                ], (isset($config['style2_content_'.$key])) ? $config['style2_content_'.$key] : '');
                $form->text('style2_btn_txt_'.$key, [
                    'label' => 'Chữ button ('.$lang['label'].')',
                    'start' => 12
                ], (isset($config['style2_btn_txt_'.$key])) ? $config['style2_btn_txt_'.$key] : '');
            }
        }
        $form->html(false);
    }
    static public function config($key = '') {
        $config = option::get('popup_salebanner_config');
        if(!have_posts($config)) $config = [];
        if(!isset($config['style2_title'])) $config['style2_title'] = 'Bộ Sưu Tập Mới '.date('Y');
        if(!isset($config['style2_title_color'])) $config['style2_title_color'] = '#fff';
        if(!isset($config['style2_content'])) $config['style2_content'] = 'Thiết kế mới kết hợp giữa sneaker và giày thể thao mang đến mẫu giày đáng mong đợi trong năm nay';
        if(!isset($config['style2_content_color'])) $config['style2_content_color'] = '#fff';
        if(!isset($config['style2_btn_txt'])) $config['style2_btn_txt'] = 'Xem ngay';
        if(!isset($config['style2_btn_color'])) $config['style2_btn_color'] = '#000';
        if(!isset($config['style2_btn_bg'])) $config['style2_btn_bg'] = 'yellow';
        if(!isset($config['style2_btn_url'])) $config['style2_btn_url'] = base_url();
        if(!isset($config['style2_popup_color'])) $config['style2_popup_color'] = '#000';
        if(!isset($config['style2_popup_bg'])) $config['style2_popup_bg'] = 'http://cdn.sikido.vn/images/popup/salebanner-2.jpeg';
        if(!empty($key)) {
            if(isset($config[$key])) return $config[$key];
            return '';
        }
        return $config;
    }
    static public function admin_config_save(\SkillDo\Http\Request $request): void
    {
        $config = static::config();
        $config['style2_title']        = $request->input('style2_title');
        $config['style2_title_color']  = $request->input('style2_title_color');
        $config['style2_content']      = $request->input('style2_content');
        $config['style2_btn_txt']      = $request->input('style2_btn_txt');
        $config['style2_btn_color']    = $request->input('style2_btn_color');
        $config['style2_btn_bg']       = $request->input('style2_btn_bg');
        $config['style2_btn_url']      = $request->input('style2_btn_url');
        $config['style2_popup_color']  = $request->input('style2_popup_color');
        $config['style2_popup_bg']     = FileHandler::handlingUrl($request->input('style2_popup_bg'));
        if(Language::hasMulti()) {
            foreach (Language::list() as $key => $lang) {
                if($key == Language::default()) continue;
                $config['style2_title_'.$key]     = $request->input('style2_title_'.$key);
                $config['style2_content_'.$key]    = $request->input('style2_content_'.$key);
                $config['style2_btn_txt_'.$key]    = $request->input('style2_btn_txt_'.$key);
            }
        }
        Option::update('popup_salebanner_config', $config);
    }

    static public function render(): void
    {
        $config = static::config();
        $language_current = Language::current();
        if(Language::default() != $language_current) {
            $config['style2_title'] = (!empty($config['style2_title_'.$language_current])) ? $config['style2_title_'.$language_current] : $config['style2_title'];
            $config['style2_content'] = (!empty($config['style2_content_'.$language_current])) ? $config['style2_content_'.$language_current] : $config['style2_content'];
            $config['style2_btn_txt'] = (!empty($config['style2_btn_txt_'.$language_current])) ? $config['style2_btn_txt_'.$language_current] : $config['style2_btn_txt'];
        }
        Plugin::view(POPUP_NAME, 'modules/salebanner/style2/popup', ['config' => $config]);
    }
}