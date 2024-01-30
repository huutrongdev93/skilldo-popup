<?php
$Form = new Form();
$Form->add('title1', 'text', [
    'label' => 'Tiêu đề nhỏ',
    'after' => '<div class="col-md-6"><div class="form-group">','before' => '</div></div>',
], $config['title1']);
$Form->add('title1_color', 'color', [
    'label' => 'Màu tiêu đề nhỏ',
    'after' => '<div class="col-md-6"><div class="form-group">','before' => '</div></div>',
], $config['title1_color']);

$Form->add('title2', 'text', [
    'label' => 'Tiêu đề lớn',
    'after' => '<div class="col-md-6"><div class="form-group">','before' => '</div></div>',
], $config['title2']);
$Form->add('title2_color', 'color', [
    'label' => 'Màu tiêu đề lớn',
    'after' => '<div class="col-md-6"><div class="form-group">','before' => '</div></div>',
], $config['title2_color']);

$Form->add('content', 'textarea', [
    'label' => 'Nội dung',
], $config['content']);
$Form->add('content_color', 'color', [
    'label' => 'Màu nội dung',
    'after' => '<div class="col-md-12"><div class="form-group">','before' => '</div></div>',
], $config['content_color']);

$Form->add('btn_txt', 'text', [
    'label' => 'Chữ button',
    'after' => '<div class="col-md-4"><div class="form-group">','before' => '</div></div>',
], $config['btn_txt']);
$Form->add('btn_color', 'color', [
    'label' => 'Màu Chữ button',
    'after' => '<div class="col-md-4"><div class="form-group">','before' => '</div></div>',
], $config['btn_color']);
$Form->add('btn_bg', 'color', [
    'label' => 'Màu nền button',
    'after' => '<div class="col-md-4"><div class="form-group">','before' => '</div></div>',
], $config['btn_bg']);
$Form->add('btn_url', 'text', [
    'label' => 'Liên kết',
], $config['btn_url']);
$Form->add('popup_color', 'color', [
    'label' => 'Màu nền popup',
    'after' => '<div class="col-md-6"><div class="form-group">','before' => '</div></div>',
], $config['popup_color']);
$Form->add('popup_bg', 'image', [
    'label' => 'Hình nền popup',
    'after' => '<div class="col-md-6"><div class="form-group">','before' => '</div></div>',
], $config['popup_bg']);

if(Language::hasMulti()) {
    foreach (Language::list() as $key => $lang) {
        if($key == Language::default()) continue;
        $Form->add('title1_'.$key, 'text', [
            'label' => 'Tiêu đề nhỏ ('.$lang['label'].')',
            'after' => '<div class="col-md-6"><div class="form-group">', 'before' => '</div></div>'
        ], (isset($config['title1_'.$key])) ? $config['title1_'.$key] : '');
        $Form->add('title2_'.$key, 'text', [
            'label' => 'Tiêu đề lớn ('.$lang['label'].')',
            'after' => '<div class="col-md-6"><div class="form-group">', 'before' => '</div></div>'
        ], (isset($config['title2_'.$key])) ? $config['title2_'.$key] : '');
        $Form->add('content_'.$key, 'textarea', [
            'label' => 'Nội dung ('.$lang['label'].')',
            'after' => '<div class="col-md-12"><div class="form-group">','before' => '</div></div>'
        ], (isset($config['content_'.$key])) ? $config['content_'.$key] : '');
        $Form->add('btn_txt_'.$key, 'text', [
            'label' => 'Chữ button ('.$lang['label'].')',
            'after' => '<div class="col-md-12"><div class="form-group">','before' => '</div></div>'
        ], (isset($config['btn_txt_'.$key])) ? $config['btn_txt_'.$key] : '');
    }
}
$Form->html(false);