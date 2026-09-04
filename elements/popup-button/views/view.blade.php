<div class="popup-button-wrap d-flex justify-content-{!! $options->position ?? 'start' !!}">
    <{!! $tag !!} class="popup-button btn" @if($tag === 'a') href="{!! $options->link !!}" target="_top" @else type="button" @endif>
        @if(!empty($options->icon)){!! $options->icon !!}&nbsp;@endif{!! $options->text !!}
    </{!! $tag !!}>
</div>
