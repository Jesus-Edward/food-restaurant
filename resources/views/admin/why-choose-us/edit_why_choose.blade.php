@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Why Choose Us</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Why Choose Us</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.why-choose-us.update', $why_choose->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Icon</label>
                        <br>
                        <button class="btn btn-primary" role="iconpicker" name="icon" data-icon="{{ $why_choose->icon }}"></button>
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" value="{{ ($why_choose->title) }}" name="title" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Short Message</label>
                        <textarea type="text" name="short_message" class="form-control">{{ ($why_choose->short_message) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" id="">
                            <option @selected($why_choose->status === 1) value="1">Yes</option>
                            <option @selected($why_choose->status === 0) value="0">No</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Why Choose Us</button>
            </div>
            </form>
        </div>
    </section>
@endsection
