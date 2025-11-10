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
                        <h4>Thêm kinh nghiệm làm việc</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.job-experiences.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="">Tên kinh nghiệm</label>
                                <input type="text" class="form-control {{ hasError($errors, 'name') }}" name="name" value="{{ old('name') }}">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Thêm mới</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
