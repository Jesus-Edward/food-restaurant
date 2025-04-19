@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Terms & Conditions</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Terms & Conditions</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.terms_and_conditions.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Terms & Conditions</label>
                        <textarea type="text" name="terms_and_cons" class="form-control summernote">{!! @$termsAndCons->terms_and_cons !!}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Terms & Cons</button>
            </div>
            </form>
        </div>
    </section>
@endsection