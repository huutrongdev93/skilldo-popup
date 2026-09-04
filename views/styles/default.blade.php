@if (!empty($popup->config('title')))
    <h4 class="popup-alert-header-title" style="{!! $popup->config('titleStyle') !!}">
        {{ $popup->config('title') }}
    </h4>
@endif
<div class="popup-alert-content">
    {!! $popup->config('description') !!}
</div>
<style>
    .popup-{!! $popup->popupKey() !!} .modal-content {
        border-radius: 0;
        border: 0;
        {!! $popup->config('style') !!}
    }
    .popup-{!! $popup->popupKey() !!} .modal-content .popup-alert-header-title
    {
        font-weight: bold;
    }
</style>
