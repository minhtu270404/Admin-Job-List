@extends('admin.layouts.master')

@section('contents')
<section class="section">
    <div class="section-header">
        <h1>Bài đăng tuyển dụng</h1>
    </div>

    <div class="section-body">
        @foreach ($errors->all() as $error)
            <div class="text-danger">{{ $error }}</div>
        @endforeach

        <div class="col-12">
            <div class="card-body">
                <form action="{{ route('admin.jobs.store') }}" method="POST">
                    @csrf

                    {{-- Thông tin công việc --}}
                    <div class="card">
                        <div class="card-header">
                            Thông tin công việc
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Tiêu đề công việc <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control {{ hasError($errors, 'title') }}" name="title" value="{{ old('title') }}">
                                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Chọn công ty <span class="text-danger">*</span></label>
                                        <select name="company" class="form-control select2 {{ hasError($errors, 'company') }}">
                                            <option value="">Chọn</option>
                                            @foreach ($companies as $company)
                                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('company')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Danh mục <span class="text-danger">*</span></label>
                                        <select name="category" class="form-control select2 {{ hasError($errors, 'category') }}">
                                            <option value="">Chọn</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Số lượng tuyển <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control {{ hasError($errors, 'vacancies') }}" name="vacancies" value="{{ old('vacancies') }}">
                                        <x-input-error :messages="$errors->get('vacancies')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Hạn nộp hồ sơ <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control datepicker {{ hasError($errors, 'deadline') }}" name="deadline" value="{{ old('deadline') }}">
                                        <x-input-error :messages="$errors->get('deadline')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Địa điểm làm việc --}}
                    <div class="card">
                        <div class="card-header">Địa điểm làm việc</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Quốc gia</label>
                                        <select name="country" class="form-control select2 country {{ hasError($errors, 'country') }}">
                                            <option value="">Chọn</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('country')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Tỉnh / Bang</label>
                                        <select name="state" class="form-control select2 state {{ hasError($errors, 'state') }}">
                                            <option value="">Chọn</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('state')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Thành phố</label>
                                        <select name="city" class="form-control select2 city {{ hasError($errors, 'city') }}">
                                            <option value="">Chọn</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('city')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Địa chỉ chi tiết</label>
                                        <input type="text" class="form-control {{ hasError($errors, 'address') }}" name="address" value="{{ old('address') }}">
                                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Mức lương --}}
                    <div class="card">
                        <div class="card-header">Chi tiết mức lương</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 d-flex">
                                    <div class="form-check mr-3">
                                        <input onclick="salaryModeChnage('salary_range')" type="radio" id="salary_range" name="salary_mode" checked value="range">
                                        <label for="salary_range">Khoảng lương</label>
                                    </div>
                                    <div class="form-check">
                                        <input onclick="salaryModeChnage('custom_salary')" type="radio" id="custom_salary" name="salary_mode" value="custom">
                                        <label for="custom_salary">Lương cố định</label>
                                    </div>
                                </div>

                                <div class="col-md-12 salary_range_part mt-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="">Lương tối thiểu <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control {{ hasError($errors, 'min_salary') }}" name="min_salary" value="{{ old('min_salary') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">Lương tối đa <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control {{ hasError($errors, 'max_salary') }}" name="max_salary" value="{{ old('max_salary') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 custom_salary_part d-none">
                                    <label for="">Lương tùy chỉnh <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control {{ hasError($errors, 'custom_salary') }}" name="custom_salary" value="{{ old('custom_salary') }}">
                                </div>

                                <div class="col-md-12 mt-3">
                                    <label for="">Loại lương <span class="text-danger">*</span></label>
                                    <select name="salary_type" class="form-control select2 {{ hasError($errors, 'salary_type') }}">
                                        <option value="">Chọn</option>
                                        @foreach ($salaryTypes as $salaryType)
                                            <option value="{{ $salaryType->id }}">{{ $salaryType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Thuộc tính --}}
                    <div class="card">
                        <div class="card-header">Thuộc tính công việc</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Kinh nghiệm <span class="text-danger">*</span></label>
                                    <select name="experience" class="form-control select2">
                                        <option value="">Chọn</option>
                                        @foreach ($experiences as $experience)
                                            <option value="{{ $experience->id }}">{{ $experience->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Vai trò công việc <span class="text-danger">*</span></label>
                                    <select name="job_role" class="form-control select2">
                                        <option value="">Chọn</option>
                                        @foreach ($jobRoles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Trình độ học vấn <span class="text-danger">*</span></label>
                                    <select name="education" class="form-control select2">
                                        <option value="">Chọn</option>
                                        @foreach ($educations as $education)
                                            <option value="{{ $education->id }}">{{ $education->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Loại hình công việc <span class="text-danger">*</span></label>
                                    <select name="job_type" class="form-control select2">
                                        <option value="">Chọn</option>
                                        @foreach ($jobTypes as $jobType)
                                            <option value="{{ $jobType->id }}">{{ $jobType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label for="">Thẻ (Tags)</label>
                                    <select name="tags[]" multiple class="form-control select2">
                                        @foreach ($tags as $tag)
                                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label for="">Phúc lợi</label>
                                    <input type="text" class="form-control inputtags" name="benefits" value="{{ old('benefits') }}">
                                </div>
                                <div class="col-md-12">
                                    <label for="">Kỹ năng yêu cầu</label>
                                    <select name="skills[]" multiple class="form-control select2">
                                        @foreach ($skills as $skill)
                                            <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Cách nhận hồ sơ --}}
                    <div class="card">
                        <div class="card-header">Cách nhận hồ sơ</div>
                        <div class="card-body">
                            <label for="">Hình thức nhận hồ sơ <span class="text-danger">*</span></label>
                            <select name="receive_applications" class="form-control select2">
                                <option value="app">Trên nền tảng</option>
                                <option value="email">Qua email</option>
                                <option value="custom_url">Qua liên kết tùy chỉnh</option>
                            </select>
                        </div>
                    </div>

                    {{-- Quảng bá --}}
                    <div class="card">
                        <div class="card-header">Tùy chọn hiển thị</div>
                        <div class="card-body d-flex">
                            <div class="form-check mr-3">
                                <input type="checkbox" id="featured" name="featured" value="1" checked>
                                <label for="featured">Nổi bật</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" id="highlight" name="highlight" value="1">
                                <label for="highlight">Đánh dấu</label>
                            </div>
                        </div>
                    </div>

                    {{-- Mô tả --}}
                    <div class="card">
                        <div class="card-header">Mô tả công việc</div>
                        <div class="card-body">
                            <textarea id="editor" name="description" placeholder="Nhập mô tả chi tiết công việc..."></textarea>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">Tạo mới</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    $(".inputtags").tagsinput('items');

    function salaryModeChnage(mode) {
        if (mode === 'salary_range') {
            $('.salary_range_part').removeClass('d-none');
            $('.custom_salary_part').addClass('d-none');
        } else {
            $('.salary_range_part').addClass('d-none');
            $('.custom_salary_part').removeClass('d-none');
        }
    }

    // Lấy danh sách tỉnh theo quốc gia
    $('.country').on('change', function() {
        let country_id = $(this).val();
        $('.city').html("");
        $.ajax({
            url: '{{ route("admin.get-states", ":id") }}'.replace(":id", country_id),
            success: function(response) {
                let html = '';
                $.each(response, function(index, value) {
                    html += `<option value="${value.id}">${value.name}</option>`;
                });
                $('.state').html(html);
            }
        })
    });

    // Lấy danh sách thành phố theo tỉnh
    $('.state').on('change', function() {
        let state_id = $(this).val();
        $.ajax({
            url: '{{ route("admin.get-cities", ":id") }}'.replace(":id", state_id),
            success: function(response) {
                let html = '';
                $.each(response, function(index, value) {
                    html += `<option value="${value.id}">${value.name}</option>`;
                });
                $('.city').html(html);
            }
        })
    });
</script>
@endpush
