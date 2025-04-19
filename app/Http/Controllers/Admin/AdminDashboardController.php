<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\TodaysOrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Order;
use App\Models\OrderPlacedNotification;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(TodaysOrderDataTable $dataTable): View|JsonResponse
    {
        $todayOrder = Order::whereDate('created_at', today()->format('Y-m-d'))->count();
        $todayEarning = Order::whereDate('created_at', today()->format('Y-m-d'))->where('order_status', 'delivered')->sum('grand_total');

        $monthlyOrder = Order::whereMonth('created_at', today()->month)->count();
        $monthlyEarning = Order::whereMonth('created_at', today()->month)->where('order_status', 'delivered')->sum('grand_total');

        $yearlyOrder = Order::whereYear('created_at', today()->year)->count();
        $yearlyEarning = Order::whereYear('created_at', today()->year)->where('order_status', 'delivered')->sum('grand_total');

        $totalOrders = Order::count();
        $totalEarnings = Order::where('order_status', 'delivered')->sum('grand_total');

        $totalUsers = User::where('role', 'user')->count();
        $totalAdmins = User::where('role', 'admin')->count();

        $totalProducts = Product::count();
        $totalBlogs = Blog::count();

        return $dataTable->render('admin.dashboard.index', compact(
            'todayOrder',
            'todayEarning',
            'monthlyOrder',
            'monthlyEarning',
            'yearlyOrder',
            'yearlyEarning',
            'totalOrders',
            'totalEarnings',
            'totalUsers',
            'totalAdmins',
            'totalProducts',
            'totalBlogs'
        ));
    }

    function clearNotification()
    {
        $notification = OrderPlacedNotification::query()->update(['seen' => 1]);
        toastr()->success('All messages marked as read');
        return redirect()->back();
    }
}
