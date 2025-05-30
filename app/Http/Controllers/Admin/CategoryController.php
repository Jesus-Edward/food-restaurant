<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CategoryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryCreateRequest;
use App\Http\Requests\Admin\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.product.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.product.category.create-category');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryCreateRequest $request): RedirectResponse
    {
        $categories = new Category();

        $categories->name = $request->name;
        $categories->slug = Str::slug($request->name);
        $categories->status = $request->status;
        $categories->show_at_home = $request->show_at_home;

        $categories->save();

        toastr()->success('Category Created Successfully', 'Created');
        return to_route('admin.category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $category = Category::findOrFail($id);
        return view('admin.product.category.edit-category', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, string $id): RedirectResponse
    {
        $categories = Category::findOrFail($id);

        $categories->name = $request->name;
        $categories->slug = Str::slug($request->name);
        $categories->status = $request->status;
        $categories->show_at_home = $request->show_at_home;

        $categories->update();

        toastr()->success('Category Updated Successfully', 'Updated');
        return to_route('admin.category.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $category = Category::findOrFail($id);

            $category->delete($id);
            return response(['status' => 'success', 'message' => 'Deleted Successfully']);
            }catch(\Exception $e){
                return response(['status' => 'error', 'message' => 'Something went wrong in the frontend']);
            }
    }
}
