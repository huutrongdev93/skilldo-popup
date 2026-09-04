<?php
namespace Popup\Modules\Admin\Popups;

use Popup\Enum\PopupStatus;
use Popup\Models\Popup;
use Popup\Services\BuilderSectionService;
use SkillDo\Cms\Support\Admin;
use SkillDo\Cms\Table\Columns\ColumnBadge;
use SkillDo\Cms\Table\Columns\ColumnText;
use SkillDo\Database\Eloquent\Builder;
use SkillDo\Cms\Form\Form;
use SkillDo\Http\Request;

class PopupTable extends \SkillDo\Cms\Table\SKDObjectTable
{
    protected string $module = 'popup';

    protected string $table = 'popups';

    protected mixed $model = Popup::class;

    function getColumns()
    {
        $this->_column_headers = [
            'cb'        => 'cb',
            'name'     => [
                'label' => 'Tên popup',
                'column' => fn ($item, $args) =>  ColumnText::make('name', $item, $args)
            ],
            'template'     => [
                'label' => 'Loại',
                'column' => fn ($item, $args) => ColumnText::make('template', $item, $args)->value(function ($item) {
                    if($item->template === BuilderSectionService::TEMPLATE) return 'Tự thiết kế (kéo thả)';

                    if($item->template === 'default') return 'Mẫu cơ bản';

                    return 'Mẫu '.ltrim((string) $item->template, 'style');
                })
            ],
            'time_delay'     => [
                'label' => 'Thời delay',
                'column' => fn ($item, $args) => ColumnText::make('time_delay', $item, $args)->value(fn($item) => $item->time_delay . ' giây')
            ],
            'time_loop'     => [
                'label' => 'Thời gian lặp lại',
                'column' => fn ($item, $args) => ColumnText::make('time_loop', $item, $args)->value(fn($item) => $item->time_delay . ' phút')
            ],
            'loop'     => [
                'label' => 'Lặp lại',
                'column' => fn ($item, $args) => ColumnBadge::make('loop', $item, $args)->color(function ($status) {
                    return match ($status) {
                        'loop' => 'green',
                        'refresh' => 'blue',
                        default => 'red',
                    };
                })
                ->label(function ($status) {
                    return match ($status) {
                        'loop'      => 'Lặp lại liên tục',
                        'refresh'   => 'Hiển thị lại khi F5',
                        default     => 'Không hiển thị lại',
                    };
                })
            ],
            'status'     => [
                'label' => 'Trạng thái',
                'column' => fn ($item, $args) => ColumnBadge::make('status', $item, $args)->color(function ($status) {
                    return PopupStatus::tryFrom($status)->badge();
                })
                    ->label(function ($status) {
                        return PopupStatus::tryFrom($status)->label();
                    })
            ],
            'created' => [
                'label'  => trans('table.created'),
                'column' => fn ($item, $args) => ColumnText::make('created', $item, $args)->datetime()
            ],
        ];

        $this->_column_headers = apply_filters( "manage_".$this->module."_columns", $this->_column_headers );

        $this->_column_headers['action'] = trans('table.action');

        return apply_filters( "manage_".$this->module."_columns_full", $this->_column_headers );
    }

    function actionButton($item, $module, $table): array
    {
        $listButton = [];

        $listButton[] = Admin::button('blue', [
            'href'   => route('admin.popup.edit', ['id' => $item->popup_id]),
            'data-id' => $item->popup_id,
            'data-item' => htmlentities(json_encode($item->toObject())),
            'icon'    => Admin::icon('edit')
        ]);
        //Mọi popup đều sửa nội dung bằng trình dựng kéo thả
        $listButton[] = Admin::button('green', [
            'href'    => route('admin.popup.builder', ['id' => $item->popup_id]),
            'icon'    => '<i class="fa-duotone fa-solid fa-pen-ruler"></i>',
            'tooltip' => 'Thiết kế popup',
        ]);

        $listButton[] = Admin::btnDelete([
            'id' => $item->popup_id,
            'module' => $this->module,
            'model' => $this->model,
            'description' => trans('admin::message.page.confirmDelete')
        ]);
        /**
         * @since 7.0.0
         */
        return apply_filters('admin_'.$this->module.'_table_columns_action', $listButton);
    }

    function queryDisplay(Builder $query, \SkillDo\Http\Request $request, $data = []): Builder
    {
        $query = parent::queryDisplay($query, $request, $data);

        $query->orderBy('created', 'desc');

        return $query;
    }

    function headerFilter(Form $form, Request $request)
    {
        /**
         * @singe v7.0.0
         */
        return apply_filters('admin_'.$this->module.'_table_form_filter', $form);
    }

    function headerSearch(Form $form, Request $request): Form
    {

        $form->text('keyword', ['placeholder' => trans('table.search.keyword').'...'], $request->input('keyword'));

        /**
         * @singe v7.0.0
         */
        return apply_filters('admin_'.$this->module.'_table_form_search', $form);
    }

    function headerButton(): array
    {
        $buttons[] = Admin::button('add', ['href' => route('admin.popup.add')]);

        $buttons[] = Admin::button('reload');

        return $buttons;
    }
}