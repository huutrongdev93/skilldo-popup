{{--
    Màn hình dựng popup.

    Bản riêng của `admin::builder-page`, khác đúng ba điểm:
      1. #preview-form bắn dữ liệu sang `review/popup` (khung xem thử có nền + lớp phủ
         mô phỏng popup thật) thay vì `review/layout`;
      2. window.BUILDER_PERMISSIONS_CONFIG mở quyền thêm hàng/cột/element cho mọi admin
         — element-builder.js đọc biến này ngay trong init() (xem BUILDER.md §4);
      3. nút quay lại trỏ về danh sách popup.

    data-builder-type PHẢI giữ nguyên "layout": JS builder chỉ hiểu 5 loại section và
    nằm trong bundle đã obfuscate.
--}}
{!! \SkillDo\Cms\Support\Admin::partial('resources/builder/builder-header', [
    'title'      => 'Popup: '.$title,
    'responsive' => true,
    'viewUrl'    => \SkillDo\Cms\Support\Url::admin('popup/edit/'.$popup->popup_id),
]) !!}

<div class="element-builder" data-builder-type="layout" data-builder-id="{!! $sectionId !!}">
    {!! \SkillDo\Cms\Support\Admin::partial('resources/builder/builder-sidebar') !!}
    <div class="builder">
        <div class="box h-full">
            <div class="box-content p-0 h-full" style="flex: 0;--preview-height:{!! $previewHeight !!};">
                <form id="preview-form" action="{!! Url::base('review/popup') !!}" method="POST" target="preview-frame-target" style="display:none;">
                    {!! csrf_field() !!}
                    <input type="hidden" name="data" id="preview-data-input">
                    <input type="hidden" name="popup_id" value="{!! $popup->popup_id !!}">
                </form>
                <div class="preview-box position-relative h-full">
                    {!! Admin::loading('preview-loader') !!}
                    <iframe name="preview-frame-target" id="preview-frame" src="about:blank"></iframe>
                </div>
            </div>
        </div>
        <div class="d-none" id="{!! $sectionId !!}-builder" data-key="{!! $sectionId !!}"></div>
    </div>
</div>

{!! \SkillDo\Cms\Support\Admin::partial('resources/builder/builder-structure') !!}

{!! \SkillDo\Cms\Support\Admin::partial('resources/builder/builder-config') !!}

{!! \SkillDo\Cms\Support\Admin::partial('resources/builder/builder-template') !!}

{!! \SkillDo\Cms\Support\Admin::partial('resources/builder/content-menu-ui') !!}

{!! \SkillDo\Cms\Support\Admin::partial('resources/builder/builder-studio') !!}

<script>
    /*
     * Trình dựng popup mở quyền thêm mới nội dung cho MỌI tài khoản admin.
     * Chính sách khoá của core tính cho builder giao diện (hỏng là hỏng cả site),
     * còn popup là nội dung độc lập nên khách hàng phải tự dựng được.
     * Phía PHP mở bằng filter `element_builder_permissions` (bootstrap/config.php).
     */
    window.BUILDER_PERMISSIONS_CONFIG = {
        canAddRow: 1,
        canAddColumn: 1,
        canDragElement: 1
    };

    $(document).ready(function()
    {
        ElementBuilderGlobal.init();
    });
</script>
<style>
    body .admin-sidebar {
        min-height: 100vh!important;
    }
    body .page-content .page-body {
        padding-bottom: 0;
    }
</style>
