# CLAUDE.md — plugin `popup` (Marketing · Pop-up)

Hướng dẫn cho agent/dev làm việc bên trong `plugins/popup`. Đọc file này trước khi quét source.

## Plugin này là gì

Popup quảng cáo / khuyến mãi / thu thập thông tin cho SkillDo CMS v8. Namespace PHP `Popup\*`
(alias khai trong `plugin.json`), **không có alias toàn cục**. Hai bảng riêng:

| Bảng | Việc |
|---|---|
| `popups` | mỗi dòng là một popup: `popup_key`, `name`, `status`, `loop`/`time_delay`/`time_loop`, `template` (mẫu), `locale`, `settings` (mảng cấu hình của mẫu, serialize) |
| `popups_submission` | dữ liệu khách gửi từ form trong popup (`data` = `[key => ['label','value']]`) |

Một popup chọn **một mẫu** (`template`). Từ 2.1.0 **mọi mẫu đều là preset của trình kéo thả**:

- 13 mẫu có sẵn (`PopupDefault`, `PopupStyle1..12`) khai `preset()` — một cây builder dựng bằng element
  chung (tiêu đề, văn bản, ảnh, nút, form popup) mô phỏng bố cục/màu/nội dung của mẫu, cộng `frame`
  (kích thước, bo góc, nền của khung popup).
- `PopupBuilder` (`builder`) là mẫu trắng: `preset()` trả rỗng, người dùng dựng từ đầu.

Chọn mẫu → `BuilderSectionService::seed()` ghi cây đó vào section `popup_{id}` → từ đó **mọi thứ sửa
trong trình dựng**. Nội dung preset lấy từ `config()` của popup (settings đã lưu, thiếu thì
`configDefault()`), nên popup của bản cũ chuyển sang kéo thả mà không mất chữ/màu/ảnh đã soạn.

Form cấu hình trong admin chỉ còn phần **khung** (`PopupStyleBase::frameForm()`) + nút mở trình dựng và
nút *Áp dụng lại mẫu*. `views/styles/{key}.blade.php` là **đường lùi**: chỉ render khi popup chưa kịp seed.

## Bản đồ file

```
app/
  Ajax/Admin/PopupAjax.php        config()  – trả HTML form cấu hình của mẫu đang chọn (metabox)
  Ajax/Web/PopupAjax.php          submit()  – form của 13 mẫu cứng
                                  submitBuilder() – form của PopupFormElement (mẫu builder)
  Controllers/Admin/PopupController.php         danh sách / thêm / sửa popup
  Controllers/Admin/PopupBuilderController.php  MỞ TRÌNH DỰNG cho một popup
  Controllers/Admin/PopupSubmissionController.php
  Controllers/Web/PopupReviewController.php     nội dung <iframe> xem thử của trình dựng
  Models/Popup.php · PopupSubmission.php
  Modules/Admin/Popups/PopupForm.php   input + nút của form popup, beforeSave
  Modules/Admin/Popups/PopupTable.php  bảng danh sách (có nút "Thiết kế" cho mẫu builder)
  Modules/Web/Popups.php               matched() + render() ở hook cle_footer
  Services/ActivatorService.php · DeactivatorService.php   tạo/xoá bảng + dọn section builder
  Services/AdminService.php            menu, tab hệ thống, đếm submission mới
  Services/AssetsService.php           css/js chung + bundle của từng popup builder
  Services/BuilderSectionService.php   DỮ LIỆU: section builder của popup (tạo/đọc/xoá/build/tìm widget)
  Services/BuilderService.php          CHÍNH SÁCH: hook lưu/xoá, quyền kéo thả, ẩn khuôn khỏi builder theme
  Styles/PopupStyle.php                registry mẫu ('builder' + 'default' + style1..12)
  Styles/PopupStyleBase.php            lớp cơ sở: form khung dùng chung, render (builder → blade cũ), preset()
  Styles/Popup{Default,Style1..12}.php mỗi mẫu = configDefault() (nội dung) + preset() (cây builder)
  Presets/PopupPresetBuilder.php       dựng row/column/widget đúng schema builder + mảnh style dùng chung
  Presets/PopupPresetLayout.php        4 khuôn bố cục: split (nội dung + ảnh), banner (ảnh nền), plain
  Services/PopupMigrationService.php   chuyển popup của bản cũ sang kéo thả (ActivatorService + trang danh sách)
elements/
  elements.json                  scope "popup" -> 6 element dưới đây (BẮT BUỘC, v8 không quét thư mục)
  popup-heading/ popup-text/     PopupHeadingElement · PopupTextElement   – tiêu đề, đoạn văn bản
  popup-image/  popup-button/    PopupImageElement   · PopupButtonElement – ảnh, nút bấm
  popup-form/                    PopupFormElement  – form thu thập thông tin trong popup
  popup-close/                   PopupCloseElement – nút "Để sau"/"Đóng"
views/
  popup.blade.php                khung modal chung cho MỌI mẫu + PopupScheduler
  styles/{key}.blade.php         nội dung từng mẫu (builder.blade.php là mẫu kéo thả)
  admin/popup/index.blade.php    trang danh sách
  admin/popup/metabox.blade.php  lưới chọn mẫu + JS nạp form cấu hình theo mẫu
  admin/popup/builder.blade.php  MÀN HÌNH TRÌNH DỰNG (bản riêng của admin::builder-page)
  admin/popup/review.blade.php   khung xem thử (nền tối + khung popup) bọc admin::builder-review-single
assets/js/popup-script.js        PopupScheduler (lịch hiển thị) + xử lý .js-popup-close
```

## Popup kéo thả nối vào Page Builder thế nào

**Mỗi popup mẫu `builder` = một `element_builder_sections`:**

```
type    = 'layout'          <- CỐ Ý dùng lại loại có sẵn
key     = 'popup_{popup_id}'
element = 'popup'           <- quyết định nhóm element trong sidebar (scope elements.json)
scope   = ''
```

**Vì sao `type=layout` chứ không thêm loại section mới:** `views/admin/assets/js/bundle/element-builder.js`
hard-code đúng 5 loại (`home/page/header/footer/layout`) và chạy từ `script.bundle.js` đã obfuscate —
thêm loại mới là phải build lại bundle qua DevTool. Dùng `layout` thì nạp dữ liệu, lưu, nháp, lịch sử,
undo/redo, thanh Cấu trúc… của core chạy nguyên vẹn, plugin **không sửa một dòng JS nào**.

Luồng đầy đủ:

| Bước | Ai làm |
|---|---|
| Lưu popup | `BuilderService::afterSavePopup` (hook `save_popup_object`) → `BuilderSectionService::seed()` tạo section + dựng preset của mẫu (bỏ qua nếu popup đã có nội dung) |
| Popup của bản cũ | `PopupMigrationService::migrateAll()` chạy ở `ActivatorService::activate()` và ở `PopupController@index` |
| Dựng lại theo mẫu | nút *Áp dụng lại mẫu* → ajax `PopupAjax::applyPreset` → `seed(force: true)` (ghi đè, có xác nhận) |
| Mở trình dựng | `admin/popup/builder/{id}` → `PopupBuilderController` → `views/admin/popup/builder.blade.php` (`data-builder-type="layout"`, `data-builder-id="popup_{id}"`) |
| Nạp cây + danh sách element | ajax core `BuilderAjax::loadData/loadElement` (nhánh `layout`) |
| Xem thử | `#preview-form` POST sang **`review/popup`** → `PopupReviewController` → `views/admin/popup/review.blade.php` |
| Xuất bản | ajax core `BuilderAjax::save` (`page=layout`) → ghi section → `ThemeLayout::build('popup_{id}')` → bundle `layout-{md5(key)}` |
| Hiển thị ngoài site | `Popups::render()` → mẫu `builder` → `views/styles/builder.blade.php` → `ElementBuilder::render()`; CSS/JS bundle do `AssetsService::builderAssets()` nạp |
| Xoá popup | `BuilderService::beforeDeletePopup` (hook `ajax_delete_popup_before_success`) → `BuilderSectionService::delete()` (section + nháp + lịch sử + file bundle) |

## Vì sao plugin tự mang bộ element cơ bản

Element của theme (`HeadingElementStyle1`, `ButtonElement`, `ImageElement`, `TextEditorElement`…) được
**tải theo nhu cầu** từ kho: `BuilderServiceAjax::download/install` giải nén vào `views/<theme>/elements/`
rồi ghi vào `elements.json` của theme. Một site thật vì thế chỉ có vài element — cái nào cần mới tải.

Preset trỏ vào element không tồn tại thì `ElementManager::getElement()` trả `null`,
`ElementBuilder::builderColum()` bỏ qua và widget render ra **rỗng**: popup thủng lỗ, không báo lỗi gì.

Vì vậy **preset chỉ dùng element `Popup*` đi kèm plugin** (`PopupPresetBuilder` chỉ sinh 6 type này).
Element của theme vẫn hiện trong sidebar khi site có, người dùng kéo thêm tuỳ ý — nhưng mẫu dựng sẵn
không phụ thuộc vào chúng. Thêm lưới an toàn: `BuilderSectionService::keepAvailableWidgets()` loại khỏi
preset mọi widget mà site không có element (dùng cho preset do plugin khác thêm sau này).

## Hai filter của core mà plugin dựa vào (thêm ở CMS 8.2.x)

| Filter | Ở đâu | Plugin dùng để |
|---|---|---|
| `element_builder_permissions` | `packages/skilldo/cms/src/Element/ElementPermission.php` | mở `canAddRow` / `canAddColumn` / `canDragElement` cho **mọi admin**, nhưng **chỉ** khi request là `admin/popup/builder/*` hoặc `review/popup` |
| `builder_index_layouts` | `app/Controllers/Admin/BuilderController@index` + `BuilderAjax::loadNavigatorLayouts` | ẩn section popup khỏi danh sách khuôn trang của Giao diện → Trình dựng |

Phía JS quyền được mở bằng `window.BUILDER_PERMISSIONS_CONFIG` in ngay trong `builder.blade.php`
(đường override có sẵn của `element-builder.js`, không phải sửa bundle).

## Quy tắc & bẫy

1. **Element mới phải khai vào `elements/elements.json`** (v8 không quét thư mục) và phải
   `Cache::delete('theme_elements')` — dùng `BuilderSectionService::clearElementCache()`.
   Scope `popup` chỉ cần tồn tại là `ElementManager` tự trộn toàn bộ scope `general` vào (81 element).
2. **`data-builder-type` phải là `layout`.** Đổi thành giá trị khác là JS builder không khởi tạo section.
3. **Route `review/popup` bắt buộc `auth:admin`** — nó render dữ liệu builder chưa lưu, chưa kiểm duyệt.
4. **Đừng tin field do client gửi.** `submitBuilder()` đọc lại danh sách field từ cây builder đã lưu
   (`BuilderSectionService::findWidget()` + `formFields()`), client chỉ gửi giá trị.
5. **`settings` của widget trong cây builder có thể RỖNG.** Builder chỉ lưu những gì người dùng đã đụng
   tới: element vừa kéo vào mà chưa mở form cấu hình được lưu với `settings: {}` — ngoài site nó vẫn hiện
   đủ nội dung vì `Element::default()` điền lúc render. Vì vậy mọi chỗ đọc cấu hình widget ở server phải
   dựng lại instance element rồi gọi `default()` (đúng việc `BuilderSectionService::formFields()` làm),
   không đọc thẳng `$widget['settings'][...]` — đọc thẳng thì form vừa kéo vào sẽ báo
   "Form chưa được cấu hình trường thông tin".
6. **Form của khách phải đăng ký `Ajax::client`.** Đăng ký nhầm `Ajax::admin` thì `AjaxController` chỉ
   tra khi người gửi đã đăng nhập có `loggin_admin` → khách luôn nhận "ajax action not found"
   (lỗi này từng xảy ra với `PopupAjax::submit`).
7. **`popup_key` chỉ sinh khi thêm mới.** Nó là khoá `localStorage popup_shown_*` của `PopupScheduler`;
   sinh lại mỗi lần lưu = mọi khách đã xem lại thấy popup "chỉ hiện một lần".
8. **Cấu hình chung (nút bánh răng) trong trình dựng vẫn ghi `theme_option` của cả site** — đây là hành
   vi của `BuilderAjax::save` dùng chung cho mọi builder. Đổi màu chủ đạo trong trình dựng popup là đổi
   cho toàn site, không phải riêng popup.
9. **Bundle CSS/JS chỉ được dựng lại khi bấm Xuất bản.** Sửa `cssBuilder()` của element popup xong phải
   vào trình dựng bấm Xuất bản (hoặc xoá file bundle để `AssetsService` dựng lại).
10. Đổi mẫu **không tự ghi đè** thiết kế đang có: `seed()` chỉ chạy khi cây builder rỗng. Muốn lấy lại
   bố cục của mẫu thì bấm *Áp dụng lại mẫu*. Xoá popup mới dọn section.
11. **Preset ghi `frame` đè lên settings khung** ở lần seed đầu (`applyFrame(..., true)`): lúc đó khung
   mới chỉ là giá trị mặc định của form (700px), nếu không đè thì mẫu 480px nào cũng ra 700px.
12. Viết preset thì khai **đúng khoá** của element (`heading`/`headingStyle`, `content`/`textStyle`,
   `text`+`link`+`style`, `img`, `fields`) và đúng schema
   `Template::cssText/cssButton/cssBackground/cssSpacing` — sai khoá là style im lặng không áp.
   Kiểm nhanh bằng `ElementBuilder::render()` + `buildAssets()` trong CLI thay vì mở trình duyệt.
   **Không mượn element của theme trong preset** (xem mục trên); cần loại nội dung mới thì viết element
   trong `plugins/popup/elements/` rồi khai vào `elements.json`.
13. `minifyCss` rút gọn màu khi build (`#00ff00` → `lime`), nên đừng so CSS bằng chuỗi hex thô.
14. **Căn popup bằng flex trên chính `.modal`, không bằng `margin` của `.modal-dialog`.** Bootstrap mở
   modal bằng inline `style="display:block"` nên phải `#popup_x.modal.show{display:flex!important}`
   (id + `.show` mới thắng inline style). Ghi đè `margin:auto` như bản đầu làm popup dán vào mép trên
   và popup cao hơn màn hình thì bị cắt mất phần dưới. Khoảng cách tới mép do `settings.edgeSpacing`
   (mặc định 30px, tự nâng lên 50px khi nút đóng đặt NGOÀI khung), `modal-body` có
   `max-height: calc(100vh - edge*2 - 20px)` + `overflow-y:auto` để nội dung dài cuộn được.
