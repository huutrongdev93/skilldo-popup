@php
    /*
     * Mẫu cũ không có tuỳ chọn này -> config() trả null, giữ nguyên hành vi mặc định
     * của Bootstrap (bấm ra ngoài là đóng).
     */
    $closeBackdrop = $popup->config('closeBackdrop');

    $closeBackdrop = ($closeBackdrop === null) ? true : !empty($closeBackdrop);
@endphp
<div class="modal fade popup-alert" id="popup_{!! $key !!}" style="display: none" @if(!$closeBackdrop) data-bs-backdrop="static" data-bs-keyboard="false" @endif>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                {!! $popup->render() !!}
                <button type="button" class="close" data-dismiss="modal" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function()
    {
        const popup = new PopupScheduler({
            id: 'popup_{!! $key !!}',
            mode: '{!! $popup->config('loop') !!}',
            time_delay: {!! $popup->config('time_delay') !!},
            time_loop: {!! $popup->config('time_loop') !!}
        });
        popup.start();
    });
</script>
