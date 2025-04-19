@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Reservation Time Schedules</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Reservation Time Schedules</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.reservation-time.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label>Start Time</label>
                        <input type="text" name="starting_time" class="form-control timepicker">
                    </div>
                    <div class="form-group">
                        <label>Stoppage Time</label>
                        <input type="text" name="stoppage_time" class="form-control timepicker">
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" id="">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Reservation Time</button>
            </div>
            </form>
        </div>
    </section>
@endsection
