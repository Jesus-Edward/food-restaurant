@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Slider</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Slider</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.slider.update', $sliders->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label>Image</label>
                        <div id="image-preview" class="image-preview">
                            <label for="image-upload" id="image-label">Choose File</label>
                            <input type="file" name="image" id="image-upload">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Offer</label>
                        <input type="text" value="{{ $sliders->offer }}" name="offer" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" value="{{ $sliders->title }}" name="title" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Sub Title</label>
                        <input type="text" value="{{ $sliders->sub_title }}" name="sub_title" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Short Description</label>
                        <textarea type="text" name="short_description" class="form-control">{{ $sliders->short_description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Button Link</label>
                        <input type="text" value="{{ $sliders->button_link }}" name="button_link" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" id="">
                            <option @selected($sliders->status === 1) value="1">Active</option>
                            <option @selected($sliders->status === 0) value="0">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Slider</button>
            </div>
            </form>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('.image-preview').css({
                'background-image': 'url({{ asset($sliders->image) }})',
                'background-size': 'cover',
                'background-position': 'centre centre'
            })
        })
    </script>
@endpush
