<?php
$Form = new Form();
$Form->add('style6_title1', 'text', [
    'label' => 'Tiêu đề nhỏ',
    'after' => '<div class="col-md-6"><div class="form-group">','before' => '</div></div>',
], $config['style6_title1']);
$Form->add('style6_title1_color', 'color', [
    'label' => 'Màu tiêu đề nhỏ',
    'after' => '<div class="col-md-6"><div class="form-group">','before' => '</div></div>',
], $config['style6_title1_color']);

$Form->add('style6_title2', 'text', [
    'label' => 'Tiêu đề lớn',
    'after' => '<div class="col-md-6"><div class="form-group">','before' => '</div></div>',
], $config['style6_title2']);
$Form->add('style6_title2_color', 'color', [
    'label' => 'Màu tiêu đề lớn',
    'after' => '<div class="col-md-6"><div class="form-group">','before' => '</div></div>',
], $config['style6_title2_color']);

$Form->add('style6_content', 'text', [
    'label' => 'Nội dung',
    'after' => '<div class="col-md-6"><div class="form-group">','before' => '</div></div>',
], $config['style6_content']);
$Form->add('style6_content_color', 'color', [
    'label' => 'Màu nội dung',
    'after' => '<div class="col-md-6"><div class="form-group">','before' => '</div></div>',
], $config['style6_content_color']);

$Form->add('style6_btn_txt', 'text', [
    'label' => 'Chữ button',
    'after' => '<div class="col-md-4"><div class="form-group">','before' => '</div></div>',
], $config['style6_btn_txt']);
$Form->add('style6_btn_color', 'color', [
    'label' => 'Màu Chữ button',
    'after' => '<div class="col-md-4"><div class="form-group">','before' => '</div></div>',
], $config['style6_btn_color']);
$Form->add('style6_btn_bg', 'color', [
    'label' => 'Màu nền button',
    'after' => '<div class="col-md-4"><div class="form-group">','before' => '</div></div>',
], $config['style6_btn_bg']);
$Form->add('style6_btn_url', 'text', [
    'label' => 'Liên kết',
], $config['style6_btn_url']);

if(Language::hasMulti()) {
    foreach (Language::list() as $key => $lang) {
        if($key == Language::default()) continue;
        $Form->add('style6_title1_'.$key, 'text', [
            'label' => 'Tiêu đề nhỏ ('.$lang['label'].')',
            'after' => '<div class="col-md-6"><div class="form-group">', 'before' => '</div></div>'
        ], (isset($config['style6_title1_'.$key])) ? $config['style6_title1_'.$key] : '');
        $Form->add('style6_title2_'.$key, 'text', [
            'label' => 'Tiêu đề lớn ('.$lang['label'].')',
            'after' => '<div class="col-md-6"><div class="form-group">', 'before' => '</div></div>'
        ], (isset($config['style6_title2_'.$key])) ? $config['style6_title2_'.$key] : '');
        $Form->add('style6_content_'.$key, 'text', [
            'label' => 'Nội dung ('.$lang['label'].')',
            'after' => '<div class="col-md-6"><div class="form-group">','before' => '</div></div>'
        ], (isset($config['style6_content_'.$key])) ? $config['style6_content_'.$key] : '');
        $Form->add('style6_btn_txt_'.$key, 'text', [
            'label' => 'Chữ button ('.$lang['label'].')',
            'after' => '<div class="col-md-6"><div class="form-group">','before' => '</div></div>'
        ], (isset($config['style6_btn_txt_'.$key])) ? $config['style6_btn_txt_'.$key] : '');
    }
}
$Form->html(false);