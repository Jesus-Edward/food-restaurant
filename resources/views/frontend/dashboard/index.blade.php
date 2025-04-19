@extends('frontend.layouts.master')

@section('content')
    <!--=============================
                                    BREADCRUMB START
                                ==============================-->
    <section class="fp__breadcrumb" style="background: url({{ config('settings.breadcrumb') }}">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>user dashboard</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">home</a></li>
                        <li><a href="javascript:;">dashboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
                                    BREADCRUMB END
                    ==============================-->
    <!--=========================
                                    DASHBOARD START
                                ==========================-->
    <section class="fp__dashboard mt_120 xs_mt_90 mb_100 xs_mb_70">
        <div class="container">
            <div class="fp__dashboard_area">
                <div class="row">
                    <div class="col-xl-3 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                        <div class="fp__dashboard_menu">
                            <div class="dasboard_header">
                                <div class="dasboard_header_img">
                                    <img src="{{ auth()->user()->avatar }}" alt="user" class="img-fluid w-100">
                                    <label for="upload"><i class="fas fa-camera"></i></label>
                                    <form id="avatar_form">
                                        <input type="file" id="upload" hidden name="avatar">
                                    </form>
                                </div>
                                <h2>{{ auth()->user()->name }}</h2>
                            </div>
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">

                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                    aria-orientation="vertical">
                                    <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-home" type="button" role="tab"
                                        aria-controls="v-pills-home" aria-selected="true"><span><i
                                                class="fas fa-user"></i></span> Parsonal Info</button>

                                    <button class="nav-link" id="v-pills-address-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-address" type="button" role="tab"
                                        aria-controls="v-pills-address" aria-selected="true"><span><i
                                                class="fas fa-user"></i></span> address</button>

                                    <button class="nav-link" id="v-pills-reservation-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-reservation" type="button" role="tab"
                                        aria-controls="v-pills-reservation" aria-selected="false"><span><i
                                            class="fas fa-shopping-cart"></i></span> reservation</button>

                                    <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-profile" type="button" role="tab"
                                        aria-controls="v-pills-profile" aria-selected="false"><span><i
                                                class="fas fa-shopping-cart"></i></span> order</button>

                                    @php
                                        $unseenMessages = \App\Models\Chat::where(['sender_id' => 1,
                                        'receiver_id' => auth()->user()->id, 'seen' => 0])->count();
                                    @endphp
                                    <button class="nav-link fp_chat_message" id="v-pills-settings-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-settings" type="button" role="tab"
                                        aria-controls="v-pills-settings" aria-selected="false"><span><i
                                        class="far fa-comment-dots"></i></span> Message
                                            {{-- @if ($unseenMessages > 0) --}}
                                            <b class="unseen_message_count">{{ $unseenMessages > 0 ?  1 : 0}}</b>
                                            {{-- @else
                                            <b>0</b>
                                            @endif --}}
                                            </button>


                                    <button class="nav-link" id="v-pills-messages-tab2" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-messages2" type="button" role="tab"
                                        aria-controls="v-pills-messages2" aria-selected="false"><span><i
                                                class="far fa-heart"></i></span> wishlist</button>

                                    <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-messages" type="button" role="tab"
                                        aria-controls="v-pills-messages" aria-selected="false"><span><i
                                                class="fas fa-star"></i></span> Reviews</button>

                                    <button class="nav-link" id="v-pills-password-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-password" type="button" role="tab"
                                        aria-controls="v-pills-password" aria-selected="false"><span><i
                                                class="fas fa-user-lock"></i></span> Change Password </button>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="nav-link" style="width: 100%;"
                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                            type="button"><span> <i class="fas fa-sign-out-alt"></i></span> Logout</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-9 col-lg-8 wow fadeInUp" data-wow-duration="1s">
                        <div class="fp__dashboard_content">
                            <div class="tab-content" id="v-pills-tabContent">

                                @include('frontend.dashboard.sections.profile-section')
                                @include('frontend.dashboard.sections.address-section')
                                @include('frontend.dashboard.sections.reservations-section')
                                @include('frontend.dashboard.sections.orders-section')
                                @include('frontend.dashboard.sections.message-section')
                                @include('frontend.dashboard.sections.wishlist-section')
                                @include('frontend.dashboard.sections.review-section')
                                @include('frontend.dashboard.change-password')

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=========================
                                    DASHBOARD END
                                ==========================-->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#upload').on('change', function() {
                let form = $('#avatar_form')[0];
                let formData = new FormData(form);

                $.ajax({
                    method: 'POST',
                    url: "{{ route('user.update.avatar') }}",
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function(response) {
                        if (response.status === 'success') {
                            window.location.reload();
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                })
            })
        })
    </script>
@endpush
