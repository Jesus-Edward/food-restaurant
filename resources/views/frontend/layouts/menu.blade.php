@php
    $main_menus = Menu::getByName('main_menu');
@endphp

<nav class="navbar navbar-expand-lg main_menu">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset(config('settings.logo')) }}" alt="FoodPark" class="img-fluid">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="far fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav m-auto">
                @if($main_menus)
                    @foreach($main_menus as $main_menu)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ $main_menu['link'] }}">{!! $main_menu['label'] !!}
                            @if( $main_menu['child'] )
                                <i class="fas fa-angle-down"></i>
                            @endif
                            </a>
                            @if( $main_menu['child'] )
                                <ul class="droap_menu">
                                @foreach($main_menu['child'] as $child)                                   
                                    
                                        <li><a href="{{ $child['link'] }}">{!! $child['label'] !!}</a></li>
                                    
                                @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                @endif
            </ul>
            <ul class="menu_icon d-flex flex-wrap">
                <li>
                    <a href="#" class="menu_search"><i class="fa fa-search"></i></a>
                    <div class="fp__search_form">
                        <form action="{{ route('product.index') }}" method="GET">
                            <span class="close_search"><i class="fa fa-times"></i></span>
                            <input type="text" name="search" placeholder="Search . . .">
                            <button type="submit">search</button>
                        </form>
                    </div>
                </li>

                <li>
                    <a href="jaavascript:;" class="cart_icon"><i class="fas fa-shopping-basket"></i> <span class="cart_count">{{ count(Cart::content()) }}</span></a>
                </li>
                @php
                    @$unseenMessages = \App\Models\Chat::where(['sender_id' => 1,
                    'receiver_id' => auth()->user()->id, 'seen' => 0])->count();
                @endphp

                <li>
                    <a class="message_icon" href="{{ route('dashboard') }}"
                      ><i class="fas fa-comment-alt"></i>
                      {{-- @if ($unseenMessages > 0) --}}
                        <span class="unseen_message_count">{{ $unseenMessages > 0 ? 1 : 0}}</span>
                      {{-- @else
                        <span>0</span>
                      @endif --}}

                      </a>
                  </li>

                <li>
                    <a href="{{ route('login') }}"><i class="fas fa-user"></i></a>
                </li>
                <li>
                    <a class="common_btn" href="#" data-bs-toggle="modal"
                        data-bs-target="#staticBackdrop">reservation</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="fp__menu_cart_area">
    <div class="fp__menu_cart_boody">
        <div class="fp__menu_cart_header">
            <h5>total item <span class="cart_count">({{ count(Cart::content()) }})</span> </h5>
            <span class="close_cart"><i class="fa fa-times"></i></span>
        </div>
        <ul class="cart_contents" style="max-height: 50%">
            @foreach (Cart::content() as $cartProduct)
            <li>
                <div class="menu_cart_img">
                    <img src="{{ $cartProduct->options->product_info['image'] }}" alt="menu" class="img-fluid w-100">
                </div>
                <div class="menu_cart_text">
                    <a class="title" href="{{ route('product.show', $cartProduct->options->product_info['slug']) }}">{!! $cartProduct->name !!}</a>
                    <p class="size">Qty: {{ $cartProduct->qty }}</p>

                    @if($cartProduct->options->product_size)
                        <p class="size">{{ @$cartProduct->options->product_size['name']}}
                            ({{ currencyPosition(@$cartProduct->options->product_size['price']) }})
                        </p>
                    @endif

                    @foreach ($cartProduct->options->product_variance as $variance)
                        <span class="extra">{{ $variance['name'] }} ({{ currencyPosition($variance['price']) }})</span>
                    @endforeach

                    <p class="price">{{ currencyPosition($cartProduct->price) }}</p>
                </div>
                <span class="del_icon" onclick="removeProductFromSidebar('{{ $cartProduct->rowId }}')"><i class="fa fa-times"></i></span>
            </li>
            @endforeach

        </ul>
            <p class="subtotal">sub total <span class="cart_subtotal">{{ currencyPosition(cartTotalPrice()) }}</span></p>
            <a class="cart_view" href="{{ route('product.view.cart') }}"> view cart</a>
            <a class="checkout" href="{{ route('checkout') }}">checkout</a>
    </div>
</div>

@php
    $rTimes = \App\Models\ReservationTime::where('status', 1)->get();
@endphp
<div class="fp__reservation">
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Book a Table</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="fp__reservation_form">
                        @csrf
                        <input class="reservation_input" type="text" placeholder="Name" name="name">
                        <input class="reservation_input" type="text" placeholder="Phone" name="phone">
                        <input class="reservation_input" type="date" name="date">
                        <select class="reservation_input nice-select" name="time">
                                <option value="">select time</option>
                            @foreach ($rTimes as $rTime)
                                <option value="{{ $rTime->starting_time }}-{{ $rTime->stoppage_time }}">{{ $rTime->starting_time }} to {{ $rTime->stoppage_time }}</option>
                            @endforeach
                        </select>
                        <input class="persons mb-4" type="text" placeholder="Persons" name="persons">
                        <button type="submit" class="submit_btn">book table</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function(){
        $('.fp__reservation_form').on('submit', function(e){
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                method: 'POST',
                url: "{{ route('reservation.store') }}",
                data: formData,
                beforeSend: function(){
                    $('.submit_btn').html(`<span class="spinner-border spinner-border-sm"></span>sending...`)
                },
                success: function(response){
                    toastr.success(response.message);
                    $('.fp__reservation_form').trigger('reset');
                    $("#staticBackdrop").modal('hide');
                },
                error: function(xhr, status, error){
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(index, value){
                        toastr.error(value);
                        $('.submit_btn').text('book table')
                    });
                },
                complete: function(){
                    $('.submit_btn').text('book table')
                }
            })
        })
    })
</script>
@endpush
