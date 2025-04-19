@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Clear Database</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Clear Database</h4>
            </div>
            <div class="card-body">
                <div class="alert alert-warning alert-has-icon">
                    <div class="alert-icon"><i class="fas fa-exclamation-triangle"></i></div>
                    <div class="alert-body">
                        <div class="alert-title">Warning</div>
                        WARNING: THIS ACTION WILL WIPE YOUR ENTIRE DATABASE, BEWARE!
                    </div>
                    <form action="" class="clear_database mt-2">
                        <button class="btn btn-danger clear-btn" type="submit"><b>Clear Database</b></button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        
        $(document).ready(function() {
            $('.clear_database').on('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: "Confirm Delete",
                    text: "Are you sure you want to clear your database ?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, clear it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: 'POST',
                            url: "{{ route('admin.clear-database.destroy') }}",
                            data: {_token: "{{ csrf_token() }}"},
                            beforeSend: function(){
                                $('.clear-btn').prop('disabled', true);
                                $('.clear-btn').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Clearing...');
                                
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    toastr.success(response.message);
                                    window.location.reload();
                                }
                                else{
                                    if(response.status === 'error'){
                                        toastr.error(response.message);
                                    }
                                }
                                $('.clear-btn').prop('disabled', false);
                            },
                            error: function(error) {
                                console.error(error);
                                $('.clear-btn').prop('disabled', false);
                            },
                            complete: function(){
                                $('.clear-btn').prop('disabled', false);
                                $('.clear-btn').html('<b>Clear Database</b>');
                            }
                        })
                    }
                })
            })
        })
    </script>
@endpush