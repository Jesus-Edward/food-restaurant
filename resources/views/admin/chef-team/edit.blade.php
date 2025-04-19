@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Our Chef Team</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Chef Profile</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.chef-team.update', $chefTeam->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Chef Photo</label>
                        <div id="image-preview" class="image-preview">
                            <label for="image-upload" id="image-label">Choose File</label>
                            <input type="file" name="image" value="{{ $chefTeam->image }}" id="image-upload">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" value="{{ $chefTeam->name }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" value="{{ $chefTeam->title }}" class="form-control">
                    </div>

                    <h5>Social Links</h5>
                    <div class="form-group">
                        <label>Facebook</label>
                        <input type="text" name="fb" value="{{ $chefTeam->fb }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>LinkedIn</label>
                        <input type="text" name="in" value="{{ $chefTeam->in }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>X Link</label>
                        <input type="text" name="x_link" value="{{ $chefTeam->x_link }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Web URL</label>
                        <input type="text" name="web_url" value="{{ $chefTeam->web_url }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Show At Home</label>
                        <select name="show_at_home" class="form-control" id="">
                            <option @selected($chefTeam->show_at_home === 1) value="1">Yes</option>
                            <option @selected($chefTeam->show_at_home === 0) value="0">No</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" id="">
                            <option @selected($chefTeam->status === 1) value="1">Active</option>
                            <option @selected($chefTeam->status === 0) value="0">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
            </div>
            </form>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $(document).ready(function(){
            $('.image-preview').css({
                'background-image': 'url({{ asset($chefTeam->image) }})',
                'background-size': 'cover',
                'background-position': 'centre centre'
            });
        });
    </script>
@endpush