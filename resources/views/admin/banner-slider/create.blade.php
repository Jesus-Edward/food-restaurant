@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Banner Slider</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Banner Slider</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.banner-slider.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label>Banner</label>
                        <div id="image-preview" class="image-preview">
                            <label for="image-upload" id="image-label">Choose File</label>
                            <input type="file" name="image" id="image-upload">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" value="{{ old('title') }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Sub Title</label>
                        <input type="text" name="sub_title" value="{{ old('sub_title') }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Slider URL</label>
                        <input type="text" name="slider_url" value="{{ old('slider_url') }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" id="">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Banner</button>
            </div>
            </form>
        </div>
    </section>
@endsection
