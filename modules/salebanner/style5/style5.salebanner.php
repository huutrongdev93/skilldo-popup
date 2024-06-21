<?php
function popup_salebanner_style5_register($style) {
    $style['popup_salebanner_style5'] = ['label' => 'Style 5'];
    return $style;
}
add_filter('popup_salebanner_style', 'popup_salebanner_style5_register');

class popup_salebanner_style5 {
    static public function admin_demo(): void
    {
        Template::img(Url::base(Path::plugin( POPUP_NAME ).'/assets/images/salebanner/demo-style5.png'));
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
        $form->text('style5_btn_url', [
            'label' => 'Liên kết',
        ], $config['style5_btn_url']);
        $form->image('style5_popup_bg', [
            'label' => 'Hình nền popup',
            'start' => 12
        ], $config['style5_popup_bg']);

        if(Language::hasMulti()) {
            foreach (Language::list() as $key => $lang) {
                if($key == Language::default()) continue;
                $form->text('style5_title1_'.$key, [
                    'label' => 'Tiêu đề nhỏ ('.$lang['label'].')',
                    'start' => 6
                ], (isset($config['style5_title1_'.$key])) ? $config['style5_title1_'.$key] : '');
                $form->text('style5_title2_'.$key, [
                    'label' => 'Tiêu đề lớn ('.$lang['label'].')',
                    'start' => 6
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
        $config = option::get('popup_salebanner_config');
        if (!have_posts($config)) $config = [];
        if (!isset($config['style5_title1'])) $config['style5_title1'] = 'Valentine\'s Day';
        if (!isset($config['style5_title1_color'])) $config['style5_title1_color'] = '#FC0E56';
        if (!isset($config['style5_title2'])) $config['style5_title2'] = 'SALE';
        if (!isset($config['style5_title2_color'])) $config['style5_title2_color'] = '#FC0E56';
        if (!isset($config['style5_content'])) $config['style5_content'] = 'Giảm 60% tất cả sản phẩm';
        if (!isset($config['style5_content_color'])) $config['style5_content_color'] = '#FC0E56';
        if (!isset($config['style5_btn_txt'])) $config['style5_btn_txt'] = 'Xem ngay';
        if (!isset($config['style5_btn_color'])) $config['style5_btn_color'] = '#fff';
        if (!isset($config['style5_btn_bg'])) $config['style5_btn_bg'] = '#FC0E56';
        if (!isset($config['style5_btn_url'])) $config['style5_btn_url'] = base_url();
        if (!isset($config['style5_popup_bg'])) $config['style5_popup_bg'] = 'http://cdn.sikido.vn/images/popup/salebanner-5.png';
        if (!empty($key)) {
            if (isset($config[$key])) return $config[$key];
            return '';
        }
        return $config;
    }
    static public function admin_config_save(\SkillDo\Http\Request $request): void
    {
        $config = static::config();
        $config['style5_title1'] = $request->input('style5_title1');
        $config['style5_title1_color'] = $request->input('style5_title1_color');
        $config['style5_title2'] = $request->input('style5_title2');
        $config['style5_title2_color'] = $request->input('style5_title2_color');
        $config['style5_content'] = $request->input('style5_content');
        $config['style5_content_color'] = $request->input('style5_content_color');
        $config['style5_btn_txt'] = $request->input('style5_btn_txt');
        $config['style5_btn_color'] = $request->input('style5_btn_color');
        $config['style5_btn_bg'] = $request->input('style5_btn_bg');
        $config['style5_btn_url'] = $request->input('style5_btn_url');
        $config['style5_popup_bg'] = FileHandler::handlingUrl($request->input('style5_popup_bg'));
        if (Language::hasMulti()) {
            foreach (Language::list() as $key => $lang) {
                if ($key == Language::default()) continue;
                $config['style5_title1_' . $key] = $request->input('style5_title1_' . $key);
                $config['style5_title2_' . $key] = $request->input('style5_title2_' . $key);
                $config['style5_content_' . $key] = $request->input('style5_content_' . $key);
                $config['style5_btn_txt_' . $key] = $request->input('style5_btn_txt_' . $key);
            }
        }
        Option::update('popup_salebanner_config', $config);
    }

    static public function render(): void
    {
        $config = static::config();
        $language_current = Language::current();
        if (Language::default() != $language_current) {
            $config['style5_title1'] = (!empty($config['style5_title1_' . $language_current])) ? $config['style5_title1_' . $language_current] : $config['style5_title1'];
            $config['style5_title2'] = (!empty($config['style5_title2_' . $language_current])) ? $config['style5_title2_' . $language_current] : $config['style5_title2'];
            $config['style5_content'] = (!empty($config['style5_content_' . $language_current])) ? $config['style5_content_' . $language_current] : $config['style5_content'];
            $config['style5_btn_txt'] = (!empty($config['style5_btn_txt_' . $language_current])) ? $config['style5_btn_txt_' . $language_current] : $config['style5_btn_txt'];
        }
        Plugin::view(POPUP_NAME, 'modules/salebanner/style5/popup', ['config' => $config]);
    }
}