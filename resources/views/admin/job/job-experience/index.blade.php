@extends('admin.layouts.master')

@section('contents')
<section class="section">
    <div class="section-header">
        <h1>Kinh Nghiệm Làm Việc</h1>
    </div>

    <div class="section-body">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Danh Sách Kinh Nghiệm</h4>
                    <div class="card-header-form">
                        <form action="{{ route('admin.job-experiences.index') }}" method="GET">
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
                    <a href="{{ route('admin.job-experiences.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Thêm Mới
                    </a>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tên Kinh Nghiệm</th>
                                    <th>Slug</th>
                                    <th style="width: 15%">Hành Động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($jobExperiences as $experience)
                                <tr>
                                    <td>{{ $experience->name }}</td>
                                    <td>{{ $experience->slug }}</td>
                                    <td>
                                        <a href="{{ route('admin.job-experiences.edit', $experience->id) }}" class="btn btn-sm btn-primary" title="Chỉnh sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('admin.job-experiences.destroy', $experience->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')">
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
                        @if ($jobExperiences->hasPages())
                            {{ $jobExperiences->withQueryString()->links() }}
                        @endif
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
