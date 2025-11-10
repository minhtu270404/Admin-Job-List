@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Biểu Tượng Mạng Xã Hội</h1>
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tất Cả Biểu Tượng</h4>
                        <div class="card-header-form"></div>
                        <a href="{{ route('admin.social-icon.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i> Thêm Mới
                        </a>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <th>Biểu Tượng</th>
                                    <th>Đường Dẫn (URL)</th>
                                    <th style="width: 10%">Hành Động</th>
                                </tr>
                                <tbody>
                                    @forelse ($icons as $icon)
                                        <tr>
                                            <td><i style="font-size: 40px" class="{{ $icon->icon }}"></i></td>
                                            <td>{{ $icon->url }}</td>
                                            <td>
                                                <a href="{{ route('admin.social-icon.edit', $icon->id) }}" class="btn-sm btn btn-primary" title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('admin.social-icon.destroy', $icon->id) }}" class="btn-sm btn btn-danger delete-item" title="Xóa">
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
                            @if ($icons->hasPages())
                                {{ $icons->withQueryString()->links() }}
                            @endif
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
