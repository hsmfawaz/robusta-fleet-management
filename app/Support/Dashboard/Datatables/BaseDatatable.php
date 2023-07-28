<?php

namespace App\Support\Dashboard\Datatables;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

abstract class BaseDatatable extends DataTable
{
    protected ?string $actionable = 'edit|delete';

    protected bool $withFormModal = false;

    protected bool $indexer = true;

    protected ?int $defaultOrder = 1;

    protected string $route = '';

    private array $customData = [];

    public ?string $ajaxEndpoint = null;

    abstract protected function columns(): array;

    abstract public function query(): Builder;

    protected function customColumns(): array
    {
        return [];
    }

    protected function deleteBtn($model)
    {
        return Blade::render(File::get(__DIR__.'/actions/delete_button.blade.php'), [
            'route' => route($this->route.'.destroy', $model),
        ]);
    }

    protected function customColumn(string $name, string $title, $searchable = true): Column
    {
        return Column::make($name)
            ->title($title)
            ->orderable(false)
            ->searchable($searchable)
            ->content('---');
    }

    public function dataTable($query)
    {
        $datatable = datatables()->eloquent($query)->addIndexColumn();
        $customColumns = collect($this->prepareCustomColumns());

        $customColumns->each(fn (\Closure $i, $key) => $datatable->addColumn($key, $i));

        collect($this->filters())
            ->each(fn (\Closure $i, $key) => $datatable->filterColumn($key, $i));

        collect($this->orders())
            ->each(fn (\Closure $i, $key) => $datatable->orderColumn($key, $i));

        return $datatable->rawColumns($customColumns->keys()->all());
    }

    public function getAjaxEndpoint()
    {
        return $this->ajaxEndpoint ?: url()->full();
    }

    protected function filters(): array
    {
        return [];
    }

    protected function actions($model): array
    {
        return [];
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $builder = $this->builder()
            ->setTableId('base-datatable-table')
            ->columns($this->prepareColumns())
            ->minifiedAjax($this->getAjaxEndpoint())
            ->responsive()
            ->buttons(array_filter(['print']))
            ->dom($this->getDomVariable())
            ->pageLength();

        if ($this->defaultOrder !== null) {
            $builder->orderBy($this->defaultOrder, 'desc');
        }

        return $builder;
    }

    public function getIndex()
    {
        $indexColumn = $this->builder()->config->get('datatables.index_column', 'DT_RowIndex');

        return new Column([
            'data' => $indexColumn,
            'name' => $indexColumn,
            'title' => '#',
            'orderable' => false,
            'searchable' => false,
            'attributes' => [
                'class' => 'w-10',
            ],
        ]);
    }

    protected function column(string $name, string $title, $searchable = true): Column
    {
        return Column::make($name)
            ->title($title)
            ->orderable(false)
            ->searchable($searchable)
            ->content('---');
    }

    protected function orders(): array
    {
        return [];
    }

    private function prepareColumns()
    {
        $list = [];

        if ($this->indexer) {
            $list[] = $this->getIndex();
        }

        $list = array_merge($list, $this->columns());

        if ($this->actionable !== '') {
            $list[] = Column::computed('action')
                ->title(__('Actions'))
                ->searchable(false)
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center');
        }

        return $list;
    }

    public static function create(
        string $route,
        array $data = [],
    ): static {
        $instance = new static();
        $instance->route = $route;
        $instance->customData = $data;

        return $instance;
    }

    private function prepareCustomColumns()
    {
        $customs = $this->customColumns();
        if ($this->actionable !== '') {
            $customs['action'] = function ($model) {
                $customActions = array_map(function ($action) {
                    return $action instanceof Renderable ? $action->render() : $action;
                }, $this->actions($model));
                $allActions = array_merge(
                    $customActions,
                    $this->prepareActionsButtons($model)
                );
                $actions = implode('', $allActions);

                return "<div class='btn-group'>{$actions}</div>";
            };
        }

        return $customs;
    }

    private function prepareActionsButtons($model)
    {
        $currentActions = explode('|', $this->actionable);
        $actions = [];

        if (in_array('show', $currentActions)) {
            $actions[] = Blade::render(File::get(__DIR__.'/actions/show_button.blade.php'), [
                'route' => route($this->route.'.show', $model),
            ]);
        }

        if (in_array(
            'edit',
            $currentActions
        )) {
            $actions[] = Blade::render(File::get(__DIR__.'/actions/edit_button.blade.php'), [
                'route' => route($this->route.'.edit', $model),
                'modelID' => $this->withFormModal ? $model->getKey() : null,
            ]);
        }
        if (in_array(
            'delete',
            $currentActions
        )) {
            $actions[] = Blade::render(File::get(__DIR__.'/actions/delete_button.blade.php'), [
                'route' => route($this->route.'.destroy', $model),
            ]);
        }

        return $actions;
    }

    private function getDomVariable()
    {
        $btns = 'l';

        return <<<HTML
        <"d-flex justify-content-between align-items-center bg-white br-25 p-3 mb-3"f<"d-flex align-items-center"$btns>>
        rt
        <"d-flex justify-content-center align-items-center items-center"p>
        HTML;
    }
}
