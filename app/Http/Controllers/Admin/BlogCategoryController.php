<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BlogCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Str;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BlogCategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.blog.blog-category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog.blog-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'max:255', 'unique:blog_categories,title'],
            'status' => ['required', 'boolean']
        ]);

        $category = new BlogCategory();
        $category->title = $request->title;
        $category->slug = Str::slug($request->title);
        $category->status = $request->status;
        $category->save();

        toastr()->success('Created Successfully');
        return to_route('admin.blogs-category.index');
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
    public function edit(string $id)
    {
        $category = BlogCategory::findOrFail($id);
        return view('admin.blog.blog-category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => ['required', 'max:255', 'unique:blog_categories,title,'.$id],
            'status' => ['required', 'boolean']
        ]);

        $category = BlogCategory::findOrFail($id);
        $category->title = $request->title;
        $category->slug = Str::slug($request->title);
        $category->status = $request->status;
        $category->save();

        toastr()->success('Updated Successfully');
        return to_route('admin.blogs-category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $category = BlogCategory::findOrFail($id);
            $category->delete();

            return response(['status' => 'success', 'message' => 'Deleted Successfully']);
        } catch (\Exception $e) {
            logger($e);
            return response(['status' => 'error', 'message' => 'Something went wrong from the frontend']);
        }
    }
}
