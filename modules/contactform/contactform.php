<?php
include 'contactform-taxonomy.php';

foreach (glob(Path::plugin(POPUP_NAME).'/modules/contactform/*', GLOB_ONLYDIR) as $foldername) {
    foreach (glob($foldername.'/*.contactform.php') as $filename) {
        include_once $filename;
    }
}

function admin_page_popup_contactform() {
    $styles = popup_contactform::style();
    $active = Option::get('popup_contactform_active');
    Plugin::view(POPUP_NAME, 'modules/contactform/html-contactform', ['styles' => $styles, 'active' => $active]);
}

class popup_contactform {

    static public function style($key = null) {
        $style = apply_filters('popup_contactform_style', []);
        if($key !== null) {
            if(isset($style[$key])) return $style[$key];
            return [];
        }
        return $style;
    }

    public static function admin_config_save($result) {
        $object_key = trim(Request::post('popup_style'));
        if(method_exists($object_key, 'admin_config_save')) {
            Option::update('popup_contactform_active', $object_key);
            return $object_key::admin_config_save($result);
        }
        return $result;
    }

    public static function render() {
        $active = Option::get('popup_contactform_active');
        if(method_exists($active, 'render')) $active::render();
    }
}

if (!function_exists('popup_ajax_contactform_submit')) {

    function popup_ajax_contactform_submit(\SkillDo\Http\Request $request, $model) {

        if ($request->isMethod('post')) {

            $phone  = $request->input('phone');

            $email  = $request->input('email');

            $note  = $request->input('note');

            $style  = $request->input('style');

            if(empty($phone) && empty($email)) {

                response()->error(__('Không có thông tin đăng ký'));
            }

            if(empty($style) || !have_posts(popup_contactform::style('popup_contactform_'.$style))) {

                response()->error(__('Style contact form chưa được đăng ký'));

            }

            $title   = '';
            $excerpt = '';
            $content = $note;

            if(!empty($email)) {
                $title   = $email;
                $excerpt = $phone;
            }
            else {
                $title   = $phone;
            }

            $post = [
                'title' => $title,
                'excerpt'   => $excerpt,
                'content'   => $content,
                'image'     => 'popup_contactform_'.$style,
                'public'    => 0,
                'status'    => 1,
                'post_type' => 'popup_contactform',
            ];

            $error =  Posts::insert($post);

            if(!is_skd_error($error)) {

                $count = (int)option::get('popup_contactform_new', 0);

                option::update('popup_contactform_new', $count+1);

                response()->success('Đăng ký thành công');

            }
        }

        response()->error(trans('ajax.save.fail'));
    }

    Ajax::client('popup_ajax_contactform_submit');
}