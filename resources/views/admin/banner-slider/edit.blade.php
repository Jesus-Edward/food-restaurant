@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Banner Slider</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Banner Slider</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.banner-slider.update', $bannerSlider->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Banner</label>
                        <div id="image-preview" class="image-preview">
                            <label for="image-upload" id="image-label">Choose File</label>
                            <input type="file" name="image" value="{{ $bannerSlider->banner }}" id="image-upload">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" value="{{ $bannerSlider->title }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Sub Title</label>
                        <input type="text" name="sub_title" value="{{ $bannerSlider->sub_title }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Slider URL</label>
                        <input type="text" name="slider_url" value="{{ $bannerSlider->slider_url }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" id="">
                            <option @selected($bannerSlider->status === 1) value="1">Active</option>
                            <option @selected($bannerSlider->status === 0) value="0">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Banner</button>
            </div>
            </form>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('.image-preview').css({
                'background-image': 'url({{ asset($bannerSlider->banner) }})',
                'background-size': 'cover',
                'background-position': 'centre centre'
            });
        });
    </script>
@endpush
