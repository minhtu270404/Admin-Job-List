@extends('admin.layouts.master')

@section('contents')
<section class="section">
    <div class="section-header">
        <h1>Quản lý Công ty</h1>
    </div>

    <div class="section-body">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h4 class="mb-0">Danh sách công ty</h4>

                    <div class="d-flex align-items-center gap-2" style="gap: 10px;">
                        <form action="{{ route('admin.companies.index') }}" method="GET" class="d-flex">
                            <div class="input-group">
                                <input type="text"
                                       class="form-control"
                                       placeholder="Tìm kiếm theo tên, email, số điện thoại..."
                                       name="search"
                                       value="{{ request('search') }}"
                                       style="min-width: 220px; border-radius: 6px 0 0 6px;">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary" style="border-radius: 0 6px 6px 0;">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>

                        <a href="{{ route('admin.companies.create') }}" class="btn btn-success">
                            <i class="fas fa-plus-circle"></i> Thêm mới
                        </a>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên</th>
                                    <th>Email</th>
                                    <th>Điện thoại</th>
                                    <th>Ngành nghề</th>
                                    <th>Loại tổ chức</th>
                                    <th>Quy mô đội nhóm</th>
                                    <th>Địa chỉ</th>
                                    <th>Quốc gia</th>
                                    <th>Logo</th>
                                    <th style="width: 10%">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($companies as $company)
                                    <tr>
                                        <td>{{ $loop->iteration + ($companies->currentPage() - 1) * $companies->perPage() }}</td>
                                        <td>{{ $company->name }}</td>
                                        <td>{{ $company->email }}</td>
                                        <td>{{ $company->phone }}</td>
                                        <td>{{ $company->industryType?->name }}</td>
                                        <td>{{ $company->organizationType?->name }}</td>
                                        <td>{{ $company->teamSize?->name }}</td>
                                        <td>{{ $company->address }}</td>
                                        <td>{{ $company->Country?->name }}</td>
                                        <td>
                                            @if($company->logo)
                                                <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo" style="width:50px;height:50px;">
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.companies.edit', $company->id) }}"
                                               class="btn btn-sm btn-primary" title="Chỉnh sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.companies.destroy', $company->id) }}"
                                                  method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger" title="Xóa">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center text-muted">Không có công ty nào.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer text-right">
                    <nav class="d-inline-block">
                        {{ $companies->withQueryString()->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
