<?php
Route::middleware('auth:admin')->prefix('admin')->group(function () {
    Route::get('/popup', [\Popup\Controllers\Admin\PopupController::class, 'index'])->name('admin.popup.index');
    Route::get('/popup/add', [\Popup\Controllers\Admin\PopupController::class, 'add'])->name('admin.popup.add');
    Route::get('/popup/edit/{id}', [\Popup\Controllers\Admin\PopupController::class, 'edit'])->name('admin.popup.edit');
    Route::get('/popup/builder/{id}', [\Popup\Controllers\Admin\PopupBuilderController::class, 'index'])->name('admin.popup.builder');
});
Route::middleware('auth:admin')->prefix('admin')->group(function () {
    Route::get('/popup-submission', [\Popup\Controllers\Admin\PopupSubmissionController::class, 'index'])->name('admin.popup.submission.index');
});