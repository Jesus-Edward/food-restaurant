<?php

namespace App\DataTables;

use App\Models\ProductRating;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductRatingDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function($query){
                $delete = '<a href="'.route('admin.review.destroy', $query->id).
                '" class="btn btn-danger ml-2 delete-item"><i class="fas fa-trash"></i></a>';

                return $delete;
            })
            ->addColumn('status', function($query){
                $html = '
                <select class="form-control review_status" data-id="'.$query->id.'">
                    <option '.($query->status === 1 ? 'selected' : '').' value="1">Approved</option>
                    <option '.($query->status === 0 ? 'selected' : '').' value="0">Pending</option>
                </select>';

                return $html;
            })
            ->addColumn('name', function($query){
                return $query->users->name;
            })
            ->addColumn('product', function($query){
                return $query->products->name;
            })
            ->rawColumns(['status', 'user_name', 'action', 'product'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProductRating $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('productrating-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(0)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('name'),
            Column::make('product'),
            Column::make('rating'),
            Column::make('review'),
            Column::make('status')->width('150px'),
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(60)
            ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ProductRating_' . date('YmdHis');
    }
}
