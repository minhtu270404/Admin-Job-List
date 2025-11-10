@extends('admin.layouts.master')

@section('contents')
<section class="section">
    <div class="section-header">
        <h1>Nghề Nghiệp</h1>
    </div>

    <div class="section-body">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Cập Nhật Nghề Nghiệp</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.professions.update', $profession->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="">Tên Nghề Nghiệp</label>
                            <input type="text" class="form-control {{ hasError($errors, 'name') }}" name="name" value="{{ old('name', $profession->name) }}">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Cập Nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
