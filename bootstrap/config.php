<?php

use Popup\Modules\Admin\Popups\PopupForm;
use Popup\Modules\Web\Popups;
use Popup\Services\AdminService;
use Popup\Services\AssetsService;
use Popup\Services\BuilderService;

add_filter('admin_system_tabs', [AdminService::class, 'system'], 50);
add_action('admin_navigation', [AdminService::class, 'navigation'], 50);
add_action('admin_after_popup_submission_table_view', [AdminService::class, 'popupSubmissionUpdate']);
/*
|--------------------------------------------------------------------------
| Đăng danh sách input vào form add và edit
|--------------------------------------------------------------------------
*/
add_filter('manage_popup_input', [PopupForm::class, 'fields']);

/*
|--------------------------------------------------------------------------
| Thêm các nút button vào form add và edit
|--------------------------------------------------------------------------
*/
add_filter('admin_form_popup_action_button', [PopupForm::class, 'buttons'], 10, 2);

/*
|--------------------------------------------------------------------------
| Xử lý dữ liệu trước khi lưu
|--------------------------------------------------------------------------
*/
add_filter('insert_data_popup_before_save', [PopupForm::class, 'beforeSave'], 10, 2);

add_action('theme_custom_assets', [AssetsService::class, 'web'], 10, 2);

add_action('cle_footer', [Popups::class, 'render']);
/*
|--------------------------------------------------------------------------
| Popup dựng bằng kéo thả (Page Builder)
|--------------------------------------------------------------------------
| Mỗi popup mẫu "builder" gắn với một section `type=layout`, `key=popup_{id}`.
| Xem Popup\Services\BuilderSectionService và plugins/popup/CLAUDE.md.
*/

//Tạo / đồng bộ section builder mỗi khi lưu popup
add_action('save_popup_object', [BuilderService::class, 'afterSavePopup'], 10, 4);

//Xóa section + nháp + lịch sử + bundle khi xóa popup
add_action('ajax_delete_popup_before_success', [BuilderService::class, 'beforeDeletePopup'], 10, 2);

/*
| Mở quyền thêm hàng / cột / element cho MỌI admin, nhưng chỉ trong trình dựng popup.
| Builder giao diện của theme giữ nguyên chính sách mặc định của core.
*/
add_filter('element_builder_permissions', [BuilderService::class, 'permissions']);

//Khuôn popup không phải khuôn trang: ẩn khỏi danh sách của Giao diện → Trình dựng
add_filter('builder_index_layouts', [BuilderService::class, 'hideLayouts']);
