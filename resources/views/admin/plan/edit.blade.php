@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Gói giá</h1>
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Cập nhật gói</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.plans.update', $plan->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Nhãn gói (Label)</label>
                                        <input type="text" class="form-control {{ hasError($errors, 'label') }}" name="label" value="{{ old('label', $plan->label) }}">
                                        <x-input-error :messages="$errors->get('label')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Giá tiền</label>
                                        <input type="text" class="form-control {{ hasError($errors, 'price') }}" name="price" value="{{ old('price', $plan->price) }}">
                                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Giới hạn số tin tuyển dụng</label>
                                        <input type="text" class="form-control {{ hasError($errors, 'job_limit') }}" name="job_limit" value="{{ old('job_limit', $plan->job_limit) }}">
                                        <x-input-error :messages="$errors->get('job_limit')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Giới hạn tin nổi bật</label>
                                        <input type="text" class="form-control {{ hasError($errors, 'featured_job_limit') }}" name="featured_job_limit" value="{{ old('featured_job_limit', $plan->featured_job_limit) }}">
                                        <x-input-error :messages="$errors->get('featured_job_limit')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Giới hạn tin được làm nổi (Highlight)</label>
                                        <input type="text" class="form-control {{ hasError($errors, 'highlight_job_limit') }}" name="highlight_job_limit" value="{{ old('highlight_job_limit', $plan->highlight_job_limit) }}">
                                        <x-input-error :messages="$errors->get('highlight_job_limit')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Xác minh hồ sơ</label>
                                        <select name="profile_verified" class="form-control {{ hasError($errors, 'profile_verified') }}">
                                            <option @selected($plan->profile_verified === 0) value="0">Không</option>
                                            <option @selected($plan->profile_verified === 1) value="1">Có</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('profile_verified')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Đề xuất (Recommended)</label>
                                        <select name="recommended" class="form-control {{ hasError($errors, 'recommended') }}">
                                            <option @selected($plan->recommended === 0) value="0">Không</option>
                                            <option @selected($plan->recommended === 1) value="1">Có</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('recommended')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Hiển thị gói này trên trang ngoài (Frontend)</label>
                                        <select name="frontend_show" class="form-control {{ hasError($errors, 'frontend_show') }}">
                                            <option @selected($plan->frontend_show === 0) value="0">Không</option>
                                            <option @selected($plan->frontend_show === 1) value="1">Có</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('frontend_show')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Hiển thị gói này ở trang chủ</label>
                                        <select name="show_at_home" class="form-control {{ hasError($errors, 'show_at_home') }}">
                                            <option @selected($plan->show_at_home === 0) value="0">Không</option>
                                            <option @selected($plan->show_at_home === 1) value="1">Có</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('show_at_home')" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Cập nhật
                                </button>
                                <a href="{{ route('admin.plans.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Quay lại
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
