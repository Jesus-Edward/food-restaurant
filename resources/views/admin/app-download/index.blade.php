@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>App Download</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Section</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.app-download.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                    <div class="form-group">
                        <div class="col-md-6">
                        <label>App Image</label>
                        <div id="image-preview" class="image-preview image-preview-1">
                            <label for="image-upload" id="image-label">Choose File</label>
                            <input type="file" name="image" id="image-upload">
                            <input type="hidden" name="old_image" value="{{ @$apps->image }}">
                        </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6">
                        <label>Background</label>
                        <div id="image-preview2" class="image-preview image-preview-2">
                            <label for="image-upload" id="image-label2">Choose File</label>
                            <input type="file" name="background" id="image-upload2">
                            <input type="hidden" name="old_background" value="{{ @$apps->background }}">
                        </div>
                        </div>
                    </div>
                    </div>

                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" value="{{ @$apps->title }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Short Description</label>
                        <input type="text" name="short_description" value="{{ @$apps->short_description }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Play Store Link <code>(Leave empty to hide)</code></label>
                        <input type="text" name="play_store_link" value="{{ @$apps->play_store_link }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>App Store Link <code>(Leave empty to hide)</code></label>
                        <input type="text" name="app_store_link" value="{{ @$apps->app_store_link }}" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
            </div>
            </form>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $.uploadPreview({
            input_field: "#image-upload", // Default: .image-upload
            preview_box: "#image-preview", // Default: .image-preview
            label_field: "#image-label", // Default: .image-label
            label_default: "Choose File", // Default: Choose File
            label_selected: "Change File", // Default: Change File
            no_label: false, // Default: false
            success_callback: null // Default: null
        });

        $.uploadPreview({
            input_field: "#image-upload2", // Default: .image-upload
            preview_box: "#image-preview2", // Default: .image-preview
            label_field: "#image-label2", // Default: .image-label
            label_default: "Choose File", // Default: Choose File
            label_selected: "Change File", // Default: Change File
            no_label: false, // Default: false
            success_callback: null // Default: null
        });

        $(document).ready(function(){
            $('.image-preview-1').css({
                'background-image': 'url({{ asset(@$apps->image) }})',
                'background-size': 'cover',
                'background-position': 'centre centre'
            });

            $('.image-preview-2').css({
                'background-image': 'url({{ asset(@$apps->background) }})',
                'background-size': 'cover',
                'background-position': 'centre centre'
            });
        });
    </script>
@endpush
