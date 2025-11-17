@extends('admin.layouts.master')

@section('contents')
<section class="section">
    <div class="section-header">
        <h1>Tạo bài đăng tuyển dụng</h1>
    </div>

    <div class="section-body">
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="text-danger">{{ $error }}</div>
            @endforeach
        @endif

        <div class="col-12">
            <div class="card-body">
                <form action="{{ route('admin.jobs.store') }}" method="POST">
                    @csrf

                    {{-- Thông tin công việc --}}
                    <div class="card">
                        <div class="card-header">Thông tin công việc</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Tiêu đề công việc <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" value="{{ old('title') }}">
                                    @if ($errors->has('title'))
                                        <div class="text-danger mt-2">{{ $errors->first('title') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label>Công ty <span class="text-danger">*</span></label>
                                    <select name="company" class="form-control select2 {{ $errors->has('company') ? 'is-invalid' : '' }}">
                                        <option value="">Chọn</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}" {{ old('company') == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('company'))
                                        <div class="text-danger mt-2">{{ $errors->first('company') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label>Danh mục <span class="text-danger">*</span></label>
                                    <select name="category" class="form-control select2 {{ $errors->has('category') ? 'is-invalid' : '' }}">
                                        <option value="">Chọn</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category'))
                                        <div class="text-danger mt-2">{{ $errors->first('category') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label>Số lượng tuyển <span class="text-danger">*</span></label>
                                    <input type="text" name="vacancies" class="form-control {{ $errors->has('vacancies') ? 'is-invalid' : '' }}" value="{{ old('vacancies') }}">
                                    @if ($errors->has('vacancies'))
                                        <div class="text-danger mt-2">{{ $errors->first('vacancies') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label>Hạn nộp hồ sơ <span class="text-danger">*</span></label>
                                    <input type="text" name="deadline" class="form-control datepicker {{ $errors->has('deadline') ? 'is-invalid' : '' }}" value="{{ old('deadline') }}">
                                    @if ($errors->has('deadline'))
                                        <div class="text-danger mt-2">{{ $errors->first('deadline') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Địa điểm làm việc --}}
                    <div class="card mt-3">
                        <div class="card-header">Địa điểm làm việc</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Quốc gia</label>
                                    <select name="country" class="form-control select2 country {{ $errors->has('country') ? 'is-invalid' : '' }}">
                                        <option value="">Chọn</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" {{ old('country') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('country'))
                                        <div class="text-danger mt-2">{{ $errors->first('country') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label>Tỉnh / Bang</label>
                                    <select name="state" class="form-control select2 state {{ $errors->has('state') ? 'is-invalid' : '' }}">
                                        <option value="">Chọn</option>
                                    </select>
                                    @if ($errors->has('state'))
                                        <div class="text-danger mt-2">{{ $errors->first('state') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label>Thành phố</label>
                                    <select name="city" class="form-control select2 city {{ $errors->has('city') ? 'is-invalid' : '' }}">
                                        <option value="">Chọn</option>
                                    </select>
                                    @if ($errors->has('city'))
                                        <div class="text-danger mt-2">{{ $errors->first('city') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-12 mt-3">
                                    <label>Địa chỉ chi tiết</label>
                                    <input type="text" name="address" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" value="{{ old('address') }}">
                                    @if ($errors->has('address'))
                                        <div class="text-danger mt-2">{{ $errors->first('address') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Mức lương --}}
                    <div class="card mt-3">
                        <div class="card-header">Chi tiết mức lương</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 d-flex">
                                    <div class="form-check mr-3">
                                        <input type="radio" id="salary_range" name="salary_mode" value="range" checked onclick="salaryModeChange('salary_range')">
                                        <label for="salary_range">Khoảng lương</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" id="custom_salary" name="salary_mode" value="custom" onclick="salaryModeChange('custom_salary')">
                                        <label for="custom_salary">Lương cố định</label>
                                    </div>
                                </div>

                                <div class="col-md-12 salary_range_part mt-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Lương tối thiểu <span class="text-danger">*</span></label>
                                            <input type="text" name="min_salary" class="form-control {{ $errors->has('min_salary') ? 'is-invalid' : '' }}" value="{{ old('min_salary') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Lương tối đa <span class="text-danger">*</span></label>
                                            <input type="text" name="max_salary" class="form-control {{ $errors->has('max_salary') ? 'is-invalid' : '' }}" value="{{ old('max_salary') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 custom_salary_part d-none mt-3">
                                    <label>Lương tùy chỉnh <span class="text-danger">*</span></label>
                                    <input type="text" name="custom_salary" class="form-control {{ $errors->has('custom_salary') ? 'is-invalid' : '' }}" value="{{ old('custom_salary') }}">
                                </div>

                                <div class="col-md-12 mt-3">
                                    <label>Loại lương <span class="text-danger">*</span></label>
                                    <select name="salary_type" class="form-control select2 {{ $errors->has('salary_type') ? 'is-invalid' : '' }}">
                                        <option value="">Chọn</option>
                                        @foreach ($salaryTypes as $type)
                                            <option value="{{ $type->id }}" {{ old('salary_type') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Thuộc tính công việc --}}
                    <div class="card mt-3">
                        <div class="card-header">Thuộc tính công việc</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Kinh nghiệm <span class="text-danger">*</span></label>
                                    <select name="experience" class="form-control select2">
                                        <option value="">Chọn</option>
                                        @foreach ($experiences as $exp)
                                            <option value="{{ $exp->id }}" {{ old('experience') == $exp->id ? 'selected' : '' }}>{{ $exp->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label>Vai trò công việc <span class="text-danger">*</span></label>
                                    <select name="job_role" class="form-control select2">
                                        <option value="">Chọn</option>
                                        @foreach ($jobRoles as $role)
                                            <option value="{{ $role->id }}" {{ old('job_role') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label>Trình độ học vấn <span class="text-danger">*</span></label>
                                    <select name="education" class="form-control select2">
                                        <option value="">Chọn</option>
                                        @foreach ($educations as $edu)
                                            <option value="{{ $edu->id }}" {{ old('education') == $edu->id ? 'selected' : '' }}>{{ $edu->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label>Loại hình công việc <span class="text-danger">*</span></label>
                                    <select name="job_type" class="form-control select2">
                                        <option value="">Chọn</option>
                                        @foreach ($jobTypes as $type)
                                            <option value="{{ $type->id }}" {{ old('job_type') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <label>Thẻ (Tags)</label>
                                    <select name="tags[]" multiple class="form-control select2">
                                        @foreach ($tags as $tag)
                                            <option value="{{ $tag->id }}" {{ collect(old('tags'))->contains($tag->id) ? 'selected' : '' }}>{{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <label>Phúc lợi</label>
                                    <input type="text" name="benefits" class="form-control inputtags" value="{{ old('benefits') }}">
                                </div>

                                <div class="col-md-12 mt-3">
                                    <label>Kỹ năng yêu cầu</label>
                                    <select name="skills[]" multiple class="form-control select2">
                                        @foreach ($skills as $skill)
                                            <option value="{{ $skill->id }}" {{ collect(old('skills'))->contains($skill->id) ? 'selected' : '' }}>{{ $skill->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Cách nhận hồ sơ --}}
                    <div class="card mt-3">
                        <div class="card-header">Cách nhận hồ sơ</div>
                        <div class="card-body">
                            <label>Hình thức nhận hồ sơ <span class="text-danger">*</span></label>
                            <select name="receive_applications" class="form-control select2">
                                <option value="app" {{ old('receive_applications')=='app' ? 'selected' : '' }}>Trên nền tảng</option>
                                <option value="email" {{ old('receive_applications')=='email' ? 'selected' : '' }}>Qua email</option>
                                <option value="custom_url" {{ old('receive_applications')=='custom_url' ? 'selected' : '' }}>Qua liên kết tùy chỉnh</option>
                            </select>
                        </div>
                    </div>

                    {{-- Tùy chọn hiển thị --}}
                    <div class="card mt-3">
                        <div class="card-header">Tùy chọn hiển thị</div>
                        <div class="card-body d-flex">
                            <div class="form-check mr-3">
                                <input type="checkbox" id="featured" name="featured" value="1" {{ old('featured',1) ? 'checked' : '' }}>
                                <label for="featured">Nổi bật</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" id="highlight" name="highlight" value="1" {{ old('highlight') ? 'checked' : '' }}>
                                <label for="highlight">Đánh dấu</label>
                            </div>
                        </div>
                    </div>

                    {{-- Mô tả công việc --}}
                    <div class="card mt-3">
                        <div class="card-header">Mô tả công việc</div>
                        <div class="card-body">
                            <textarea id="editor" name="description" placeholder="Nhập mô tả chi tiết công việc...">{{ old('description') }}</textarea>
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

    function salaryModeChange(mode) {
        if(mode === 'salary_range') {
            $('.salary_range_part').removeClass('d-none');
            $('.custom_salary_part').addClass('d-none');
        } else {
            $('.salary_range_part').addClass('d-none');
            $('.custom_salary_part').removeClass('d-none');
        }
    }

    // Load states
    $('.country').on('change', function() {
        let country_id = $(this).val();
        $('.state').html('<option value="">Chọn</option>');
        $('.city').html('<option value="">Chọn</option>');

        if(!country_id) return;

        $.get('{{ url("admin/get-states") }}/'+country_id, function(states) {
            let html = '<option value="">Chọn</option>';
            $.each(states, function(_, state){
                html += `<option value="${state.id}">${state.name}</option>`;
            });
            $('.state').html(html);
        });
    });

    // Load cities
    $('.state').on('change', function() {
        let state_id = $(this).val();
        $('.city').html('<option value="">Chọn</option>');

        if(!state_id) return;

        $.get('{{ url("admin/get-cities") }}/'+state_id, function(cities) {
            let html = '<option value="">Chọn</option>';
            $.each(cities, function(_, city){
                html += `<option value="${city.id}">${city.name}</option>`;
            });
            $('.city').html(html);
        });
    });

    // Giữ giá trị cũ khi reload form
    $(document).ready(function() {
        let oldCountry = '{{ old("country") }}';
        let oldState = '{{ old("state") }}';
        let oldCity = '{{ old("city") }}';

        if(oldCountry) {
            $('.country').val(oldCountry).trigger('change');
            $.get('{{ url("admin/get-states") }}/'+oldCountry, function(states){
                let html = '<option value="">Chọn</option>';
                $.each(states, function(_, state){
                    html += `<option value="${state.id}" ${oldState==state.id?'selected':''}>${state.name}</option>`;
                });
                $('.state').html(html);

                if(oldState){
                    $.get('{{ url("admin/get-cities") }}/'+oldState, function(cities){
                        let htmlCity = '<option value="">Chọn</option>';
                        $.each(cities, function(_, city){
                            htmlCity += `<option value="${city.id}" ${oldCity==city.id?'selected':''}>${city.name}</option>`;
                        });
                        $('.city').html(htmlCity);
                    });
                }
            });
        }
    });
</script>
@endpush
