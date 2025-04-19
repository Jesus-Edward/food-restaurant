<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class WishlistController extends Controller
{
    function storeWishlist($productId)
    {
        $productAlreadyExist = Wishlist::where(['user_id' => auth()->user()->id, 'product_id' => $productId])
            ->exists();
        if ($productAlreadyExist) {
            throw ValidationException::withMessages(['message' => 'Product already added to wishlist']);
        }

        if (!Auth::check()) {
            throw ValidationException::withMessages(['message' => 'Login add this product to your wishlist']);
        }
        $wishlist = new Wishlist();
        $wishlist->user_id = auth()->user()->id;
        $wishlist->product_id = $productId;
        $wishlist->save();

        return response(['status' => 'success', 'message' => 'Product added to your wishlist']);
    }
}
