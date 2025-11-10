@extends('admin.layouts.master')

@section('contents')
<section class="section">
    <div class="section-header">
        <h1>Thành phố</h1>
    </div>

    <div class="section-body">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Danh sách thành phố</h4>
                    <div class="card-header-form">
                        <form action="{{ route('admin.cities.index') }}" method="GET">
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
                    <a href="{{ route('admin.cities.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Thêm mới
                    </a>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <th>Tên thành phố</th>
                                <th>Tỉnh / Bang</th>
                                <th>Quốc gia</th>
                                <th style="width: 10%">Hành động</th>
                            </tr>
                            <tbody>
                                @forelse ($cities as $city)
                                <tr>
                                    <td>{{ $city->name }}</td>
                                    <td>{{ $city->state?->name }}</td>
                                    <td>{{ $city->country?->name }}</td>
                                    <td>
                                        <a href="{{ route('admin.cities.edit', $city->id) }}" class="btn-sm btn btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.cities.destroy', $city->id) }}" class="btn-sm btn btn-danger delete-item">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Không có kết quả nào!</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer text-right">
                    <nav class="d-inline-block">
                        @if ($cities->hasPages())
                            {{ $cities->withQueryString()->links() }}
                        @endif
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
