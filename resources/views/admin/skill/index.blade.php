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
                                        <button type="submit" style="height: 40px;" class="btn btn-primary"><i class="fas fa-search"></i></button>
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
                                <tr>
                                    <th>Tên Kỹ Năng</th>
                                    <th>Đường Dẫn (Slug)</th>
                                    <th style="width: 10%">Hành Động</th>
                                </tr>
                                <tbody>
                                    @forelse ($skills as $skill)
                                        <tr>
                                            <td>{{ $skill->name }}</td>
                                            <td>{{ $skill->slug }}</td>
                                            <td>
                                                <a href="{{ route('admin.skills.edit', $skill->id) }}" class="btn-sm btn btn-primary" title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('admin.skills.destroy', $skill->id) }}" class="btn-sm btn btn-danger delete-item" title="Xóa">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
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
