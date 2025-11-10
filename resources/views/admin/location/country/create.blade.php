@extends('admin.layouts.master')

@section('contents')
<section class="section">
    <div class="section-header">
        <h1>Quốc gia</h1>
    </div>

    <div class="section-body">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Thêm quốc gia mới</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.countries.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">Tên quốc gia</label>
                            <input type="text" class="form-control {{ hasError($errors, 'name') }}" name="name" value="{{ old('name') }}" placeholder="Nhập tên quốc gia...">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                            <a href="{{ route('admin.countries.index') }}" class="btn btn-secondary">Quay lại</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
