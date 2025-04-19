<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use Gloudemans\Shoppingcart\Facades\Cart;

class AllOrdersService
{
    /**Stores all orders into the database */
    function createAllOrders()
    {
        try{
            $orders = new Order();
            $orders->invoice_id = generateInvoiceId();
            $orders->user_id = auth()->user()->id;
            $orders->address = session()->get('address');
            $orders->discount = session()->get('coupon')['discount'] ?? 0;
            $orders->delivery_charge = session()->get('delivery_fee');
            $orders->subtotal = cartTotalPrice();
            $orders->grand_total = grandCartTotal(session()->get('delivery_fee'));
            $orders->product_qty = \Cart::content()->count();
            $orders->payment_method  =  NULL;
            $orders->payment_status  = 'pending';
            $orders->payment_approved_date = Null;
            $orders->transaction_id = Null;
            $orders->coupon_info = json_encode(session()->get('coupon'));
            $orders->currency_name = NULL;
            $orders->order_status = 'pending';
            $orders->address_id = session()->get('address_id');

            $orders->save();


            foreach (\Cart::content() as $product) {
                $oderItem = new OrderItem();

                $oderItem->order_id = $orders->id;
                $oderItem->product_name = $product->name;
                $oderItem->product_id = $product->id;
                $oderItem->unit_price  = $product->price;
                $oderItem->qty  = $product->qty;
                $oderItem->product_option = json_encode($product->options->product_variance);
                $oderItem->product_size = json_encode($product->options->product_size);

                $oderItem->save();
            }

            /**Adding the grand order id into the cart session */
            session()->put('order_id', $orders->id);

            /**Adding the grand total amount into the cart session */
            session()->put('grandTotal', $orders->grand_total);

            return true;
        }catch(\Exception $e){
            logger($e) ;
            return false;
        }
    }

    /**Clears the session after creating an order */
    function clearSessionItems()
    {
        \Cart::destroy();
        session()->forget('coupon');
        session()->forget('address');
        session()->forget('delivery_fee');
        session()->forget('delivery_area_id');
        session()->forget('order_id');
        session()->forget('grandTotal');
    }
}
