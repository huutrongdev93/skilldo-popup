<?php
namespace Popup\Services;

use Illuminate\Database\Schema\Blueprint;
use Popup\Services\BuilderSectionService;
use Illuminate\Support\Facades\DB;

Class ActivatorService
{
    public static function activate(): void
    {
        /*
         * Element của plugin (scope `popup`) khai trong elements/elements.json;
         * ElementManager cache danh sách 24h nên phải xoá khi bật/tắt plugin.
         */
        BuilderSectionService::clearElementCache();

        if (!schema()->hasTable('popups'))
        {
            schema()->create('popups', function (Blueprint $table)
            {
                $table->increments('popup_id');
                $table->string('popup_key', 100)->nullable();
                $table->string('name', 100)->collation('utf8mb4_unicode_ci')->nullable();
                $table->char('status', 50)->default('run');
                $table->char('loop', 50)->default('only')->comment('Lặp lại popup: loop, only');
                $table->integer('time_delay')->default(0)->comment('Thời gian chờ hiển thị popup (giây)');
                $table->integer('time_loop')->default(0)->comment('Thời gian chờ lặp lại popup (phút)');
                $table->string('template', 100)->nullable()->comment('popup template');
                $table->string('locale', 10)->nullable()->comment('ngoôn ngữ popup');
                $table->text('settings')->nullable()->comment('Cài đặt popup');
                $table->dateTime('created')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->dateTime('updated')->nullable();
                $table->index('status');
            });
        }

        if (!schema()->hasTable('popups_submission'))
        {
            schema()->create('popups_submission', function (Blueprint $table)
            {
                $table->increments('submission_id');
                $table->integer('popup_id')->nullable();
                $table->string('name', 100)->collation('utf8mb4_unicode_ci')->nullable();
                $table->text('data')->nullable()->collation('utf8mb4_unicode_ci')->comment('Dữ liệu thu thập được');
                $table->char('status', 50)->default('new')->comment('Trạng thái: new, read');
                $table->string('ip', 50)->nullable()->comment('Địa chỉ IP');
                $table->dateTime('created')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->dateTime('updated')->nullable();
            });
        }

        /*
         * Popup của bản cũ (mẫu cứng) được dựng sẵn thành cây builder để sửa bằng kéo thả.
         * Gọi cuối cùng vì cần bảng `popups` đã tồn tại.
         */
        PopupMigrationService::migrateAll();
    }
}