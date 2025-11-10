@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Bài viết</h1>
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tất cả bài viết</h4>
                        <div class="card-header-form">
                            <form action="{{ route('admin.blogs.index') }}" method="GET">
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
                        <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i> Thêm mới
                        </a>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <th>Tiêu đề</th>
                                    <th>Đường dẫn (slug)</th>
                                    <th>Nổi bật</th>
                                    <th>Trạng thái</th>
                                    <th style="width: 10%">Hành động</th>
                                </tr>
                                <tbody>
                                    @foreach ($blogs as $blog)
                                    <tr>
                                        <td>{{ $blog->title }}</td>
                                        <td>{{ $blog->slug }}</td>
                                        <td>
                                            @if ($blog->featured == 1)
                                                <span class="badge badge-success">Có</span>
                                            @else
                                                <span class="badge badge-danger">Không</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($blog->status == 1)
                                                <span class="badge badge-success">Hoạt động</span>
                                            @else
                                                <span class="badge badge-danger">Không hoạt động</span>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn-sm btn btn-primary" title="Chỉnh sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.blogs.destroy', $blog->id) }}" class="btn-sm btn btn-danger delete-item" title="Xóa">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <nav class="d-inline-block">
                            @if ($blogs->hasPages())
                                {{ $blogs->withQueryString()->links() }}
                            @endif
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
