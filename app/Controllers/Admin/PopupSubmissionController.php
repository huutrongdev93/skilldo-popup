<?php
namespace Popup\Controllers\Admin;

use Popup\Modules\Admin\PopupSubmission\PopupSubmissionTable;
use SkillDo\Cms\Controller;
use SkillDo\Cms\Support\Cms;
use SkillDo\Http\Request;

class PopupSubmissionController extends Controller
{
    public function index(Request $request)
    {
        return Cms::view("admin::resources/page-default/page-index", data: [
            'name' => 'Thống kê gửi popup',
            'table' => new PopupSubmissionTable()
        ]);
    }
}