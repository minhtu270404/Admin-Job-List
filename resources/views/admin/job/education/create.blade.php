@extends('admin.layouts.master')

@section('contents')
<section class="section">
    <div class="section-header">
        <h1>Trình độ học vấn</h1>
    </div>

    <div class="section-body">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Thêm trình độ học vấn</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.educations.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Tên trình độ <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                class="form-control {{ hasError($errors, 'name') }}" 
                                name="name" 
                                value="{{ old('name') }}" 
                                placeholder="Nhập tên trình độ học vấn...">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
