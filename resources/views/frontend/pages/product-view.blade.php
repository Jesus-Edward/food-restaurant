@extends('frontend.layouts.master')

@section('content')

    <style>
        * {
            margin: 0;
            padding: 0;
        }

        .rate {
            float: left;
            height: 46px;
            padding: 0 10px;
        }

        .rate:not(:checked)>input {
            position: absolute;
            top: auto;
            clip: rect(0, 0, 0, 0);
        }

        .rate:not(:checked)>label {
            float: right;
            width: 1em;
            overflow: hidden;
            white-space: nowrap;
            cursor: pointer;
            font-size: 30px;
            color: #ccc;
        }

        .rate:not(:checked)>label:before {
            content: '★ ';
        }

        .rate>input:checked~label {
            color: #ffc700;
        }

        .rate:not(:checked)>label:hover,
        .rate:not(:checked)>label:hover~label {
            color: #deb217;
        }

        .rate>input:checked+label:hover,
        .rate>input:checked+label:hover~label,
        .rate>input:checked~label:hover,
        .rate>input:checked~label:hover~label,
        .rate>label:hover~input:checked~label {
            color: #c59b08;
        }
    </style>


    <!--=============================
                                BREADCRUMB START
                            ==============================-->
    <section class="fp__breadcrumb" style="background: url({{ asset(config('settings.breadcrumb')) }});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>menu Details</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">home</a></li>
                        <li><a href="javascript:;">menu Details</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
                                BREADCRUMB END
                            ==============================-->


    <!--=============================
                                MENU DETAILS START
                            ==============================-->
    <section class="fp__menu_details mt_115 xs_mt_85 mb_95 xs_mb_65">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-9 wow fadeInUp" data-wow-duration="1s">
                    <div class="exzoom hidden" id="exzoom">
                        <div class="exzoom_img_box fp__menu_details_images">
                            <ul class='exzoom_img_ul'>
                                <li><img class="zoom ing-fluid w-100" src="{{ asset(@$products->thumb_image) }}"
                                        alt="product"></li>

                                @foreach (@$products->productImages as @$image)
                                    <li><img class="zoom ing-fluid w-100" src="{{ asset(@$image->image) }}" alt="product">
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                        <div class="exzoom_nav"></div>
                        <p class="exzoom_btn">
                            <a href="javascript:void(0);" class="exzoom_prev_btn"> <i class="far fa-chevron-left"></i>
                            </a>
                            <a href="javascript:void(0);" class="exzoom_next_btn"> <i class="far fa-chevron-right"></i>
                            </a>
                        </p>
                    </div>
                </div>
                <div class="col-lg-7 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__menu_details_text">
                        <h2>{!! @$products->name !!}</h2>
                        @if (@$products->reviews_avg_rating)
                            <p class="rating">
                                @for ($i = 1; $i <= @$products->reviews_avg_rating; $i++)
                                    <i class="fas fa-star"></i>
                                @endfor
                                <span>({{ @$products->reviews_count }})</span>
                            </p>
                        @endif
                        <h3 class="price">
                            @if (@$products->offer_price > 0)
                                ${{ @$products->offer_price }}
                                <del>${{ @$products->price }}</del>
                            @else
                                ${{ @$products->price }}
                            @endif
                        </h3>
                        <p class="short_description">{!! @$products->short_description !!}</p>
                        <form action="" id="v_add_to_cart_form">
                            @csrf
                            <input type="hidden" name="base_price" class="v_base_price"
                                value="{{ @$products->offer_price > 0 ? @$products->offer_price : @$products->price }}">
                            <input type="hidden" name="product_id" value="{{ @$products->id }}">

                            @if (@$products->productSizes()->exists())
                                <div class="details_size">
                                    <h5>select size</h5>
                                    @foreach (@$products->productSizes as @$size)
                                        <div class="form-check">
                                            <input class="form-check-input v_product_size" type="radio"
                                                name="product_size" id="option-{{ @$size->id }}"
                                                data-price="{{ @$size->price }}" value="{{ @$size->id }}">
                                            <label class="form-check-label" for="option-{{ @$size->id }}">
                                                {{ @$size->name }}
                                                <span>+{{ currencyPosition(@$size->price) }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            @if (@$products->productVariance()->exists())
                                <div class="details_extra_item">
                                    <h5>select option <span>(optional)</span></h5>
                                    @foreach (@$products->productVariance as @$variance)
                                        <div class="form-check">
                                            <input class="form-check-input v_product_variance" type="checkbox"
                                                value="" name="product_variance[]" id="option-{{ @$variance->id }}"
                                                data-price="{{ @$variance->prices }}" value="{{ @$variance->id }}">
                                            <label class="form-check-label" for="option-{{ @$variance->id }}">
                                                {{ @$variance->names }}
                                                <span>+{{ currencyPosition(@$variance->prices) }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <div class="details_quentity">
                                <h5>select quantity</h5>
                                <div class="quentity_btn_area d-flex flex-wrapa align-items-center">
                                    <div class="quentity_btn">
                                        <button class="btn btn-danger v_decrement"><i class="fal fa-minus"></i></button>
                                        <input type="text" placeholder="1" name="quantity" id="v_quantity" value="1"
                                            readonly>
                                        <button class="btn btn-success v_increment"><i class="fal fa-plus"></i></button>
                                    </div>
                                    @if (@$products->offer_price)
                                        <h3 id="v_total_price">{{ currencyPosition(@$products->offer_price) }}</h3>
                                    @else
                                        <h3 id="v_total_price">{{ currencyPosition(@$products->price) }}</h3>
                                    @endif

                                </div>
                            </div>
                        </form>
                        <ul class="details_button_area d-flex flex-wrap">
                            @if (@$products->quantity === 0)
                                <li><button class="common_btn bg-danger" type="button" style="margin-right: 10px">Out of
                                        stock</button></li>
                            @else
                                <li><a class="common_btn v_submit_button" href="#">add to cart</a></li>
                            @endif
                            <li><a class="wishlist" href="#"><i class="far fa-heart"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__menu_description_area mt_100 xs_mt_70">
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-home" type="button" role="tab"
                                    aria-controls="pills-home" aria-selected="true">Description</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-contact" type="button" role="tab"
                                    aria-controls="pills-contact" aria-selected="false">Reviews</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                aria-labelledby="pills-home-tab" tabindex="0">
                                <div class="menu_det_description">
                                    {!! $products->long_description !!}
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                aria-labelledby="pills-contact-tab" tabindex="0">
                                <div class="fp__review_area">
                                    <div class="row">
                                        @include('frontend.pages.review')

                                        @auth
                                            <div class="col-lg-4">
                                                <div class="fp__post_review">
                                                    <h4>write a Review</h4>
                                                    <form action="{{ route('product-review.store') }}" method="POST">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-xl-12 mb-2">
                                                                <label for=""
                                                                    style="display: block; margin-bottom: -10px;">Rating</label>
                                                                <div class="rate" style="padding-left: 0px;">
                                                                    <input type="radio" id="star5" name="rating"
                                                                        value="5" />
                                                                    <label for="star5" title="text">5 stars</label>
                                                                    <input type="radio" id="star4" name="rating"
                                                                        value="4" />
                                                                    <label for="star4" title="text">4 stars</label>
                                                                    <input type="radio" id="star3" name="rating"
                                                                        value="3" />
                                                                    <label for="star3" title="text">3 stars</label>
                                                                    <input type="radio" id="star2" name="rating"
                                                                        value="2" />
                                                                    <label for="star2" title="text">2 stars</label>
                                                                    <input type="radio" id="star1" name="rating"
                                                                        value="1" />
                                                                    <label for="star1" title="text">1 star</label>
                                                                </div>
                                                                <input type="hidden" name="product_id"
                                                                    value="{{ @$products->id }}">

                                                            </div>

                                                            <div class="col-xl-12" style="margin-top: -10px;">
                                                                <label for="">Review</label>
                                                                <textarea rows="3" style="margin-top: 2px;" name="review" placeholder="Write your review"></textarea>
                                                            </div>
                                                            <div class="col-12">
                                                                <button class="common_btn" type="submit">submit
                                                                    review</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-lg-4">
                                                <h4>write a Review</h4>
                                                <div class="alert alert-warning mt-4">Please login to make a review</div>
                                            </div>
                                        @endauth

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- @if ($reviews->hasPages())
                <div class="fp__pagination mt_35">
                    <div class="row">
                        <div class="col-12">
                            {{-- <nav aria-label="..."> --}}
                            {{-- <ul class="pagination">
                                {{ $reviews->links() }} --}}
                                {{-- </ul> --}}
                                {{-- </nav> --}}
                        </div>
                    </div>
                </div>
            {{-- @endif  --}}

            @if (count(@$relatedProducts) > 0)
                <div class="fp__related_menu mt_90 xs_mt_60">
                    <h2>related item</h2>
                    <div class="row related_product_slider">
                        @foreach (@$relatedProducts as @$relatedProduct)
                            <div class="col-xl-3 wow fadeInUp" data-wow-duration="1s">
                                <div class="fp__menu_item">
                                    <div class="fp__menu_item_img">
                                        <img src="{{ asset(@$relatedProduct->thumb_image) }}"
                                            alt="{{ @$relatedProduct->name }}" class="img-fluid w-100">
                                        <a class="category" href="#">{{ @$relatedProduct->category->name }}</a>
                                    </div>
                                    <div class="fp__menu_item_text">
                                        @if (@$relatedProduct->reviews_avg_rating)
                                            <p class="rating">
                                                @for (@$i = 1; $i <= @$relatedProduct->reviews_avg_rating; $i++)
                                                    <i class="fas fa-star"></i>
                                                @endfor
                                                <span>({{ @$relatedProduct->reviews_count }})</span>
                                            </p>
                                        @endif
                                        <a class="title"
                                            href="{{ route('product.show', @$relatedProduct->slug) }}">{!! @$relatedProduct->name !!}</a>
                                        <h5 class="price">
                                            @if (@$relatedProduct->offer_price > 0)
                                                {{ currencyPosition(@$relatedProduct->offer_price) }}
                                                <del>{{ currencyPosition(@$relatedProduct->price) }}</del>
                                            @else
                                                {{ currencyPosition(@$relatedProduct->price) }}
                                            @endif
                                        </h5>
                                        <ul class="d-flex flex-wrap justify-content-center">
                                            <li><a href="javascript:;"
                                                    onclick="loadProductModal('{{ @$relatedProduct->id }}')"><i
                                                        class="fas fa-shopping-basket"></i></a></li>
                                            <li><a href="#"><i class="fal fa-heart"></i></a></li>
                                            <li><a href="#"><i class="far fa-eye"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </section>
    <!--=============================
                                MENU DETAILS END
                            ==============================-->

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $('.v_product_size').on('change', function() {
                v_updateTotalPrice();
            });

            $('.v_product_variance').on('change', function() {
                v_updateTotalPrice();
            });

            // Function to update total price based on selected options
            function v_updateTotalPrice() {
                let basePrice = parseFloat($('.v_base_price').val());
                let selectedSizePrice = 0;
                let selectedVariancePrice = 0;
                let quantity = parseFloat($("#v_quantity").val());

                // calculate the selected size price
                let selectedSize = $('.v_product_size:checked');
                if (selectedSize.length > 0) {
                    selectedSizePrice = parseFloat(selectedSize.data("price"));
                }

                // calculate the selected variance price
                let selectedVariance = $('.v_product_variance:checked');
                $(selectedVariance).each(function() {
                    selectedVariancePrice += parseFloat($(this).data("price"));
                });

                let totalPrice = (basePrice + selectedSizePrice + selectedVariancePrice) * quantity;

                $("#v_total_price").text("{{ config('settings.site_currency_symbol') }}" + totalPrice);
            }

            // Event handling product quantity increment
            $('.v_increment').on('click', function(e) {
                e.preventDefault();
                let quantity = $("#v_quantity");
                let currentQuantity = parseFloat(quantity.val());
                quantity.val(currentQuantity + 1);
                v_updateTotalPrice();
            });

            // Event handling product quantity decrement
            $('.v_decrement').on('click', function(e) {
                e.preventDefault();
                let quantity = $("#v_quantity");
                let currentQuantity = parseFloat(quantity.val());
                if (currentQuantity > 1) {
                    quantity.val(currentQuantity - 1);
                    v_updateTotalPrice();
                }
            });

            $('.v_submit_button').on('click', function(e) {
                e.preventDefault();
                $("#v_add_to_cart_form").submit();
            });

            //Add to cart function
            $("#v_add_to_cart_form").on('submit', function(e) {
                e.preventDefault();

                //Validation
                let selectedSize = $('.v_product_size');
                if (selectedSize.length > 0) {
                    if ($('.v_product_size:checked').val() === undefined) {
                        toastr.error("Please select a size for the product");
                        console.error("Please select a size for the product");
                        return;
                    }
                }

                let formData = $(this).serialize();
                $.ajax({
                    method: 'POST',
                    url: '{{ route('add-to-cart') }}',
                    data: formData,
                    beforeSend: function() {
                        $('.v_submit_button').attr('disabled', true);
                        $('.v_submit_button').html(
                            '<span class="spinner-border spinner-border-sm text-light" role="status"aria-hidden="true"></span>Loading...'
                        );
                    },
                    success: function(response) {
                        updateSidebarCart();
                        toastr.success(response.message);
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = xhr.responseJSON.message;
                        toastr.error(errorMessage);
                    },
                    complete: function() {
                        $('.v_submit_button').html('Add to cart');
                        $('.v_submit_button').attr('disabled', false);
                    }
                })
            })

        })
    </script>
@endpush
