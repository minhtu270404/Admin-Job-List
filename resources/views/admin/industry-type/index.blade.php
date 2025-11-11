@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Ngành nghề</h1>
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h4 class="mb-0">Tất cả ngành nghề</h4>

                        <div class="d-flex align-items-center gap-2" style="gap: 10px;">
                            <form action="{{ route('admin.industry-types.index') }}" method="GET" class="d-flex">
                                <div class="input-group">
                                    <input type="text"
                                           class="form-control"
                                           placeholder="Nhập tên ngành nghề..."
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

                            <a href="{{ route('admin.industry-types.create') }}" class="btn btn-success">
                                <i class="fas fa-plus-circle"></i> Thêm mới
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Tên ngành nghề</th>
                                        <th>Đường dẫn (Slug)</th>
                                        <th style="width: 10%">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($industryTypes as $type)
                                        <tr>
                                            <td>{{ $type->name }}</td>
                                            <td>{{ $type->slug }}</td>
                                            <td>
                                                <a href="{{ route('admin.industry-types.edit', $type->id) }}"
                                                   class="btn-sm btn btn-primary" title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('admin.industry-types.destroy', $type->id) }}"
                                                   class="btn-sm btn btn-danger delete-item" title="Xóa">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
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
                            @if ($industryTypes->hasPages())
                                {{ $industryTypes->withQueryString()->links() }}
                            @endif
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
