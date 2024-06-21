<?php
function popup_salebanner_style6_register($style) {
    $style['popup_salebanner_style6'] = ['label' => 'Style 5'];
    return $style;
}
add_filter('popup_salebanner_style', 'popup_salebanner_style6_register');

class popup_salebanner_style6 {
    static public function admin_demo(): void
    {
        Template::img(Url::base(Path::plugin( POPUP_NAME ).'/assets/images/salebanner/demo-style6.png'));
    }
    static public function admin_config($key = ''): void
    {
        $config = static::config();
        $form = form();
        $form->text('style6_title1', [
            'label' => 'Tiêu đề nhỏ',
            'start' => 6
        ], $config['style6_title1']);
        $form->color('style6_title1_color', [
            'label' => 'Màu tiêu đề nhỏ',
            'start' => 6
        ], $config['style6_title1_color']);

        $form->text('style6_title2', [
            'label' => 'Tiêu đề lớn',
            'start' => 6
        ], $config['style6_title2']);
        $form->color('style6_title2_color', [
            'label' => 'Màu tiêu đề lớn',
            'start' => 6
        ], $config['style6_title2_color']);

        $form->text('style6_content', [
            'label' => 'Nội dung',
            'start' => 6
        ], $config['style6_content']);
        $form->color('style6_content_color', [
            'label' => 'Màu nội dung',
            'start' => 6
        ], $config['style6_content_color']);

        $form->text('style6_btn_txt', [
            'label' => 'Chữ button',
            'start' => 4
        ], $config['style6_btn_txt']);
        $form->color('style6_btn_color', [
            'label' => 'Màu Chữ button',
            'start' => 4
        ], $config['style6_btn_color']);
        $form->color('style6_btn_bg', [
            'label' => 'Màu nền button',
            'start' => 4
        ], $config['style6_btn_bg']);
        $form->text('style6_btn_url', [
            'label' => 'Liên kết',
        ], $config['style6_btn_url']);

        if(Language::hasMulti()) {
            foreach (Language::list() as $key => $lang) {
                if($key == Language::default()) continue;
                $form->text('style6_title1_'.$key, [
                    'label' => 'Tiêu đề nhỏ ('.$lang['label'].')',
                    'start' => 6
                ], (isset($config['style6_title1_'.$key])) ? $config['style6_title1_'.$key] : '');
                $form->text('style6_title2_'.$key, [
                    'label' => 'Tiêu đề lớn ('.$lang['label'].')',
                    'start' => 6
                ], (isset($config['style6_title2_'.$key])) ? $config['style6_title2_'.$key] : '');
                $form->text('style6_content_'.$key, [
                    'label' => 'Nội dung ('.$lang['label'].')',
                    'start' => 6
                ], (isset($config['style6_content_'.$key])) ? $config['style6_content_'.$key] : '');
                $form->text('style6_btn_txt_'.$key, [
                    'label' => 'Chữ button ('.$lang['label'].')',
                    'start' => 6
                ], (isset($config['style6_btn_txt_'.$key])) ? $config['style6_btn_txt_'.$key] : '');
            }
        }
        $form->html(false);
    }
    static public function config($key = '') {
        $config = option::get('popup_salebanner_config');
        if (!have_posts($config)) $config = [];
        if (!isset($config['style6_title1'])) $config['style6_title1'] = 'TẾT SALE HẾT';
        if (!isset($config['style6_title1_color'])) $config['style6_title1_color'] = 'rgb(255, 0, 0)';
        if (!isset($config['style6_title2'])) $config['style6_title2'] = 'SALE';
        if (!isset($config['style6_title2_color'])) $config['style6_title2_color'] = '#fff';
        if (!isset($config['style6_content'])) $config['style6_content'] = '50%';
        if (!isset($config['style6_content_color'])) $config['style6_content_color'] = '#fff';
        if (!isset($config['style6_btn_txt'])) $config['style6_btn_txt'] = 'Mua sắm ngay';
        if (!isset($config['style6_btn_color'])) $config['style6_btn_color'] = 'rgb(255, 0, 0)';
        if (!isset($config['style6_btn_bg'])) $config['style6_btn_bg'] = '#FFE500';
        if (!isset($config['style6_btn_url'])) $config['style6_btn_url'] = base_url();
        if (!empty($key)) {
            if (isset($config[$key])) return $config[$key];
            return '';
        }
        return $config;
    }
    static public function admin_config_save(\SkillDo\Http\Request $request): void
    {
        $config = static::config();
        $config['style6_title1'] = $request->input('style6_title1');
        $config['style6_title1_color'] = $request->input('style6_title1_color');
        $config['style6_title2'] = $request->input('style6_title2');
        $config['style6_title2_color'] = $request->input('style6_title2_color');
        $config['style6_content'] = $request->input('style6_content');
        $config['style6_content_color'] = $request->input('style6_content_color');
        $config['style6_btn_txt'] = $request->input('style6_btn_txt');
        $config['style6_btn_color'] = $request->input('style6_btn_color');
        $config['style6_btn_bg'] = $request->input('style6_btn_bg');
        $config['style6_btn_url'] = $request->input('style6_btn_url');
        if (Language::hasMulti()) {
            foreach (Language::list() as $key => $lang) {
                if ($key == Language::default()) continue;
                $config['style6_title1_' . $key] = $request->input('style6_title1_' . $key);
                $config['style6_title2_' . $key] = $request->input('style6_title2_' . $key);
                $config['style6_content_' . $key] = $request->input('style6_content_' . $key);
                $config['style6_btn_txt_' . $key] = $request->input('style6_btn_txt_' . $key);
            }
        }
        Option::update('popup_salebanner_config', $config);
    }

    static public function render(): void
    {
        $config = static::config();
        $language_current = Language::current();
        if (Language::default() != $language_current) {
            $config['style6_title1'] = (!empty($config['style6_title1_' . $language_current])) ? $config['style6_title1_' . $language_current] : $config['style6_title1'];
            $config['style6_title2'] = (!empty($config['style6_title2_' . $language_current])) ? $config['style6_title2_' . $language_current] : $config['style6_title2'];
            $config['style6_content'] = (!empty($config['style6_content_' . $language_current])) ? $config['style6_content_' . $language_current] : $config['style6_content'];
            $config['style6_btn_txt'] = (!empty($config['style6_btn_txt_' . $language_current])) ? $config['style6_btn_txt_' . $language_current] : $config['style6_btn_txt'];
        }
        Plugin::view(POPUP_NAME, 'modules/salebanner/style6/popup', ['config' => $config]);
    }
}