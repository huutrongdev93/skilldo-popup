<?php
function popup_contactform_style1_register($style) {
    $style['popup_contactform_style1'] = ['label' => 'Style 1'];
    return $style;
}
add_filter('popup_contactform_style', 'popup_contactform_style1_register');

class popup_contactform_style1 {
    static public function admin_demo(): void
    {
        Template::img(Url::base(Path::plugin( POPUP_NAME ).'/assets/images/contactform/demo-style1.png'));
    }
    static public function admin_config($key = ''): void
    {
        $config = static::config();
        $form = form();
        $form->text('title1', [
            'label' => 'Tiêu đề nhỏ',
            'start' => 6
        ], $config['title1']);
        $form->color('title1_color', [
            'label' => 'Màu tiêu đề nhỏ',
            'start' => 6
        ], $config['title1_color']);

        $form->textarea('content', [
            'label' => 'Nội dung',
        ], $config['content']);
        $form->color('content_color', [
            'label' => 'Màu nội dung',
            'start' => 12
        ], $config['content_color']);

        $form->text('btn_txt', [
            'label' => 'Chữ button',
            'start' => 4
        ], $config['btn_txt']);
        $form->color('btn_color', [
            'label' => 'Màu Chữ button',
            'start' => 4
        ], $config['btn_color']);
        $form->color('btn_bg', [
            'label' => 'Màu nền button',
            'start' => 4
        ], $config['btn_bg']);
        $form->image('popup_bg', [
            'label' => 'Hình nền popup',
            'start' => 12
        ], $config['popup_bg']);

        if(Language::hasMulti()) {
            foreach (Language::list() as $key => $lang) {
                if($key == Language::default()) continue;
                $form->text('title1_'.$key, [
                    'label' => 'Tiêu đề nhỏ ('.$lang['label'].')',
                    'start' => 12
                ], (isset($config['title1_'.$key])) ? $config['title1_'.$key] : '');
                $form->textarea('content_'.$key, [
                    'label' => 'Nội dung ('.$lang['label'].')',
                    'start' => 12
                ], (isset($config['content_'.$key])) ? $config['content_'.$key] : '');
                $form->text('btn_txt_'.$key, [
                    'label' => 'Chữ button ('.$lang['label'].')',
                    'start' => 12
                ], (isset($config['btn_txt_'.$key])) ? $config['btn_txt_'.$key] : '');
            }
        }
        $form->html(false);
    }
    static public function config($key = '') {
        $config = option::get('popup_contactform_config');
        if(!have_posts($config)) $config = [];
        if(!isset($config['title1'])) $config['title1'] = 'Trợ giúp qua điện thoại';
        if(!isset($config['title1_color'])) $config['title1_color'] = 'rgb(214, 97, 97)';
        if(!isset($config['content'])) $config['content'] = 'Nhận ngay 2.000.000 VNĐ cho dịch vụ Tắm Trắng Phi Thuyền Hồng Ngoại';
        if(!isset($config['content_color'])) $config['content_color'] = 'rgb(34, 34, 34)';
        if(!isset($config['btn_txt'])) $config['btn_txt'] = 'Nhận mã ngay';
        if(!isset($config['btn_color'])) $config['btn_color'] = '#fff';
        if(!isset($config['btn_bg'])) $config['btn_bg'] = 'rgb(214, 97, 97)';
        if(!isset($config['popup_bg'])) $config['popup_bg'] = 'http://cdn.sikido.vn/images/popup/contactform-1.jpg';
        if(!empty($key)) {
            if(isset($config[$key])) return $config[$key];
            return '';
        }
        return $config;
    }
    static public function admin_config_save(\SkillDo\Http\Request $request): void
    {
        $config = static::config();
        $config['title1']       = $request->input('title1');
        $config['title1_color']  = $request->input('title1_color');
        $config['content']      = $request->input('content');
        $config['content_color']      = $request->input('content_color');
        $config['btn_txt']      = $request->input('btn_txt');
        $config['btn_color']    = $request->input('btn_color');
        $config['btn_bg']       = $request->input('btn_bg');
        $config['popup_bg']     = FileHandler::handlingUrl($request->input('popup_bg'));
        if(Language::hasMulti()) {
            foreach (Language::list() as $key => $lang) {
                if($key == Language::default()) continue;
                $config['title1_'.$key]     = $request->input('title1_'.$key);
                $config['content_'.$key]    = $request->input('content_'.$key);
                $config['btn_txt_'.$key]    = $request->input('btn_txt_'.$key);
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
            $config['title1'] = (!empty($config['title1_'.$language_current])) ? $config['title1_'.$language_current] : $config['title1'];
            $config['content'] = (!empty($config['content_'.$language_current])) ? $config['content_'.$language_current] : $config['content'];
            $config['btn_txt'] = (!empty($config['btn_txt_'.$language_current])) ? $config['btn_txt_'.$language_current] : $config['btn_txt'];
        }
        Plugin::view(POPUP_NAME, 'modules/contactform/style1/popup', ['config' => $config, 'contactform_input' => $contactform_input, 'contactform_required' => $contactform_required, 'language_current' => $language_current]);
    }
}