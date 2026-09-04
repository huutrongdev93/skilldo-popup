<?php
namespace Popup\Styles;

/**
 * Mẫu "Tự thiết kế" — không có nội dung dựng sẵn, người dùng bắt đầu từ trang trắng
 * trong trình kéo thả. Toàn bộ form cấu hình khung nằm ở `PopupStyleBase`.
 */
class PopupBuilder extends PopupStyleBase
{
    public function key(): string
    {
        return 'builder';
    }

    public function image(): string
    {
        return asset('popup::images/demo-builder.png');
    }

    public function preset(): array
    {
        return ['frame' => [], 'rows' => []];
    }

    protected function configDefault(): array
    {
        //Khung mặc định đã khai ở PopupStyleBase::frameDefault()
        return [];
    }
}
