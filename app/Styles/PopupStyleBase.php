<?php
namespace Popup\Styles;

use Illuminate\Support\Arr;
use Popup\Services\BuilderSectionService;
use SkillDo\Cms\Form\Form;
use SkillDo\Cms\Support\Url;

/**
 * Lớp cơ sở của một mẫu popup.
 *
 * Từ 2.1.0 mọi mẫu đều là **preset của trình kéo thả**: `preset()` trả về cây builder
 * (rows) + cấu hình khung (frame) dựng từ chính `config()` của popup, `BuilderSectionService::seed()`
 * ghi cây đó vào section `popup_{id}` rồi từ đó người dùng sửa trong trình dựng.
 *
 * `configDefault()` vẫn giữ nguyên vai trò cũ: nguồn nội dung mặc định của mẫu (và là
 * nơi đọc lại nội dung mà popup cũ đã soạn khi chuyển sang kéo thả).
 *
 * Blade `views/styles/{key}.blade.php` chỉ còn là đường lùi cho popup chưa kịp seed.
 */
abstract class PopupStyleBase
{
    protected array $config = [];

    protected $object;

    public function __construct()
    {
        $this->config = mergeConfig($this->frameDefault(), $this->configDefault(), true);
    }

    abstract public function key(): string;

    abstract public function image(): string;

    abstract protected function configDefault(): array;

    /**
     * Cây builder dựng sẵn của mẫu.
     *
     * @return array{frame: array, rows: array} frame = cấu hình khung popup ghi vào
     *         `popups.settings`; rows = cây builder ghi vào section.
     */
    public function preset(): array
    {
        return ['frame' => [], 'rows' => []];
    }

    public function setObject($object): void
    {
        $this->object = $object;

        $this->config = mergeConfig($this->config, $object->settings, true);

        $this->config['loop'] = $object->loop;

        $this->config['time_loop'] = (int)$object->time_loop;

        $this->config['time_delay'] = (int)$object->time_delay;
    }

    public function object()
    {
        return $this->object;
    }

    public function popupKey(): string
    {
        return $this->object->popup_key ?? '';
    }

    public function config($key = null, $default = null)
    {
        if($key == null) return $this->config;

        return Arr::get($this->config, $key, $default);
    }

    /**
     * Popup đã có nội dung trong trình kéo thả thì render bằng cây builder;
     * chưa có (popup chưa kịp seed) thì lùi về blade cũ của mẫu.
     */
    public function render()
    {
        $rows = BuilderSectionService::content($this->object->popup_id ?? 0);

        if(hasItems($rows))
        {
            return view('popup::styles/builder', [
                'popup'  => $this,
                'config' => $this->config,
                'rows'   => $rows,
            ]);
        }

        return view('popup::styles/'.$this->key(), ['popup' => $this, 'config' => $this->config]);
    }

    /*
    |--------------------------------------------------------------------------
    | Form cấu hình trong admin
    |--------------------------------------------------------------------------
    | Nội dung popup nằm trong trình dựng, nên form ở đây chỉ còn phần KHUNG:
    | kích thước, vị trí, nền, lớp phủ, nút đóng — dùng chung cho mọi mẫu.
    */

    public function configForm(Form $form): Form
    {
        $form->none($this->builderBox());

        return $this->frameForm($form);
    }

    protected function frameForm(Form $form): Form
    {
        $form->none('<h4 class="fw-bold text-secondary fs-6 mb-3 mt-2">KHUNG POPUP</h4>');

        $form->number('settings[width]', [
            'label' => 'Chiều rộng tối đa (px)',
            'start' => 6,
        ], $this->config('width'));

        $form->select('settings[position]', [
            'center' => 'Giữa màn hình',
            'top'    => 'Trên cùng',
            'bottom' => 'Dưới cùng',
            'left'   => 'Bên trái',
            'right'  => 'Bên phải',
        ], [
            'label' => 'Vị trí hiển thị',
            'start' => 6,
        ], $this->config('position'));

        $form->number('settings[padding]', [
            'label' => 'Khoảng đệm trong (px)',
            'start' => 6,
        ], $this->config('padding'));

        $form->number('settings[edgeSpacing]', [
            'label' => 'Cách mép màn hình (px)',
            'note'  => 'Khoảng trống giữa popup và cạnh trên/dưới màn hình.',
            'start' => 6,
        ], $this->config('edgeSpacing'));

        $form->number('settings[radius]', [
            'label' => 'Bo góc (px)',
            'start' => 6,
        ], $this->config('radius'));

        $form->color('settings[background]', [
            'label' => 'Màu nền popup',
            'start' => 6,
        ], $this->config('background'));

        $form->image('settings[backgroundImage]', [
            'label' => 'Ảnh nền popup',
            'start' => 6,
        ], $this->config('backgroundImage'));

        $form->color('settings[overlay]', [
            'label' => 'Màu lớp phủ nền',
            'start' => 6,
        ], $this->config('overlay'));

        $form->select('settings[animation]', [
            'fade'  => 'Mờ dần',
            'zoom'  => 'Phóng to',
            'slide' => 'Trượt xuống',
        ], [
            'label' => 'Hiệu ứng mở',
            'start' => 6,
        ], $this->config('animation'));

        $form->none('<h4 class="fw-bold text-secondary fs-6 mb-3 mt-3">NÚT ĐÓNG</h4>');

        $form->switch('settings[closeShow]', [
            'label' => 'Hiển thị nút đóng',
            'start' => 4,
        ], $this->config('closeShow'));

        $form->select('settings[closePosition]', [
            'inside'  => 'Trong khung popup',
            'outside' => 'Ngoài khung popup',
        ], [
            'label' => 'Vị trí nút đóng',
            'start' => 4,
        ], $this->config('closePosition'));

        $form->color('settings[closeColor]', [
            'label' => 'Màu nút đóng',
            'start' => 4,
        ], $this->config('closeColor'));

        $form->switch('settings[closeBackdrop]', [
            'label' => 'Đóng khi bấm ra ngoài popup',
        ], $this->config('closeBackdrop'));

        return $form;
    }

    /**
     * Khối dẫn sang trình dựng. Popup chưa lưu lần đầu thì chưa có id, cũng chưa có
     * section để dựng — chỉ nhắc lưu trước.
     */
    protected function builderBox(): string
    {
        $id = (int)($this->object->popup_id ?? 0);

        if(empty($id))
        {
            return '<div class="alert alert-warning d-flex align-items-center gap-2 mb-3">'
                .'<i class="fa-duotone fa-solid fa-circle-info fs-5"></i>'
                .'<span>Lưu popup trước, mẫu sẽ được dựng sẵn trong trình kéo thả để bạn chỉnh lại.</span>'
                .'</div>';
        }

        return '<div class="alert alert-info d-flex align-items-center justify-content-between gap-3 mb-3 flex-wrap">'
            .'<span><i class="fa-duotone fa-solid fa-object-ungroup"></i>&nbsp; Nội dung popup được dựng bằng trình kéo thả.</span>'
            .'<span class="d-flex gap-2">'
            .'<button type="button" class="btn btn-light js_popup_apply_preset" data-id="'.$id.'">'
            .'<i class="fa-duotone fa-solid fa-rotate"></i>&nbsp; Áp dụng lại mẫu</button>'
            .'<a class="btn btn-blue" href="'.Url::admin('popup/builder/'.$id).'">'
            .'<i class="fa-duotone fa-solid fa-pen-ruler"></i>&nbsp; Mở trình dựng kéo thả</a>'
            .'</span>'
            .'</div>';
    }

    /**
     * Cấu hình khung mặc định — mẫu nào cần khác thì trả `frame` trong `preset()`.
     */
    protected function frameDefault(): array
    {
        return [
            'width'           => 700,
            'position'        => 'center',
            'padding'         => 0,
            'edgeSpacing'     => 30,
            'radius'          => 8,
            'background'      => '#ffffff',
            'backgroundImage' => '',
            'overlay'         => 'rgba(0, 0, 0, 0.5)',
            'animation'       => 'fade',
            'closeShow'       => 1,
            'closePosition'   => 'inside',
            'closeColor'      => '#333333',
            'closeBackdrop'   => 1,
        ];
    }
}
