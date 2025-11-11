@extends('admin.layouts.master')

@section('contents')
<section class="section">
    <div class="section-header">
        <h1>Kỹ Năng</h1>
    </div>

    <div class="section-body">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Danh Sách Kỹ Năng</h4>
                    <div class="card-header-form">
                        <form action="{{ route('admin.skills.index') }}" method="GET">
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
                    <a href="{{ route('admin.skills.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Thêm Mới
                    </a>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tên Kỹ Năng</th>
                                    <th>Đường Dẫn (Slug)</th>
                                    <th style="width: 15%">Hành Động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($skills as $skill)
                                <tr>
                                    <td>{{ $skill->name }}</td>
                                    <td>{{ $skill->slug }}</td>
                                    <td>
                                        <a href="{{ route('admin.skills.edit', $skill->id) }}" class="btn-sm btn btn-primary" title="Chỉnh sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- Form DELETE chuẩn Laravel -->
                                        <form action="{{ route('admin.skills.destroy', $skill->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa kỹ năng này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-sm btn btn-danger" title="Xóa">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">Không có kết quả nào!</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer text-right">
                    <nav class="d-inline-block">
                        @if ($skills->hasPages())
                            {{ $skills->withQueryString()->links() }}
                        @endif
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
