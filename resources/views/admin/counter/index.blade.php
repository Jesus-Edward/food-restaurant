@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Counter Section</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Counter</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.counter.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Background</label>
                        <div id="image-preview" class="image-preview image-preview">
                            <label for="image-upload" id="image-label">Choose File</label>
                            <input type="file" name="background" id="image-upload">
                            <input type="hidden" name="old_background" value="{{ @$counter->background }}">
                        </div>
                    </div>

                    <h4>Counter One</h4>
                    <hr>
                    <div class="form-group">
                        <label for="">Counter Icon One</label>
                        <br>
                        <button class="btn btn-secondary" role="iconpicker" data-icon="{{ @$counter->counter_icon_one }}" name="counter_icon_one"></button>
                    </div>

                    <div class="form-group">
                        <label>Counter Title One</label>
                        <input type="text" name="counter_title_one" value="{{ @$counter->counter_title_one }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Counter Count One</label>
                        <input type="text" name="counter_count_one" value="{{ @$counter->counter_count_one }}" class="form-control">
                    </div>

                    <h4>Counter Two</h4>
                    <hr>
                    <div class="form-group">
                        <label for="">Counter Icon Two</label>
                        <br>
                        <button class="btn btn-secondary" role="iconpicker" data-icon="{{ @$counter->counter_icon_two }}" name="counter_icon_two"></button>
                    </div>

                    <div class="form-group">
                        <label>Counter Title Two</label>
                        <input type="text" name="counter_title_two" value="{{ @$counter->counter_title_two }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Counter Count Two</label>
                        <input type="text" name="counter_count_two" value="{{ @$counter->counter_count_two }}" class="form-control">
                    </div>

                    <h4>Counter Three</h4>
                    <hr>
                    <div class="form-group">
                        <label for="">Counter Icon Three</label>
                        <br>
                        <button class="btn btn-secondary" role="iconpicker" data-icon="{{ @$counter->counter_icon_three }}" name="counter_icon_three"></button>
                    </div>

                    <div class="form-group">
                        <label>Counter Title Three</label>
                        <input type="text" name="counter_title_three" value="{{ @$counter->counter_title_three }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Counter Count Three</label>
                        <input type="text" name="counter_count_three" value="{{ @$counter->counter_count_three }}" class="form-control">
                    </div>

                    <h4>Counter Four</h4>
                    <hr>
                    <div class="form-group">
                        <label for="">Counter Icon Four</label>
                        <br>
                        <button class="btn btn-secondary" role="iconpicker" data-icon="{{ @$counter->counter_icon_four }}" name="counter_icon_four"></button>
                    </div>

                    <div class="form-group">
                        <label>Counter Title Four</label>
                        <input type="text" name="counter_title_four" value="{{ @$counter->counter_title_four }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Counter Count Four</label>
                        <input type="text" name="counter_count_four" value="{{ @$counter->counter_count_four }}" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
            </div>
            </form>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $(document).ready(function(){
            $('.image-preview').css({
                'background-image': 'url({{ asset(@$counter->background) }})',
                'background-size': 'cover',
                'background-position': 'centre centre'
            });
        });
    </script>
@endpush
