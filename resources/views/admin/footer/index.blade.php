@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Footer</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Footer</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.footer-info.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Short Info</label>
                        <textarea type="text" name="short_info" class="form-control">{!! @$footer_info->short_info !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="address" value="{{ @$footer_info->address }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone" value="{{ @$footer_info->phone }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" value="{{ @$footer_info->email }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Copyright</label>
                        <input type="text" name="copyright" value="{{ @$footer_info->copyright }}" class="form-control">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update Footer Info</button>
            </div>
            </form>
        </div>
    </section>
@endsection
