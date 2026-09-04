<div class="popup-box popup-template" data-template="{{ $active }}">
    <div class="popup-template-selection">
        <label for="">Chọn mẫu</label>
        <hr style="margin: 5px 0;">
        <div class="popup-template-grid gap-4">
        @foreach ($styles as $key => $template)
            <div class="popup-template-item {{($active == $key) ? 'active' : ''}}" data-template="{{ $key }}">
                {!! Image::url($template->image())->html() !!}
                <input type="radio" value="{{$key}}" name="template" {{($active == $key) ? 'checked' : ''}}>
                <button class="popup-template-select-button btn btn-blue" type="button">Chọn</button>
            </div>
        @endforeach
        </div>
    </div>
    <div class="popup-template-loading" style="display: none">
        <p class="placeholder-glow"><span class="placeholder col-12 rounded"></span></p>
        <p class="placeholder-wave"><span class="placeholder col-12 rounded"></span></p>
        <p class="placeholder-glow"><span class="placeholder col-12 rounded"></span></p>
        <p class="placeholder-wave"><span class="placeholder col-12 rounded"></span></p>
    </div>
    <div class="popup-template-setting" style="display: none">
        <div>
            <button type="button" class="btn btn-light btn-sm btn-effect-default mb-3 popup-template-back-button">← Quay lại</button>
        </div>
        <div class="popup-template-setting-content"></div>
    </div>
</div>

<div class="modal fade" id="popupBackConfirmModal" tabindex="-1" aria-labelledby="popupBackConfirmLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="popupBackConfirmLabel">Xác nhận</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Quay lại sẽ làm mất mọi thay đổi của bạn. Bạn có chắc chắn muốn quay lại?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" id="popupBackConfirmBtn">Đồng ý</button>
            </div>
        </div>
    </div>
</div>

<style>
    .popup-template-selection { background-color: #fff; padding:10px; overflow:hidden;}
    .popup-template-grid
    {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 16px;
    }
    .popup-template-item {
        position: relative; /* Ensure positioning context for children */
        overflow: hidden;
        height: auto;
        border: 2px solid #E3E7FB;
        border-radius: 5px;
    }
    .popup-template-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black overlay */
        opacity: 0; /* Hidden by default */
        transition: opacity 0.3s ease; /* Smooth transition for overlay */
        z-index: 1; /* Below the button */
    }

    .popup-template-item:hover::before {
        opacity: 1; /* Show overlay on hover */
    }

    .popup-template-item input {
        display: none;
    }

    .popup-template-item .popup-template-select-button {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%); /* Center the button */
        z-index: 2; /* Above the overlay */
        opacity: 0; /* Hidden by default */
        visibility: hidden; /* Also hide from screen readers when not visible */
        transition: opacity 0.3s ease, visibility 0.3s ease; /* Smooth transition for button */
    }

    .popup-template-item:hover .popup-template-select-button {
        opacity: 1; /* Show button on hover */
        visibility: visible;
    }

    .popup-template-item img {
        width: 100%;
    }
    .popup-template-item.active {
        border:2px solid #263A53;
    }


</style>

<script defer>

    class PopupTemplateSelector
    {
        template;
        id;
        buttons;
        popupTemplates;
        backButtons;
        backModalEl;
        backModal;
        confirmButton;

        constructor()
        {
            this.buttons        = document.querySelectorAll('.popup-template-select-button');
            this.popupTemplates = document.querySelectorAll('.popup-template-item');
            this.template       = document.querySelector('.popup-template').dataset.template;
            this.id             = document.querySelector('input[name="id"]')?.value;

            this.backButtons    = document.querySelectorAll('.popup-template-back-button');
            this.confirmButton  = document.getElementById('popupBackConfirmBtn');
            this.backModalEl    = document.getElementById('popupBackConfirmModal');

            // Initialize Bootstrap modal if available
            if (typeof bootstrap !== 'undefined' && this.backModalEl)
            {
                this.backModal = new bootstrap.Modal(this.backModalEl);
            }

            this.init();
        }

        init()
        {
            if(this.template !== undefined && this.id !== undefined && this.id !== '')
            {
                this.loadConfig(this.template);
            }

            this.buttons.forEach(button => {
                button.addEventListener('click', () => this.handleButtonClick(button));
            });

            // Back button shows confirm modal
            this.backButtons.forEach(btn =>
            {
                btn.addEventListener('click', (e) =>
                {
                    e.preventDefault();

                    if (typeof bootstrap !== 'undefined' && this.backModalEl && !this.backModal)
                    {
                        this.backModal = new bootstrap.Modal(this.backModalEl);
                    }

                    if (this.backModal)
                    {
                        this.backModal.show();
                    }
                    else
                    {
                        // Fallback to native confirm if bootstrap not available
                        if (confirm('Quay lại sẽ làm mất mọi thay đổi của bạn. Bạn có chắc chắn muốn quay lại?'))
                        {
                            this.handleBackConfirm();
                        }
                    }
                });
            });

            // Confirm button in modal
            if (this.confirmButton) {
                this.confirmButton.addEventListener('click', () => this.handleBackConfirm());
            }

            /*
             * Nút "Áp dụng lại mẫu" nằm trong form cấu hình do ajax trả về nên phải bắt
             * bằng delegate — lúc gắn listener này nút chưa tồn tại trong DOM.
             */
            document.addEventListener('click', (e) =>
            {
                const button = e.target.closest('.js_popup_apply_preset');

                if (!button) return;

                e.preventDefault();

                this.applyPreset(button);
            });
        }

        applyPreset(button)
        {
            if (!confirm('Dựng lại popup theo mẫu này? Thiết kế hiện tại trong trình kéo thả sẽ bị thay thế.')) return;

            const loading = (typeof SkilldoUtil !== 'undefined') ? SkilldoUtil.buttonLoading($(button)) : null;

            if (loading) loading.start();

            request.post(ajax, {
                action: 'Popup\Ajax\Admin\PopupAjax::applyPreset',
                id: button.dataset.id,
                template: this.template
            }).then(response => {
                if (loading) loading.stop();

                SkilldoMessage.response(response);
            }).catch(error => {
                if (loading) loading.stop();

                console.error('[Popup] áp dụng mẫu thất bại:', error);
            });
        }

        handleButtonClick(button)
        {
            const parentTemplate = button.closest('.popup-template-item');

            // Remove 'active' class from all popup-template elements
            this.popupTemplates.forEach(template =>
            {
                template.classList.remove('active');
            });

            if (parentTemplate)
            {
                // Add 'active' class to the current popup-template
                parentTemplate.classList.add('active');

                // Check the corresponding radio input
                const radioInput = parentTemplate.querySelector('input[type="radio"]');

                if (radioInput)
                {
                    radioInput.checked = true;
                }

                // Get the template key
                this.template = parentTemplate.dataset.template;

                // Load configuration for the selected template
                this.loadConfig(this.template);
            }
        }

        loadConfig(key)
        {
            // Hide all relevant sections
            document.querySelector('.popup-template-selection').style.display = 'none';
            document.querySelector('.popup-template-loading').style.display = 'none';
            document.querySelector('.popup-template-setting').style.display = 'none';

            // Show loading section
            document.querySelector('.popup-template-loading').style.display = 'block';

            request.post(ajax, {
                action: 'Popup\\Ajax\\Admin\\PopupAjax::config',
                template: key,
                id: this.id
            }).then( response => {
                document.querySelector('.popup-template-loading').style.display = 'none';
                document.querySelector('.popup-template-setting-content').innerHTML = decodeURIComponent(atob(response.data.html).split('').map(function (c) {
                    return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
                }).join(''))
                document.querySelector('.popup-template-setting').style.display = 'block'; // Show setting on success
                FormHelper.reset()
            }).catch(error => {
                document.querySelector('.popup-template-loading').style.display = 'none';
                document.querySelector('.popup-template-selection').style.display = 'block'; // Show selection on error
            });
        }

        handleBackConfirm()
        {
            // Hide modal
            if (this.backModal)
            {
                this.backModal.hide();
            }

            // Clear settings content and show selection grid
            const selectionEl = document.querySelector('.popup-template-selection');
            const loadingEl   = document.querySelector('.popup-template-loading');
            const settingEl   = document.querySelector('.popup-template-setting');
            const settingContent = document.querySelector('.popup-template-setting-content');

            if (settingContent)
            {
                settingContent.innerHTML = '';
            }

            if (settingEl)
            {
                settingEl.style.display = 'none';
            }
            if (loadingEl)
            {
                loadingEl.style.display = 'none';
            }
            if (selectionEl)
            {
                selectionEl.style.display = 'block';
            }

            // Reset active state to currently selected template (this.template)
            this.popupTemplates.forEach(t =>
            {
                const r = t.querySelector('input[type="radio"]');

                if (t.dataset.template === this.template)
                {
                    t.classList.add('active');

                    if (r) r.checked = true;
                }
                else
                {
                    t.classList.remove('active');

                    if (r) r.checked = false;
                }
            });
        }
    }

    new PopupTemplateSelector()
</script>

