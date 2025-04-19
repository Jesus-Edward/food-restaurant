<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\DeliveryArea;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    function index(): View
    {
        $addresses = Address::where(['user_id' => auth()->user()->id])->get();
        $deliveryAreas = DeliveryArea::where('status', 1)->get();
        return view('frontend.pages.checkout', compact('addresses', 'deliveryAreas'));
    }

    function calculateDeliveryCharge($id)
    {
        try {
            $address = Address::findOrFail($id);
            $deliveryFee = $address->deliveryArea?->delivery_fee;
            $grandTotal = grandCartTotal($deliveryFee);

            return response(['status' => 'success', 'delivery_fee' => $deliveryFee, 'grand_total' => $grandTotal]);
        } catch (\Exception $e) {
            logger($e);
            return response(['status' => 'error', 'message' => 'Something went wrong in the frontend'], 422);
        }
    }

    function checkoutRedirectPayment(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer']
        ]);

        $address = Address::with(['deliveryArea'])->findOrFail($request->id);

        $selectedArea = $address->address.', Area: '. $address->deliveryArea?->area_name;

        session()->put('address', $selectedArea);
        session()->put('delivery_fee', $address->deliveryArea?->delivery_fee);
        session()->put('address_id', $address->id);

        return response(['redirect_url' => route('checkout.payment.index')]);
    }
}
