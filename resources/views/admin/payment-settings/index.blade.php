@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Payment Gateway</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>All Gateways</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-4">
                        <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab4" data-toggle="tab" href="#paypal-setting"
                                    role="tab" aria-controls="home" aria-selected="true">Paypal Settings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab4" data-toggle="tab" href="#stripe-setting" role="tab"
                                    aria-controls="profile" aria-selected="false">Stripe Settings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="contact-tab4" data-toggle="tab" href="#razorpay_setting" role="tab"
                                    aria-controls="contact" aria-selected="false">Razorpay Settings</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-12 col-sm-12 col-md-8">
                        <div class="tab-content no-padding" id="myTab2Content">
                            @include('admin.payment-settings.sections.paypal')

                            @include('admin.payment-settings.sections.stripe')

                            @include('admin.payment-settings.sections.razorpay')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
