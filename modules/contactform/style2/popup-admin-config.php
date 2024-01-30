<?php
$Form = new Form();
$Form->add('style2_title1', 'text', [
    'label' => 'Tiêu đề nhỏ',
    'after' => '<div class="col-md-6"><div class="form-group">','before' => '</div></div>',
], $config['style2_title1']);
$Form->add('style2_title1_color', 'color', [
    'label' => 'Màu tiêu đề nhỏ',
    'after' => '<div class="col-md-6"><div class="form-group">','before' => '</div></div>',
], $config['style2_title1_color']);

$Form->add('style2_content', 'textarea', [
    'label' => 'Nội dung',
], $config['style2_content']);
$Form->add('style2_content_color', 'color', [
    'label' => 'Màu nội dung',
    'after' => '<div class="col-md-12"><div class="form-group">','before' => '</div></div>',
], $config['style2_content_color']);

$Form->add('style2_btn_txt', 'text', [
    'label' => 'Chữ button',
    'after' => '<div class="col-md-4"><div class="form-group">','before' => '</div></div>',
], $config['style2_btn_txt']);
$Form->add('style2_btn_color', 'color', [
    'label' => 'Màu Chữ button',
    'after' => '<div class="col-md-4"><div class="form-group">','before' => '</div></div>',
], $config['style2_btn_color']);
$Form->add('style2_btn_bg', 'color', [
    'label' => 'Màu nền button',
    'after' => '<div class="col-md-4"><div class="form-group">','before' => '</div></div>',
], $config['style2_btn_bg']);
$Form->add('style2_popup_bg', 'image', [
    'label' => 'Hình nền popup',
    'after' => '<div class="col-md-12"><div class="form-group">','before' => '</div></div>',
], $config['style2_popup_bg']);

if(Language::hasMulti()) {
    foreach (Language::list() as $key => $lang) {
        if($key == Language::default()) continue;
        $Form->add('style2_title1_'.$key, 'text', [
            'label' => 'Tiêu đề nhỏ ('.$lang['label'].')',
            'after' => '<div class="col-md-12"><div class="form-group">', 'before' => '</div></div>'
        ], (isset($config['style2_title1_'.$key])) ? $config['style2_title1_'.$key] : '');
        $Form->add('style2_content_'.$key, 'textarea', [
            'label' => 'Nội dung ('.$lang['label'].')',
            'after' => '<div class="col-md-12"><div class="form-group">','before' => '</div></div>'
        ], (isset($config['style2_content_'.$key])) ? $config['style2_content_'.$key] : '');
        $Form->add('style2_btn_txt_'.$key, 'text', [
            'label' => 'Chữ button ('.$lang['label'].')',
            'after' => '<div class="col-md-12"><div class="form-group">','before' => '</div></div>'
        ], (isset($config['style2_btn_txt_'.$key])) ? $config['style2_btn_txt_'.$key] : '');
    }
}
$Form->html(false);