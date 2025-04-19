<div class="col-lg-8">
    <h4>{{ count($reviews) }} reviews</h4>
    <div class="fp__comment pt-0 mt_20">
        @foreach($reviews as $review)
            <div class="fp__single_comment m-0 border-0">
                <img src="{{ $review->users->avatar }}" alt="review" class="img-fluid">
                <div class="fp__single_comm_text">
                    <h3>{{ $review->users->name }} <span>{{ date('d M y', strtotime($review->created_at)) }} </span></h3>
                    <span class="rating">
                        @for($i=1; $i <= $review->rating; $i++)
                            <i class="fas fa-star"></i>
                        @endfor
                        {{-- <b>({{ $reviewCount[0]->count }})</b> --}}
                    </span>
                    <p>{!! $review->review !!}</p>
                </div>
            </div>
        @endforeach
        <a href="#" class="load_more">load More</a>
        @if(count($reviews) === 0)
            <div class="alert alert-warning mt-5">No review found for this product!</div>
        @endif

    </div>
</div>
