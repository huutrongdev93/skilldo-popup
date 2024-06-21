<?php
function popup_salebanner_style3_register($style) {
    $style['popup_salebanner_style3'] = ['label' => 'Style 2'];
    return $style;
}

add_filter('popup_salebanner_style', 'popup_salebanner_style3_register');

class popup_salebanner_style3 {
    static public function admin_demo() {
        Template::img(Url::base(Path::plugin( POPUP_NAME ).'/assets/images/salebanner/demo-style3.png'));
    }
    static public function admin_config($key = '') {
        $config = static::config();
        $form = form();
        $form->text('style3_title1', [
            'label' => 'Tiêu đề nhỏ',
            'start' => 6
        ], $config['style3_title1']);
        $form->color('style3_title1_color', [
            'label' => 'Màu tiêu đề nhỏ',
            'start' => 6
        ], $config['style3_title1_color']);

        $form->text('style3_title2', [
            'label' => 'Tiêu đề lớn',
            'start' => 6
        ], $config['style3_title2']);
        $form->color('style3_title2_color', [
            'label' => 'Màu tiêu đề lớn',
            'start' => 6
        ], $config['style3_title2_color']);

        $form->text('style3_title3', [
            'label' => 'Tiêu đề sale',
            'start' => 6
        ], $config['style3_title3']);
        $form->color('style3_title3_color', [
            'label' => 'Màu tiêu đề sale',
            'start' => 6
        ], $config['style3_title3_color']);

        $form->textarea('style3_content', [
            'label' => 'Nội dung',
        ], $config['style3_content']);
        $form->color('style3_content_color', [
            'label' => 'Màu nội dung',
            'start' => 12
        ], $config['style3_content_color']);

        $form->text('style3_btn_txt', [
            'label' => 'Chữ button',
            'start' => 4
        ], $config['style3_btn_txt']);
        $form->color('style3_btn_color', [
            'label' => 'Màu Chữ button',
            'start' => 4
        ], $config['style3_btn_color']);
        $form->color('style3_btn_bg', [
            'label' => 'Màu nền button',
            'start' => 4
        ], $config['style3_btn_bg']);
        $form->text('style3_btn_url', [
            'label' => 'Liên kết',
        ], $config['style3_btn_url']);
        $form->image('style3_popup_bg', [
            'label' => 'Hình nền popup',
            'start' => 12
        ], $config['style3_popup_bg']);

        if(Language::hasMulti()) {
            foreach (Language::list() as $key => $lang) {
                if($key == Language::default()) continue;
                $form->text('style3_title1_'.$key, [
                    'label' => 'Tiêu đề nhỏ ('.$lang['label'].')',
                    'start' => 6
                ], (isset($config['style3_title1_'.$key])) ? $config['style3_title1_'.$key] : '');
                $form->text('style3_title2_'.$key, [
                    'label' => 'Tiêu đề lớn ('.$lang['label'].')',
                    'start' => 6
                ], (isset($config['style3_title2_'.$key])) ? $config['style3_title2_'.$key] : '');
                $form->text('style3_title3_'.$key, [
                    'label' => 'Tiêu đề sale ('.$lang['label'].')',
                    'start' => 12
                ], (isset($config['style3_title3_'.$key])) ? $config['style3_title2_'.$key] : '');
                $form->textarea('style3_content_'.$key, [
                    'label' => 'Nội dung ('.$lang['label'].')',
                    'start' => 12
                ], (isset($config['style3_content_'.$key])) ? $config['style3_content_'.$key] : '');
                $form->text('style3_btn_txt_'.$key, [
                    'label' => 'Chữ button ('.$lang['label'].')',
                    'start' => 12
                ], (isset($config['style3_btn_txt_'.$key])) ? $config['style3_btn_txt_'.$key] : '');
            }
        }
        $form->html(false);
    }
    static public function config($key = '') {
        $config = option::get('popup_salebanner_config');
        if(!have_posts($config)) $config = [];
        if(!isset($config['style3_title1'])) $config['style3_title1'] = 'ƯU ĐÃI LỚN';
        if(!isset($config['style3_title1_color'])) $config['style3_title1_color'] = '#fff';
        if(!isset($config['style3_title2'])) $config['style3_title2'] = 'SALE';
        if(!isset($config['style3_title2_color'])) $config['style3_title2_color'] = '#fff';
        if(!isset($config['style3_title3'])) $config['style3_title3'] = 'GIẢM NGAY 70%';
        if(!isset($config['style3_title3_color'])) $config['style3_title3_color'] = '#fff';
        if(!isset($config['style3_content'])) $config['style3_content'] = 'Tặng ngay món quà đặc biệt cho các khách hàng mua đơn hàng có giá trị từ 500.000đ';
        if(!isset($config['style3_content_color'])) $config['style3_content_color'] = '#fff';
        if(!isset($config['style3_btn_txt'])) $config['style3_btn_txt'] = 'Xem ngay';
        if(!isset($config['style3_btn_color'])) $config['style3_btn_color'] = '#000';
        if(!isset($config['style3_btn_bg'])) $config['style3_btn_bg'] = 'yellow';
        if(!isset($config['style3_btn_url'])) $config['style3_btn_url'] = base_url();
        if(!isset($config['style3_popup_bg'])) $config['style3_popup_bg'] = 'http://cdn.sikido.vn/images/popup/salebanner-3.jpg';
        if(!empty($key)) {
            if(isset($config[$key])) return $config[$key];
            return '';
        }
        return $config;
    }
    static public function admin_config_save(\SkillDo\Http\Request $request): void
    {
        $config = static::config();
        $config['style3_title1']       = $request->input('style3_title1');
        $config['style3_title1_color'] = $request->input('style3_title1_color');
        $config['style3_title2']       = $request->input('style3_title2');
        $config['style3_title2_color'] = $request->input('style3_title2_color');
        $config['style3_title3']       = $request->input('style3_title3');
        $config['style3_title3_color'] = $request->input('style3_title3_color');
        $config['style3_content']      = $request->input('style3_content');
        $config['style3_content_color']= $request->input('style3_content_color');
        $config['style3_btn_txt']      = $request->input('style3_btn_txt');
        $config['style3_btn_color']    = $request->input('style3_btn_color');
        $config['style3_btn_bg']       = $request->input('style3_btn_bg');
        $config['style3_btn_url']      = $request->input('style3_btn_url');
        $config['style3_popup_bg']     = FileHandler::handlingUrl($request->input('style3_popup_bg'));
        if(Language::hasMulti()) {
            foreach (Language::list() as $key => $lang) {
                if($key == Language::default()) continue;
                $config['style3_title1_'.$key]     = $request->input('style3_title1_'.$key);
                $config['style3_title2_'.$key]     = $request->input('style3_title2_'.$key);
                $config['style3_title3_'.$key]     = $request->input('style3_title3_'.$key);
                $config['style3_content_'.$key]    = $request->input('style3_content_'.$key);
                $config['style3_btn_txt_'.$key]    = $request->input('style3_btn_txt_'.$key);
            }
        }
        Option::update('popup_salebanner_config', $config);
    }

    static public function render(): void
    {
        $config = static::config();
        $language_current = Language::current();
        if (Language::default() != $language_current) {
            $config['style3_title1'] = (!empty($config['style3_title1_' . $language_current])) ? $config['style3_title1_' . $language_current] : $config['style3_title1'];
            $config['style3_title2'] = (!empty($config['style3_title2_' . $language_current])) ? $config['style3_title2_' . $language_current] : $config['style3_title2'];
            $config['style3_title3'] = (!empty($config['style3_title3_' . $language_current])) ? $config['style3_title3_' . $language_current] : $config['style3_title3'];
            $config['style3_content'] = (!empty($config['style3_content_' . $language_current])) ? $config['style3_content_' . $language_current] : $config['style3_content'];
            $config['style3_btn_txt'] = (!empty($config['style3_btn_txt_' . $language_current])) ? $config['style3_btn_txt_' . $language_current] : $config['style3_btn_txt'];
        }
        Plugin::view(POPUP_NAME, 'modules/salebanner/style3/popup', ['config' => $config]);
    }
}