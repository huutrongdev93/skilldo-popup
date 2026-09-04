/**
 * Form thu thập thông tin trong popup dựng bằng kéo thả.
 *
 * Gửi về Popup\Ajax\Web\PopupAjax::submitBuilder; định nghĩa field được server đọc
 * lại từ cây builder theo widget_id nên dữ liệu gửi lên chỉ là giá trị người dùng nhập.
 */
class PopupBuilderForm
{
    constructor(scope, $)
    {
        this.$ = $;

        this.scope = scope;

        this.wrapper = scope.find('.popup-builder-form');

        this.form = scope.find('.popup-builder-form-body');

        if (!this.form.length) return;

        // Trong khung xem thử của trình dựng thì chỉ hiển thị, không gửi dữ liệu thật
        this.isPreview = document.body.classList.contains('popup-builder-review')
            || document.body.classList.contains('builder-review');

        this.bind();
    }

    bind()
    {
        const self = this;

        this.form.off('submit.popupBuilderForm').on('submit.popupBuilderForm', function (e)
        {
            e.preventDefault();

            if (self.isPreview) return;

            self.submit(self.$(this));
        });
    }

    submit(form)
    {
        const $ = this.$;

        const self = this;

        if (typeof request === 'undefined' || typeof ajax === 'undefined')
        {
            console.error('[PopupBuilderForm] thiếu http.js (request/ajax) của theme');
            return;
        }

        const button = form.find('button[type="submit"]');

        const loading = (typeof SkilldoUtil !== 'undefined') ? SkilldoUtil.buttonLoading(button) : null;

        const data = form.serializeJSON();

        data.action = 'Popup\\Ajax\\Web\\PopupAjax::submitBuilder';

        data.popup_id = form.data('popup-id');

        data.widget_id = form.data('widget-id');

        if (loading) loading.start();

        request.post(ajax, data).then((response) =>
        {
            if (loading) loading.stop();

            if (response.status === 'success')
            {
                self.wrapper.addClass('success');

                if (parseInt(form.data('close-after'), 10) === 1)
                {
                    const delay = (parseInt(form.data('close-delay'), 10) || 0) * 1000;

                    setTimeout(() => self.closePopup(), delay);
                }

                return;
            }

            if (typeof SkilldoMessage !== 'undefined') SkilldoMessage.response(response);
        }).catch((err) =>
        {
            if (loading) loading.stop();

            console.error('[PopupBuilderForm] gửi dữ liệu thất bại:', err);
        });
    }

    closePopup()
    {
        const modal = this.form.closest('.modal');

        if (!modal.length || typeof bootstrap === 'undefined') return;

        const instance = bootstrap.Modal.getInstance(modal.get(0));

        if (instance) instance.hide();
    }
}

$(window).on('elementor/frontend/init', function ()
{
    elementorFrontend.hooks.addAction(
        'frontend/ready/PopupFormElement.default',
        function (scope, $)
        {
            new PopupBuilderForm(scope, $);
        }
    );
});
