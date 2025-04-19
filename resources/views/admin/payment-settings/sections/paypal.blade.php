<div class="tab-pane fade show active" id="paypal-setting" role="tabpanel" aria-labelledby="home-tab4">
    <div class="card">
        <div class="card-body border">
            <form action="{{ route('admin.paypal-settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="">Paypal Status</label>
                    <select name="paypal_status" id="" class="select2 form-control">
                        <option @selected(@$paymentGateway['paypal_status'] == 1) value="1">Active</option>
                        <option @selected(@$paymentGateway['paypal_status'] == 0) value="0">Inactive</option>
                    </select>
                </div>


                <div class="form-group">
                    <label for="">Paypal Account Mode</label>
                    <select name="paypal_acct_mode" id="" class="select2 form-control">
                        <option @selected(@$paymentGateway['paypal_acct_mode'] === 'sandbox') value="sandbox">Sandbox</option>
                        <option @selected(@$paymentGateway['paypal_acct_mode'] === 'live') value="live">Live</option>
                    </select>
                </div>


                <div class="form-group">
                    <label for="">Paypal Country Name</label>
                    <select name="paypal_country_name" id="" class="select2 form-control">
                        @foreach (config('countries.country_list') as $key => $country)
                            <option @selected(@$paymentGateway['paypal_country_name'] === $key) value="{{ $key }}">{{ $country }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Paypal Currency Name</label>
                    <select name="paypal_currency_name" id="" class="select2 form-control">
                        <option value="">Select</option>
                        @foreach (config('currencies.currency_list') as $currency)
                            <option @selected(@$paymentGateway['paypal_currency_name'] === $currency) value="{{ $currency }}">{{ $currency }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Paypal Currency Rate (Per
                        {{ config('settings.site_default_currency') }})</label>
                    <input name="paypal_currency_rate" value="{{ @$paymentGateway['paypal_currency_rate'] }}"
                        type="text" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Paypal Client ID</label>
                    <input name="paypal_client_id" value="{{ @$paymentGateway['paypal_client_id'] }}" type="text"
                        class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Paypal Secret Key</label>
                    <input name="paypal_secret_key" value="{{ @$paymentGateway['paypal_secret_key'] }}" type="text"
                        class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Paypal App ID</label>
                    <input name="paypal_app_id" value="{{ @$paymentGateway['paypal_app_id'] }}" type="text"
                        class="form-control">
                </div>

                <div class="form-group">
                    <label>Paypal Logo</label>
                    <div id="image-preview" class="image-preview paypal-preview">
                        <label for="image-upload" id="image-label">Choose File</label>
                        <input type="file" name="paypal_logo" id="image-upload">
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
            $('.paypal-preview').css({
                'background-image': 'url({{ @$paymentGateway['paypal_logo'] }})',
                'background-size': 'cover',
                'background-position': 'centre centre'
            })
        })
    </script>
@endpush
