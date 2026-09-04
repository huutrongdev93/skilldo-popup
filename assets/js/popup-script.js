class PopupScheduler
{
	constructor({ id, time_delay = 5, mode = 'only', time_loop = 1 })
	{
		this.id = id;
		this.time_delay = time_delay * 1000; // giây → ms
		this.mode = mode; // 'only' hoặc 'loop'
		this.time_loop = time_loop * 60 * 1000; // phút → ms
		this.modal = new bootstrap.Modal(document.getElementById(this.id));
		this.timer = null;
		this.localKey = `popup_shown_${this.id}`; // key lưu trạng thái
	}

	hasShown()
	{
		return localStorage.getItem(this.localKey) === 'true';
	}

	markAsShown()
	{
		localStorage.setItem(this.localKey, 'true');
	}

	start() {
		// Nếu đã hiển thị rồi và là chế độ only → bỏ qua
		if (this.mode === 'only' && this.hasShown()) return;

		// Bắt đầu hẹn giờ hiển thị
		setTimeout(() => {
			// Chỉ hiển thị lại nếu chưa xem (với only)
			if (this.mode === 'only' && this.hasShown()) return;

			this.show();

			// Nếu là loop → lặp lại
			if (this.mode === 'loop')
			{
				this.timer = setInterval(() => this.show(), this.time_loop);
			}
		}, this.time_delay);
	}

	show()
	{
		this.modal.show();

		// Khi modal được đóng → đánh dấu là đã hiển thị (đối với only)
		const element = document.getElementById(this.id);

		element.addEventListener('hidden.bs.modal', () => {
			if (this.mode === 'only') this.markAsShown();
		}, { once: true });
	}

	stop()
	{
		if (this.timer) clearInterval(this.timer);
	}

	reset()
	{
		// Dành cho admin hoặc debug: reset trạng thái hiển thị
		localStorage.removeItem(this.localKey);
	}
}

const PopupFormHandler = function () {}

PopupFormHandler.prototype.submit = function (form)
{
	const loading = SkilldoUtil.buttonLoading(form.find('button[type="submit"]'));

	const data = form.serializeJSON()

	data.action = 'Popup\\Ajax\\Web\\PopupAjax::submit';

	loading.start()

	request.post(ajax, data).then((response) =>
	{
		loading.stop()

		SkilldoMessage.response(response);

		if (response.status === 'success')
		{
			form.closest('.js_popup_contact_form').addClass('success');
		}
	});
}


/*
 * Nút "Đóng" do người dùng kéo vào popup builder (PopupCloseElement).
 * Bắt bằng delegate để nút nào chèn thêm sau khi trang đã tải cũng chạy.
 */
document.addEventListener('click', function (event)
{
	const button = event.target.closest('.js-popup-close');

	if (!button) return;

	const modal = button.closest('.modal');

	if (!modal || typeof bootstrap === 'undefined') return;

	event.preventDefault();

	const instance = bootstrap.Modal.getInstance(modal);

	if (instance) instance.hide();
});
