<?php
function popup_contactform_style4_register($style) {
    $style['popup_contactform_style4'] = ['label' => 'Style 1'];
    return $style;
}
add_filter('popup_contactform_style', 'popup_contactform_style4_register');

class popup_contactform_style4 {
    static public function admin_demo(): void
    {
        Template::img(Url::base(Path::plugin( POPUP_NAME ).'/assets/images/contactform/demo-style4.png'));
    }
    static public function admin_config($key = ''): void
    {
        $config = static::config();
        $form = form();
        $form->text('style4_title1', [
            'label' => 'Tiêu đề nhỏ',
            'start' => 6
        ], $config['style4_title1']);
        $form->color('style4_title1_color', [
            'label' => 'Màu tiêu đề nhỏ',
            'start' => 6
        ], $config['style4_title1_color']);

        $form->textarea('style4_content', [
            'label' => 'Nội dung',
        ], $config['style4_content']);
        $form->color('style4_content_color',[
            'label' => 'Màu nội dung',
            'start' => 12
        ], $config['style4_content_color']);

        $form->text('style4_btn_txt', [
            'label' => 'Chữ button',
            'start' => 4
        ], $config['style4_btn_txt']);
        $form->color('style4_btn_color', [
            'label' => 'Màu Chữ button',
            'start' => 4
        ], $config['style4_btn_color']);
        $form->color('style4_btn_bg', [
            'label' => 'Màu nền button',
            'start' => 4
        ], $config['style4_btn_bg']);
        $form->image('style4_popup_bg', [
            'label' => 'Hình nền popup',
            'start' => 6
        ], $config['style4_popup_bg']);
        $form->image('style4_popup_sp', [
            'label' => 'Hình sản phẩm',
            'start' => 6
        ], $config['style4_popup_sp']);

        if(Language::hasMulti()) {
            foreach (Language::list() as $key => $lang) {
                if($key == Language::default()) continue;
                $form->text('style4_title1_'.$key, [
                    'label' => 'Tiêu đề nhỏ ('.$lang['label'].')',
                    'start' => 12
                ], (isset($config['style4_title1_'.$key])) ? $config['style4_title1_'.$key] : '');
                $form->textarea('style4_content_'.$key, [
                    'label' => 'Nội dung ('.$lang['label'].')',
                    'start' => 12
                ], (isset($config['style4_content_'.$key])) ? $config['style4_content_'.$key] : '');
                $form->text('style4_btn_txt_'.$key, [
                    'label' => 'Chữ button ('.$lang['label'].')',
                    'start' => 12
                ], (isset($config['style4_btn_txt_'.$key])) ? $config['style4_btn_txt_'.$key] : '');
            }
        }
        $form->html(false);
    }
    static public function config($key = '') {
        $config = option::get('popup_contactform_config');
        if(!have_posts($config)) $config = [];
        if(!isset($config['style4_title1'])) $config['style4_title1'] = 'Apple Watch Thế Hệ Mới Nhất 40mm';
        if(!isset($config['style4_title1_color'])) $config['style4_title1_color'] = '#fff';
        if(!isset($config['style4_content'])) $config['style4_content'] = 'Đồng hồ thông minh là một sản phẩm công nghệ được nhiều người ưa chuộng bởi sự tiện lợi và hữu ích mà thiết bị mang lại.';
        if(!isset($config['style4_content_color'])) $config['style4_content_color'] = '#fff';
        if(!isset($config['style4_btn_txt'])) $config['style4_btn_txt'] = 'Nhận mã ngay';
        if(!isset($config['style4_btn_color'])) $config['style4_btn_color'] = '#fff';
        if(!isset($config['style4_btn_bg'])) $config['style4_btn_bg'] = 'rgb(214, 97, 97)';
        if(!isset($config['style4_popup_bg'])) $config['style4_popup_bg'] = 'http://cdn.sikido.vn/images/popup/contactform-4-1.png';
        if(!isset($config['style4_popup_sp'])) $config['style4_popup_sp'] = 'http://cdn.sikido.vn/images/popup/contactform-4-2.png';
        if(!empty($key)) {
            if(isset($config[$key])) return $config[$key];
            return '';
        }
        return $config;
    }
    static public function admin_config_save(\SkillDo\Http\Request $request): void
    {
        $config = static::config();
        $config['style4_title1']       = $request->input('style4_title1');
        $config['style4_title1_color'] = $request->input('style4_title1_color');
        $config['style4_content']      = $request->input('style4_content');
        $config['style4_content_color']= $request->input('style4_content_color');
        $config['style4_btn_txt']      = $request->input('style4_btn_txt');
        $config['style4_btn_color']    = $request->input('style4_btn_color');
        $config['style4_btn_bg']       = $request->input('style4_btn_bg');
        $config['style4_popup_bg']     = FileHandler::handlingUrl($request->input('style4_popup_bg'));
        $config['style4_popup_sp']     = FileHandler::handlingUrl($request->input('style4_popup_sp'));
        if(Language::hasMulti()) {
            foreach (Language::list() as $key => $lang) {
                if($key == Language::default()) continue;
                $config['style4_title1_'.$key]     = $request->input('style4_title1_'.$key);
                $config['style4_content_'.$key]    = $request->input('style4_content_'.$key);
                $config['style4_btn_txt_'.$key]    = $request->input('style4_btn_txt_'.$key);
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
            $config['style4_title1'] = (!empty($config['style4_title1_'.$language_current])) ? $config['style4_title1_'.$language_current] : $config['style4_title1'];
            $config['style4_content'] = (!empty($config['style4_content_'.$language_current])) ? $config['style4_content_'.$language_current] : $config['style4_content'];
            $config['style4_btn_txt'] = (!empty($config['style4_btn_txt_'.$language_current])) ? $config['style4_btn_txt_'.$language_current] : $config['style4_btn_txt'];
        }
        Plugin::view(POPUP_NAME, 'modules/contactform/style4/popup', ['config' => $config, 'contactform_input' => $contactform_input, 'contactform_required' => $contactform_required, 'language_current' => $language_current]);
    }
}