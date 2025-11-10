@extends('admin.layouts.master')

@section('contents')
<section class="section">
    <div class="section-header">
        <h1>Trình tạo trang (Page Builder)</h1>
    </div>

    <div class="section-body">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Tất cả các trang</h4>

                    <div class="card-header-form">
                        <form action="{{ route('admin.page-builder.index') }}" method="GET">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Tìm kiếm..." name="search" value="{{ request('search') }}">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-primary" style="height: 40px;">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <a href="{{ route('admin.page-builder.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Thêm mới
                    </a>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <th>Tên trang</th>
                                <th>Đường dẫn</th>
                                <th style="width: 10%">Thao tác</th>
                            </tr>
                            <tbody>
                                @forelse ($pages as $page)
                                    <tr>
                                        <td>{{ $page->page_name }}</td>
                                        <td><code>/page/{{ $page->slug }}</code></td>
                                        <td>
                                            <a href="{{ route('admin.page-builder.edit', $page->id) }}" class="btn-sm btn btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.page-builder.destroy', $page->id) }}" class="btn-sm btn btn-danger delete-item">
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

            </div>
        </div>
    </div>
</section>
@endsection
