{{-- @php  
    $products = \App\Models\Product::where('status', 1)->firstOrFail();
    $ratingSum = \App\Models\ProductRating::where(['product_id' => $products->id, 'status' => 1])->sum('rating');
    $ratingCount = \App\Models\ProductRating::where(['product_id' => $products->id, 'status' => 1])->count();
    $avgRating = round(($ratingSum / $ratingCount), 2);
    $avgStarRating = round($avgRating);
@endphp --}}

<div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
    <div class="fp_dashboard_body dashboard_review">
        <h3>review</h3>
        <div class="fp__review_area">
            <div class="fp__comment pt-4 mt_20">
                @foreach($reviews as $review)
                    <div class="fp__single_comment m-0 border-0">
                        <img src="{{ $review->users->avatar }}" alt="{{ $review->users->name }}" class="img-fluid">
                        <div class="fp__single_comm_text">
                            <h3><a href="javascript:;">{{ $review->users->name }}</a> <span>{{ date('d M y | H:i', strtotime($review->created_at)) }}</span>
                            </h3>
                            <span class="rating">
                                @for ($i=1; $i <=$review->rating; $i++)
                                    <i class="fas fa-star"></i>  
                                @endfor                          
                                {{-- <b>({{ $avgRating }})</b> --}}
                            </span>
                            <p>{{ $review->review }}</p>
                            @if ($review->status === 1)
                                <span class="status active">Active</span>
                            @else
                                <span class="status inactive">Pending</span>
                            @endif
                            
                        </div>
                    </div>
                @endforeach
                @if (count($reviews) === 0)
                    <h5>No review added!</h5>
                @endif
                {{-- <a href="#" class="load_more">load More</a> --}}
            </div>
        </div>
    </div>
</div>
