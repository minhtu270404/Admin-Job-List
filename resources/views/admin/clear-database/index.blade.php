@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Xóa Dữ Liệu Hệ Thống</h1>
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Xóa Toàn Bộ Dữ Liệu</h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning alert-has-icon">
                            <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                            <div class="alert-body">
                                <div class="alert-title">Cảnh Báo Nguy Hiểm</div>
                                Nếu bạn thực hiện thao tác này, toàn bộ dữ liệu trong hệ thống sẽ bị **xóa vĩnh viễn** và **không thể khôi phục**.
                            </div>
                            <form action="" class="mt-2 clear_db">
                                <button class="btn btn-danger submit_button" type="submit">Xóa Toàn Bộ Dữ Liệu</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.clear_db').on('submit', function(e) {
                e.preventDefault();

                swal({
                    title: 'Bạn có chắc chắn không?',
                    text: 'Hành động này sẽ xóa toàn bộ dữ liệu trong cơ sở dữ liệu!',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {

                        $.ajax({
                            method: 'POST',
                            url: "{{ route('admin.clear-database') }}",
                            data: {_token: "{{ csrf_token() }}"},
                            beforeSend: function() {
                                swal('Đang tiến hành xóa dữ liệu, vui lòng không tải lại trang...', {
                                    icon: 'info',
                                    buttons: false,
                                    closeOnClickOutside: false
                                });
                            },
                            success: function(response) {
                                swal(response.message, {
                                    icon: 'success',
                                });
                                window.location.reload();
                            },
                            error: function(xhr, status, error) {
                                console.log(xhr);
                                swal(xhr.responseJSON.message, {
                                    icon: 'error',
                                });
                            }
                        })
                    }
                });
            })
        })
    </script>
@endpush
