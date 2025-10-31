<div class="col-md-7">
    <div class="card shadow-sm border-0 rounded-4">
        <form action="{{ route('admin.profile.update') }}" method="post" enctype="multipart/form-data" id="profileForm">
            @csrf
            <div class="card-header bg-light">
                <h4 class="mb-0">Chỉnh sửa hồ sơ</h4>
            </div>
            <div class="card-body">

                <div class="row g-3">
                    {{-- Username --}}
                    <div class="col-md-6">
                        <label class="form-label" data-bs-toggle="tooltip" title="Nhập tên người dùng duy nhất">
                            <i class="fas fa-user me-1"></i> Tên đăng nhập
                        </label>
                        <input type="text" name="name" required
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $data->username) }}">
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Full Name --}}
                    <div class="col-md-6">
                        <label class="form-label" data-bs-toggle="tooltip" title="Họ và tên đầy đủ">
                            <i class="fas fa-id-badge me-1"></i> Họ và tên
                        </label>
                        <input type="text" name="full_name"
                            class="form-control @error('full_name') is-invalid @enderror"
                            value="{{ old('full_name', $data->full_name) }}">
                        @error('full_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- First Name --}}
                    <div class="col-md-6">
                        <label class="form-label" data-bs-toggle="tooltip" title="Tên">
                            <i class="fas fa-id-badge me-1"></i> Tên
                        </label>
                        <input type="text" name="first_name"
                            class="form-control @error('first_name') is-invalid @enderror"
                            value="{{ old('first_name', $data->first_name) }}">
                        @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Last Name --}}
                    <div class="col-md-6">
                        <label class="form-label" data-bs-toggle="tooltip" title="Họ">
                            <i class="fas fa-id-card me-1"></i> Họ
                        </label>
                        <input type="text" name="last_name"
                            class="form-control @error('last_name') is-invalid @enderror"
                            value="{{ old('last_name', $data->last_name) }}">
                        @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Phone --}}
                    <div class="col-md-6">
                        <label class="form-label" data-bs-toggle="tooltip"
                            title="Nhập số điện thoại hợp lệ tại Việt Nam">
                            <i class="fas fa-phone me-1"></i> Số điện thoại
                        </label>
                        <input type="tel" id="phoneInput" name="phone" placeholder="Nhập số điện thoại..."
                            class="form-control @error('phone') is-invalid @enderror"
                            value="{{ old('phone', $data->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Gender --}}
                    <div class="col-md-6">
                        <label for="gender" class="form-label">Giới tính</label>
                        <select name="gender" id="gender" class="form-control">
                            <option value="male" {{ old('gender', $data->gender) === 'male' ? 'selected' : '' }}>Nam
                            </option>
                            <option value="female" {{ old('gender', $data->gender) === 'female' ? 'selected' : '' }}>Nữ
                            </option>
                            <option value="other" {{ old('gender', $data->gender) === 'other' ? 'selected' : '' }}>
                                Khác</option>
                        </select>
                    </div>


                    {{-- Social Link --}}
                    <div class="col-md-12">
                        <label class="form-label" data-bs-toggle="tooltip"
                            title="Nhập URL Facebook/LinkedIn/Website của bạn">
                            <i class="fas fa-link me-1"></i> Liên kết mạng xã hội
                        </label>
                        <input type="url" name="link_social"
                            class="form-control @error('link_social') is-invalid @enderror"
                            placeholder="https://facebook.com/username"
                            value="{{ old('link_social', $data->link_social) }}">
                        @error('link_social')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Birth Day --}}
                    <div class="col-md-12">
                        <label class="form-label">
                            <i class="fas fa-calendar me-1"></i> Ngày sinh
                        </label>
                        <input type="date" name="dob" class="form-control @error('dob') is-invalid @enderror"
                            value="{{ old('dob', $data->dob) }}">
                        @error('dob')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Avatar --}}
                <div class="col-12 mt-3">
                    <label class="form-label fw-bold">Ảnh đại diện</label>
                    <div class="border rounded-3 p-3 text-center position-relative"
                        style="border-style: dashed; cursor: pointer;"
                        onclick="document.getElementById('image').click()">
                        <img id="previewAvatar"
                            src="{{ $data->avatar_url ? asset('uploads/images/' . $data->avatar_url) : asset('uploads/no_image.jpg') }}"
                            class="rounded-circle shadow-sm mb-2" width="120" height="120"
                            style="object-fit: cover;">
                        <p class="mb-1 small text-muted">Nhấp hoặc kéo thả để thay đổi</p>
                        <input type="file" name="avatar_url" id="image" accept="image/*" class="d-none">
                    </div>
                    @if ($data->avatar_url)
                        <button type="button" id="removeImageBtn" class="btn btn-outline-danger btn-sm mt-2">
                            <i class="fas fa-trash-alt me-1"></i> Xóa ảnh hiện tại
                        </button>
                    @endif
                    <p class="text-muted small mt-2" id="noAvatarHint"
                        style="{{ $data->avatar_url ? 'display: none;' : '' }}">
                        Bạn chưa tải ảnh đại diện nào.
                    </p>
                    <input type="hidden" name="remove_current_photo" id="removeCurrentPhoto" value="0">
                </div>

            </div>

            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">
                    <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                    <span class="btn-text">Lưu thay đổi</span>
                </button>
            </div>
        </form>
    </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function() {

            // Preview ảnh avatar khi chọn file
            $('#image').on('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#previewAvatar').attr('src', e.target.result);
                        $('#noAvatarHint').hide();
                    }
                    reader.readAsDataURL(file);
                    $('#removeCurrentPhoto').val(0); // Reset flag xóa
                }
            });

            // Xóa avatar hiện tại
            $('#removeImageBtn').on('click', function() {
                $('#previewAvatar').attr('src', '{{ asset('uploads/no_image.jpg') }}');
                $('#image').val('');
                $('#removeCurrentPhoto').val(1); // Gắn flag xóa
                $('#noAvatarHint').show();
            });

            // Tooltip Bootstrap
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })

            // Validate realtime
            $('#profileForm input, #profileForm select').on('input change', function() {
                if ($(this).val()) {
                    $(this).removeClass('is-invalid');
                }
            });

            // Submit form với loader spinner
            $('#profileForm').on('submit', function(e) {
                const btn = $(this).find('button[type="submit"]');
                btn.find('.spinner-border').removeClass('d-none');
                btn.find('.btn-text').text('Đang lưu...');
            });

        });
    </script>
@endpush
