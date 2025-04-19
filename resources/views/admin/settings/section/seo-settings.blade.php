<div class="tab-pane fade show active" id="seo-settings" role="tabpanel" aria-labelledby="seo-tab4">
    <div class="card">
        <div class="card-body border">
            <form action="{{ route('admin.seo-settings.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="">SEO Title</label>
                    <input name="seo_title" value="{{ config('settings.seo_title') }}" type="text"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="">SEO Description</label>
                    <textarea name="seo_description" type="text"
                        class="form-control">{{ config('settings.seo_description') }}</textarea>
                </div>
                <div class="form-group">
                    <label for="">SEO Keyword</label>
                    <input name="seo_keywords" value="{{ config('settings.seo_keywords') }}" type="text"
                        class="form-control inputtags">
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>

@push('script')
    <script>
        $(".inputtags").tagsinput('items');
    </script>
@endpush
