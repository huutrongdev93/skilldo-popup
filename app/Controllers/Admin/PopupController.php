<?php
namespace Popup\Controllers\Admin;

use Admin\Supports\FormAdminHelper;
use Popup\Models\Popup;
use Popup\Modules\Admin\Popups\PopupForm;
use Popup\Modules\Admin\Popups\PopupTable;
use SkillDo\Cms\Controller;
use SkillDo\Cms\Support\Admin;
use SkillDo\Cms\Support\Cms;
use SkillDo\Cms\Support\Metabox;
use SkillDo\Http\Request;

class PopupController extends Controller
{
    public function index(Request $request)
    {
        /*
         * Lưới an toàn khi site cập nhật file mà không chạy lại ActivatorService:
         * popup của bản cũ được dựng sẵn thành cây builder ngay lần đầu vào trang này.
         * Popup đã có nội dung thì bỏ qua nên chỉ tốn một lượt duyệt.
         */
        \Popup\Services\PopupMigrationService::migrateAll();

        Cms::setData('module', 'popup');

        return Cms::view("popup::admin/popup/index", data: [
            'table' => new PopupTable()
        ]);
    }

    public function add(Request $request)
    {
        Cms::setData('module', 'popup');

        Metabox::add('popup_styles', 'Cấu hình popup', [PopupForm::class, 'metabox']);

        return Cms::view("admin::resources/page-default/page-save", data: [
            'form' => FormAdminHelper::getForm('popup')
        ]);
    }

    public function edit(Request $request, $id)
    {
        if(empty($id))
        {
            return Admin::pageNotFound();
        }

        $object = Popup::find($id);

        if(empty($object))
        {
            return Admin::pageNotFound();
        }

        Cms::setData('module', 'popup');

        Cms::setData('object', $object);

        Metabox::add('popup_styles', 'Cấu hình popup', [PopupForm::class, 'metabox']);

        return Cms::view("admin::resources/page-default/page-save", data: [
            'form' => FormAdminHelper::getForm('popup', $object)
        ]);
    }
}