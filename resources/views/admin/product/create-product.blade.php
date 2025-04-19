@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Products</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Products</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Thumb Image</label>
                        <div id="image-preview" class="image-preview">
                            <label for="image-upload" id="image-label">Choose File</label>
                            <input type="file" name="image" id="image-upload">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select name="category" class="form-control select2" id="">
                            @foreach ($categories as $categories)
                                <option value="{{ $categories->id }}">{{ $categories->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <input type="text" name="price" value="{{ old('price') }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Offer Price</label>
                        <input type="text" name="offer_price" value="{{ old('offer_price') }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="text" name="quantity" value="{{ old('quantity') }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Short Description</label>
                        <textarea type="text" name="short_description" class="form-control">{{ old('short_description') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Long Description</label>
                        <textarea type="text" name="long_description" class="form-control summernote">{{ old('long_description') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Sku</label>
                        <input type="text" name="sku" value="{{ old('sku') }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>SEO Title</label>
                        <input type="text" name="seo_title" value="{{ old('seo_title') }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>SEO Description</label>
                        <textarea type="text" name="seo_description" value="{{ old('seo_description') }}" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Show At Home</label>
                        <select name="show_at_home" class="form-control" id="">
                            <option value="1">Yes</option>
                            <option selected value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" id="">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Products</button>
            </div>
            </form>
        </div>
    </section>
@endsection
