<?php
namespace Popup\Presets;

use Illuminate\Support\Str;

/**
 * Dựng cây builder (row → column → widget) cho preset của một mẫu popup.
 *
 * Cây phải đúng schema mà `ElementBuilder` đọc — cùng schema JS builder ghi ra:
 *
 *   [ ['id'=>'row_…','label'=>…,'style'=>[…],'columns'=>[
 *        ['id'=>'column_…','width'=>'50%','style'=>[…],'widgets'=>[
 *            ['id'=>'fw_…','type'=>'HeadingElementStyle1','name'=>…,'settings'=>[…]]
 *        ]]
 *   ]] ]
 *
 * Khác dữ liệu do người dùng kéo thả ở một điểm: preset ghi **đầy đủ** settings, nên
 * mọi khoá phải khớp đúng tên trong `form()` của element và đúng schema
 * `Template::cssText/cssButton/cssBackground` — sai khoá thì style im lặng không áp.
 *
 * QUAN TRỌNG — preset CHỈ dùng element do chính plugin mang theo (`Popup*Element`).
 * Element của theme (HeadingElementStyle1, ButtonElement, ImageElement…) được tải theo nhu
 * cầu từ kho, site thật có thể chưa có; trỏ vào element không tồn tại thì
 * `ElementBuilder::builderColum()` bỏ qua và widget render ra RỖNG, popup trắng trơn mà
 * không báo lỗi. Muốn thêm loại nội dung mới vào preset thì viết element trong
 * `plugins/popup/elements/`, đừng mượn element của theme.
 */
class PopupPresetBuilder
{
    /**
     * Id kiểu builder: `row_<time36>_<random>` — cùng dạng `generateId()` của
     * builder-data-store.js và qua được `CssSanitizer::id()` (chỉ [A-Za-z0-9_-]).
     */
    public static function id(string $prefix): string
    {
        return $prefix.'_'.base_convert((string)(int)(microtime(true) * 1000), 10, 36).'_'.Str::lower(Str::random(7));
    }

    /*
    |--------------------------------------------------------------------------
    | Khung cây
    |--------------------------------------------------------------------------
    */

    public static function row(array $columns, array $style = [], string $label = 'Hàng'): array
    {
        return [
            'id'      => static::id('row'),
            'label'   => $label,
            'style'   => $style,
            'columns' => $columns,
        ];
    }

    public static function column(string $width, array $widgets, array $style = []): array
    {
        $style = array_merge([
            'widthDesktop' => $width,
            'widthTablet'  => $width,
            'widthMobile'  => '100%',
        ], $style);

        return [
            'id'      => static::id('column'),
            'width'   => $width,
            'style'   => $style,
            'widgets' => $widgets,
        ];
    }

    public static function widget(string $type, string $name, array $settings = []): array
    {
        return [
            'id'       => static::id('fw'),
            'type'     => $type,
            'name'     => $name,
            'settings' => $settings,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Widget dựng sẵn (dùng element có sẵn của theme + 2 element của plugin)
    |--------------------------------------------------------------------------
    */

    /**
     * @param array $opts color, size, sizeMobile, weight, align, transform, tag, spacing (mb)
     */
    public static function heading(string $text, array $opts = []): array
    {
        return static::widget('PopupHeadingElement', 'Tiêu đề popup', [
            'heading'      => $text,
            'headingTag'   => $opts['tag'] ?? 'p',
            'headingStyle' => static::textStyle($opts),
            'spacing'      => static::spacing(['bottom' => $opts['mb'] ?? 8]),
        ]);
    }

    public static function textEditor(string $html, array $opts = []): array
    {
        return static::widget('PopupTextElement', 'Văn bản popup', [
            'content'   => $html,
            'textStyle' => static::textStyle($opts),
            'spacing'   => static::spacing(['bottom' => $opts['mb'] ?? 14]),
        ]);
    }

    /**
     * @param array $opts color, background, radius, padding, position, size, weight
     */
    public static function button(string $text, string $url, array $opts = []): array
    {
        return static::widget('PopupButtonElement', 'Nút bấm popup', [
            'text'     => $text,
            'link'     => $url,
            'position' => $opts['position'] ?? 'start',
            'style'    => static::buttonStyle($opts),
            'spacing'  => static::spacing(['bottom' => $opts['mb'] ?? 0]),
        ]);
    }

    public static function image(string $src, array $opts = []): array
    {
        return static::widget('PopupImageElement', 'Hình ảnh popup', [
            'img'       => $src,
            'align'     => $opts['align'] ?? 'center',
            'width'     => $opts['width'] ?? 100,
            'unitWidth' => $opts['unit'] ?? '%',
            'spacing'   => static::spacing(['bottom' => $opts['mb'] ?? 0]),
        ]);
    }

    /**
     * Form thu thập thông tin.
     *
     * @param array $fields danh sách ['name','label','type','required','placeholder']
     */
    public static function form(array $fields, string $buttonText, array $opts = []): array
    {
        $settings = [
            'fields'     => static::formFields($fields),
            'labelShow'  => $opts['labelShow'] ?? 0,
            'buttonText' => $buttonText,
            'formGap'    => 12,
            'formRow'    => 12,
        ];

        if(!empty($opts['successMessage'])) $settings['successMessage'] = $opts['successMessage'];

        if(!empty($opts['buttonStyle']))    $settings['buttonStyle'] = static::buttonStyle($opts['buttonStyle']);

        if(!empty($opts['fieldBg']))        $settings['fieldBg'] = $opts['fieldBg'];

        if(!empty($opts['fieldColor']))     $settings['fieldColor'] = $opts['fieldColor'];

        return static::widget('PopupFormElement', 'Form popup', $settings);
    }

    public static function close(string $text = 'Để sau', array $opts = []): array
    {
        return static::widget('PopupCloseElement', 'Nút đóng popup', [
            'text'     => $text,
            'position' => $opts['position'] ?? 'center',
            'style'    => static::buttonStyle($opts),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Mảnh style dùng chung
    |--------------------------------------------------------------------------
    */

    /**
     * Chuẩn hoá danh sách field của mẫu cũ (`settings['form']`) sang schema `formField`
     * mà `Template::formFieldToFields()` đọc.
     */
    public static function formFields(array $fields): array
    {
        $result = [];

        foreach ($fields as $index => $field)
        {
            $type = $field['type'] ?? 'text';

            //Mẫu cũ dùng 'phone', form builder dùng input type 'tel'
            if($type === 'phone') $type = 'tel';

            $name = $field['name'] ?? match ($type) {
                'email' => 'email',
                'tel'   => 'phone',
                default => 'field'.($index + 1),
            };

            $result['field_'.Str::lower(Str::random(5)).uniqid()] = [
                'name'         => $name,
                'label'        => $field['label'] ?? '',
                'type'         => $type,
                'placeholder'  => $field['placeholder'] ?? ($field['label'] ?? ''),
                'required'     => !empty($field['required']),
                'column'       => 100,
                'columnTablet' => 100,
                'columnMobile' => 100,
            ];
        }

        return $result;
    }

    /**
     * Dữ liệu cho `textBuilding` (Template::cssText).
     */
    public static function textStyle(array $opts): array
    {
        $typography = [];

        if(!empty($opts['size']))
        {
            $typography['fontSize'] = [
                'desktop' => $opts['size'],
                'tablet'  => $opts['sizeTablet'] ?? $opts['size'],
                'mobile'  => $opts['sizeMobile'] ?? min((int)$opts['size'], 28),
            ];
        }

        if(!empty($opts['weight']))    $typography['fontWeight'] = $opts['weight'];

        if(!empty($opts['align']))     $typography['align'] = $opts['align'];

        if(!empty($opts['lineHeight']))$typography['lineHeight'] = $opts['lineHeight'];

        if(!empty($opts['transform'])) $typography['textStyle'] = ['transform' => $opts['transform']];

        $style = [];

        if(!empty($typography)) $style['typography'] = $typography;

        if(!empty($opts['color'])) $style['color'] = ['color' => $opts['color'], 'active' => 'color'];

        return $style;
    }

    /**
     * Dữ liệu cho `buttonBuilding` (Template::cssButton).
     */
    public static function buttonStyle(array $opts): array
    {
        $style = [];

        if(!empty($opts['color'])) $style['color'] = ['color' => $opts['color'], 'active' => 'color'];

        if(!empty($opts['background']))
        {
            $style['background'] = static::background(['color' => $opts['background']]);
        }

        $style['padding'] = static::dimension($opts['padding'] ?? ['top' => 10, 'right' => 26, 'bottom' => 10, 'left' => 26]);

        $radius = $opts['radius'] ?? 4;

        $style['border'] = [
            'radius' => static::dimension([
                'top'    => $radius,
                'right'  => $radius,
                'bottom' => $radius,
                'left'   => $radius,
            ]),
        ];

        if(!empty($opts['size']) || !empty($opts['weight']))
        {
            $style['typography'] = array_filter([
                'fontSize'   => !empty($opts['size']) ? ['desktop' => $opts['size']] : null,
                'fontWeight' => $opts['weight'] ?? null,
            ]);
        }

        return $style;
    }

    /**
     * Dữ liệu nền cho row/column (Template::cssBackground).
     *
     * @param array $opts color, image, size (cover/contain/…), position, repeat
     */
    public static function background(array $opts): array
    {
        $background = ['active' => 'classic'];

        if(!empty($opts['color']))
        {
            $background['color'] = ['color' => $opts['color'], 'active' => 'color'];
        }

        if(!empty($opts['image']))
        {
            $background['image']         = $opts['image'];
            $background['imageSize']     = $opts['size'] ?? 'cover';
            $background['imagePosition'] = $opts['position'] ?? 'center center';
            $background['imageRepeat']   = $opts['repeat'] ?? 'no-repeat';
        }

        return $background;
    }

    /**
     * `spacing` của widget/row/column (Template::cssSpacing) — chỉ khai desktop,
     * tablet/mobile để trống thì kế thừa.
     */
    public static function spacing(array $margin = [], array $padding = []): array
    {
        $spacing = [];

        if(hasItems($margin))  $spacing['margin']  = ['desktop' => static::dimension($margin)];

        if(hasItems($padding)) $spacing['padding'] = ['desktop' => static::dimension($padding)];

        return $spacing;
    }

    public static function padding(array $padding): array
    {
        return static::spacing([], $padding);
    }

    protected static function dimension(array $values): array
    {
        return [
            'top'    => $values['top']    ?? '',
            'right'  => $values['right']  ?? '',
            'bottom' => $values['bottom'] ?? '',
            'left'   => $values['left']   ?? '',
        ];
    }
}
