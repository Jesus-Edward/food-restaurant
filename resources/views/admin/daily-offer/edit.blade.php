@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Daily Offer</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Daily Offer</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.daily-offer.update', $daily_offer->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Product Id</label>
                        <select name="product" class="form-control" id="product_search">
                            <option value="{{ $daily_offer->product->id }}" selected>{{ $daily_offer->product->name }}</option>

                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" id="">
                            <option @selected($daily_offer->status === 1) value="1">Active</option>
                            <option @selected($daily_offer->status === 0) value="0">Inactive</option>
                        </select>
                    </div>


                    <button type="submit" class="btn btn-primary">Update Offer</button>
            </div>
            </form>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#product_search').select2({
                ajax: {
                    url: "{{ route('admin.daily-offer.product-search') }}",
                    data: function(params) {
                        var query = {
                            search: params.term,
                            type: 'public'
                        }

                        return query;
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(product) {
                                return {
                                    text: product.name,
                                    id: product.id,
                                    image_url: product.thumb_image
                                }
                            })
                        }
                    }
                },
                minimumInputLength: 3,
                templateResult: formatProduct,
                escapeMarkup: function(m){return m;}
            });

            function formatProduct(product) {
                var product = $('<span><img src="'+product.image_url+'" class="img-thumbnail" width="50px">  '+product.text+'</span>')
                return product;
            }
        })
    </script>
@endpush
