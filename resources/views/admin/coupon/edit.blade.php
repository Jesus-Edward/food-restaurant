@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Coupon</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Coupon</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.coupon.update', $coupon->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" value="{{ $coupon->name }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Coupon Code</label>
                        <input type="text" name="code" value="{{ $coupon->code }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="text" name="quantity" value="{{ $coupon->quantity }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Min Purchase Amount</label>
                        <input type="text" name="min_purchase_amount" value="{{ $coupon->min_purchase_amount }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Expiration Date</label>
                        <input type="date" name="expired_date" value="{{ $coupon->expired_date }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Discount Type</label>
                        <select name="discount_type" class="form-control" id="">
                            <option @selected($coupon->status === 'percent') value="percent">Percent</option>
                            <option @selected($coupon->status === 'amount') value="amount"> Amount</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Discount Amount</label>
                        <input type="text" name="discount" value="{{ $coupon->discount }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" id="">
                            <option @selected($coupon->status === 1) value="1">Active</option>
                            <option @selected($coupon->status === 0) value="0">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Coupon</button>
            </div>
            </form>
        </div>
    </section>
@endsection
