@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Chỉnh sửa công ty</h1>
        </div>

        <div class="section-body">
            <form action="{{ route('admin.companies.update', $company->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-body">

                        <div class="form-group">
                            <label>Tên công ty</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $company->name) }}">
                            @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="form-group">
                            <label>Người dùng</label>
                            <select name="user_id" class="form-control">
                                @foreach(\App\Models\User::all() as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id', $company->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="form-group">
                            <label>Ngành</label>
                            <select name="industry_type_id" class="form-control">
                                <option value="">-- Chọn ngành --</option>
                                @foreach($industries as $industry)
                                    <option value="{{ $industry->id }}" {{ old('industry_type_id', $company->industry_type_id) == $industry->id ? 'selected' : '' }}>{{ $industry->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Loại tổ chức</label>
                            <select name="organization_type_id" class="form-control">
                                <option value="">-- Chọn loại tổ chức --</option>
                                @foreach($organizations as $org)
                                    <option value="{{ $org->id }}" {{ old('organization_type_id', $company->organization_type_id) == $org->id ? 'selected' : '' }}>{{ $org->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Team Size</label>
                            <select name="team_size_id" class="form-control">
                                <option value="">-- Chọn team size --</option>
                                @foreach($teamSizes as $size)
                                    <option value="{{ $size->id }}" {{ old('team_size_id', $company->team_size_id) == $size->id ? 'selected' : '' }}>{{ $size->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $company->email) }}">
                            @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control"
                                value="{{ old('phone', $company->phone) }}">
                            @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="form-group">
                            <label>Website</label>
                            <input type="text" name="website" class="form-control"
                                value="{{ old('website', $company->website) }}">
                            @error('website')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="form-group">
                            <label>Quốc gia</label>
                            <select name="country" class="form-control">
                                <option value="">-- Chọn quốc gia --</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" {{ old('country', $company->country) == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Tỉnh/Thành phố</label>
                            <select name="state" class="form-control">
                                <option value="">-- Chọn --</option>
                                @foreach($states as $state)
                                    <option value="{{ $state->id }}" {{ old('state', $company->state) == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Quận/Huyện</label>
                            <select name="city" class="form-control">
                                <option value="">-- Chọn --</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" {{ old('city', $company->city) == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Địa chỉ</label>
                            <input type="text" name="address" class="form-control"
                                value="{{ old('address', $company->address) }}">
                        </div>

                        <div class="form-group">
                            <label>Logo</label>
                            @if($company->logo)
                                <div class="mb-2"><img src="{{ asset($company->logo) }}" alt="logo" width="100"></div>
                            @endif
                            <input type="file" name="logo" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Banner</label>
                            @if($company->banner)
                                <div class="mb-2"><img src="{{ asset($company->banner) }}" alt="banner" width="150"></div>
                            @endif
                            <input type="file" name="banner" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Ngày thành lập</label>
                            <input type="date" name="establishment_date" class="form-control"
                                value="{{ old('establishment_date', $company->establishment_date?->format('Y-m-d')) }}">
                        </div>

                        <div class="form-group">
                            <label>Bio</label>
                            <textarea name="bio" class="form-control"
                                style="min-height:100px; resize: vertical;">{{ old('bio', $company->bio) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Vision</label>
                            <textarea name="vision" class="form-control"
                                style="min-height:100px; resize: vertical;">{{ old('vision', $company->vision) }}</textarea>
                        </div>


                        <div class="form-group">
                            <label>Map link</label>
                            <input type="text" name="map_link" class="form-control"
                                value="{{ old('map_link', $company->map_link) }}">
                        </div>

                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('admin.companies.index') }}" class="btn btn-secondary">Hủy</a>
                        <button type="submit" class="btn btn-success">Cập nhật</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection