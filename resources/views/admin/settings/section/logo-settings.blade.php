<div class="tab-pane fade" id="logo-setting" role="tabpanel" aria-labelledby="home-tab4">
    <div class="card">
        <div class="card-body border">
            <form action="{{ route('admin.logo-settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Logo</label>
                            <div id="image-preview1" class="image-preview logo">
                                <label for="image-upload" id="image-label1">Choose File</label>
                                <input type="file" name="logo" id="image-upload1">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Footer Logo</label>
                            <div id="image-preview2" class="image-preview footer_logo">
                                <label for="image-upload" id="image-label2">Choose File</label>
                                <input type="file" name="footer_logo" id="image-upload2">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Favicon</label>
                            <div id="image-preview3" class="image-preview favicon">
                                <label for="image-upload" id="image-label3">Choose File</label>
                                <input type="file" name="favicon" id="image-upload3">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Breadcrumb Logo</label>
                            <div id="image-preview4" class="image-preview breadcrumb">
                                <label for="image-upload" id="image-label4">Choose File</label>
                                <input type="file" name="breadcrumb" id="image-upload4">
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>

@push('script')
    <script>

        $(document).ready(function() {
            $('.logo').css({
                'background-image': 'url({{ asset(config("settings.logo")) }})',
                'background-size': 'cover',
                'background-position': 'centre centre'
            })
        })

        $(document).ready(function() {
            $('.footer_logo').css({
                'background-image': 'url({{ asset(config("settings.footer_logo")) }})',
                'background-size': 'cover',
                'background-position': 'centre centre'
            })
        })

        $(document).ready(function() {
            $('.favicon').css({
                'background-image': 'url({{ asset(config("settings.favicon")) }})',
                'background-size': 'cover',
                'background-position': 'centre centre'
            })
        })

        $(document).ready(function() {
            $('.breadcrumb').css({
                'background-image': 'url({{ asset(config("settings.breadcrumb")) }})',
                'background-size': 'cover',
                'background-position': 'centre centre'
            })
        })

        $.uploadPreview({
            input_field: "#image-upload1", // Default: .image-upload
            preview_box: "#image-preview1", // Default: .image-preview
            label_field: "#image-label1", // Default: .image-label
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

        $.uploadPreview({
            input_field: "#image-upload3", // Default: .image-upload
            preview_box: "#image-preview3", // Default: .image-preview
            label_field: "#image-label3", // Default: .image-label
            label_default: "Choose File", // Default: Choose File
            label_selected: "Change File", // Default: Change File
            no_label: false, // Default: false
            success_callback: null // Default: null
        });

        $.uploadPreview({
            input_field: "#image-upload4", // Default: .image-upload
            preview_box: "#image-preview4", // Default: .image-preview
            label_field: "#image-label4", // Default: .image-label
            label_default: "Choose File", // Default: Choose File
            label_selected: "Change File", // Default: Change File
            no_label: false, // Default: false
            success_callback: null // Default: null
        });
    </script>
@endpush
