<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CouponDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CouponCreateRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CouponDataTable $dataTable)
    {
        return $dataTable->render('admin.coupon.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CouponCreateRequest $request)
    {
        $coupon = new Coupon();

        $coupon->name = $request->name;
        $coupon->code = $request->code;
        $coupon->quantity = $request->quantity;
        $coupon->min_purchase_amount = $request->min_purchase_amount;
        $coupon->expired_date = $request->expired_date;
        $coupon->discount_type = $request->discount_type;
        $coupon->discount = $request->discount;
        $coupon->status = $request->status;

        $coupon->save();
        toastr()->success('Coupon created successfully!');
        return to_route('admin.coupon.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupon.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CouponCreateRequest $request, string $id)
    {
        $coupon = Coupon::findOrFail($id);

        $coupon->name = $request->name;
        $coupon->code = $request->code;
        $coupon->quantity = $request->quantity;
        $coupon->min_purchase_amount = $request->min_purchase_amount;
        $coupon->expired_date = $request->expired_date;
        $coupon->discount_type = $request->discount_type;
        $coupon->discount = $request->discount;
        $coupon->status = $request->status;

        $coupon->update();
        toastr()->success('Coupon updated successfully!');
        return to_route('admin.coupon.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $coupon = Coupon::findOrFail($id);

            $coupon->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'Something went wrong in the frontend']);
        }

    }
}
