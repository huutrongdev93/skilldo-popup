<?php
function popup_salebanner_style4_register($style) {
    $style['popup_salebanner_style4'] = ['label' => 'Style 2'];
    return $style;
}

add_filter('popup_salebanner_style', 'popup_salebanner_style4_register');

class popup_salebanner_style4 {
    static public function admin_demo(): void
    {
        Template::img(Url::base(Path::plugin( POPUP_NAME ).'/assets/images/salebanner/demo-style4.png'));
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

        $form->text('style4_title2', [
            'label' => 'Tiêu đề lớn',
            'start' => 6
        ], $config['style4_title2']);
        $form->color('style4_title2_color', [
            'label' => 'Màu tiêu đề lớn',
            'start' => 6
        ], $config['style4_title2_color']);

        $form->textarea('style4_content', [
            'label' => 'Nội dung',
        ], $config['style4_content']);
        $form->color('style4_content_color', [
            'label' => 'Màu nội dung',
            'start' => 12
        ], $config['style4_content_color']);

        $form->text('style4_price', [
            'label' => 'Giá',
            'start' => 12
        ], $config['style4_price']);
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
        $form->text('style4_btn_url', [
            'label' => 'Liên kết',
        ], $config['style4_btn_url']);
        $form->image('style4_popup_bg', [
            'label' => 'Hình nền popup',
            'start' => 12
        ], $config['style4_popup_bg']);

        if(Language::hasMulti()) {
            foreach (Language::list() as $key => $lang) {
                if($key == Language::default()) continue;
                $form->text('style4_title1_'.$key, [
                    'label' => 'Tiêu đề nhỏ ('.$lang['label'].')',
                    'start' => 6
                ], (isset($config['style4_title1_'.$key])) ? $config['style4_title1_'.$key] : '');
                $form->text('style4_title2_'.$key, [
                    'label' => 'Tiêu đề lớn ('.$lang['label'].')',
                    'start' => 6
                ], (isset($config['style4_title2_'.$key])) ? $config['style4_title2_'.$key] : '');
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
        $config = option::get('popup_salebanner_config');
        if (!have_posts($config)) $config = [];
        if (!isset($config['style4_title1'])) $config['style4_title1'] = 'Dịch vụ trọn gói';
        if (!isset($config['style4_title1_color'])) $config['style4_title1_color'] = 'rgb(140, 138, 139)';
        if (!isset($config['style4_title2'])) $config['style4_title2'] = 'Rộn Ràng Đón Xuân';
        if (!isset($config['style4_title2_color'])) $config['style4_title2_color'] = 'rgb(98, 187, 122)';
        if (!isset($config['style4_content'])) $config['style4_content'] = 'Hưởng ngay ưu đãi liệu trình massage thư giãn với tinh dầu thảo mộc';
        if (!isset($config['style4_content_color'])) $config['style4_content_color'] = 'rgb(140, 138, 139)';
        if (!isset($config['style4_price'])) $config['style4_price'] = '399k';
        if (!isset($config['style4_btn_txt'])) $config['style4_btn_txt'] = 'Mua ngay';
        if (!isset($config['style4_btn_color'])) $config['style4_btn_color'] = '#000';
        if (!isset($config['style4_btn_bg'])) $config['style4_btn_bg'] = 'yellow';
        if (!isset($config['style4_btn_url'])) $config['style4_btn_url'] = base_url();
        if (!isset($config['style4_popup_bg'])) $config['style4_popup_bg'] = 'http://cdn.sikido.vn/images/popup/salebanner-4.jpg';
        if (!empty($key)) {
            if (isset($config[$key])) return $config[$key];
            return '';
        }
        return $config;
    }
    static public function admin_config_save(\SkillDo\Http\Request $request): void
    {
        $config = static::config();
        $config['style4_title1'] = $request->input('style4_title1');
        $config['style4_title1_color'] = $request->input('style4_title1_color');
        $config['style4_title2'] = $request->input('style4_title2');
        $config['style4_title2_color'] = $request->input('style4_title2_color');
        $config['style4_content'] = $request->input('style4_content');
        $config['style4_content_color'] = $request->input('style4_content_color');
        $config['style4_price'] = $request->input('style4_price');
        $config['style4_btn_txt'] = $request->input('style4_btn_txt');
        $config['style4_btn_color'] = $request->input('style4_btn_color');
        $config['style4_btn_bg'] = $request->input('style4_btn_bg');
        $config['style4_btn_url'] = $request->input('style4_btn_url');
        $config['style4_popup_bg'] = FileHandler::handlingUrl($request->input('style4_popup_bg'));
        if (Language::hasMulti()) {
            foreach (Language::list() as $key => $lang) {
                if ($key == Language::default()) continue;
                $config['style4_title1_' . $key] = $request->input('style4_title1_' . $key);
                $config['style4_title2_' . $key] = $request->input('style4_title2_' . $key);
                $config['style4_content_' . $key] = $request->input('style4_content_' . $key);
                $config['style4_btn_txt_' . $key] = $request->input('style4_btn_txt_' . $key);
            }
        }
        Option::update('popup_salebanner_config', $config);
    }

    static public function render(): void
    {
        $config = static::config();
        $language_current = Language::current();
        if (Language::default() != $language_current) {
            $config['style4_title1'] = (!empty($config['style4_title1_' . $language_current])) ? $config['style4_title1_' . $language_current] : $config['style4_title1'];
            $config['style4_title2'] = (!empty($config['style4_title2_' . $language_current])) ? $config['style4_title2_' . $language_current] : $config['style4_title2'];
            $config['style4_content'] = (!empty($config['style4_content_' . $language_current])) ? $config['style4_content_' . $language_current] : $config['style4_content'];
            $config['style4_btn_txt'] = (!empty($config['style4_btn_txt_' . $language_current])) ? $config['style4_btn_txt_' . $language_current] : $config['style4_btn_txt'];
        }
        Plugin::view(POPUP_NAME, 'modules/salebanner/style4/popup', ['config' => $config]);
    }
}