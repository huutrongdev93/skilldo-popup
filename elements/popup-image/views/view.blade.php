@php
    $width = $options->width ?? '';
    $unit  = $options->unitWidth ?? '%';
    $style = is_numeric($width) ? 'width:'.$width.$unit.';height:auto;' : '';
    $image = Image::source($options->img ?? '', $options->alt ?? '');
    if(!empty($style)) $image->attribute('style', $style);
@endphp
<div class="popup-image d-flex justify-content-{!! $options->align ?? 'center' !!}">
    @if(!empty($options->url))
        <a href="{!! $options->url !!}" target="_top">{!! $image->html() !!}</a>
    @else
        {!! $image->html() !!}
    @endif
</div>
