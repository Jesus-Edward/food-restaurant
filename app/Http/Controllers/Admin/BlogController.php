<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BlogCommentDataTable;
use App\DataTables\BlogDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogCreateRequest;
use App\Http\Requests\Admin\BlogUpdateRequest;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Traits\FileUploadTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Str;

class BlogController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(BlogDataTable $dataTable)
    {
        return $dataTable->render('admin.blog.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = BlogCategory::all();
        return view('admin.blog.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogCreateRequest $request): RedirectResponse
    {
        $imagePath = $this->uploadImage($request, 'image');

        $blog = new Blog();
        $blog->image = $imagePath;
        $blog->user_id = auth()->user()->id;
        $blog->title = $request->title;
        $blog->slug = Str::slug($request->title);
        $blog->category_id = $request->category;
        $blog->post = $request->post;
        $blog->seo_title = $request->seo_title;
        $blog->seo_post = $request->seo_post;
        $blog->status = $request->status;
        $blog->save();

        toastr()->success('Blog Created Successfully');
        return to_route('admin.blogs.index');
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
        $categories = BlogCategory::all();
        $blog = Blog::findOrFail($id);
        return view('admin.blog.edit', compact('blog', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogUpdateRequest $request, string $id)
    {
        $imagePath = $this->uploadImage($request, 'image', $request->old_image);

        $blog = Blog::findOrFail($id);
        $blog->image = !empty($imagePath) ? $imagePath : $request->old_image;
        $blog->title = $request->title;
        $blog->slug = Str::slug($request->title);
        $blog->category_id = $request->category;
        $blog->post = $request->post;
        $blog->seo_title = $request->seo_title;
        $blog->seo_post = $request->seo_post;
        $blog->status = $request->status;
        $blog->save();

        toastr()->success('Blog Updated Successfully');
        return to_route('admin.blogs.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $blog = Blog::findOrFail($id);
            $blog->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully']);
        } catch (\Exception $e) {
            logger($e);
            return response(['status' => 'error', 'message' => 'Something went wrong in the frontend']);
        }
    }

    /**Shows blog comments dataTable */
    function blogsComments(BlogCommentDataTable $dataTable)
    {
        return $dataTable->render('admin.blog.blog-comment.index');
    }

    /**Edits blog comments dataTable */
    function editComment($id)
    {
        $blogComment = BlogComment::findOrFail($id);
        return view('admin.blog.blog-comment.edit', compact('blogComment'));
    }

    /**Update blog comment database */
    function updateComment($id)
    {
        $blogComment = BlogComment::find($id);
        $blogComment->status = !$blogComment->status;
        $blogComment->update();

        toastr()->success('Comment Update Successfully');
        return to_route('admin.blogs.comments.index');
    }

    /**
     * Remove the specified comment from storage.
     */
    public function destroyComment(string $id)
    {
        try {
            $blogComment = BlogComment::findOrFail($id);
            $blogComment->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully']);
        } catch (\Exception $e) {
            logger($e);
            return response(['status' => 'error', 'message' => 'Something went wrong in the frontend']);
        }
    }
}
