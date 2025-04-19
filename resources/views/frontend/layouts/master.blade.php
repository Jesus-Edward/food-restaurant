<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=device-dpi" />
    <meta name="description" content="{{ config('settings.seo_description') }}">
    <meta name="keywords" content="{{ config('settings.seo_keywords') }}">

    @yield('og_metatag_section')

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ config('settings.seo_title') }}</title>

    <title>FoodPark || Restaurant Template</title>
    <link rel="icon" type="image/png" href="{{ asset(config('settings.favicon')) }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/spacing.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/venobox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/jquery.exzoom.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/custom-loader.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="css/rtl.css"> -->

    <style>
        :root {
            --colorPrimary: {{ config('settings.site_color') }};
        }
    </style>

    <script>
        var pusherKey = "{{ config('settings.pusher_app_key') }}"
        var pusherCluster = "{{ config('settings.pusher_cluster') }}"
        var loggedInUserId = "{{ auth()->user()->id ?? '' }}";
    </script>
    @vite(['resources/js/bootstrap.js', 'resources/js/frontend.js']);
</head>

<body>

    <!--A simple to the issue which was showing extra whitespace in the frontend instead of adding
    d-none and removing it in the ajax setup you can simply change the position of the container
    class to absolute from relative. -->

    <div class="overlay-container d-none">
        <div class="overlay" id="loader">
            <span class="loader"></span>
        </div>
    </div>


    <!-- CART POPUT START -->
    <div class="fp__cart_popup">
        <div class="modal fade" id="loadCartModal" tabindex="1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body load_product_modal_body">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CART POPUT END -->


    {{-- {{ Cart::destroy(); }} --}}

    <!--=============================
        TOPBAR START
    ==============================-->
    <section class="fp__topbar">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-md-8">
                    <ul class="fp__topbar_info d-flex flex-wrap">
                        @if (config('settings.site_email'))
                            <li><a href="mailto:{{ config('settings.site_email') }}"><i class="fas fa-envelope"></i>
                                    {{ config('settings.site_email') }}</a>
                            </li>
                        @endif
                        @if (config('settings.site_phone'))
                            <li><a href="callto:{{ config('settings.site_phone') }}"><i class="fas fa-phone-alt"></i>
                                    {{ config('settings.site_phone') }}</a></li>
                        @endif
                    </ul>
                </div>
                @php
                    $socials = \App\Models\SocialLink::where('status', 1)->get();
                @endphp
                <div class="col-xl-6 col-md-4 d-none d-md-block">
                    <ul class="topbar_icon d-flex flex-wrap">
                        @foreach ($socials as $social)
                            <li><a href="{{ $social->social_link }}"><i class="{{ $social->icon }}"></i></a> </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        TOPBAR END
    ==============================-->


    <!--=============================
        MENU START
    ==============================-->
    @include('frontend.layouts.menu')
    <!--=============================
        MENU END
    ==============================-->

    @yield('content')
    <!--=============================
        FOOTER START
    ==============================-->
    @include('frontend.layouts.footer')
    <!--=============================
        FOOTER END
    ==============================-->


    <!--=============================
        SCROLL BUTTON START
    ==============================-->
    <div class="fp__scroll_btn">
        go to top
    </div>
    <!--=============================
        SCROLL BUTTON END
    ==============================-->


    <!--jquery library js-->
    <script src="{{ asset('frontend/assets/js/jquery-3.6.0.min.js') }}"></script>
    <!--bootstrap js-->
    <script src="{{ asset('frontend/assets/js/bootstrap.bundle.min.js') }}"></script>
    <!--font-awesome js-->
    <script src="{{ asset('frontend/assets/js/Font-Awesome.js') }}"></script>
    <!-- slick slider -->
    <script src="{{ asset('frontend/assets/js/slick.min.js') }}"></script>
    <!-- isotop js -->
    <script src="{{ asset('frontend/assets/js/isotope.pkgd.min.js') }}"></script>
    <!-- simplyCountdownjs -->
    <script src="{{ asset('frontend/assets/js/simplyCountdown.js') }}"></script>
    <!-- counter up js -->
    <script src="{{ asset('frontend/assets/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery.countup.min.js') }}"></script>
    <!-- nice select js -->
    <script src="{{ asset('frontend/assets/js/jquery.nice-select.min.js') }}"></script>
    <!-- venobox js -->
    <script src="{{ asset('frontend/assets/js/venobox.min.js') }}"></script>
    <!-- sticky sidebar js -->
    <script src="{{ asset('frontend/assets/js/sticky_sidebar.js') }}"></script>
    <!-- wow js -->
    <script src="{{ asset('frontend/assets/js/wow.min.js') }}"></script>
    <!-- ex zoom js -->
    <script src="{{ asset('frontend/assets/js/jquery.exzoom.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/toastr.min.js') }}"></script>

    <!--main/custom js-->
    <script src="{{ asset('frontend/assets/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>

    <script>
        toastr.options.progressBar = true;

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}")
            @endforeach
        @endif

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        })

        $(document).ready(function(){
            $('.button-click').click();
        })
    </script>
    {{-- Load global js --}}
    @include('frontend.layouts.global-scripts')
    @stack('scripts')
</body>

</html>
