@extends('admin.layouts.master')
@section('module', 'Quản trị')
@section('action', 'Đổi Mật Khẩu')

@section('contents')

    <h2 class="section-title">Xin chào, {{ Auth::user()->name }}!</h2>
    <p class="section-lead">
        Bạn có thể cập nhật mật khẩu cá nhân tại đây.
    </p>

    <div class="row mt-sm-4 justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card shadow-sm border-0">
                <form id="change-password-form" action="{{ route('admin.password.update') }}" method="POST"
                    class="needs-validation" novalidate>
                    @csrf
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Cập Nhật Mật Khẩu</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <!-- Mật khẩu hiện tại -->
                            <div class="form-group col-12 position-relative mb-3">
                                <label for="old_password">Mật khẩu hiện tại</label>
                                <input type="password" name="old_password" id="old_password"
                                    class="form-control @error('old_password') is-invalid @enderror" required
                                    placeholder="Nhập mật khẩu hiện tại">
                                <i class="fas fa-eye toggle-password"
                                    style="position:absolute; top:38px; right:15px; cursor:pointer;"></i>
                                <div class="invalid-feedback">Vui lòng nhập mật khẩu hiện tại.</div>
                                @error('old_password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Mật khẩu mới -->
                            <div class="form-group col-12 position-relative mb-3">
                                <label for="new_password">Mật khẩu mới</label>
                                <input type="password" name="new_password" id="new_password"
                                    class="form-control @error('new_password') is-invalid @enderror" required
                                    placeholder="Nhập mật khẩu mới">
                                <i class="fas fa-eye toggle-password"
                                    style="position:absolute; top:38px; right:15px; cursor:pointer;"></i>
                                <div class="invalid-feedback">Vui lòng nhập mật khẩu mới.</div>
                                @error('new_password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small id="passwordStrength" class="form-text text-muted mt-1"></small>
                            </div>

                            <!-- Xác nhận mật khẩu mới -->
                            <div class="form-group col-12 position-relative mb-3">
                                <label for="new_password_confirmation">Xác nhận mật khẩu mới</label>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                    class="form-control @error('new_password_confirmation') is-invalid @enderror" required
                                    placeholder="Nhập lại mật khẩu mới">
                                <i class="fas fa-eye toggle-password"
                                    style="position:absolute; top:38px; right:15px; cursor:pointer;"></i>
                                <div class="invalid-feedback">Vui lòng xác nhận mật khẩu mới.</div>
                                @error('new_password_confirmation')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                    <div class="card-footer text-end bg-light">
                        <button type="submit" class="btn btn-primary" id="saveBtn">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {

    const form = $('#change-password-form');
    const btn = $('#saveBtn');
    const strengthText = $('#passwordStrength');

    // Đo độ mạnh mật khẩu
    $('#new_password').on('input', function() {
        const val = $(this).val();
        let strength = 'Yếu';
        let color = 'text-danger';

        if (val.length >= 8 && /[A-Z]/.test(val) && /[0-9]/.test(val) && /[!@#$%^&*]/.test(val)) {
            strength = 'Mạnh';
            color = 'text-success';
        } else if (val.length >= 6) {
            strength = 'Trung bình';
            color = 'text-warning';
        }

        strengthText.text('Độ mạnh: ' + strength)
            .removeClass('text-danger text-warning text-success')
            .addClass(color);
    });

    // Hiển thị/ẩn mật khẩu
    $('.toggle-password').on('click', function() {
        const input = $(this).siblings('input');
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            $(this).removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            $(this).removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // Xử lý submit form
    form.on('submit', function(e) {
        e.preventDefault();

        const oldPass = form.find('[name="old_password"]').val().trim();
        const newPass = form.find('[name="new_password"]').val().trim();
        const confirmPass = form.find('[name="new_password_confirmation"]').val().trim();

        // Kiểm tra client-side
        if (!oldPass || !newPass || !confirmPass) {
            Swal.fire({
                icon: 'warning',
                title: 'Thiếu thông tin',
                text: 'Vui lòng điền đầy đủ các trường mật khẩu.'
            });
            return;
        }

        if (newPass !== confirmPass) {
            Swal.fire({
                icon: 'warning',
                title: 'Mật khẩu không khớp',
                text: 'Mật khẩu mới và xác nhận mật khẩu không trùng nhau.'
            });
            return;
        }

        btn.prop('disabled', true).text('Đang xử lý...');

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function(res) {
                if (res.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công',
                        text: res.message,
                        confirmButtonText: 'OK'
                    }).then(() => window.location.href = '/login');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: res.message || 'Không thể đổi mật khẩu.'
                    });
                }
            },
            error: function(xhr) {
                let msg = 'Có lỗi xảy ra, vui lòng thử lại.';
                if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: msg
                });
            },
            complete: function() {
                btn.prop('disabled', false).text('Lưu thay đổi');
            }
        });
    });

});
</script>
@endpush
