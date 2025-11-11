@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Quản lý vai trò</h1>
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h4 class="mb-0">Danh sách vai trò</h4>

                        <div class="d-flex align-items-center flex-wrap gap-2">
                            {{-- Ô tìm kiếm --}}
                            <form action="{{ route('admin.role.index') }}" method="GET" class="d-flex">
                                <div class="input-group">
                                    <input type="text"
                                           class="form-control"
                                           name="search"
                                           placeholder="Nhập tên vai trò..."
                                           value="{{ request('search') }}"
                                           style="min-width: 220px; border-radius: 6px 0 0 6px;">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary" style="border-radius: 0 6px 6px 0;">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>

                            {{-- Nút thêm mới --}}
                            <a href="{{ route('admin.role.create') }}" class="btn btn-success">
                                <i class="fas fa-plus-circle"></i> Thêm mới
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Tên vai trò</th>
                                        <th>Quyền hạn</th>
                                        <th style="width: 10%">Hành động</th>
                                    </tr>
                                </thead>
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
                                                    <a href="{{ route('admin.role.edit', $role->id) }}"
                                                       class="btn-sm btn btn-primary" title="Chỉnh sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('admin.role.destroy', $role->id) }}"
                                                       class="btn-sm btn btn-danger delete-item" title="Xóa">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">Không tìm thấy kết quả!</td>
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
