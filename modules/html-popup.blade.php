<div class="modal fade popup-alert" id="modal-popup-alert" style="display: none">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                {!! $active::render() !!}
            </div>
        </div>
    </div>
</div>

<style>
    .popup-alert .modal-content {
        border-radius: 20px;
        overflow: hidden;
        border: 0;
        background-size: cover;
        padding: 0px;
    }

    .popup-alert .modal-content button.close {
        position: absolute;
        right: 3px;
        top: 3px;
        padding: 0;
        cursor: pointer;
        border: 0;
        -webkit-appearance: none;
        appearance: none;
        width: 40px;
        height: 40px;
        background-color: #000;
        border-radius: 50%;
        color: #fff;
        font-size: 30px;
        z-index: 9;
    }

    .popup-alert .modal-dialog {
        width: 800px;
        max-width: 100%;
        z-index: 999999999;
    }

    .modal-body {
        padding: 0;
    }

    .modal-open .modal {
        display: block;
    }

    .modal-backdrop.show {
        opacity: var(--bs-backdrop-opacity) !important;
    }

    #modal-popup-alert {
        z-index: 99999;
    }

    @media(max-width: 600px) {
        .popup-alert .modal-dialog {
            max-width: calc(100% - 20px) !important;
        }
    }
</style>
