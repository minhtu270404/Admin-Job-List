@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Vai trò và Quyền hạn</h1>
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Thêm vai trò mới</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.role.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="">Tên vai trò</label>
                                <input type="text" class="form-control {{ hasError($errors, 'name') }}" name="name"
                                    value="{{ old('name') }}">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            @foreach ($permissions as $groupname => $permission)
                                <div class="form-group">
                                    <h5 class="">{{ $groupname }}</h5>
                                    <div class="row">
                                        @foreach ($permission as $item)
                                            <div class="col-md-2">
                                                <label class="custom-switch mt-2">
                                                    <input type="checkbox" name="permissions[]"
                                                        class="custom-switch-input" value="{{ $item->name }}">
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description">{{ $item->name }}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <hr>
                            @endforeach

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Tạo mới</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
