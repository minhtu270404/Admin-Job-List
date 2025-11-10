@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Danh mục công việc</h1>
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Thêm danh mục công việc</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.job-categories.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="">Biểu tượng (Icon)</label>
                                <div role="iconpicker" data-align="left" name="icon" class="{{ hasError($errors, 'icon') }}"></div>
                                <x-input-error :messages="$errors->get('icon')" class="mt-2" />
                            </div>

                            <div class="form-group">
                                <label for="">Tên danh mục</label>
                                <input type="text" class="form-control {{ hasError($errors, 'name') }}" name="name" value="{{ old('name') }}">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div class="form-group">
                                <label for="">Hiển thị trong mục phổ biến</label>
                                <select name="show_at_popular" class="form-control {{ hasError($errors, 'show_at_popular') }}">
                                    <option value="0">Không</option>
                                    <option value="1">Có</option>
                                </select>
                                <x-input-error :messages="$errors->get('show_at_popular')" class="mt-2" />
                            </div>

                            <div class="form-group">
                                <label for="">Hiển thị trong mục nổi bật</label>
                                <select name="show_at_featured" class="form-control {{ hasError($errors, 'show_at_featured') }}">
                                    <option value="0">Không</option>
                                    <option value="1">Có</option>
                                </select>
                                <x-input-error :messages="$errors->get('show_at_featured')" class="mt-2" />
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
