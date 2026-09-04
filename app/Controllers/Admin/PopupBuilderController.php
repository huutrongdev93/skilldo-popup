<?php
namespace Popup\Controllers\Admin;

use Popup\Models\Popup;
use Popup\Services\BuilderSectionService;
use SkillDo\Cms\Controller;
use SkillDo\Cms\Support\Admin;
use SkillDo\Cms\Support\Cms;
use SkillDo\Http\Request;

/**
 * Mở màn hình Page Builder cho một popup.
 *
 * View là bản riêng của plugin (popup::admin/popup/builder) chứ không dùng
 * `admin::builder-page`: cần trỏ khung xem thử sang `review/popup` và mở quyền
 * kéo thả cho admin thường. Mọi thứ khác (sidebar, config, cây, ajax) dùng lại
 * partial + JS của core, không sao chép.
 */
class PopupBuilderController extends Controller
{
    public function index(Request $request, $id)
    {
        $id = (int) $id;

        if(empty($id)) return Admin::pageNotFound();

        $object = Popup::find($id);

        if(empty($object)) return Admin::pageNotFound();

        //Mọi mẫu đều dựng bằng kéo thả: chưa có nội dung thì seed preset của mẫu đang chọn
        BuilderSectionService::seed($object);

        $section = BuilderSectionService::section($id);

        if(empty($section)) return Admin::pageNotFound();

        Cms::setData('module', 'popup');

        return Cms::view('popup::admin/popup/builder', data: [
            'popup'         => $object,
            'title'         => $object->name,
            'sectionId'     => BuilderSectionService::key($id),
            'previewHeight' => '100vh',
        ]);
    }
}
