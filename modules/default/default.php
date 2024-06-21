<?php
function admin_page_popup_default(): void
{
    $form = form();
    $form->textBuilding('popup_alert_title', ['label' => 'Tiêu đề', 'start' => 10], Popup_default::config('title'));
    $form->boxBuilding('popup_alert_style', [
        'label' => 'Style Popup',
        'start' => 2,
        'customInput' => [
            'hover' => false
        ],
    ], Popup_default::config('title_color'));
    $form->wysiwyg('popup_alert_description', [
        'label' => 'Nội dung popup', 'start' => 12,
    ], popup_default::config('description'));

    Plugin::view(POPUP_NAME, 'modules/default/views/popup-alert-config', ['form' =>$form]);
}

class Popup_default {

    public static function config($key = '') {
        $default = [
            'title'             => '',
            'description'       => '',
            'background_color'  => '',
            'background_image'  => '',
            'title_color'       => '',
            'style' => [],
        ];

        $config = Option::get('popup_default', array_merge([], $default));

        if(empty($config) || !is_array($config)) {
            $config = $default;
        }
        else {
            foreach ($default as $keyDefault => $valueDefault) {
                if(!isset($config[$keyDefault])) {
                    $config[$keyDefault] = $valueDefault;
                }
            }
        }

        if(!empty($key)) {
            return Arr::get($config, $key);
        }

        return $config;
    }

    public static function admin_config_save(\SkillDo\Http\Request $request): void
    {
        $config = [
            'title'             => $request->input('popup_alert_title'),
            'description'       => $request->input('popup_alert_description', ['clear' => false]),
            'style'             => $request->input('popup_alert_style'),
        ];

        Option::update('popup_default', $config);
    }

    public static function render(): void
    {
        $config = static::config();

        $config['style'] = Template::cssBox($config['style']);

        Plugin::view(POPUP_NAME, 'modules/default/views/popup', [
            'config' => $config
        ]);
    }
}