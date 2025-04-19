<div class="tab-pane fade" id="pusher-setting" role="tabpanel" aria-labelledby="profile-tab4">
    <div class="card">
        <div class="card-body border">
            <form action="{{ route('admin.pusher-settings.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="">Pusher App ID</label>
                    <input name="pusher_app_id" value="{{ config('settings.pusher_app_id') }}" type="text"
                        class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Pusher App Key</label>
                    <input name="pusher_app_key" value="{{ config('settings.pusher_app_key') }}" type="text"
                        class="form-control">
                </div>


                <div class="form-group">
                    <label for="">Pusher App Secret Key</label>
                    <input name="pusher_app_secret_key" value="{{ config('settings.pusher_app_secret_key') }}" type="text"
                        class="form-control">
                </div>


                <div class="form-group">
                    <label for="">Pusher Cluster</label>
                    <input name="pusher_cluster" value="{{ config('settings.pusher_cluster') }}" type="text"
                        class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>
