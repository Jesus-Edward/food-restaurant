
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
    class="fa fa-times"></i></button>

<form action="" id="modal_add_to_cart_form">

    <input type="hidden" name="product_id" value="{{ $products->id }}">
    <div class="fp__cart_popup_img">
    <img src="{{ asset($products->thumb_image) }}" alt="{{ $products->name }}" class="img-fluid w-100">
    </div>
    <div class="fp__cart_popup_text">
    <a href="{{ route('product.show', $products->slug) }}" class="title">{!! $products->name !!}</a>
    <p class="rating">
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star-half-alt"></i>
        <i class="far fa-star"></i>
        <span>(201)</span>
    </p>


    <h4 class="price">
        @if($products->offer_price > 0)
        <input type="hidden" name="base_price" value="{{ $products->offer_price }}">
            {{ currencyPosition($products->offer_price) }}
            <del>{{ currencyPosition($products->price) }}</del>
        @else
        <input type="hidden" name="base_price" value="{{ $products->price }}">
            {{ currencyPosition($products->price) }}
        @endif
    </h4>


    @if($products->productSizes()->exists())
    <div class="details_size">
        <h5>select size</h5>
        @foreach ($products->productSizes as $productSize)
        <div class="form-check">
            <input class="form-check-input" type="radio" value="{{ $productSize->id }}"
             name="product_size" data-price="{{ $productSize->price }}" id="size-{{ $productSize->id }}">
            <label class="form-check-label" for="size-{{ $productSize->id }}">
                {{ $productSize->name }} <span>+ {{ currencyPosition($productSize->price) }}</span>
            </label>
        </div>
        @endforeach
    </div>
    @endif

    @if($products->productVariance()->exists())
    <div class="details_extra_item">
        <h5>select option <span>(optional)</span></h5>
        @foreach($products->productVariance as $variance)
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="{{ $variance->id }}"
            name="product_variance[]" data-price="{{ $variance->prices }}" id="variance-{{ $variance->id }}">
            <label class="form-check-label" for="variance-{{ $variance->id }}">
                {!! $variance->names !!} <span>+ {{ currencyPosition($variance->prices) }}</span>
            </label>
        </div>
        @endforeach
    </div>
    @endif

    <div class="details_quentity">
        <h5>select quantity</h5>
        <div class="quentity_btn_area d-flex flex-wrapa align-items-center">
            <div class="quentity_btn">
                <button class="btn btn-danger decrement"><i class="fal fa-minus"></i></button>
                <input type="text" id="quantity" name="quantity" placeholder="1" value="1" readonly>
                <button class="btn btn-success increment"><i class="fal fa-plus"></i></button>
            </div>
            @if($products->offer_price)
            <h3 id="total_price">{{ currencyPosition($products->offer_price) }}</h3>
            @else
            <h3 id="total_price">{{ currencyPosition($products->price) }}</h3>
            @endif
        </div>
    </div>
    <ul class="details_button_area d-flex flex-wrap">
        @if ($products->quantity === 0 )
            <li><button class="common_btn bg-danger" type="button">Out of stock</button></li>
        @else
        <li><button class="common_btn modal_cart_button" type="submit">add to cart</button></li>
        @endif
    </ul>
    </div>
</form>


<script>
    $(document).ready(function(){
        $('input[name="product_size"]').on('change', function(){
            updateTotalPrice();
        });

        $('input[name="product_variance[]"]').on('change', function(){
            updateTotalPrice();
        });

        // Even handling product quantity increment
        $('.increment').on('click', function(e){
            e.preventDefault();
            let quantity = $("#quantity");
            let currentQuantity = parseFloat(quantity.val());
            quantity.val(currentQuantity + 1);
            updateTotalPrice();
        });

        // Even handling product quantity decrement
        $('.decrement').on('click', function(e){
            e.preventDefault();
            let quantity = $("#quantity");
            let currentQuantity = parseFloat(quantity.val());
            if (currentQuantity > 1) {
                quantity.val(currentQuantity - 1);
                updateTotalPrice();
            }
        });

        // Function to update total price based on selected options
        function updateTotalPrice(){
            let basePrice = parseFloat($('input[name="base_price"]').val());
            let selectedSizePrice = 0;
            let selectedVariancePrice = 0;
            let quantity = parseFloat($("#quantity").val());

            // calculate the selected size price
            let selectedSize = $('input[name="product_size"]:checked');
            if(selectedSize.length > 0){
                selectedSizePrice = parseFloat(selectedSize.data("price"));
            }

            // calculate the selected variance price
            let selectedVariance = $('input[name="product_variance[]"]:checked');
            $(selectedVariance).each(function(){
                selectedVariancePrice += parseFloat($(this).data("price"));
            });

            let totalPrice = (basePrice + selectedSizePrice + selectedVariancePrice) * quantity;

            $("#total_price").text("{{ config('settings.site_currency_symbol') }}" + totalPrice);
        }

        //Add to cart function
        $("#modal_add_to_cart_form").on('submit', function(e){
            e.preventDefault();

            //Validation
            let selectedSize = $('input[name="product_size"]');
                if (selectedSize.length > 0) {
                    if ($('input[name="product_size"]:checked').val() === undefined) {
                        toastr.error("Please select a size for the product");
                        console.error("Please select a size for the product");
                    return;
                }
            }

            let formData = $(this).serialize();
            $.ajax({
                method: 'POST',
                url: '{{ route("add-to-cart") }}',
                data: formData,
                beforeSend: function(){
                    $('.modal_cart_button').attr('disabled', true);
                    $('.modal_cart_button').html(
                        '<span class="spinner-border spinner-border-sm text-light" role="status"aria-hidden="true"></span>Loading...');
                },
                success: function(response){
                    updateSidebarCart();
                    toastr.success(response.message);
                },
                error: function(xhr, status, error){
                    let errorMessage = xhr.responseJSON.message;
                    toastr.error(errorMessage);
                },
                complete: function(){
                    $('.modal_cart_button').html('Add to cart');
                    $('.modal_cart_button').attr('disabled', false);
                }
            })
        })
    })
</script>


