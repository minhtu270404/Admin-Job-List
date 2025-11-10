@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Kinh nghiệm làm việc</h1>
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Danh sách kinh nghiệm</h4>
                        <div class="card-header-form">
                            <form action="{{ route('admin.job-experiences.index') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Tìm kiếm..." name="search" value="{{ request('search') }}">
                                    <div class="input-group-btn">
                                        <button type="submit" style="height: 40px;" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <a href="{{ route('admin.job-experiences.create') }}" class="btn btn-primary"> 
                            <i class="fas fa-plus-circle"></i> Thêm mới
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <th>Tên kinh nghiệm</th>
                                    <th>Slug</th>
                                    <th style="width: 10%">Thao tác</th>
                                </tr>
                                <tbody>
                                    @forelse ($jobExperiences as $experience)
                                        <tr>
                                            <td>{{ $experience->name }}</td>
                                            <td>{{ $experience->slug }}</td>
                                            <td>
                                                <a href="{{ route('admin.job-experiences.edit', $experience->id) }}" class="btn-sm btn btn-primary"><i class="fas fa-edit"></i></a>
                                                <a href="{{ route('admin.job-experiences.destroy', $experience->id) }}" class="btn-sm btn btn-danger delete-item"><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">Không tìm thấy kết quả!</td>
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
