<div class="box mb-2">
    <div class="box-content" style="padding:20px 10px;">
        <div class="float-start">
            @foreach ($tabs as $key => $tab)
                <a href="{!! Url::admin('system/popup?view=' . $key) !!}"
                   class="btn {{ $key == $view ? 'btn-blue' : 'btn-white' }} btn-icon">
                    {!! isset($tab['icon']) ?? '<i class="fal fa-layer-plus"></i>' !!}
                    {{ $tab['label'] }}
                </a>
            @endforeach
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<input type="hidden" name="key" id="popup_module" class="form-control" value="{{ $view }}" required>
