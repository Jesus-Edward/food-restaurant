<div class="tab-pane fade" id="stripe-setting" role="tabpanel" aria-labelledby="home-tab4">
    <div class="card">
        <div class="card-body border">
            <form action="{{ route('admin.stripe-settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="">Stripe Status</label>
                    <select name="stripe_status" id="" class="select3 form-control">
                        <option @selected(@$paymentGateway['stripe_status'] == 1) value="1">Active</option>
                        <option @selected(@$paymentGateway['stripe_status'] == 0) value="0">Inactive</option>
                    </select>
                </div>
                {{--
                                            <div class="form-group">
                                                <label for="">Stripe Account Mode</label>
                                                <select name="stripe_acct_mode" id=""
                                                    class="select2 form-control">
                                                    <option @selected(@$paymentGateway['paypal_acct_mode'] === 'sandbox') value="sandbox">Sandbox</option>
                                                    <option @selected(@$paymentGateway['paypal_acct_mode'] === 'live') value="live">Live</option>
                                                </select>
                                            </div> --}}

                <div class="form-group">
                    <label for="">Stripe Country Name</label>
                    <select name="stripe_country_name" id="" class="select3 form-control">
                        @foreach (config('countries.country_list') as $key => $country)
                            <option @selected(@$paymentGateway['stripe_country_name'] === $key) value="{{ $key }}">{{ $country }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Stripe Currency Name</label>
                    <select name="stripe_currency_name" id="" class="select3 form-control">
                        <option value="">Select</option>
                        @foreach (config('currencies.currency_list') as $currency)
                            <option @selected(@$paymentGateway['stripe_currency_name'] === $currency) value="{{ $currency }}">{{ $currency }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Stripe Currency Rate (Per
                        {{ config('settings.site_default_currency') }})</label>
                    <input name="stripe_currency_rate" value="{{ @$paymentGateway['stripe_currency_rate'] }}"
                        type="text" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Stripe Client ID</label>
                    <input name="stripe_client_id" value="{{ @$paymentGateway['stripe_client_id'] }}" type="text"
                        class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Stripe Secret Key</label>
                    <input name="stripe_secret_key" value="{{ @$paymentGateway['stripe_secret_key'] }}" type="text"
                        class="form-control">
                </div>

                <div class="form-group">
                    <label>Stripe Logo</label>
                    <div id="image-preview-2" class="image-preview stripe-preview">
                        <label for="image-upload-2" id="image-label-2">Choose File</label>
                        <input type="file" name="stripe_logo" id="image-upload-2">
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
            $('.stripe-preview').css({
                'background-image': 'url({{ @$paymentGateway['stripe_logo'] }})',
                'background-size': 'cover',
                'background-position': 'centre centre'
            })

            if (jQuery().select) {
                $(".select3").select2();
            }
        })


        $.uploadPreview({
            input_field: "#image-upload-2", // Default: .image-upload
            preview_box: "#image-preview-2", // Default: .image-preview
            label_field: "#image-label-2", // Default: .image-label
            label_default: "Choose File", // Default: Choose File
            label_selected: "Change File", // Default: Change File
            no_label: false, // Default: false
            success_callback: null // Default: null
        });
    </script>
@endpush
