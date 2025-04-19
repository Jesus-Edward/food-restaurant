

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
                        <b>({{ $reviewCount[0]->count }})</b>
                    </span>
                    <p>{!! $review->review !!}</p>
                </div>
            </div>
        @endforeach
        <button type="submit" class="load_more">load More</button>
        @if(count($reviews) === 0)
            <div class="alert alert-warning mt-5">No review found for this product!</div>
        @endif

    </div>
</div>

@push('scripts')
    <script>
            var ENDPOINT = "{{ route('review.load-more') }}";
            var = page = 1;

            $(".load_more").on('click', function(e){
                e.preventDefault();
                page++;
                LoadMore(page);
            });

            function LoadMore(page) {
                $.ajax({
                    method: 'GET',
                    url: ENDPOINT + "?page=" + page,
                    datatype: "html",
                    beforeSend: function(){
                        $('.load_more').attr('disabled', true);
                        $('.load_more').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>')
                    },
                    success: function(response){
                        $('.fp__single_comment').append(response.html)
                        $('.load_more').attr('disabled', false);
                        $('.load_more').text('load more')
                    },
                    error: function(xhr, status, error){
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(index, value){
                            console.log(value);
                        })
                    },
                    complete: function(){
                        $('.load_more').attr('disabled', false);
                        $('.load_more').text("Load More");
                    }
                })
            }
    </script>
@endpush
