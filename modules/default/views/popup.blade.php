@if (!empty($config['title']))
    <h4 class="popup-alert-header-title" style="{{ Template::cssText($config['title'])['css'] }}">
        {{ $config['title']['txt'] }}
    </h4>
@endif
<div class="popup-alert-content">
    {!! $config['description'] !!}
</div>
<style>
    .popup-alert .modal-content {
        border-radius: 0;
        border: 0;
        {!! $config['style']['css'] !!}
    }
    .popup-alert .modal-content .popup-alert-header-title {
        color: {{ $config['title_color'] }};
        font-weight: bold;
    }
</style>
