<?php
namespace Popup\Ajax\Web;

use Popup\Enum\PopupStatus;
use Popup\Services\BuilderSectionService;
use SkillDo\Cache\Cache;
use SkillDo\Http\Request;
use SkillDo\Validate\Rule;
use SkillDo\Validate\Validate;

class PopupAjax
{
    static function submit(Request $request): void
    {
        if($request->has('antibot') && $request->input('antibot') != '')
        {
            response()->error('Có lỗi xảy ra, vui lòng thử lại.');
        }

        $validate = $request->validate([
            'popup_id' => Rule::make('Popup')->notEmpty()->integer()->min(1),
        ]);

        if ($validate->fails())
        {
            response()->error($validate->errors());
        }

        $id = $request->input('popup_id');

        $popup = \Popup\Models\Popup::find($id);

        if(empty($popup))
        {
            response()->error( 'Popup không tồn tại.');
        }

        if(empty($popup->settings['form']))
        {
            response()->error( 'Popup chưa được cấu hình form thu thập thông tin.');
        }

        $validations = [];

        foreach($popup->settings['form'] as $key => $field)
        {
            $validation = Rule::make($field['label']);

            if(isset($field['required']) && $field['required'] == '1')
            {
                $validation->notEmpty();
            }
            if($field['type'] == 'email')
            {
                $validation->email();
            }
            if($field['type'] == 'phone')
            {
                $validation->phone();
            }

            $validations['field_'.$key] = $validation;
        }

        $validate = $request->validate($validations);

        if ($validate->fails())
        {
            response()->error($validate->errors());
        }

        $data = [
            'popup_id' => $id,
            'name'     => $popup->name,
            'ip'       => $request->ip(),
            'data'     => [],
        ];

        foreach($popup->settings['form'] as $key => $field)
        {
            $data['data']['field_'.$key] = [
                'label' => $field['label'],
                'value' => $request->input('field_'.$key),
            ];
        }

        \Popup\Models\PopupSubmission::create($data);

        Cache::delete('popup_submission_new');

        do_action('popup_submission_created', $data, $popup);

        response()->success('Đăng ký thành công. Chúng tôi sẽ liên hệ với bạn sớm nhất!');
    }

    /**
     * Nhận dữ liệu từ PopupFormElement (popup dựng bằng kéo thả).
     *
     * Định nghĩa field KHÔNG lấy từ dữ liệu client gửi lên mà đọc lại từ cây builder
     * đã lưu (theo widget_id) — client chỉ gửi giá trị người dùng nhập.
     */
    static function submitBuilder(Request $request): void
    {
        if($request->has('antibot') && $request->input('antibot') != '')
        {
            response()->error('Có lỗi xảy ra, vui lòng thử lại.');
        }

        $validate = $request->validate([
            'popup_id'  => Rule::make('Popup')->notEmpty()->integer()->min(1),
            'widget_id' => Rule::make('Form')->notEmpty(),
        ]);

        if ($validate->fails())
        {
            response()->error($validate->errors());
        }

        $id = (int) $request->input('popup_id');

        $popup = \Popup\Models\Popup::find($id);

        if(empty($popup))
        {
            response()->error('Popup không tồn tại.');
        }

        //Mẫu nào cũng có thể chứa form (mọi popup đều dựng bằng builder), chỉ cần đang bật
        if($popup->status !== PopupStatus::RUN->value)
        {
            response()->error('Popup không nhận đăng ký.');
        }

        $widget = BuilderSectionService::findWidget($id, (string) $request->input('widget_id'), 'PopupFormElement');

        if(noItems($widget))
        {
            response()->error('Không tìm thấy form trong popup này.');
        }

        $fields = BuilderSectionService::formFields($widget);

        if(noItems($fields))
        {
            response()->error('Form chưa được cấu hình trường thông tin.');
        }

        $values = $request->input('fields');

        if(!is_array($values)) $values = [];

        $rules = [];

        foreach ($fields as $field)
        {
            $rule = Rule::make($field['label'] ?: $field['name']);

            if(!empty($field['required'])) $rule->notEmpty();

            if($field['type'] == 'email') $rule->email();

            if($field['type'] == 'tel' || $field['type'] == 'phone') $rule->phone();

            $rules[$field['name']] = $rule;
        }

        $validate = Validate::make($values, $rules)->validate();

        if ($validate->fails())
        {
            response()->error($validate->errors());
        }

        $data = [
            'popup_id' => $id,
            'name'     => $popup->name,
            'ip'       => $request->ip(),
            'data'     => [],
        ];

        foreach ($fields as $field)
        {
            $value = $values[$field['name']] ?? '';

            if(is_array($value)) $value = implode(', ', $value);

            $data['data']['field_'.$field['name']] = [
                'label' => $field['label'] ?: $field['name'],
                'value' => strip_tags((string) $value),
            ];
        }

        \Popup\Models\PopupSubmission::create($data);

        Cache::delete('popup_submission_new');

        do_action('popup_submission_created', $data, $popup);

        response()->success('Đăng ký thành công. Chúng tôi sẽ liên hệ với bạn sớm nhất!');
    }
}
