<?php

namespace App\DataTables;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CategoryDataTable extends DataTable
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
                $edit = '<a href="'.route('admin.category.edit', $query->id).'"
                class="btn btn-primary"><i class="fas fa-edit"></i></a>';
                $delete = '<a href="'.route('admin.category.destroy', $query->id).'"
                class="btn btn-danger ml-2 delete-item"><i class="fas fa-trash"></i></a>';
                return $edit.$delete;
            })->addColumn('status', function($query){
                if ($query->status === 1) {
                    return '<span class="badge badge-primary">Active</span>';
                }else{
                    return '<span class="badge badge-danger">Inactive</span>';
                }
            })->addColumn('show_at_home', function($query){
                if ($query->show_at_home === 1) {
                    return '<span class="badge badge-primary">Yes</span>';
                }else{
                    return '<span class="badge badge-danger">No</span>';
                }
            })
            ->rawColumns(['action', 'status', 'show_at_home'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Category $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('category-table')
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
            Column::make('id')->width('20px'),
            Column::make('name')->width('150px'),
            Column::make('slug')->width('150px'),
            Column::make('show_at_home')->width('100px'),
            Column::make('status')->width('100px'),
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(120)
            ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Category_' . date('YmdHis');
    }
}
