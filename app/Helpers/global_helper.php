<?php

/**Creating a unique slug */

use Gloudemans\Shoppingcart\Facades\Cart;

if (!function_exists('generateUniqueSlug')) {
    function generateUniqueSlug($model, $name): string
    {
        $modelClass = "App\\Models\\$model";

        if (!class_exists($modelClass)) {
            throw new InvalidArgumentException("Model $model not found");
        }

        $slug = \Str::slug($name);
        $count = 2;

        while ($modelClass::where('slug', $slug)->exists()) {
            $slug = \Str::slug($name) . '-' . $count;
            $count++;
        }

        return $slug;
    }
}

if (!function_exists('currencyPosition')) {
    function currencyPosition($price): string
    {
        if (config('settings.site_currency_symbol_position') === 'left') {
            return config('settings.site_currency_symbol') . $price;
        } else {
            return $price . config('settings.site_currency_symbol');
        }
    }
}

/**cart total function */
if (!function_exists('cartTotalPrice')) {
    function cartTotalPrice()
    {
        $total = 0;
        foreach (Cart::content() as $content) {
            $productPrice = $content->price;
            $sizePrice = @$content->options?->product_size['price'] ?: 0;
            /** '?' is the null coalescing
                                                                            operator */
            $variancePrice = 0;
            foreach ($content->options->product_variance as $variance) {
                $variancePrice += $variance['price'];
            }

            $total += ($productPrice +  $sizePrice + $variancePrice) * $content->qty;
        }

        return $total;
    }
}


/**product total function */
if (!function_exists('productTotal')) {
    function productTotal($rowId)
    {
        $total = 0;

        $product = Cart::get($rowId);
        $productPrice = $product->price;
        $sizePrice = @$product->options?->product_size['price'] ?: 0;
        /** '?' is the null coalescing operator */
        $variancePrice = 0;
        foreach ($product->options->product_variance as $variance) {
            $variancePrice += $variance['price'];
        }

        $total += ($productPrice +  $sizePrice + $variancePrice) * $product->qty;

        return $total;
    }
}


/**grand total function */
if (!function_exists('grandCartTotal')) {
    function grandCartTotal($deliveryFee = 0)
    {
        $total = 0;
        $cartTotal = cartTotalPrice();

        if (session()->has('coupon')) {
            $discount = session()->get('coupon')['discount'];
            $total = ($cartTotal + $deliveryFee) - $discount;

            return $total;
        } else {
            $total = $cartTotal + $deliveryFee;

            return $total;
        }
    }
}

/**Generate unique invoice id */
if (!function_exists('generateInvoiceId')) {
    function generateInvoiceId()
    {
        $random = rand(1, 9999);
        $currentDateTime = now();

        $invoiceId = $random . $currentDateTime->format('yd') . $currentDateTime->format('s');

        return $invoiceId;
    }
}

/**Generate discount in percent */
if (!function_exists('discountInPercent')) {
    function discountInPercent($originalPrice, $discountPrice)
    {
        return round((($originalPrice - $discountPrice) / $originalPrice) * 100, 2);
    }
}

/**Truncate a specified string */
if (!function_exists('truncateTitle')) {
    function truncateTitle($string, $limit = 100)
    {
        return \Str::limit($string, $limit, '...');
    }
}

/**Get the thumbnail of a youtube video*/
if (!function_exists('getYtThumbnail')) {
    function getYtThumbnail($link, $size = 'medium')
    {
        try {
            $videoId = explode('?si=', $link);
            $videoId = $videoId[1];

            $finalSize = match ($size) {
                'low' => 'sddefault',
                'medium' => 'mqdefault',
                'high' => 'hqdefault',
                'max' => 'maxresdefault'
            };

            return "https://img.youtube.com/vi/$videoId/$finalSize.jpg";
        } catch (\Exception $e) {
            logger($e);
            return NULL;
        }
    }
}

/**Activate a sidebar item */
if (!function_exists('activateSidebar')) {
    function activateSidebar(array $routes)
    {
        foreach ($routes as $route) {
            if (request()->routeIs($route)) {
                return 'active';
            }
        }
        return '';
    }
}
