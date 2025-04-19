@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Contact Page</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Contact Details</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.contact.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Phone One</label>
                        <input type="text" name="phone_one" class="form-control" value="{!!  @$contact->phone_one !!}">
                    </div>
                    <div class="form-group">
                        <label>Phone Two</label>
                        <input type="text" name="phone_two" class="form-control" value="{!!  @$contact->phone_two !!}">
                    </div>
                    <div class="form-group">
                        <label>Email One</label>
                        <input type="text" name="email_one" class="form-control" value="{!!  @$contact->email_one !!}">
                    </div>
                    <div class="form-group">
                        <label>Email Two</label>
                        <input type="text" name="email_two" class="form-control" value="{!!  @$contact->email_two !!}">
                    </div>
                    <div class="form-group">
                        <label>Location</label>
                        <input type="text" name="location" value="{!! @$contact->location !!}" class="form-control ">
                    </div>
                    <div class="form-group">
                        <label>Map Link</label>
                        <input type="text" name="map_link" value="{!! @$contact->map_link !!}" class="form-control ">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update Contact Details</button>
            </div>
            </form>
        </div>
    </section>
@endsection

