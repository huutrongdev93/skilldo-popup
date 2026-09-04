<?php
namespace Popup\Ajax\Admin;

use Popup\Styles\PopupStyle;
use SkillDo\Http\Request;
use SkillDo\Validate\Rule;

class PopupAjax
{
    static function config(Request $request): void
    {
        $validate = $request->validate([
            'template' => Rule::make('Template popup')->notEmpty()->in(PopupStyle::getInstance()->keys()),
        ]);

        if ($validate->fails())
        {
            response()->error($validate->errors());
        }

        $id = $request->input('id');

        $template = $request->input('template');

        $template = PopupStyle::getInstance()->get($template);

        if(!empty($id))
        {
            $object = \Popup\Models\Popup::find($id);

            if(!empty($object))
            {
                $template->setObject($object);
            }
        }

        $form = new \SkillDo\Cms\Form\Form();

        $template->configForm($form);

        response()->success('ajax.load.success', [
            'html' => base64_encode('<div class="row">'.$form->html().'</div>'),
        ]);
    }

    /**
     * Dựng lại nội dung popup theo mẫu đang chọn, GHI ĐÈ thiết kế hiện có.
     *
     * Chỉ chạy khi người dùng chủ động bấm "Áp dụng lại mẫu" — lưu popup bình thường
     * không bao giờ ghi đè (xem BuilderService::afterSavePopup).
     */
    static function applyPreset(Request $request): void
    {
        $validate = $request->validate([
            'id' => Rule::make('Popup')->notEmpty()->integer()->min(1),
        ]);

        if ($validate->fails())
        {
            response()->error($validate->errors());
        }

        $popup = \Popup\Models\Popup::find((int) $request->input('id'));

        if(empty($popup))
        {
            response()->error('Popup không tồn tại.');
        }

        //Mẫu người dùng vừa chọn trên form (chưa lưu) được ưu tiên
        $template = $request->input('template');

        if(!empty($template) && $template !== $popup->template && in_array($template, PopupStyle::getInstance()->keys()))
        {
            /*
             * Ghi luôn mẫu mới xuống DB: nếu chỉ đổi trong bộ nhớ mà người dùng không bấm
             * Lưu, popup sẽ có nội dung của mẫu này nhưng cột `template` vẫn là mẫu cũ.
             */
            \Popup\Models\Popup::insert([
                'popup_id' => (int) $popup->popup_id,
                'template' => $template,
            ]);

            $popup->template = $template;
        }

        if(!\Popup\Services\BuilderSectionService::seed($popup, true))
        {
            response()->error('Mẫu này không có nội dung dựng sẵn.');
        }

        response()->success('Đã dựng lại popup theo mẫu. Mở trình dựng để chỉnh lại.');
    }
}
