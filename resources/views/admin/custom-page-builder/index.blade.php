@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Custom Page Builder</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>All Pages</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.custom-page-builder.create') }}" class="btn btn-primary">
                        Create new
                    </a>
                </div>
            </div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </section>
@endsection

@push('script')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
