<?php
namespace Popup\Controllers\Web;

use App\Controllers\Web\BuilderReviewController;
use Popup\Models\Popup;
use Popup\Services\BuilderSectionService;
use Popup\Styles\PopupStyle;
use SkillDo\Cms\Element\ElementBuilder;
use SkillDo\Http\Request;

/**
 * Khung xem thử của trình dựng popup (nội dung của <iframe> trong builder).
 *
 * Kế thừa controller review của core để dùng lại assets() (nạp axios/element.js,
 * gỡ bundle theme, đẩy theme-custom.css xuống cuối — WD-56) và globalStyles().
 *
 * Route `review/popup` BẮT BUỘC nằm sau middleware auth:admin: nó nhận và render
 * dữ liệu builder chưa qua kiểm duyệt (SEC-09, BUILDER.md §5.8).
 */
class PopupReviewController extends BuilderReviewController
{
    public function index(Request $request)
    {
        $this->builder = 'layout';

        $this->assets();

        $data = json_decode(base64_decode($request->input('data', '{}')));

        $data = json_decode(json_encode($data), true);

        $this->globalStyles($data);

        $sectionId = !empty($data['section']) ? array_key_first($data['section']) : '';

        $sections = $data['section'][$sectionId] ?? [];

        $popupId = (int) $request->input('popup_id', BuilderSectionService::popupId((string) $sectionId));

        $object = Popup::find($popupId);

        /*
        | Element trong popup (PopupFormElement) cần biết mình thuộc popup nào để
        | gắn popup_id vào form. Ngoài site việc này do Popups::render() làm.
        */
        \SkillDo\Cms\Support\Cms::setData('popup_section_key', $sectionId);

        if(!empty($object))
        {
            \SkillDo\Cms\Support\Cms::setData('popup_object', $object);
        }

        $style = PopupStyle::getInstance()->get(BuilderSectionService::TEMPLATE);

        if(!empty($object)) $style->setObject($object);

        $assets = ElementBuilder::buildAssets($sectionId, $sections, 'review');

        $sections = ElementBuilder::render($sections, 'review');

        $cssWidth = $assets['cssResponsive']['desktop'];

        $cssWidth .= $assets['cssResponsive']['tablet'];

        $cssWidth .= $assets['cssResponsive']['mobile'];

        return view('popup::admin/popup/review', [
            'builder'    => $this->builder,
            'sections'   => $sections,
            'style'      => $assets['css'],
            'script'     => $assets['js'],
            'cssWidth'   => $cssWidth,
            'elementCss' => $assets['elementCss'],
            'sectionId'  => $sectionId,
            'config'     => $style->config(),
        ]);
    }
}
