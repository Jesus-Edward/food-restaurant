@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Product Sizes & Options({{ $product->name }})</h1>
        </div>

        <div>
            <a href="{{ route('admin.product.index') }}" class="btn btn-primary my-3">Go Back</a>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Create Sizes</h4>
                    </div>
                    <div class="card-body">
                            <form action="{{ route('admin.product-size.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div form-group>
                                            <label for="">Name</label>
                                            <input type="text" class="form-control" value="{{ old('name') }}" name="name">
                                            <input type="hidden" value="{{ $product->id }}" name="product_id">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div form-group>
                                            <label for="">Price</label>
                                            <input type="text" class="form-control" value="{{ old('price') }}" name="price">
                                        </div>
                                    </div>
                                </div>

                                <div form-group>
                                    <button type="submit" class="btn btn-primary" style="margin-top: 5%">Create</button>
                                </div>
                            </form>
                    </div>
                </div>

                <div class="card card-primary">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Size</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sizes as $size)
                                <tr>
                                    <td>{{ ++$loop->index }}</td>
                                    <td>{{ $size->name }}</td>
                                    <td>{{ $size->price }}</td>
                                    <td>
                                        <a href="{{ route('admin.product-size.edit', $size->id) }}"
                                            class="btn btn-primary mx-2"><i class="fas fa-edit"></i></a>
                                        <a href="{{ route('admin.product-size.destroy', $size->id) }}"
                                            class="btn btn-danger mx-2 my-1  delete-item"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                                @if (count($sizes )=== 0)
                                <tr>
                                    <td colspan="3" class="text-center">No sizes found for this product!</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Create Product Options</h4>
                    </div>
                    <div class="card-body">
                            <form action="{{ route('admin.product-option.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div form-group>
                                            <label for="">Name</label>
                                            <input type="text" class="form-control" value="{{ old('names') }}" name="names">
                                            <input type="hidden" value="{{ $product->id }}" name="product_id">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div form-group>
                                            <label for="">Price</label>
                                            <input type="text" class="form-control" value="{{ old('prices') }}" name="prices">
                                        </div>
                                    </div>
                                </div>

                                <div form-group>
                                    <button type="submit" class="btn btn-primary" style="margin-top: 5%">Create</button>
                                </div>
                            </form>
                    </div>
                </div>

                <div class="card card-primary">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Options</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($options as $option)
                                <tr>
                                    <td>{{ ++$loop->index }}</td>
                                    <td>{{ $option->names }}</td>
                                    <td>{{ $option->prices }}</td>
                                    <td><a href="{{ route('admin.product-option.destroy', $option->id) }}"
                                        class="btn btn-danger mx-2 delete-item"><i class="fas fa-trash"></i></a></td>
                                </tr>
                                @endforeach
                                @if (count($options )=== 0)
                                <tr>
                                    <td colspan="3" class="text-center">No options found for this product!</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

