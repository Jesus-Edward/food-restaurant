@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Privacy Policy</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Privacy Policy</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.privacy-policy.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Privacy Policy</label>
                        <textarea type="text" name="privacy_policy" class="form-control summernote">{!! @$privatePolicy->privacy_policy !!}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Privacy</button>
            </div>
            </form>
        </div>
    </section>
@endsection