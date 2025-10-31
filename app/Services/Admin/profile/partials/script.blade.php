@push('scripts')
<script>
$(function() {
    // -------------------
    // Config / Elements
    // -------------------
    const defaultAvatar = '{{ asset('uploads/no_image.jpg') }}';

    const $form = $('#profileForm');
    const $btn = $form.find('button[type=submit]');
    const $spinner = $btn.find('.spinner-border');
    const $btnText = $btn.find('.btn-text');

    const $file = $('#image');                // input file avatar
    const $previewAvatar = $('#previewAvatar'); // ảnh preview trong form
    const $profileAvatar = $('#profileAvatar'); // avatar hiển thị ngoài widget (nếu có)
    const $removeBtn = $('#removeImageBtn');

    const $usernameInput = $('input[name="name"]');
    const $fullNameInput = $('input[name="full_name"]');
    const $firstNameInput = $('input[name="first_name"]');
    const $lastNameInput = $('input[name="last_name"]');
    const $phoneInput = $('#phoneInput');
    const $socialInput = $('input[name="link_social"]');

    // -------------------
    // Helpers
    // -------------------
    const showAlert = (icon, title, text, timer = null) => {
        Swal.fire({
            icon,
            title,
            html: text,
            timer,
            showConfirmButton: !timer
        });
    };

    const setButtonLoading = (state) => {
        $btn.prop('disabled', state);
        $spinner.toggleClass('d-none', !state);
        $btnText.text(state ? 'Đang lưu...' : 'Save Changes');
    };

    const applyWidgetData = (data) => {
        if (!data) return;
        $profileAvatar?.attr('src', data.avatar_url || defaultAvatar);
        $('#profileName').text(data.name);
        $('#profilePhone').text(data.phone || '-');
        if (data.link_social) {
            $('#profileSocial').text(data.link_social).attr('href', data.link_social);
        } else {
            $('#profileSocial').text('No social link').removeAttr('href');
        }
    };

    const clearValidation = () => {
        $form.find('.is-invalid').removeClass('is-invalid');
        $form.find('.invalid-feedback').remove();
    };

    const showFieldError = ($input, msg) => {
        $input.addClass('is-invalid');
        if ($input.next('.invalid-feedback').length === 0) {
            $input.after(`<div class="invalid-feedback d-block">${msg}</div>`);
        } else {
            $input.next('.invalid-feedback').html(msg);
        }
    };

    const clearFieldError = ($input) => {
        $input.removeClass('is-invalid');
        $input.next('.invalid-feedback').remove();
    };

    // -------------------
    // Validation (giữ như code gốc)
    // -------------------
    const isValidName = (full_name) => {
        if (!full_name) return { ok: false, msg: 'Tên không được để trống.' };
        if (full_name.length < 2) return { ok: false, msg: 'Tên phải có ít nhất 2 ký tự.' };
        if (full_name.length > 100) return { ok: false, msg: 'Tên không được quá 100 ký tự.' };
        const re = /^[\p{L}\p{M}\s.'\-]+$/u;
        if (!re.test(full_name)) return { ok: false, msg: 'Tên chứa ký tự không hợp lệ.' };
        return { ok: true };
    };

    const isValidPhone = (phone) => {
        if (!phone) return { ok: true };
        const digits = phone.replace(/\D/g, '');
        if (digits.length !== 10) return { ok: false, msg: 'Số điện thoại phải gồm 10 chữ số (ví dụ 0912345678).' };
        if (!/^0\d{9}$/.test(digits)) return { ok: false, msg: 'Số điện thoại không hợp lệ.' };
        return { ok: true };
    };

    const normalizeAndValidateUrl = (url) => {
        if (!url) return { ok: true, normalized: '' };
        url = url.trim();
        if (!/^https?:\/\//i.test(url)) url = 'https://' + url;
        try {
            const u = new URL(url);
            return { ok: true, normalized: u.href };
        } catch {
            return { ok: false, msg: 'Đường dẫn không hợp lệ.' };
        }
    };

    const validateImageFile = (file) => {
        if (!file) return { ok: true };
        const validTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        if (!validTypes.includes(file.type)) return { ok: false, msg: 'Vui lòng tải ảnh JPG/PNG/WEBP/GIF.' };
        if (file.size > 2 * 1024 * 1024) return { ok: false, msg: 'Kích thước ảnh không được vượt quá 2MB.' };
        return { ok: true };
    };

    // -------------------
    // Avatar handling
    // -------------------
    function handleFile(file) {
        const v = validateImageFile(file);
        if (!v.ok) {
            showAlert('error', 'Tệp không hợp lệ', v.msg);
            $file.val('');
            return;
        }
        const url = URL.createObjectURL(file);
        $previewAvatar.attr('src', url);
        $profileAvatar?.attr('src', url);
        $('#removeCurrentPhoto').val('0');
        $removeBtn.show();
    }

    $file.on('change', function() {
        if (this.files?.[0]) handleFile(this.files[0]);
        clearFieldError($file);
    });

    $removeBtn.on('click', function() {
        Swal.fire({
            title: 'Bạn chắc chứ?',
            text: 'Ảnh đại diện hiện tại sẽ bị xóa!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Có, xóa!',
            cancelButtonText: 'Hủy'
        }).then(result => {
            if (!result.isConfirmed) return;
            $.post('{{ route('admin.profile.remove-photo') }}', {
                _token: '{{ csrf_token() }}'
            }).done(res => {
                const src = res.avatar_url || defaultAvatar;
                $previewAvatar.attr('src', src);
                $profileAvatar?.attr('src', src);
                $('#removeCurrentPhoto').val('1');
                $removeBtn.hide();
                showAlert('success', 'Đã xóa!', res.message);
            }).fail(() => {
                showAlert('error', 'Lỗi!', 'Không thể xóa ảnh.');
            });
        });
    });

    // -------------------
    // Form Submit
    // -------------------
    $form.on('submit', function(e) {
        e.preventDefault();
        clearValidation();
        setButtonLoading(true);

        const errors = [];
        const vFullName = isValidName($fullNameInput.val());
        if (!vFullName.ok) {
            showFieldError($fullNameInput, vFullName.msg);
            errors.push(vFullName.msg);
        }

        const vPhone = isValidPhone($phoneInput.val());
        if (!vPhone.ok) {
            showFieldError($phoneInput, vPhone.msg);
            errors.push(vPhone.msg);
        }

        const vSocial = normalizeAndValidateUrl($socialInput.val());
        if (!vSocial.ok) {
            showFieldError($socialInput, vSocial.msg);
            errors.push(vSocial.msg);
        } else {
            $socialInput.val(vSocial.normalized);
        }

        const fileVal = $file[0]?.files?.[0] ?? null;
        const vFile = validateImageFile(fileVal);
        if (!vFile.ok) {
            showFieldError($file, vFile.msg);
            errors.push(vFile.msg);
        }

        if (errors.length) {
            showAlert('error', 'Lỗi xác thực', errors.join('<br>'));
            setButtonLoading(false);
            return;
        }

        const formData = new FormData(this);

        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
        }).done(res => {
            if (res.status === 'success') {
                applyWidgetData(res.data);
                showAlert('success', 'Thành công!', res.message);
            } else {
                showAlert('error', 'Lỗi!', res.message || 'Cập nhật thất bại.');
            }
        }).fail(xhr => {
            if (xhr.status === 422 && xhr.responseJSON?.errors) {
                const errs = xhr.responseJSON.errors;
                let list = [];
                for (const field in errs) {
                    const $input = $form.find(`[name="${field}"]`);
                    if ($input.length) {
                        showFieldError($input, errs[field][0]);
                    } else {
                        $form.prepend(`<div class="alert alert-danger">${errs[field][0]}</div>`);
                    }
                    list.push(errs[field][0]);
                }
                showAlert('error', 'Lỗi xác thực từ server', list.join('<br>'));
            } else {
                showAlert('error', 'Lỗi!', 'Cập nhật thất bại.');
            }
        }).always(() => {
            setButtonLoading(false);
        });
    });
});
</script>
@endpush
