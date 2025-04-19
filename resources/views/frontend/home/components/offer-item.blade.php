<section class="fp__offer_item mt_100 xs_mt_70 pt_95 xs_pt_65 pb_150 xs_pb_120">
    <div class="container">
        <div class="row wow fadeInUp" data-wow-duration="1s">
            <div class="col-md-8 col-lg-7 col-xl-6 m-auto text-center">
                <div class="fp__section_heading mb_50">
                    <h4>{!! @$sectionTitles['daily_offer_top_title'] !!}</h4>
                    <h2>{!! @$sectionTitles['daily_offer_main_title'] !!}</h2>
                    <span>
                        <img src="{{ asset('frontend/assets/images/heading_shapes.png') }}" alt="shapes" class="img-fluid w-100">
                    </span>
                    <p>{!! @$sectionTitles['daily_offer_sub_title'] !!}</p>
                </div>
            </div>
        </div>

        <div class="row offer_item_slider wow fadeInUp" data-wow-duration="1s">
            @foreach ($offers as $offer)
                <div class="col-xl-4">
                    <div class="fp__offer_item_single">
                        <div class="img">
                            <img src="{{ asset($offer->product->thumb_image) }}" class="img-fluid w-100">
                        </div>
                        <div class="text">
                            @if ($offer->product->offer_price > 0)
                                <span>{{ discountInPercent($offer->product->price, $offer->product->offer_price) }}% off</span>
                            @endif
                            
                            <a class="title" href="{{ route('product.show',$offer->product->slug) }}">{!! $offer->product->name !!}</a>
                            <p>{!! $offer->product->short_description !!}</p>
                            <ul class="d-flex flex-wrap">
                                <li><a href="javascript:;" onclick="loadProductModal('{{ $offer->product->id }}')"><i class="fas fa-shopping-basket"></i></a></li>
                                <li><a href="#"><i class="fal fa-heart"></i></a></li>
                                <li><a href="{{ route('product.show',$offer->product->slug) }}"><i class="far fa-eye"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- <div class="fp__cart_popup">
    <div class="modal fade" id="cartModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="fal fa-times"></i></button>
                    <div class="fp__cart_popup_img">
                        <img src="images/menu1.png" alt="menu" class="img-fluid w-100">
                    </div>
                    <div class="fp__cart_popup_text">
                        <a href="#" class="title">Maxican Pizza Test Better</a>
                        <p class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <i class="far fa-star"></i>
                            <span>(201)</span>
                        </p>
                        <h4 class="price">$320.00 <del>$350.00</del> </h4>

                        <div class="details_size">
                            <h5>select size</h5>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="large"
                                    checked>
                                <label class="form-check-label" for="large">
                                    large <span>+ $350</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="medium">
                                <label class="form-check-label" for="medium">
                                    medium <span>+ $250</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="small">
                                <label class="form-check-label" for="small">
                                    small <span>+ $150</span>
                                </label>
                            </div>
                        </div>

                        <div class="details_extra_item">
                            <h5>select option <span>(optional)</span></h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="coca-cola">
                                <label class="form-check-label" for="coca-cola">
                                    coca-cola <span>+ $10</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="7up">
                                <label class="form-check-label" for="7up">
                                    7up <span>+ $15</span>
                                </label>
                            </div>
                        </div>

                        <div class="details_quentity">
                            <h5>select quentity</h5>
                            <div class="quentity_btn_area d-flex flex-wrapa align-items-center">
                                <div class="quentity_btn">
                                    <button class="btn btn-danger"><i class="fal fa-minus"></i></button>
                                    <input type="text" placeholder="1">
                                    <button class="btn btn-success"><i class="fal fa-plus"></i></button>
                                </div>
                                <h3>$320.00</h3>
                            </div>
                        </div>
                        <ul class="details_button_area d-flex flex-wrap">
                            <li><a class="common_btn" href="#">add to cart</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}