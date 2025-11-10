@extends('admin.layouts.master')

@section('contents')
<section class="section">
    <div class="section-header">
        <h1>Trình độ học vấn</h1>
    </div>

    <div class="section-body">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between w-100">
                    <h4>Danh sách trình độ học vấn</h4>
                    <a href="{{ route('admin.educations.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Thêm mới
                    </a>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Tên trình độ</th>
                                    <th>Slug</th>
                                    <th class="text-center" style="width: 10%">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($educations as $education)
                                    <tr>
                                        <td>{{ $education->name }}</td>
                                        <td>{{ $education->slug }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.educations.edit', $education->id) }}" class="btn btn-sm btn-primary" title="Chỉnh sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.educations.destroy', $education->id) }}" class="btn btn-sm btn-danger delete-item" title="Xóa">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Không có dữ liệu nào!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($educations->hasPages())
                    <div class="card-footer text-right">
                        <nav class="d-inline-block">
                            {{ $educations->withQueryString()->links() }}
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
