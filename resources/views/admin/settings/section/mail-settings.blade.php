<div class="tab-pane fade" id="mail-settings" role="tabpanel" aria-labelledby="contact-tab4">
    <div class="card">
        <div class="card-body border">
            <form action="{{ route('admin.mail-settings.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Mail Driver</label>
                            <input name="mail_driver" value="{{ config('settings.mail_driver') }}" type="text"
                                class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Mail Port</label>
                            <input name="mail_port" value="{{ config('settings.mail_port') }}" type="text"
                                class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Mail Encryption</label>
                            <input name="mail_encryption" value="{{ config('settings.mail_encryption') }}" type="text"
                                class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Mail Host</label>
                            <input name="mail_host" value="{{ config('settings.mail_host') }}" type="text"
                                class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Mail Username</label>
                            <input name="mail_username" value="{{ config('settings.mail_username') }}" type="text"
                                class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Mail Password</label>
                            <input name="mail_password" value="{{ config('settings.mail_password') }}" type="text"
                                class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Mail From Address</label>
                            <input name="mail_from_address" value="{{ config('settings.mail_from_address') }}" type="text"
                                class="form-control">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Received Mail Address</label>
                            <input name="received_mail_address" value="{{ config('settings.received_mail_address') }}" type="text"
                                class="form-control">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>
