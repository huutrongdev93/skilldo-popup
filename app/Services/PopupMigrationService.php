<?php
namespace Popup\Services;

use Popup\Models\Popup;

/**
 * Chuyển popup của bản cũ (mẫu cứng, nội dung trong `popups.settings`) sang trình kéo thả.
 *
 * Mỗi popup được dựng đúng mẫu nó đang chọn, lấy chính nội dung/màu/ảnh người dùng đã
 * soạn — nên sau khi cập nhật plugin, popup trông như cũ nhưng đã sửa được bằng kéo thả.
 *
 * Chạy một lần cho mỗi popup: lần sau cây builder đã khác rỗng nên `seed()` bỏ qua.
 */
class PopupMigrationService
{
    /**
     * @return int số popup vừa được dựng preset
     */
    public static function migrateAll(): int
    {
        if(!schema()->hasTable('popups')) return 0;

        $count = 0;

        $popups = Popup::query()->get();

        if(noItems($popups)) return 0;

        foreach ($popups as $popup)
        {
            if(BuilderSectionService::seed($popup)) $count++;
        }

        return $count;
    }
}
