<div class="tab-pane fade" id="razorpay_setting" role="tabpanel" aria-labelledby="home-tab4">
    <div class="card">
        <div class="card-body border">
            <form action="{{ route('admin.razorpay-settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="">Razorpay Status</label>
                    <select name="razorpay_status" id="" class="select3 form-control">
                        <option @selected(@$paymentGateway['razorpay_status'] == 1) value="1">Active</option>
                        <option @selected(@$paymentGateway['razorpay_status'] == 0) value="0">Inactive</option>
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
                    <label for="">Razorpay Country Name</label>
                    <select name="razorpay_country_name" id="" class="select3 form-control">
                        @foreach (config('countries.country_list') as $key => $country)
                            <option @selected(@$paymentGateway['razorpay_country_name'] === $key) value="{{ $key }}">{{ $country }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Stripe Currency Name</label>
                    <select name="razorpay_currency_name" id="" class="select3 form-control">
                        <option value="">Select</option>
                        @foreach (config('currencies.currency_list') as $currency)
                            <option @selected(@$paymentGateway['razorpay_currency_name'] === $currency) value="{{ $currency }}">{{ $currency }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Razorpay Currency Rate (Per
                        {{ config('settings.site_default_currency') }})</label>
                    <input name="razorpay_currency_rate" value="{{ @$paymentGateway['razorpay_currency_rate'] }}"
                        type="text" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Razorpay Client ID</label>
                    <input name="razorpay_client_id" value="{{ @$paymentGateway['razorpay_client_id'] }}" type="text"
                        class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Razorpay Secret Key</label>
                    <input name="razorpay_secret_key" value="{{ @$paymentGateway['razorpay_secret_key'] }}"
                        type="text" class="form-control">
                </div>

                <div class="form-group">
                    <label>Razorpay Logo</label>
                    <div id="image-preview-3" class="image-preview razorpay-preview">
                        <label for="image-upload-3" id="image-label-3">Choose File</label>
                        <input type="file" name="razorpay_logo" id="image-upload-3">
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
            $('.razorpay-preview').css({
                'background-image': 'url({{ @$paymentGateway['razorpay_logo'] }})',
                'background-size': 'cover',
                'background-position': 'centre centre'
            })

            if (jQuery().select) {
                $(".select3").select2();
            }
        })


        $.uploadPreview({
            input_field: "#image-upload-3", // Default: .image-upload
            preview_box: "#image-preview-3", // Default: .image-preview
            label_field: "#image-label-3", // Default: .image-label
            label_default: "Choose File", // Default: Choose File
            label_selected: "Change File", // Default: Change File
            no_label: false, // Default: false
            success_callback: null // Default: null
        });
    </script>
@endpush
