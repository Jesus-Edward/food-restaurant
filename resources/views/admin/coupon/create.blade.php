@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Coupon</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Coupon</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.coupon.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Coupon Code</label>
                        <input type="text" name="code" value="{{ old('code') }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="text" name="quantity" value="{{ old('quantity') }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Min Purchase Amount</label>
                        <input type="text" name="min_purchase_amount" value="{{ old('min_purchase_amount') }}"
                            class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Expiration Date</label>
                        <input type="date" name="expired_date" value="{{ old('expired_date') }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Discount Type</label>
                        <select name="discount_type" class="form-control" id="">
                            <option value="percent">Percent</option>
                            <option value="amount"> Amount</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Discount Amount</label>
                        <input type="text" name="discount" value="{{ old('discount') }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" id="">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Coupon</button>
            </div>
            </form>
        </div>
    </section>
@endsection
