<div class="box mt-2 mb-2">
    <div class="box-header">
        <h4 class="box-title">Cấu hình chung</h4>
    </div>
    <div class="box-content">
        <div class="m-3">
            <div class="row">
                @php
                    $Form = form();
                    $Form->radio(
                        'active',
                        [
                            'off' => 'Tắt popup',
                            'default' => 'Popup mặc định',
                            'contactform' => 'Popup thông tin liên hệ',
                            'salebanner' => 'Popup quảng cáo sản phẩm',
                        ],
                        [
                            'label' => 'Sử dụng loại popup',
                            'single' => true,
                            'after' => '<div class="col-md-6">',
                            'before' => '</div>',
                        ],
                        popup::config('active'),
                    );
                    $Form->checkbox(
                        'show',
                        [
                            'all' => 'Tất cả các trang',
                            'home_index' => 'Trang chủ',
                            'post_index' => 'Trang danh sách bài viết',
                            'post_detail' => 'Trang bài viết chi tiết',
                            'page_detail' => 'Trang nội dung',
                            'products_index' => 'Trang danh sách sản phẩm',
                            'products_detail' => 'Trang chi tiết sản phẩm',
                        ],
                        [
                            'label' => 'Hiển thị',
                            'after' => '<div class="col-md-6">',
                            'before' => '</div>',
                        ],
                        popup::config('show'),
                    );
                    $Form->select(
                        'loop',
                        [
                            'loop' => 'Hiển thị lặp lại',
                            'only' => 'Chỉ hiển thị một lần',
                        ],
                        [
                            'label' => 'Lặp lại',
                        ],
                        popup::config('loop'),
                    );
                    $Form->number(
                        'time_delay',
                        [
                            'label' => 'Thời gian delay (giây)',
                            'after' => '<div class="col-md-6">',
                            'before' => '</div>',
                        ],
                        popup::config('time_delay'),
                    );
                    $Form->number(
                        'time_loop',
                        [
                            'label' => 'Thời gian lặp lại (phút)',
                            'after' => '<div class="col-md-6">',
                            'before' => '</div>',
                        ],
                        popup::config('time_loop'),
                    );
                    $Form->html(false);
                @endphp
            </div>
        </div>
    </div>
</div>

<div class="box mb-2">
    <div class="box-header">
        <h4 class="box-title">Cấu hình popup thông tin liên hệ</h4>
    </div>
    <div class="box-content">
        <div class="m-3">
            <div class="row">
                @php
                    $Form->checkbox(
                        'contactform_input',
                        [
                            'email' => 'Input Email khách hàng',
                            'phone' => 'Input Số điện thoại khách hàng',
                            'note' => 'Input ghi chú',
                        ],
                        [
                            'label' => 'Input lấy thông tin',
                            'after' => '<div class="col-xs-6 col-md-6">',
                            'before' => '</div>',
                        ],
                        popup::config('contactform_input'),
                    );
                    $Form->checkbox(
                        'contactform_required',
                        [
                            'email' => 'Bật/ tắt bắt buộc email',
                            'phone' => 'Bật/ tắt bắt buộc điện thoại',
                            'note' => 'Bật/ tắt bắt buộc ghi chú',
                        ],
                        [
                            'label' => 'Bắt buộc điền thông tin',
                            'after' => '<div class="col-xs-6 col-md-6">',
                            'before' => '</div>',
                        ],
                        popup::config('contactform_required'),
                    );
                    $Form->html(false);
                @endphp
            </div>
        </div>
    </div>
</div>
