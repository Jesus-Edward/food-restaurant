@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Testimonial</h1>
        </div>

        <div class="card">
            <div class="card-body">
              <div id="accordion">
                <div class="accordion">
                  <div class="accordion-header collapsed bg-primary text-light p-3" role="button" data-toggle="collapse" data-target="#panel-body-1" aria-expanded="false">
                    <h4>Testimonial Section Titles...</h4>
                  </div>
                  <div class="accordion-body collapse" id="panel-body-1" data-parent="#accordion" style="">
                    <form action="{{ route('admin.testimonial-title.update') }}" method="POST">
                      @csrf
                      @method('PUT')
                      <div class="form-group">
                      <label for="">Top Title</label>
                      <input type="text" name="testimonial_top_title" class="form-control"
                      value="{{ @$titles['testimonial_top_title'] }}">
                    </div>
                    <div class="form-group">
                      <label for="">Main Title</label>
                      <input type="text" name="testimonial_main_title" class="form-control"
                       value="{{ @$titles['testimonial_main_title'] }}">
                    </div>
                    <div class="form-group">
                      <label for="">Sub Title</label>
                      <input type="text" name="testimonial_sub_title" class="form-control"
                      value="{{ @$titles['testimonial_sub_title'] }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                  </form>
                  </div>
                </div>
              </div>
            </div>
          </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>All Testimonials</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.testimonial.create') }}" class="btn btn-primary">
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
