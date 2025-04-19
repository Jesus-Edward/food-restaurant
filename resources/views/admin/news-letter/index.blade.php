@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Subscribers</h1>
        </div>

        <div class="card">
            <div class="card-body">
              <div id="accordion">
                <div class="accordion">
                  <div class="accordion-header collapsed bg-primary text-light p-3" role="button" data-toggle="collapse" data-target="#panel-body-1" aria-expanded="false">
                    <h4>Send Newsletter</h4>
                  </div>
                  <div class="accordion-body collapse" id="panel-body-1" data-parent="#accordion" style="">
                    <form action="{{ route('admin.newsletter-subscribers.message') }}" method="POST">
                      @csrf
                      <div class="form-group">
                      <label for="">Subject</label>
                      <input type="text" name="subject" value="{{ old('subject') }}" class="form-control"
                      value="">
                    </div>
                    <div class="form-group">
                      <label for="">Message</label>
                      <textarea name="message" class="summernote">{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Newsletter</button>
                  </form>
                  </div>
                </div>
              </div>
            </div>
          </div>


        <div class="card card-primary">
            <div class="card-header">
                <h4>All Subscribers</h4>
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
