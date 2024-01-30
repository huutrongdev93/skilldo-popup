<div class="box">
    <div class="header"><h3>Cấu hình chung</h3></div>
    <div class="box-content">
        <div class="m-3">
            <div class="row">
                <?php
                    $Form = new Form();
                    $Form->add('active', 'radio', [
                        'label' => 'Sử dụng loại popup',
                        'single' => true,
                        'options' => [
                            'off'   => 'Tăt popup',
                            'default' => 'Popup mặc định',
                            'contactform' => 'Popup thông tin liên hệ',
                            'salebanner' => 'Popup quảng cáo sản phẩm',
                        ],
                        'after' => '<div class="col-md-6">',
                        'before' => '</div>',
                    ], popup::config('active'));
                    $Form->add('show', 'checkbox', [
                        'label' => 'Hiển thị',
                        'options' => [
                            'all'           => 'Tất cả các trang',
                            'home_index'    => 'Trang chủ',
                            'post_index'    => 'Trang danh sách bài viết',
                            'post_detail'   => 'Trang bài viết chi tiết',
                            'page_detail'   => 'Trang nội dung',
                            'product_index' => 'Trang danh sách sản phẩm',
                            'product_detail'=> 'Trang chi tiết sản phẩm',
                        ],
                        'after' => '<div class="col-md-6">',
                        'before' => '</div>',
                    ], popup::config('show'));
                    $Form->add('loop', 'select', [
                        'label' => 'Lặp lại',
                        'options' => [
                            'loop'      => 'Hiển thị lặp lại',
                            'only'      => 'Chỉ hiển thị một lần',
                        ]
                    ], popup::config('loop'));
                    $Form->add('time_delay', 'number', ['label' => 'Thời gian delay (giây)','after' => '<div class="col-md-6">',
                        'before' => '</div>',], popup::config('time_delay'));
                    $Form->add('time_loop', 'number', ['label' => 'Thời gian lặp lại (phút)','after' => '<div class="col-md-6">',
                        'before' => '</div>',], popup::config('time_loop'));
                    $Form->html(false);
                ?>
            </div>
        </div>
    </div>
</div>

<div class="box">
    <div class="header"><h3>Cấu hình popup thông tin liên hệ</h3></div>
    <div class="box-content">
        <div class="m-3">
            <div class="row">
                <?php
                $Form->add('contactform_input', 'checkbox', [
                    'label' => 'Input lấy thông tin',
                    'options' => [
                        'email'           => 'Input Email khách hàng',
                        'phone'           => 'Input Số điện thoại khách hàng',
                        'note'            => 'Input ghi chú',
                    ],
                    'after' => '<div class="col-xs-6 col-md-6">',
                    'before' => '</div>',
                ], popup::config('contactform_input'));
                $Form->add('contactform_required', 'checkbox', [
                    'label' => 'Bắt buộc điền thông tin',
                    'options' => [
                        'email'           => 'Bật/ tắt bắt buộc email',
                        'phone'           => 'Bật/ tắt bắt buộc điện thoại',
                        'note'            => 'Bật/ tắt bắt buộc ghi chú',
                    ],
                    'after' => '<div class="col-xs-6 col-md-6">',
                    'before' => '</div>',
                ], popup::config('contactform_required'));
                $Form->html(false);
                ?>
            </div>
        </div>
    </div>
</div>
