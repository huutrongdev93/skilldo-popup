@php
    $position = $options->position ?? 'center';
    $icon     = $options->icon ?? '';
@endphp
<div class="popup-close-element d-flex" style="justify-content: {!! $position !!}">
    <button type="button" class="btn btn-theme js-popup-close">@if(!empty($icon)){!! $icon !!}&nbsp;@endif{!! $options->text ?? 'Để sau' !!}</button>
</div>
