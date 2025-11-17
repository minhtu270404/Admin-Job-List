@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Cập nhật bài đăng tuyển dụng</h1>
        </div>

        <div class="section-body">
            @foreach ($errors->all() as $error)
                <div class="text-danger">{{ $error }}</div>
            @endforeach

            <div class="col-12">
                <div class="card-body">
                    <form action="{{ route('admin.jobs.update', $job->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Job Details --}}
                        <div class="card">
                            <div class="card-header">Thông tin công việc</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Tiêu đề công việc <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control {{ hasError($errors, 'title') }}"
                                            name="title" value="{{ old('title', $job->title) }}">
                                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label>Công ty <span class="text-danger">*</span></label>
                                        <select name="company"
                                            class="form-control select2 {{ hasError($errors, 'company') }}">
                                            <option value="">Chọn công ty</option>
                                            @foreach ($companies as $company)
                                                <option @selected($company->id === $job->company_id) value="{{ $company->id }}">
                                                    {{ $company->name }}</option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('company')" class="mt-2" />
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label>Danh mục <span class="text-danger">*</span></label>
                                        <select name="category"
                                            class="form-control select2 {{ hasError($errors, 'category') }}">
                                            <option value="">Chọn danh mục</option>
                                            @foreach ($categories as $category)
                                                <option @selected($category->id === $job->job_category_id)
                                                    value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label>Số lượng tuyển <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control {{ hasError($errors, 'vacancies') }}"
                                            name="vacancies" value="{{ old('vacancies', $job->vacancies) }}">
                                        <x-input-error :messages="$errors->get('vacancies')" class="mt-2" />
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label>Hạn nộp hồ sơ <span class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control datepicker {{ hasError($errors, 'deadline') }}"
                                            name="deadline" value="{{ old('deadline', $job->deadline) }}">
                                        <x-input-error :messages="$errors->get('deadline')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Location --}}
                        <div class="card mt-3">
                            <div class="card-header">Địa điểm làm việc</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Quốc gia</label>
                                        <select name="country"
                                            class="form-control select2 country {{ hasError($errors, 'country') }}">
                                            <option value="">Chọn quốc gia</option>
                                            @foreach ($countries as $country)
                                                <option @selected($country->id === $job->country_id) value="{{ $country->id }}">
                                                    {{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('country')" class="mt-2" />
                                    </div>

                                    <div class="col-md-4">
                                        <label>Tỉnh / Bang</label>
                                        <select name="state"
                                            class="form-control select2 state {{ hasError($errors, 'state') }}">
                                            <option value="">Chọn tỉnh / bang</option>
                                            @foreach ($states as $state)
                                                <option @selected($state->id === $job->state_id) value="{{ $state->id }}">
                                                    {{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('state')" class="mt-2" />
                                    </div>

                                    <div class="col-md-4">
                                        <label>Thành phố</label>
                                        <select name="city"
                                            class="form-control select2 city {{ hasError($errors, 'city') }}">
                                            <option value="">Chọn thành phố</option>
                                            @foreach ($cities as $city)
                                                <option @selected($city->id === $job->city_id) value="{{ $city->id }}">
                                                    {{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('city')" class="mt-2" />
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <label>Địa chỉ chi tiết</label>
                                        <input type="text" class="form-control {{ hasError($errors, 'address') }}"
                                            name="address" value="{{ old('address', $job->address) }}">
                                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Salary --}}
                        <div class="card mt-3">
                            <div class="card-header">Chi tiết mức lương</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 d-flex gap-3 mb-3">
                                        <div class="form-check">
                                            <input type="radio" name="salary_mode" id="salary_range" value="range"
                                                @checked($job->salary_mode === 'range')
                                                onclick="salaryModeChnage('salary_range')">
                                            <label for="salary_range">Khoảng lương</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="salary_mode" id="custom_salary" value="custom"
                                                @checked($job->salary_mode === 'custom')
                                                onclick="salaryModeChnage('custom_salary')">
                                            <label for="custom_salary">Lương cố định</label>
                                        </div>
                                    </div>

                                    <div
                                        class="col-md-12 salary_range_part @if($job->salary_mode === 'custom') d-none @endif">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Lương tối thiểu <span class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control {{ hasError($errors, 'min_salary') }}"
                                                    name="min_salary" value="{{ old('min_salary', $job->min_salary) }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Lương tối đa <span class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control {{ hasError($errors, 'max_salary') }}"
                                                    name="max_salary" value="{{ old('max_salary', $job->max_salary) }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="col-md-12 custom_salary_part @if($job->salary_mode === 'range') d-none @endif">
                                        <label>Lương cố định <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control {{ hasError($errors, 'custom_salary') }}"
                                            name="custom_salary" value="{{ old('custom_salary', $job->custom_salary) }}">
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <label>Loại lương <span class="text-danger">*</span></label>
                                        <select name="salary_type"
                                            class="form-control select2 {{ hasError($errors, 'salary_type') }}">
                                            <option value="">Chọn loại lương</option>
                                            @foreach ($salaryTypes as $salaryType)
                                                <option @selected($job->salary_type_id === $salaryType->id)
                                                    value="{{ $salaryType->id }}">{{ $salaryType->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Attributes --}}
                        <div class="card mt-3">
                            <div class="card-header">Thuộc tính công việc</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Kinh nghiệm <span class="text-danger">*</span></label>
                                        <select name="experience" class="form-control select2">
                                            <option value="">Chọn</option>
                                            @foreach ($experiences as $experience)
                                                <option @selected($experience->id === $job->job_experience_id)
                                                    value="{{ $experience->id }}">{{ $experience->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label>Vai trò công việc <span class="text-danger">*</span></label>
                                        <select name="job_role" class="form-control select2">
                                            <option value="">Chọn</option>
                                            @foreach ($jobRoles as $role)
                                                <option @selected($role->id === $job->job_role_id) value="{{ $role->id }}">
                                                    {{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label>Trình độ học vấn <span class="text-danger">*</span></label>
                                        <select name="education" class="form-control select2">
                                            <option value="">Chọn</option>
                                            @foreach ($educations as $education)
                                                <option @selected($education->id === $job->education_id)
                                                    value="{{ $education->id }}">{{ $education->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label>Loại hình công việc <span class="text-danger">*</span></label>
                                        <select name="job_type" class="form-control select2">
                                            <option value="">Chọn</option>
                                            @foreach ($jobTypes as $jobType)
                                                <option @selected($jobType->id === $job->job_type_id) value="{{ $jobType->id }}">
                                                    {{ $jobType->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <label>Thẻ (Tags)</label>
                                        @php
                                            $selectedTags = $job->tags()->pluck('tag_id')->toArray();
                                        @endphp
                                        <select name="tags[]" multiple class="form-control select2">
                                            @foreach ($tags as $tag)
                                                <option @selected(in_array($tag->id, $selectedTags)) value="{{ $tag->id }}">
                                                    {{ $tag->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <label>Phúc lợi</label>
                                        @php
                                            $benefitNames = $job->benefits()->with('benefit')->get()->pluck('benefit.name')->toArray();
                                        @endphp
                                        <input type="text" class="form-control inputtags" name="benefits"
                                            value="{{ old('benefits', implode(',', $benefitNames)) }}">
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <label>Kỹ năng yêu cầu</label>
                                        @php
                                            $selectedSkills = $job->skills()->pluck('skill_id')->toArray();
                                        @endphp
                                        <select name="skills[]" multiple class="form-control select2">
                                            @foreach ($skills as $skill)
                                                <option @selected(in_array($skill->id, $selectedSkills))
                                                    value="{{ $skill->id }}">{{ $skill->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Application Options --}}
                        <div class="card mt-3">
                            <div class="card-header">Cách nhận hồ sơ</div>
                            <div class="card-body">
                                <label>Hình thức nhận hồ sơ <span class="text-danger">*</span></label>
                                <select name="receive_applications" class="form-control select2">
                                    <option @selected($job->apply_on == 'app') value="app">Trên nền tảng</option>
                                    <option @selected($job->apply_on == 'email') value="email">Qua email</option>
                                    <option @selected($job->apply_on == 'custom_url') value="custom_url">Qua liên kết tùy
                                        chỉnh</option>
                                </select>
                            </div>
                        </div>

                        {{-- Promote --}}
                        <div class="card mt-3">
                            <div class="card-header">Tùy chọn hiển thị</div>
                            <div class="card-body d-flex gap-3">
                                <div class="form-check">
                                    <input type="checkbox" id="featured" name="featured" value="1" @checked($job->featured)>
                                    <label for="featured">Nổi bật</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" id="highlight" name="highlight" value="1"
                                        @checked($job->highlight)>
                                    <label for="highlight">Đánh dấu</label>
                                </div>
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="card mt-3">
                            <div class="card-header">Mô tả công việc</div>
                            <div class="card-body">
                                <textarea id="editor"
                                    name="description">{!! old('description', $job->description) !!}</textarea>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
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

        // Ajax Country -> State
        $('.country').on('change', function () {
            let country_id = $(this).val();
            $('.state, .city').html('<option value="">Chọn</option>');

            $.ajax({
                method: 'GET',
                url: '{{ route("admin.get-states", ":id") }}'.replace(':id', country_id),
                success: function (response) {
                    let html = '<option value="">Chọn</option>';
                    $.each(response, function (i, state) {
                        html += `<option value="${state.id}">${state.name}</option>`;
                    });
                    $('.state').html(html);
                }
            });
        });

        // Ajax State -> City
        $('.state').on('change', function () {
            let state_id = $(this).val();
            $('.city').html('<option value="">Chọn</option>');

            $.ajax({
                method: 'GET',
                url: '{{ route("admin.get-cities", ":id") }}'.replace(':id', state_id),
                success: function (response) {
                    let html = '<option value="">Chọn</option>';
                    $.each(response, function (i, city) {
                        html += `<option value="${city.id}">${city.name}</option>`;
                    });
                    $('.city').html(html);
                }
            });
        });
    </script>
@endpush