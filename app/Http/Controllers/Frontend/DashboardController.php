<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\AddressCreateRequest;
use App\Models\Address;
use App\Models\DeliveryArea;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductRating;
use App\Models\Reservation;
use App\Models\Wishlist;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function userDashboard(Request $request): View {
        $deliveryAreas = DeliveryArea::where('status', 1)->get();
        $userAddresses = Address::where('user_id', auth()->user()->id)->get();
        $orders = Order::where('user_id', auth()->user()->id)->get();
        $reservations = Reservation::where('user_id', auth()->user()->id)->get();
        $reviews = ProductRating::where('user_id', auth()->user()->id)->get();
        $wishlists = Wishlist::where('user_id', auth()->user()->id)->latest()->get();
        $totalOrders = Order::where('user_id', auth()->user()->id)->count();
        $totalCompleteOrders = Order::where(['user_id' => auth()->user()->id, 'order_status' => 'delivered'])->count();
        $totalCancelledOrders = Order::where(['user_id' => auth()->user()->id, 'order_status' => 'declined'])->count();
        return view('frontend.dashboard.index', compact(
            'deliveryAreas',
            'userAddresses',
            'orders',
            'reservations',
            'reviews',
            'wishlists',
            'totalOrders',
            'totalCompleteOrders',
            'totalCancelledOrders',
        ));
    }

    public function createAddress(AddressCreateRequest $request){
        $address = new Address();

        $address->user_id = auth()->user()->id;
        $address->delivery_area_id = $request->area;
        $address->first_name = $request->first_name;
        $address->last_name = $request->last_name;
        $address->phone = $request->phone;
        $address->email = $request->email;
        $address->address = $request->address;
        $address->type = $request->type;

        $address->save();

        toastr()->success('Address created successfully');
        return redirect()->back();
    }

    public function updateAddress(AddressCreateRequest $request, $id){
        $address = Address::findOrFail($id);

        $address->user_id = auth()->user()->id;
        $address->delivery_area_id = $request->area;
        $address->first_name = $request->first_name;
        $address->last_name = $request->last_name;
        $address->phone = $request->phone;
        $address->email = $request->email;
        $address->address = $request->address;
        $address->type = $request->type;

        $address->update();

        toastr()->success('Address updated successfully');
        return to_route('dashboard');
    }

    function deleteAddress($id) {
        $address = Address::findOrFail($id);

        if ($address && $address->user_id === auth()->user()->id ) {
            $address->delete();

            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        }

        return response(['status' => 'error', 'message' => 'Something went wrong in the frontend!']);
    }
}
