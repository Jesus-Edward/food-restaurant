@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Social Link</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Social Link</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.social-links.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group">
                        <label>Icon</label> <br>
                        <button class="btn btn-secondary" role="iconpicker" data-icon="" name="icon"></button>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Social Link</label>
                        <input type="text" name="social_link" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" id="">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Social Link</button>
            </div>
            </form>
        </div>
    </section>
@endsection
