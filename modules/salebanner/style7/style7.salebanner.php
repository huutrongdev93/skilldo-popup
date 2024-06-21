<?php
function popup_salebanner_style7_register($style) {
    $style['popup_salebanner_style7'] = ['label' => 'Style 5'];
    return $style;
}
add_filter('popup_salebanner_style', 'popup_salebanner_style7_register');

class popup_salebanner_style7 {
    static public function admin_demo(): void
    {
        Template::img(Url::base(Path::plugin( POPUP_NAME ).'/assets/images/salebanner/demo-style7.png'));
    }
    static public function admin_config($key = ''): void
    {
        $config = static::config();
        $form = form();
        $form->text('style7_title1', [
            'label' => 'Tiêu đề nhỏ',
            'start' => 6
        ], $config['style7_title1']);
        $form->color('style7_title1_color', [
            'label' => 'Màu tiêu đề nhỏ',
            'start' => 6
        ], $config['style7_title1_color']);

        $form->text('style7_title2', [
            'label' => 'Tiêu đề lớn',
            'start' => 6
        ], $config['style7_title2']);
        $form->color('style7_title2_color', [
            'label' => 'Màu tiêu đề lớn',
            'start' => 6
        ], $config['style7_title2_color']);

        $form->textarea('style7_content', [
            'label' => 'Nội dung',
        ], $config['style7_content']);
        $form->color('style7_content_color', [
            'label' => 'Màu nội dung',
            'start' => 12
        ], $config['style7_content_color']);

        $form->text('style7_btn_txt', [
            'label' => 'Chữ button',
            'start' => 4
        ], $config['style7_btn_txt']);
        $form->color('style7_btn_color', [
            'label' => 'Màu Chữ button',
            'start' => 4
        ], $config['style7_btn_color']);
        $form->color('style7_btn_bg', [
            'label' => 'Màu nền button',
            'start' => 4
        ], $config['style7_btn_bg']);
        $form->text('style7_btn_url', [
            'label' => 'Liên kết',
        ], $config['style7_btn_url']);
        $form->image('style7_popup_bg', [
            'label' => 'Hình nền popup',
            'start' => 12
        ], $config['style7_popup_bg']);

        if(Language::hasMulti()) {
            foreach (Language::list() as $key => $lang) {
                if($key == Language::default()) continue;
                $form->text('style7_title1_'.$key, [
                    'label' => 'Tiêu đề nhỏ ('.$lang['label'].')',
                    'start' => 6
                ], (isset($config['style7_title1_'.$key])) ? $config['style7_title1_'.$key] : '');
                $form->text('style7_title2_'.$key, [
                    'label' => 'Tiêu đề lớn ('.$lang['label'].')',
                    'start' => 6
                ], (isset($config['style7_title2_'.$key])) ? $config['style7_title2_'.$key] : '');
                $form->textarea('style7_content_'.$key, [
                    'label' => 'Nội dung ('.$lang['label'].')',
                    'start' => 12
                ], (isset($config['style7_content_'.$key])) ? $config['style7_content_'.$key] : '');
                $form->text('style7_btn_txt_'.$key, [
                    'label' => 'Chữ button ('.$lang['label'].')',
                    'start' => 12
                ], (isset($config['style7_btn_txt_'.$key])) ? $config['style7_btn_txt_'.$key] : '');
            }
        }
        $form->html(false);
    }
    static public function config($key = '') {
        $config = option::get('popup_salebanner_config');
        if (!have_posts($config)) $config = [];
        if (!isset($config['style7_title1'])) $config['style7_title1'] = 'Về nhà ăn Tết - Sale bằng hết';
        if (!isset($config['style7_title1_color'])) $config['style7_title1_color'] = '#fff';
        if (!isset($config['style7_title2'])) $config['style7_title2'] = 'SALE';
        if (!isset($config['style7_title2_color'])) $config['style7_title2_color'] = '#FFC107';
        if (!isset($config['style7_content'])) $config['style7_content'] = 'Giảm giá lên đến 25% cho sản phẩm & nhiều quà tặng hấp dẫn';
        if (!isset($config['style7_content_color'])) $config['style7_content_color'] = '#fff';
        if (!isset($config['style7_btn_txt'])) $config['style7_btn_txt'] = 'Xem ngay';
        if (!isset($config['style7_btn_color'])) $config['style7_btn_color'] = '#FFC107';
        if (!isset($config['style7_btn_bg'])) $config['style7_btn_bg'] = '#FC0E56';
        if (!isset($config['style7_btn_url'])) $config['style7_btn_url'] = base_url();
        if (!isset($config['style7_popup_bg'])) $config['style7_popup_bg'] = 'http://cdn.sikido.vn/images/popup/salebanner-7.png';
        if (!empty($key)) {
            if (isset($config[$key])) return $config[$key];
            return '';
        }
        return $config;
    }
    static public function admin_config_save(\SkillDo\Http\Request $request): void
    {
        $config = static::config();
        $config['style7_title1'] = $request->input('style7_title1');
        $config['style7_title1_color'] = $request->input('style7_title1_color');
        $config['style7_title2'] = $request->input('style7_title2');
        $config['style7_title2_color'] = $request->input('style7_title2_color');
        $config['style7_content'] = $request->input('style7_content');
        $config['style7_content_color'] = $request->input('style7_content_color');
        $config['style7_btn_txt'] = $request->input('style7_btn_txt');
        $config['style7_btn_color'] = $request->input('style7_btn_color');
        $config['style7_btn_bg'] = $request->input('style7_btn_bg');
        $config['style7_btn_url'] = $request->input('style7_btn_url');
        $config['style7_popup_bg'] = FileHandler::handlingUrl($request->input('style7_popup_bg'));
        if (Language::hasMulti()) {
            foreach (Language::list() as $key => $lang) {
                if ($key == Language::default()) continue;
                $config['style7_title1_' . $key] = $request->input('style7_title1_' . $key);
                $config['style7_title2_' . $key] = $request->input('style7_title2_' . $key);
                $config['style7_content_' . $key] = $request->input('style7_content_' . $key);
                $config['style7_btn_txt_' . $key] = $request->input('style7_btn_txt_' . $key);
            }
        }
        Option::update('popup_salebanner_config', $config);
    }

    static public function render(): void
    {
        $config = static::config();
        $language_current = Language::current();
        if (Language::default() != $language_current) {
            $config['style7_title1'] = (!empty($config['style7_title1_' . $language_current])) ? $config['style7_title1_' . $language_current] : $config['style7_title1'];
            $config['style7_title2'] = (!empty($config['style7_title2_' . $language_current])) ? $config['style7_title2_' . $language_current] : $config['style7_title2'];
            $config['style7_content'] = (!empty($config['style7_content_' . $language_current])) ? $config['style7_content_' . $language_current] : $config['style7_content'];
            $config['style7_btn_txt'] = (!empty($config['style7_btn_txt_' . $language_current])) ? $config['style7_btn_txt_' . $language_current] : $config['style7_btn_txt'];
        }
        Plugin::view(POPUP_NAME, 'modules/salebanner/style7/popup', ['config' => $config]);
    }
}