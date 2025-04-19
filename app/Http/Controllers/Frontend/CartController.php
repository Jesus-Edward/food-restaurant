<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Http\Response;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $products = Product::with(['productSizes', 'productVariance'])->findOrFail($request->product_id);
        if ($products->quantity < $request->quantity) {
            throw ValidationException::withMessages(['Quantity is not available!']);
        }

        try {
            $productSize = $products->productSizes->where('id', $request->product_size)->first();
            $productVariance = $products->productVariance->whereIn('id', $request->product_variance);

            $options = [
                'product_size' => [],
                'product_variance' => [],
                'product_info' => [
                    'image' => $products->thumb_image,
                    'slug' => $products->slug,
                ]
            ];

            if ($productSize !== null) {
                $options['product_size'] = [
                    'id' => $productSize?->id,
                    'name' => $productSize?->name,
                    'price' => $productSize?->price
                ];
            }

            foreach ($productVariance as $variance) {
                $options['product_variance'][] = [
                    'id' => $variance->id,
                    'name' => $variance->names,
                    'price' => $variance->prices
                ];
            }

            Cart::add([
                'id' => $products->id,
                'name' => $products->name,
                'qty' => $request->quantity,
                'price' => $products->offer_price > 0 ? $products->offer_price : $products->price,
                'weight' => 0,
                'options' => $options
            ]);

            return response(['status' => 'success', 'message' => 'Product added into cart'], 200);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'Something went wrong!', 500]);
        }
    }

    public function getCartProduct()
    {
        return view('frontend.layouts.ajax-files.sidebar-cart-item')->render();
    }

    public function cartProductRemove($rowId)
    {
        try {
            Cart::remove($rowId);

            return response([
                'status' => 'success',
                'message' => 'Product removed successfully!',
                'cart_total' => cartTotalPrice(),
                'grand_cart_total' => grandCartTotal()
            ], 200);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'Unexpected error, something went wrong!'], 500);
        }
    }

    public function viewCart(): View
    {
        return view('frontend.pages.cart-view');
    }

    public function updateCartQty(Request $request): Response
    {
        $cartItem = Cart::get($request->rowId);
        $products = Product::findOrFail($cartItem->id);
        if ($products->quantity < $request->qty) {
            return response(['status' => 'error', 'message' =>  'Quantity is not available!', 'qty' => $cartItem->qty]);
        }

        try {
            $cart = Cart::update($request->rowId, $request->qty);
            return response([
                'status' => 'success',
                'product_total' => productTotal($request->rowId),
                'qty' => $cart->qty,
                'cart_total' => cartTotalPrice(),
                'grand_cart_total' => grandCartTotal()
            ],
                200
            );
        } catch (\Exception $e) {
            logger($e);
            return response(['status' => 'error', 'message' => 'Something went wrong!'], 500);
        }

    }

    public function destroyCart(){
        Cart::destroy();
        session()->forget('coupon');
        return redirect()->back();
    }
}
