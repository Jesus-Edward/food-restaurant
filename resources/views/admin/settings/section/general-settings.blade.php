<div class="tab-pane fade show active" id="general-setting" role="tabpanel" aria-labelledby="home-tab4">
    <div class="card">
        <div class="card-body border">
            <form action="{{ route('admin.general.settings.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="">Website Name</label>
                    <input name="site_name" value="{{ config('settings.site_name') }}" type="text"
                        class="form-control">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Website Email</label>
                            <input name="site_email" value="{{ config('settings.site_email') }}" type="text"
                                class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Website Phone</label>
                            <input name="site_phone" value="{{ config('settings.site_phone') }}" type="text"
                                class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Default Currency</label>
                    <select name="site_default_currency" id="" class="select2 form-control">
                        @foreach (config('currencies.currency_list') as $currency)
                            <option @selected(config('settings.site_default_currency') === $currency) value="{{ $currency }}">{{ $currency }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Currency Symbol</label>
                            <input name="site_currency_symbol" value="{{ config('settings.site_currency_symbol') }}"
                                type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Currency Symbol Position</label>
                            <select name="site_currency_symbol_position" id="" class="select2 form-control">
                                <option @selected(config('settings.site_currency_symbol_position') === 'right') value="right">Right
                                </option>
                                <option @selected(config('settings.site_currency_symbol_position') === 'left') value="left">Left
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>
