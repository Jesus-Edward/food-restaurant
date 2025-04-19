@extends('frontend.layouts.master')

@section('content')
    <!--=============================
                BREADCRUMB START
            ==============================-->
    <section class="fp__breadcrumb" style="background: url({{ asset(config('settings.breadcrumb')) }});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>cart view</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">home</a></li>
                        <li><a href="javascript:;">cart view</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
                BREADCRUMB END
            ==============================-->


    <!--============================
                CART VIEW START
            ==============================-->
    <section class="fp__cart_view mt_125 xs_mt_95 mb_100 xs_mb_70">
        <div class="container">
            <div class="row">
                <div class="col-lg-8  wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__cart_list">
                        <div class="table-responsive">
                            <table>
                                <tbody>
                                    <tr>
                                        <th class="fp__pro_img">
                                            Image
                                        </th>

                                        <th class="fp__pro_name">
                                            details
                                        </th>

                                        <th class="fp__pro_status">
                                            price
                                        </th>

                                        <th class="fp__pro_select">
                                            quantity
                                        </th>

                                        <th class="fp__pro_tk">
                                            total
                                        </th>

                                        <th class="fp__pro_icon">
                                            <a class="clear_all" href="{{ route('product.destroy.cart') }}">clear all</a>
                                        </th>
                                    </tr>
                                    @foreach (Cart::content() as $product)
                                        <tr>
                                            <td class="fp__pro_img"><img
                                                    src="{{ $product->options->product_info['image'] }}" alt="product"
                                                    class="img-fluid w-100">
                                            </td>

                                            <td class="fp__pro_name">
                                                <a
                                                    href="{{ route('product.show', $product->options->product_info['slug']) }}">{{ $product->name }}</a>

                                                <span>{{ @$product->options->product_size['name'] }}
                                                    {{ @$product->options->product_size['price'] ? '(' . currencyPosition(@$product->options->product_size['price']) . ')' : '' }}</span>

                                                @foreach ($product->options->product_variance as $variance)
                                                    <p>{{ $variance['name'] }} ({{ currencyPosition($variance['price']) }})
                                                    </p>
                                                @endforeach
                                            </td>

                                            <td class="fp__pro_status">
                                                <h6>{{ currencyPosition($product->price) }}</h6>
                                            </td>

                                            <td class="fp__pro_select">
                                                <div class="quentity_btn">
                                                    <button class="btn btn-danger decrement"><i
                                                            class="fal fa-minus"></i></button>
                                                    <input type="text" class="qty" data-id="{{ $product->rowId }}"
                                                        placeholder="1" value="{{ $product->qty }}" readonly>
                                                    <button class="btn btn-success increment"><i
                                                            class="fal fa-plus"></i></button>
                                                </div>
                                            </td>

                                            <td class="fp__pro_tk">
                                                <h6 class="product_cart_total">
                                                    {{ currencyPosition(productTotal($product->rowId)) }}</h6>
                                            </td>

                                            <td class="fp__pro_icon" style="width: 93px;">
                                                <a href="#" class="remove_cart_product"
                                                    data-id="{{ $product->rowId }}"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @if (Cart::content()->count() === 0)
                                        <tr>
                                            <td colspan="6" class="text-center fp__pro_name"
                                                style="width: 100%; display: inline;">
                                                Cart is empty!
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__cart_list_footer_button">
                        <h6>total cart</h6>
                        <p>subtotal: <span id="subtotals">{{ currencyPosition(cartTotalPrice()) }}</span></p>
                        <p>delivery: <span>$00.00</span></p>
                        <p>discount: <span id="discount">
                            @if(isset(session()->get('coupon')['discount']))
                            {{ config('settings.site_currency_symbol') }}{{ session()->get('coupon')['discount'] }}
                            @else
                            {{ config('settings.site_currency_symbol') }}0
                            @endif
                        </span></p>

                        <p class="total"><span>total:</span><span id="final_total">
                            @if(isset(session()->get('coupon')['discount']))
                            {{ config('settings.site_currency_symbol') }}{{ cartTotalPrice() - session()->get('coupon')['discount'] }}
                            @else
                            {{ config('settings.site_currency_symbol') }}{{ cartTotalPrice() }}
                            @endif
                        </span></p>

                        <form id="coupon_form">
                            <input type="text" id="coupon_code" name="code" placeholder="Coupon Code">
                            <button type="submit">apply</button>
                        </form>

                        <div class="coupon_cart">
                            @if (session()->has('coupon'))
                                <div class="card mt-2" style="border-radius: 30px; padding: 2px 4px;">
                                    <div class="m-2">
                                        <span><b class="v_coupon_code">Applied Coupon: {{ session()->get('coupon')['code'] }}</b></span>
                                        <span>
                                            <button id="destroy_coupon"><i class="fa fa-times"></i></button>
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <a class="common_btn" href="{{ route('checkout') }}">checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
                CART VIEW END
            ==============================-->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var cartTotal = parseInt("{{ cartTotalPrice() }}");

            $(".increment").on('click', function() {
                let inputField = $(this).siblings('.qty');
                let currentValue = parseInt(inputField.val());
                let rowId = inputField.data("id");
                inputField.val(currentValue + 1);

                updateCartQty(rowId, inputField.val(), function(response) {
                    if (response.status === 'success') {
                        inputField.val(response.qty);
                        let productTotal = response.product_total;
                        inputField.closest("tr")
                            .find(".product_cart_total")
                            .text("{{ currencyPosition(":productTotal") }}"
                            .replace(":productTotal", productTotal));

                            cartTotal = response.cart_total;

                            $("#subtotals").text("{{ config('settings.site_currency_symbol') }}" + cartTotal);

                            let grandTotal = response.grand_cart_total;
                            $("#final_total").text("{{ config('settings.site_currency_symbol') }}" + grandTotal);

                    }else if (response.status === 'error') {
                        inputField.val(response.qty);
                        toastr.error(response.message);
                    }
                });
            });

            $(".decrement").on('click', function() {
                let inputField = $(this).siblings('.qty');
                let currentValue = parseInt(inputField.val());
                let rowId = inputField.data("id");

                if (inputField.val() > 1){
                    inputField.val(currentValue - 1);

                    updateCartQty(rowId, inputField.val(), function(response) {

                        if (response.status === 'success') {
                             inputField.val(response.qty);
                            let productTotal = response.product_total;
                            inputField.closest("tr")
                                .find(".product_cart_total")
                                .text("{{ currencyPosition(":productTotal") }}"
                                .replace(":productTotal", productTotal));

                            cartTotal = response.cart_total;

                            $("#subtotals").text("{{ config('settings.site_currency_symbol') }}" + cartTotal);

                            let grandTotal = response.grand_cart_total;
                            $("#final_total").text("{{ config('settings.site_currency_symbol') }}" + grandTotal);

                        } else if (response.status === 'error') {
                            inputField.val(response.qty);
                            toastr.error(response.message);
                        }
                    });
                }
            });

            function updateCartQty(rowId, qty, callback) {
                $.ajax({
                    method: 'post',
                    url: '{{ route("product.update.cart-qty") }}',
                    data: {
                        'rowId': rowId,
                        'qty': qty
                    },
                    beforeSend: function() {
                        showLoader();
                    },
                    success: function(response) {
                        if (callback && typeof callback === 'function') {
                            callback(response);
                        }
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = xhr.responseJSON.message;
                        hideLoader();
                        toastr.error(errorMessage);
                    },
                    complete: function() {
                        hideLoader();
                    }
                })
            }

            $('.remove_cart_product').on('click', function(e) {
                e.preventDefault();
                let rowId = $(this).data('id');
                removeCartProduct(rowId);
                $(this).closest('tr').remove();
            });

            function removeCartProduct(rowId) {
                $.ajax({
                    method: 'get',
                    url: '{{ route("cart-product-remove", ":rowId") }}'.replace(":rowId", rowId),
                    beforeSend: function() {
                        showLoader();
                    },
                    success: function(response) {
                        updateSidebarCart();

                        cartTotal = response.cart_total;
                        $("#subtotals").text("{{ config('settings.site_currency_symbol') }}" + cartTotal);

                        grandTotal = response.grand_cart_total;
                        $("#final_total").text("{{ config('settings.site_currency_symbol') }}" + grandTotal);
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = xhr.responseJSON.message;
                        hideLoader();
                        toastr.error(errorMessage);
                    },
                    complete: function() {
                        hideLoader();
                    }
                })
            }

            $('#coupon_form').on('submit', function(e){
                e.preventDefault();
                let code = $("#coupon_code").val();
                let subtotal = cartTotal;

                couponApply(code, subtotal);

            });

            function couponApply(code, subtotal){
                $.ajax({
                    method: 'POST',
                    url: '{{ route("apply-coupon") }}',
                    data: {
                        code: code,
                        subtotal: subtotal
                    },
                    beforeSend: function(){
                        showLoader();
                    },
                    success: function(response){
                        $("#coupon_code").val("");
                        $("#discount").text("{{ config('settings.site_currency_symbol') }}" + response.discount);
                        $("#final_total").text("{{ config('settings.site_currency_symbol') }}" + response.finalTotal);

                        $couponCartHtml = `
                            <div class="card mt-2" style="border-radius: 30px; padding: 2px 4px">
                                <div class="m-2">
                                    <span><b class="v_coupon_code">Applied Coupon: ${ response.coupon_code }</b></span>
                                    <span>
                                        <button id="destroy_coupon"><i class="fa fa-times"></i></button>
                                    </span>
                                </div>
                            </div>
                        `
                        $(".coupon_cart").html($couponCartHtml);
                        toastr.success(response.message);
                    },
                    error: function(xhr, status, error){
                        let errorMessage = xhr.responseJSON.message;
                        toastr.error(errorMessage);
                    },
                    complete: function(){
                        hideLoader();
                    }
                })
            }

            $(document).on("click", "#destroy_coupon", function(){
                destroyCoupon();
            })

            function destroyCoupon(){
                $.ajax({
                    method: 'GET',
                    url: '{{ route("destroy-coupon") }}',
                    beforeSend: function(){
                        showLoader();
                    },
                    success: function(response){
                        $("#discount").text("{{ config('settings.site_currency_symbol') }}" + 0);
                        let grandTotal = response.grand_cart_total;
                        $("#final_total").text("{{ config('settings.site_currency_symbol') }}" + grandTotal);
                        $(".coupon_cart").html("");

                        toastr.success(response.message);
                    },
                    error: function(xhr, status, error){
                        let errorMessage = xhr.responseJSON.message;
                        toastr.error(errorMessage);
                    },
                    complete: function(){
                        hideLoader();
                    }
                })
            }
        })
    </script>
@endpush
