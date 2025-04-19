@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Profile</h1>
        </div>
        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Update User Settings</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <div id="image-preview" class="image-preview">
                                <input type="file" name="avatar" id="image-upload">
                            </div>
                            <div class="form-group">
                            <label for="image-upload" id="image-label">Choose File</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" value="{{ auth()->user()->name }}" class="form-control">
                        </div>
                        {{-- @if ($errors->has('name'))
                            @if ($errors->has('name'))
                                <div class="alert alert-danger col-5 px-0.5 py-2 border
                                 border-red text-red-700  rounded relative"
                                    role="alert">{{ $errors->first('name') }}</div>
                            @endif
                        @endif --}}
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" value="{{ auth()->user()->email }}" class="form-control">
                        </div>
                        {{-- @if ($errors->has('email'))
                            @if ($errors->has('email'))
                                <div class="alert alert-danger col-5 px-0.5 py-2
                                border-red text-red-700  rounded relative"
                                    role="alert">{{ $errors->first('email') }}</div>
                            @endif
                        @endif --}}
                        <button class="btn btn-primary" type="submit">Save</button>
                </div>
                </form>
            </div>
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Update Password</h4>
                </div>
                <form action="{{ route('admin.profile.password.update') }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Current Password</label>
                            <input type="password" name="current_password" class="form-control">
                        </div>
                        {{-- @if ($errors->has('current_password'))
                            @if ($errors->has('current_password'))
                                <div class="alert alert-danger col-5 px-0.5 py-2
                            border-red text-red-700  rounded relative"
                                    role="alert">{{ $errors->first('current_password') }}</div>
                            @endif
                        @endif --}}
                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        {{-- @if ($errors->has('password'))
                            @if ($errors->has('password'))
                                <div class="alert alert-danger col-5 px-0.5 py-2
                                border-red text-red-700  rounded relative"
                                    role="alert">{{ $errors->first('password') }}</div>
                            @endif
                        @endif --}}
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                        <button class="btn btn-primary" type="submit">Change Password</button>
                    </div>
            </div>
            </form>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('.image-preview').css({
                'background-image': 'url({{ asset(auth()->user()->avatar) }})',
                'background-size': 'cover',
                'background-position': 'centre centre'
            })
        })
    </script>
@endpush
