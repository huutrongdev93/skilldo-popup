<?php
namespace Popup\Presets;

/**
 * Bốn khuôn bố cục dùng chung cho 13 mẫu popup.
 *
 * 13 mẫu cứng chỉ khác nhau ở nội dung/màu/ảnh chứ bố cục quy về vài dạng, nên preset
 * khai theo khuôn thay vì chép 13 khối JSON. Mỗi hàm trả về MỘT hàng (row) của cây builder.
 */
class PopupPresetLayout
{
    /**
     * Khuôn A/C — hai cột: nội dung một bên, ảnh bên kia.
     *
     * Cột ảnh chứa hẳn một `ImageElement` (không dùng ảnh nền) để cột có chiều cao thật
     * và người dùng đổi ảnh ngay trong trình dựng.
     *
     * @param array  $content   widget của cột nội dung
     * @param string $image     ảnh cột còn lại
     * @param array  $opts      contentWidth, imageSide ('right'|'left'), contentBg, rowBg, padding
     */
    public static function split(array $content, string $image, array $opts = []): array
    {
        $contentWidth = $opts['contentWidth'] ?? '55%';

        $imageWidth   = $opts['imageWidth'] ?? static::rest($contentWidth);

        $columnContent = PopupPresetBuilder::column($contentWidth, $content, array_filter([
            'spacing'    => PopupPresetBuilder::padding($opts['padding'] ?? ['top' => 30, 'right' => 30, 'bottom' => 30, 'left' => 30]),
            'background' => !empty($opts['contentBg']) ? PopupPresetBuilder::background(['color' => $opts['contentBg']]) : null,
        ]));

        $columnImage = PopupPresetBuilder::column($imageWidth, [
            PopupPresetBuilder::image($image, ['align' => 'center', 'width' => 100]),
        ], [
            'spacing' => PopupPresetBuilder::padding([]),
        ]);

        $columns = (($opts['imageSide'] ?? 'right') === 'left')
            ? [$columnImage, $columnContent]
            : [$columnContent, $columnImage];

        return PopupPresetBuilder::row($columns, array_filter([
            'background' => !empty($opts['rowBg']) ? PopupPresetBuilder::background($opts['rowBg']) : null,
        ]), $opts['label'] ?? 'Nội dung + hình ảnh');
    }

    /**
     * Khuôn B/D — một cột trên nền (ảnh và/hoặc màu) của cả hàng.
     *
     * @param array $widgets widget của cột
     * @param array $opts    image, color, imageSize, imagePosition, padding, columnWidth, align
     */
    public static function banner(array $widgets, array $opts = []): array
    {
        $columnWidth = $opts['columnWidth'] ?? '100%';

        $column = PopupPresetBuilder::column($columnWidth, $widgets, [
            'spacing' => PopupPresetBuilder::padding($opts['padding'] ?? ['top' => 40, 'right' => 40, 'bottom' => 40, 'left' => 40]),
        ]);

        $columns = [$column];

        /*
         * Nội dung chỉ chiếm một phần chiều ngang (vd mẫu 7: chữ nằm bên phải ảnh nền)
         * -> chèn thêm một cột trống làm khoảng đệm, người dùng vẫn kéo thả vào được.
         */
        if($columnWidth !== '100%')
        {
            $spacer = PopupPresetBuilder::column(static::rest($columnWidth), [], [
                'spacing' => PopupPresetBuilder::padding([]),
            ]);

            $columns = (($opts['align'] ?? 'left') === 'right') ? [$spacer, $column] : [$column, $spacer];
        }

        return PopupPresetBuilder::row($columns, [
            'background' => PopupPresetBuilder::background([
                'color'    => $opts['color'] ?? '',
                'image'    => $opts['image'] ?? '',
                'size'     => $opts['imageSize'] ?? 'cover',
                'position' => $opts['imagePosition'] ?? 'center center',
            ]),
        ], $opts['label'] ?? 'Banner');
    }

    /**
     * Khuôn E — hàng trống/tự do: chỉ một cột, không nền.
     */
    public static function plain(array $widgets, array $opts = []): array
    {
        return PopupPresetBuilder::row([
            PopupPresetBuilder::column('100%', $widgets, [
                'spacing' => PopupPresetBuilder::padding($opts['padding'] ?? ['top' => 30, 'right' => 30, 'bottom' => 30, 'left' => 30]),
            ]),
        ], array_filter([
            'background' => !empty($opts['color']) ? PopupPresetBuilder::background(['color' => $opts['color']]) : null,
        ]), $opts['label'] ?? 'Nội dung');
    }

    /**
     * Phần trăm còn lại của một chiều rộng dạng "60%".
     */
    protected static function rest(string $width): string
    {
        $value = (float) rtrim($width, '%');

        if($value <= 0 || $value >= 100) return '50%';

        return (100 - $value).'%';
    }
}
