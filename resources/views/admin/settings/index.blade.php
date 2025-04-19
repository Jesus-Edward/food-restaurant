@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Settings</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>All Settings</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-4">
                        <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab4" data-toggle="tab" href="#general-setting"
                                    role="tab" aria-controls="home" aria-selected="true">General Settings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="home-tab4" data-toggle="tab" href="#logo-setting"
                                    role="tab" aria-controls="home" aria-selected="true">Logo Settings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="appearance-tab4" data-toggle="tab" href="#appearance-settings" role="tab"
                                    aria-controls="contact" aria-selected="false">Appearance Settings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab4" data-toggle="tab" href="#pusher-setting" role="tab"
                                    aria-controls="profile" aria-selected="false">Pusher Settings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="contact-tab4" data-toggle="tab" href="#mail-settings" role="tab"
                                    aria-controls="contact" aria-selected="false">Mail Settings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="seo-tab4" data-toggle="tab" href="#seo-settings" role="tab"
                                    aria-controls="contact" aria-selected="false">SEO Settings</a>
                            </li>

                        </ul>
                    </div>

                    <div class="col-12 col-sm-12 col-md-8">
                        <div class="tab-content no-padding" id="myTab2Content">

                            @include('admin.settings.section.general-settings')

                            @include('admin.settings.section.logo-settings')

                            @include('admin.settings.section.appearance-settings')

                            @include('admin.settings.section.pusher-settings')

                            @include('admin.settings.section.mail-settings')

                            @include('admin.settings.section.seo-settings')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
