<input type="hidden" value="{{ cartTotalPrice() }}" id="cart_total">
<input type="hidden" value="{{ count(Cart::content()) }}" id="cart_product_count">
@foreach (Cart::content() as $cartProduct)
    <li>
        <div class="menu_cart_img">
            <img src="{{ $cartProduct->options->product_info['image'] }}" alt="menu" class="img-fluid w-100">
        </div>
        <div class="menu_cart_text" style="max-height: 50%>
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
