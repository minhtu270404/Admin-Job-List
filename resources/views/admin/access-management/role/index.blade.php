@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Quản lý vai trò</h1>
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Danh sách vai trò</h4>
                        <div class="card-header-form">
                            <form action="{{ route('admin.role.index') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Tìm kiếm..." name="search" value="{{ request('search') }}">
                                    <div class="input-group-btn">
                                        <button type="submit" style="height: 40px;" class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <a href="{{ route('admin.role.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i> Thêm mới
                        </a>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <th>Tên vai trò</th>
                                    <th>Quyền hạn</th>
                                    <th style="width: 10%">Hành động</th>
                                </tr>
                                <tbody>
                                    @forelse ($roles as $role)
                                        <tr>
                                            <td>{{ $role->name }}</td>
                                            <td style="width: 70%">
                                                @foreach ($role->permissions as $permission)
                                                    <span class="badge bg-primary text-light m-1">{{ $permission->name }}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                @if ($role->name !== 'Super Admin')
                                                    <a href="{{ route('admin.role.edit', $role->id) }}" class="btn-sm btn btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('admin.role.destroy', $role->id) }}" class="btn-sm btn btn-danger delete-item">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">Không tìm thấy kết quả!</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <nav class="d-inline-block">
                            {{-- @if ($roles->hasPages())
                                {{ $roles->withQueryString()->links() }}
                            @endif --}}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
