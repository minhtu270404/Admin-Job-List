@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Danh mục công việc</h1>
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h4>Danh sách danh mục công việc</h4>

                        <div class="card-header-form">
                            <form action="{{ route('admin.job-categories.index') }}" method="GET">
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

                        <a href="{{ route('admin.job-categories.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i> Thêm mới
                        </a>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Biểu tượng</th>
                                        <th>Tên danh mục</th>
                                        <th>Hiển thị trong mục phổ biến</th>
                                        <th>Hiển thị trong mục nổi bật</th>
                                        <th style="width: 10%">Hành động</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td><i style="font-size:40px" class="{{ $category->icon }}"></i></td>
                                            <td>{{ $category->name }}</td>

                                            <td>
                                                @if ($category->show_at_popular === 1)
                                                    <span class="badge badge-success">Có</span>
                                                @else
                                                    <span class="badge badge-danger">Không</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($category->show_at_featured === 1)
                                                    <span class="badge badge-success">Có</span>
                                                @else
                                                    <span class="badge badge-danger">Không</span>
                                                @endif
                                            </td>

                                            <td>
                                                <a href="{{ route('admin.job-categories.edit', $category->id) }}" class="btn-sm btn btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('admin.job-categories.destroy', $category->id) }}" class="btn-sm btn btn-danger delete-item">
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
                            @if ($categories->hasPages())
                                {{ $categories->withQueryString()->links() }}
                            @endif
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
