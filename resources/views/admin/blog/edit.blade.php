@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Blog</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Blog</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Blog Image</label>
                        <div id="image-preview" class="image-preview">
                            <label for="image-upload" id="image-label">Choose File</label>
                            <input type="file" name="image" id="image-upload">
                            <input type="hidden" name="old_image" value="{{ $blog->image }}" id="image-upload">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" value="{{ $blog->title }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Post</label>
                        <textarea type="text" name="post" class="form-control summernote" id="">{!! $blog->post !!}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Blog Category</label>
                        <select name="category" class="form-control select2" id="">
                            @foreach ($categories as $category)
                                <option @selected($blog->category_id === $category->id) value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>SEO Title</label>
                        <input type="text" name="seo_title" value="{{ $blog->seo_title }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>SEO Description</label>
                        <textarea type="text" name="seo_post" class="form-control">{{ $blog->seo_post }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" id="">
                            <option @selected($blog->status === 1) value="1">Active</option>
                            <option @selected($blog->status === 0) value="0">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Blog</button>
            </div>
            </form>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('.image-preview').css({
                'background-image': 'url({{ asset($blog->image) }})',
                'background-size': 'cover',
                'background-position': 'centre centre'
            });
        });
    </script>
@endpush
