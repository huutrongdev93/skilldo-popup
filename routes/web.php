<?php
/*
| Khung xem thử của trình dựng popup.
|
| BẮT BUỘC giữ middleware auth:admin — route này nhận dữ liệu builder chưa lưu,
| chưa qua kiểm duyệt và render thẳng ra HTML (cùng chính sách với /review/* của core).
*/
Route::middleware('auth:admin')->group(function () {
    Route::match(['post', 'get'], '/review/popup', [\Popup\Controllers\Web\PopupReviewController::class, 'index'])->name('popup.review');
});
