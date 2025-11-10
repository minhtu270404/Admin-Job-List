@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Lý Do Chọn Chúng Tôi</h1>
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Cập Nhật Lý Do Chọn Chúng Tôi</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.why-choose-us.update', 1) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Mục 1 --}}
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="">Biểu Tượng 1</label>
                                        <div role="iconpicker" data-icon="{{ $whyChooseUs?->icon_one }}" data-align="left" name="icon_one" class="{{ hasError($errors, 'icon_one') }}"></div>
                                        <x-input-error :messages="$errors->get('icon_one')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="col-md-10">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Tiêu Đề 1</label>
                                            <input type="text" class="form-control {{ hasError($errors, 'title_one') }}" name="title_one" value="{{ old('title_one', $whyChooseUs?->title_one) }}">
                                            <x-input-error :messages="$errors->get('title_one')" class="mt-2" />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Phụ Đề 1</label>
                                            <input type="text" class="form-control {{ hasError($errors, 'sub_title_one') }}" name="sub_title_one" value="{{ old('sub_title_one', $whyChooseUs?->sub_title_one) }}">
                                            <x-input-error :messages="$errors->get('sub_title_one')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            {{-- Mục 2 --}}
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="">Biểu Tượng 2</label>
                                        <div role="iconpicker" data-icon="{{ $whyChooseUs?->icon_two }}" data-align="left" name="icon_two" class="{{ hasError($errors, 'icon_two') }}"></div>
                                        <x-input-error :messages="$errors->get('icon_two')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="col-md-10">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Tiêu Đề 2</label>
                                            <input type="text" class="form-control {{ hasError($errors, 'title_two') }}" name="title_two" value="{{ old('title_two', $whyChooseUs?->title_two) }}">
                                            <x-input-error :messages="$errors->get('title_two')" class="mt-2" />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Phụ Đề 2</label>
                                            <input type="text" class="form-control {{ hasError($errors, 'sub_title_two') }}" name="sub_title_two" value="{{ old('sub_title_two', $whyChooseUs?->sub_title_two) }}">
                                            <x-input-error :messages="$errors->get('sub_title_two')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            {{-- Mục 3 --}}
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="">Biểu Tượng 3</label>
                                        <div role="iconpicker" data-icon="{{ $whyChooseUs?->icon_three }}" data-align="left" name="icon_three" class="{{ hasError($errors, 'icon_three') }}"></div>
                                        <x-input-error :messages="$errors->get('icon_three')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="col-md-10">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Tiêu Đề 3</label>
                                            <input type="text" class="form-control {{ hasError($errors, 'title_three') }}" name="title_three" value="{{ old('title_three', $whyChooseUs?->title_three) }}">
                                            <x-input-error :messages="$errors->get('title_three')" class="mt-2" />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Phụ Đề 3</label>
                                            <input type="text" class="form-control {{ hasError($errors, 'sub_title_three') }}" name="sub_title_three" value="{{ old('sub_title_three', $whyChooseUs?->sub_title_three) }}">
                                            <x-input-error :messages="$errors->get('sub_title_three')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary">Cập Nhật</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
