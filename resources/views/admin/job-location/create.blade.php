@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Khu vực tuyển dụng</h1>
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Thêm địa điểm mới</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.job-location.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="">Hình ảnh</label>
                                        <input type="file"
                                            class="form-control {{ hasError($errors, 'image') }}"
                                            name="image">
                                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="">Quốc gia</label>
                                <select name="country"
                                        class="form-control select2 {{ hasError($errors, 'country') }}">
                                    <option value="">-- Chọn quốc gia --</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('country')" class="mt-2" />
                            </div>

                            <div class="form-group">
                                <label for="">Trạng thái</label>
                                <select name="status"
                                        class="form-control {{ hasError($errors, 'status') }}">
                                    <option value="">-- Chọn trạng thái --</option>
                                    <option value="featured">Nổi bật</option>
                                    <option value="trending">Xu hướng</option>
                                    <option value="hot">HOT</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
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
