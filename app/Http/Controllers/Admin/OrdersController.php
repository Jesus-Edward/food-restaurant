<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\DeclinedOrderDataTable;
use App\DataTables\DeliveredOrderDataTable;
use App\DataTables\OrderDataTable;
use App\DataTables\PendingDataTable;
use App\DataTables\ProcessingOrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderPlacedNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrdersController extends Controller
{
    function index(OrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.index');
    }

    function pendingOrders(PendingDataTable $dataTable)
    {
        return $dataTable->render('admin.order.pending-orders');
    }

    function processingOrders(ProcessingOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.processing-order');
    }

    function deliveredOrders(DeliveredOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.delivered-order');
    }

    function declinedOrders(DeclinedOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.declined-order');
    }

    function viewOrder($id)
    {
        $order = Order::findOrFail($id);
        $notification = OrderPlacedNotification::where('order_id', $order->id)->update(['seen' => 1]);
        return view('admin.order.view-order', compact('order'));
    }

    function updateOrderStatus(Request $request, $id): RedirectResponse|Response
    {
        $request->validate([
            'payment_status' => ['required', 'in:pending,completed,failed'],
            'order_status' => ['required', 'in:pending,processing,delivered,declined']
        ]);
        $order = Order::findOrFail($id);
        $order->payment_status = $request->payment_status;
        $order->order_status = $request->order_status;

        $order->update();

        if ($request->ajax()) {
            return response(['message' => 'Status Updated!']);
        } else {
            toastr()->success('Status Updated Successfully!');
            return redirect()->back();
        }
    }

    function getOrderStatus($id)
    {
        $order = Order::select(['order_status', 'payment_status'])->findOrFail($id);

        return response($order);
    }

    function deleteOrder($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();

            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            logger($e);
            return response(['status' => 'error', 'message' => 'Something went wrong in the frontend']);
        }
    }
}
