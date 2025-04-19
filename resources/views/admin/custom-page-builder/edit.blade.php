@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Custom Page</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Custom Page</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.custom-page-builder.update', $customPage->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" value="{{ $customPage->name }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Content</label>
                        <textarea type="text" name="content" class="form-control summernote">{{ $customPage->content }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" id="">
                            <option @selected($customPage->status === 1) value="1">Active</option>
                            <option @selected($customPage->status === 0) value="0">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Custom Page</button>
            </div>
            </form>
        </div>
    </section>
@endsection
