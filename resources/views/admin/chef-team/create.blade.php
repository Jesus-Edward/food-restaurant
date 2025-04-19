@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Our Chef Team</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Chef Profile</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.chef-team.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label>Chef Photo</label>
                        <div id="image-preview" class="image-preview">
                            <label for="image-upload" id="image-label">Choose File</label>
                            <input type="file" name="image" id="image-upload">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" value="{{ old('title') }}" class="form-control">
                    </div>

                    <h5>Social Links</h5>
                    <div class="form-group">
                        <label>Facebook <code>(Leave empty to hide)</code></label>
                        <input type="text" name="fb" value="{{ old('fb') }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>LinkedIn <code>(Leave empty to hide)</code></label>
                        <input type="text" name="in" value="{{ old('in') }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>X Link <code>(Leave empty to hide)</code></label>
                        <input type="text" name="x_link" value="{{ old('x_link') }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Web URL <code>(Leave empty to hide)</code></label>
                        <input type="text" name="web_url" value="{{ old('web_url') }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Show At Home</label>
                        <select name="show_at_home" class="form-control" id="">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" id="">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Profile</button>
            </div>
            </form>
        </div>
    </section>
@endsection
