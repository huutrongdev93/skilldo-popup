@php
    $buttonText = $options->buttonText ?? 'Gửi thông tin';
    $buttonIcon = $options->buttonIcon ?? '';
    $success    = $options->successMessage ?? 'Đăng ký thành công. Chúng tôi sẽ liên hệ với bạn sớm nhất!';
    $closeAfter = !empty($options->closeAfterSubmit) ? 1 : 0;
    $closeDelay = (int)($options->closeDelay ?? 2);
@endphp
<div class="popup-builder-form">
    <form class="popup-builder-form-body"
          data-popup-id="{!! $popupId !!}"
          data-widget-id="{!! $id !!}"
          data-close-after="{!! $closeAfter !!}"
          data-close-delay="{!! $closeDelay !!}">
        <div class="form-field-row">
            {{-- honeypot: bot điền vào là loại ngay ở server (cùng cách với form popup mẫu cũ) --}}
            <input type="text" name="antibot" value="" tabindex="-1" autocomplete="off" class="popup-builder-form-antibot">
            {!! Template::formFieldRender(
                fieldsData: $fields,
                options: [
                    'wrapper'       => false,
                    'includeStyles' => false,
                    'namePrefix'    => 'fields',
                ]
            ) !!}
            <div class="form-field-col popup-builder-form-button">
                <button class="btn btn-theme w-full" type="submit">@if(!empty($buttonIcon)){!! $buttonIcon !!}&nbsp;@endif{!! $buttonText !!}</button>
            </div>
        </div>
    </form>
    <div class="popup-builder-form-success" style="display:none">{!! $success !!}</div>
</div>
