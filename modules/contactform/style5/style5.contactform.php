<?php
function popup_contactform_style5_register($style) {
    $style['popup_contactform_style5'] = ['label' => 'Style 1'];
    return $style;
}
add_filter('popup_contactform_style', 'popup_contactform_style5_register');

class popup_contactform_style5 {
    static public function admin_demo(): void
    {
        Template::img(Url::base(Path::plugin( POPUP_NAME ).'/assets/images/contactform/demo-style5.png'));
    }
    static public function admin_config($key = ''): void
    {
        $config = static::config();
        $form = form();
        $form->text('style5_title1', [
            'label' => 'Tiêu đề nhỏ',
            'start' => 6
        ], $config['style5_title1']);
        $form->color('style5_title1_color', [
            'label' => 'Màu tiêu đề nhỏ',
            'start' => 6
        ], $config['style5_title1_color']);

        $form->text('style5_title2', [
            'label' => 'Tiêu đề lớn',
            'start' => 6
        ], $config['style5_title2']);
        $form->color('style5_title2_color', [
            'label' => 'Màu tiêu đề lớn',
            'start' => 6
        ], $config['style5_title2_color']);

        $form->textarea('style5_content', [
            'label' => 'Nội dung',
        ], $config['style5_content']);
        $form->color('style5_content_color', [
            'label' => 'Màu nội dung',
            'start' => 12
        ], $config['style5_content_color']);

        $form->text('style5_btn_txt', [
            'label' => 'Chữ button',
            'start' => 4
        ], $config['style5_btn_txt']);
        $form->color('style5_btn_color', [
            'label' => 'Màu Chữ button',
            'start' => 4
        ], $config['style5_btn_color']);
        $form->color('style5_btn_bg', [
            'label' => 'Màu nền button',
            'start' => 4
        ], $config['style5_btn_bg']);

        if(Language::hasMulti()) {
            foreach (Language::list() as $key => $lang) {
                if($key == Language::default()) continue;
                $form->text('style5_title1_'.$key, [
                    'label' => 'Tiêu đề nhỏ ('.$lang['label'].')',
                    'start' => 12
                ], (isset($config['style5_title1_'.$key])) ? $config['style5_title1_'.$key] : '');
                $form->text('style5_title2_'.$key, [
                    'label' => 'Tiêu đề lớn ('.$lang['label'].')',
                    'start' => 12
                ], (isset($config['style5_title2_'.$key])) ? $config['style5_title2_'.$key] : '');
                $form->textarea('style5_content_'.$key, [
                    'label' => 'Nội dung ('.$lang['label'].')',
                    'start' => 12
                ], (isset($config['style5_content_'.$key])) ? $config['style5_content_'.$key] : '');
                $form->text('style5_btn_txt_'.$key, [
                    'label' => 'Chữ button ('.$lang['label'].')',
                    'start' => 12
                ], (isset($config['style5_btn_txt_'.$key])) ? $config['style5_btn_txt_'.$key] : '');
            }
        }
        $form->html(false);
    }
    static public function config($key = '') {
        $config = option::get('popup_contactform_config');
        if(!have_posts($config)) $config = [];
        if(!isset($config['style5_title1'])) $config['style5_title1'] = 'Tiết kiệm đến';
        if(!isset($config['style5_title1_color'])) $config['style5_title1_color'] = '#000';
        if(!isset($config['style5_title2'])) $config['style5_title2'] = '30%';
        if(!isset($config['style5_title2_color'])) $config['style5_title2_color'] = '#EF4B4B';
        if(!isset($config['style5_content'])) $config['style5_content'] = 'cho phiếu thanh toán lần sau của bạn';
        if(!isset($config['style5_content_color'])) $config['style5_content_color'] = '#000';
        if(!isset($config['style5_btn_txt'])) $config['style5_btn_txt'] = 'Nhận mã ngay';
        if(!isset($config['style5_btn_color'])) $config['style5_btn_color'] = '#fff';
        if(!isset($config['style5_btn_bg'])) $config['style5_btn_bg'] = '#EF4B4B';
        if(!empty($key)) {
            if(isset($config[$key])) return $config[$key];
            return '';
        }
        return $config;
    }
    static public function admin_config_save(\SkillDo\Http\Request $request): void
    {
        $config = static::config();
        $config['style5_title1']       = $request->input('style5_title1');
        $config['style5_title1_color'] = $request->input('style5_title1_color');
        $config['style5_title2']       = $request->input('style5_title2');
        $config['style5_title2_color'] = $request->input('style5_title2_color');
        $config['style5_content']      = $request->input('style5_content');
        $config['style5_content_color']= $request->input('style5_content_color');
        $config['style5_btn_txt']      = $request->input('style5_btn_txt');
        $config['style5_btn_color']    = $request->input('style5_btn_color');
        $config['style5_btn_bg']       = $request->input('style5_btn_bg');
        if(Language::hasMulti()) {
            foreach (Language::list() as $key => $lang) {
                if($key == Language::default()) continue;
                $config['style5_title1_'.$key]     = $request->input('style5_title1_'.$key);
                $config['style5_title2_'.$key]     = $request->input('style5_title2_'.$key);
                $config['style5_content_'.$key]    = $request->input('style5_content_'.$key);
                $config['style5_btn_txt_'.$key]    = $request->input('style5_btn_txt_'.$key);
            }
        }
        Option::update('popup_contactform_config', $config);
    }
    static public function render(): void
    {
        $config = static::config();
        $contactform_input = popup::config('contactform_input');
        $contactform_required = popup::config('contactform_required');
        $language_current = Language::current();
        if(Language::default() != $language_current) {
            $config['style5_title1'] = (!empty($config['style5_title1_'.$language_current])) ? $config['style5_title1_'.$language_current] : $config['style5_title1'];
            $config['style5_title2'] = (!empty($config['style5_title2_'.$language_current])) ? $config['style5_title2_'.$language_current] : $config['style5_title2'];
            $config['style5_content'] = (!empty($config['style5_content_'.$language_current])) ? $config['style5_content_'.$language_current] : $config['style5_content'];
            $config['style5_btn_txt'] = (!empty($config['style5_btn_txt_'.$language_current])) ? $config['style5_btn_txt_'.$language_current] : $config['style5_btn_txt'];
        }
        Plugin::view(POPUP_NAME, 'modules/contactform/style5/popup', ['config' => $config, 'contactform_input' => $contactform_input, 'contactform_required' => $contactform_required, 'language_current' => $language_current]);
    }
}