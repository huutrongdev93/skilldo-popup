<?php
function popup_salebanner_style1_register($style) {
    $style['popup_salebanner_style1'] = ['label' => 'Style 1'];
    return $style;
}
add_filter('popup_salebanner_style', 'popup_salebanner_style1_register');

class popup_salebanner_style1 {
    static public function admin_demo(): void
    {
        Template::img(Url::base(Path::plugin( POPUP_NAME ).'/assets/images/salebanner/demo-style1.png'));
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

        $form->text('title2',[
            'label' => 'Tiêu đề lớn',
            'start' => 6
        ], $config['title2']);
        $form->color('title2_color', [
            'label' => 'Màu tiêu đề lớn',
            'start' => 6
        ], $config['title2_color']);

        $form->textarea('content', [
            'label' => 'Nội dung',
        ], $config['content']);
        $form->color('content_color', [
            'label' => 'Màu nội dung',
            'after' => '<div class="col-md-12"><div class="form-group">','before' => '</div></div>',
        ], $config['content_color']);

        $form->text('btn_txt', [
            'label' => 'Chữ button',
            'after' => '<div class="col-md-4"><div class="form-group">','before' => '</div></div>',
        ], $config['btn_txt']);
        $form->color('btn_color', [
            'label' => 'Màu Chữ button',
            'after' => '<div class="col-md-4"><div class="form-group">','before' => '</div></div>',
        ], $config['btn_color']);
        $form->color('btn_bg', [
            'label' => 'Màu nền button',
            'after' => '<div class="col-md-4"><div class="form-group">','before' => '</div></div>',
        ], $config['btn_bg']);
        $form->text('btn_url', [
            'label' => 'Liên kết',
        ], $config['btn_url']);
        $form->color('popup_color', [
            'label' => 'Màu nền popup',
            'start' => 6
        ], $config['popup_color']);
        $form->image('popup_bg', [
            'label' => 'Hình nền popup',
            'start' => 6
        ], $config['popup_bg']);

        if(Language::hasMulti()) {
            foreach (Language::list() as $key => $lang) {
                if($key == Language::default()) continue;
                $form->text('title1_'.$key, [
                    'label' => 'Tiêu đề nhỏ ('.$lang['label'].')',
                    'start' => 6
                ], (isset($config['title1_'.$key])) ? $config['title1_'.$key] : '');
                $form->text('title2_'.$key, [
                    'label' => 'Tiêu đề lớn ('.$lang['label'].')',
                    'start' => 6
                ], (isset($config['title2_'.$key])) ? $config['title2_'.$key] : '');
                $form->textarea('content_'.$key, [
                    'label' => 'Nội dung ('.$lang['label'].')',
                    'start' => 6
                ], (isset($config['content_'.$key])) ? $config['content_'.$key] : '');
                $form->text('btn_txt_'.$key, [
                    'label' => 'Chữ button ('.$lang['label'].')',
                    'start' => 6
                ], (isset($config['btn_txt_'.$key])) ? $config['btn_txt_'.$key] : '');
            }
        }
        $form->html(false);
    }

    static public function config($key = '') {
        $config = option::get('popup_salebanner_config');
        if(!have_posts($config))            $config = [];
        if(!isset($config['title1']))       $config['title1'] = 'SUMMER';
        if(!isset($config['title1_color'])) $config['title1_color'] = '#fff';
        if(!isset($config['title2']))       $config['title2'] = 'SALE';
        if(!isset($config['title2_color'])) $config['title2_color'] = '#fff';
        if(!isset($config['content']))      $config['content'] = '+ Giảm 50% tất cả sản phẩm &amp; Miễn phí ship cho lần đặt hàng tiếp theo';
        if(!isset($config['content_color'])) $config['content_color'] = '#fff';
        if(!isset($config['btn_txt']))      $config['btn_txt'] = 'Mua ngay';
        if(!isset($config['btn_color']))    $config['btn_color'] = '#fff';
        if(!isset($config['btn_bg']))       $config['btn_bg'] = 'yellow';
        if(!isset($config['btn_url']))      $config['btn_url'] = 'https://sikido.vn';
        if(!isset($config['popup_color']))  $config['popup_color'] = '#000';
        if(!isset($config['popup_bg']))     $config['popup_bg'] = 'http://cdn.sikido.vn/images/popup/salebanner-1.png';
        if(!empty($key)) {
            if(isset($config[$key])) return $config[$key];
            return '';
        }
        return $config;
    }

    static public function admin_config_save(\SkillDo\Http\Request $request): void
    {
        $config = static::config();
        $config['title1']           = $request->input('title1');
        $config['title1_color']     = $request->input('title1_color');
        $config['title2']           = $request->input('title2');
        $config['content']          = $request->input('content');
        $config['content_color']    = $request->input('content_color');
        $config['btn_txt']          = $request->input('btn_txt');
        $config['btn_color']        = $request->input('btn_color');
        $config['btn_bg']           = $request->input('btn_bg');
        $config['btn_url']          = $request->input('btn_url');
        $config['popup_color']      = $request->input('popup_color');
        $config['popup_bg']         = FileHandler::handlingUrl($request->input('popup_bg'));
        if(Language::hasMulti()) {
            foreach (Language::list() as $key => $lang) {
                if($key == Language::default()) continue;
                $config['title1_'.$key]     = $request->input('title1_'.$key);
                $config['title2_'.$key]     = $request->input('title2_'.$key);
                $config['content_'.$key]    = $request->input('content_'.$key);
                $config['btn_txt_'.$key]    = $request->input('btn_txt_'.$key);
            }
        }
        Option::update('popup_salebanner_config', $config);
    }
    static public function render(): void
    {
        $config = static::config();
        $language_current = Language::current();
        if(Language::default() != $language_current) {
            $config['title1'] = (!empty($config['title1_'.$language_current])) ? $config['title1_'.$language_current] : $config['title1'];
            $config['title2'] = (!empty($config['title2_'.$language_current])) ? $config['title2_'.$language_current] : $config['title2'];
            $config['content'] = (!empty($config['content_'.$language_current])) ? $config['content_'.$language_current] : $config['content'];
            $config['btn_txt'] = (!empty($config['btn_txt_'.$language_current])) ? $config['btn_txt_'.$language_current] : $config['btn_txt'];
        }
        Plugin::view(POPUP_NAME, 'modules/salebanner/style1/popup', ['config' => $config]);
    }
}