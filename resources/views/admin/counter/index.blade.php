@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Phần Bộ Đếm (Counter Section)</h1>
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Cập Nhật Phần Bộ Đếm</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.counter.update', 1) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- Bộ đếm 1 --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Giá trị bộ đếm 1</label>
                                        <input type="text" class="form-control {{ hasError($errors, 'counter_one') }}" name="counter_one" value="{{ old('counter_one', $counter?->counter_one) }}">
                                        <x-input-error :messages="$errors->get('counter_one')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Tiêu đề 1</label>
                                        <input type="text" class="form-control {{ hasError($errors, 'title_one') }}" name="title_one" value="{{ old('title_one', $counter?->title_one) }}">
                                        <x-input-error :messages="$errors->get('title_one')" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            {{-- Bộ đếm 2 --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Giá trị bộ đếm 2</label>
                                        <input type="text" class="form-control {{ hasError($errors, 'counter_two') }}" name="counter_two" value="{{ old('counter_two', $counter?->counter_two) }}">
                                        <x-input-error :messages="$errors->get('counter_two')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Tiêu đề 2</label>
                                        <input type="text" class="form-control {{ hasError($errors, 'title_two') }}" name="title_two" value="{{ old('title_two', $counter?->title_two) }}">
                                        <x-input-error :messages="$errors->get('title_two')" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            {{-- Bộ đếm 3 --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Giá trị bộ đếm 3</label>
                                        <input type="text" class="form-control {{ hasError($errors, 'counter_three') }}" name="counter_three" value="{{ old('counter_three', $counter?->counter_three) }}">
                                        <x-input-error :messages="$errors->get('counter_three')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Tiêu đề 3</label>
                                        <input type="text" class="form-control {{ hasError($errors, 'title_three') }}" name="title_three" value="{{ old('title_three', $counter?->title_three) }}">
                                        <x-input-error :messages="$errors->get('title_three')" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            {{-- Bộ đếm 4 --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Giá trị bộ đếm 4</label>
                                        <input type="text" class="form-control {{ hasError($errors, 'counter_four') }}" name="counter_four" value="{{ old('counter_four', $counter?->counter_four) }}">
                                        <x-input-error :messages="$errors->get('counter_four')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Tiêu đề 4</label>
                                        <input type="text" class="form-control {{ hasError($errors, 'title_four') }}" name="title_four" value="{{ old('title_four', $counter?->title_four) }}">
                                        <x-input-error :messages="$errors->get('title_four')" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
