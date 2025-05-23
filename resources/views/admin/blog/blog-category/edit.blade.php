@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Blog Categories</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Blog Categories</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.blogs-category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" value="{{ $category->title }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" id="">
                            <option @selected($category->status === 1) value="1">Active</option>
                            <option @selected($category->status === 0) value="0">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Category</button>
            </div>
            </form>
        </div>
    </section>
@endsection
