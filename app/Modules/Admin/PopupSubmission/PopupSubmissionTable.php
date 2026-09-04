<?php
namespace Popup\Modules\Admin\PopupSubmission;

use Popup\Models\PopupSubmission;
use SkillDo\Cms\Support\Admin;
use SkillDo\Cms\Table\Columns\ColumnText;
use SkillDo\Cms\Table\Columns\ColumnView;
use SkillDo\Database\Eloquent\Builder;
use SkillDo\Cms\Form\Form;
use SkillDo\Http\Request;

class PopupSubmissionTable extends \SkillDo\Cms\Table\SKDObjectTable
{
    protected string $module = 'popup_submission';

    protected mixed $model = PopupSubmission::class;

    function getColumns()
    {
        $this->_column_headers = [
            'cb'        => 'cb',
            'name'     => [
                'label' => 'Tên popup',
                'column' => fn ($item, $args) =>  ColumnText::make('name', $item, $args)
            ],
            'data'     => [
                'label' => 'Thông tin',
                'column' => fn ($item, $args) => ColumnView::make('data', $item, $args)->html(function ($column) {

                    if(!empty($column->item->data) && hasItems($column->item->data))
                    {
                        foreach ($column->item->data as $item)
                        {
                            echo '<div><strong>'. $item['label'] .':</strong> '. $item['value'] .'</div>';
                        }
                    }
                })
            ],
            'ip' => [
                'label'  => 'Địa chỉ IP',
                'column' => fn ($item, $args) => ColumnText::make('ip', $item, $args)
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

        $listButton[] = Admin::btnDelete([
            'id' => $item->getKey(),
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
        return apply_filters('admin_'.$this->module.'_table_form_filter', $form);
    }

    function headerSearch(Form $form, Request $request): Form
    {
        return apply_filters('admin_'.$this->module.'_table_form_search', $form);
    }

    function headerButton(): array
    {
        $buttons[] = Admin::button('reload');

        return $buttons;
    }
}