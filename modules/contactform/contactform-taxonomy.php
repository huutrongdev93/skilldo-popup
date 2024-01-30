<?php
Taxonomy::addPost('popup_contactform', [
    'labels' => array(
        'name'          => __('Khách hàng đăng ký'),
        'singular_name' => __('Khách hàng đăng ký'),
    ),
    'show_in_nav_menus'  => false,
    'show_in_nav_admin'  => false,
    'supports' => array(
        'group' => array('info', 'seo', 'media'),
        'field' => array('title', 'excerpt', 'seo_title', 'seo_description', 'seo_keywords', 'image')
    ),
    'capabilities' => array(
        'view'      => 'view_posts',
        'add'       => 'add_popup_contactform',
        'edit'      => 'edit_popup_contactform',
        'delete'    => 'delete_posts',
    ),
]);

function popup_contactform_column_header( $columns ) {
    $columnsnew = [];
    $columnsnew['cb'] = 'cb';
    $columnsnew['style'] = 'Style';
    $columnsnew['info'] = 'Thông tin';
    $columnsnew['content'] = 'Ghi chú';
    $columnsnew['created'] = 'Thời gian';
    $columnsnew['action'] = '#';
    return $columnsnew;
}
add_filter( 'manage_post_popup_contactform_columns', 'popup_contactform_column_header');

function popup_contactform_single_row( $columns, $item ) {
    return '<tr class="tr_'.$item->id.' '.(($item->status == 1) ? 'new' : '').'">';
}
add_filter('single_row_post_popup_contactform', 'popup_contactform_single_row', 10, 2);

function popup_contactform_column_data( $column_name, $item ) {
    switch ( $column_name ) {
        case 'style':
            $item->image::admin_demo();
            break;
        case 'info':
            echo '<p>'.$item->title.'</p>';
            echo '<p>'.$item->excerpt.'</p>';
            break;
        case 'content':
            echo '<p>'.$item->content.'</p>';
            break;
    }
}
add_action( 'manage_post_popup_contactform_custom_column', 'popup_contactform_column_data',10,2);

function popup_contactform_read_footer() {
    if(Template::isPage('post_index')) {
        $post_type = Admin::getPostType();
        if(!empty($post_type) && $post_type == 'popup_contactform') {
            Option::update('popup_contactform_new', 0);
            model('post')->update(['status' => 0], Qr::set('post_type', 'popup_contactform')->where('status', 1));
        }
    }
}
add_action('admin_footer', 'popup_contactform_read_footer');