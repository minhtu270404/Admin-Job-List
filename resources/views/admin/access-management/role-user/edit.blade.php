@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Người dùng & Vai trò</h1>
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Cập nhật người dùng</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.role-user.update', $admin->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="">Họ và tên</label>
                                <input type="text" class="form-control {{ hasError($errors, 'name') }}" 
                                       name="name"
                                       value="{{ old('name', $admin->name) }}"
                                       placeholder="Nhập họ và tên">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="text" class="form-control {{ hasError($errors, 'email') }}" 
                                       name="email"
                                       value="{{ old('email', $admin->email) }}"
                                       placeholder="Nhập địa chỉ email">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div class="form-group">
                                <label for="">Mật khẩu</label>
                                <input type="password" class="form-control {{ hasError($errors, 'password') }}" 
                                       name="password"
                                       placeholder="Nhập mật khẩu mới (nếu muốn đổi)">
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div class="form-group">
                                <label for="">Xác nhận mật khẩu</label>
                                <input type="password" class="form-control {{ hasError($errors, 'password_confirmation') }}" 
                                       name="password_confirmation"
                                       placeholder="Nhập lại mật khẩu mới">
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>

                            <div class="form-group">
                                <label for="">Vai trò</label>
                                <select name="role" id="" class="form-control">
                                    <option value="">Chọn vai trò</option>
                                    @foreach ($roles as $role)
                                        <option @selected($role->name == $admin->getRoleNames()->first()) 
                                                value="{{ $role->name }}">
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('role')" class="mt-2" />
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
