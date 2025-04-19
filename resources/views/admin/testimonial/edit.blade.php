@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Testimonial</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Testimonial</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.testimonial.update', $testimonials->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Image</label>
                        <div id="image-preview" class="image-preview">
                            <label for="image-upload" id="image-label">Choose File</label>
                            <input type="file" name="image" value="{{ $testimonials->image }}" id="image-upload">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" value="{{ $testimonials->name }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Location</label>
                        <input type="text" name="location" value="{{ $testimonials->location }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Review</label>
                        <textarea name="review" id="" class="form-control">{{ $testimonials->review }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Rating</label>
                        <select name="rating" id="" class="form-control">
                            <option @selected($testimonials->rating == 1) value="1">1</option>
                            <option @selected($testimonials->rating == 2) value="2">2</option>
                            <option @selected($testimonials->rating == 3) value="3">3</option>
                            <option @selected($testimonials->rating == 4) value="4">4</option>
                            <option @selected($testimonials->rating == 5) value="5">5</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Show At Home</label>
                        <select name="show_at_home" class="form-control" id="">
                            <option @selected($testimonials->show_at_home === 1) value="1">Yes</option>
                            <option @selected($testimonials->show_at_home === 0) value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" id="">
                            <option @selected($testimonials->status === 1) value="1">Active</option>
                            <option @selected($testimonials->status === 0) value="0">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Testimonial</button>
            </div>
            </form>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('.image-preview').css({
                'background-image': 'url({{ asset($testimonials->image) }})',
                'background-size': 'cover',
                'background-position': 'centre centre'
            })
        })
    </script>
@endpush
