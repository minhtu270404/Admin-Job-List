@extends('admin.layouts.master')

@section('contents')
<section class="section">
    <div class="section-header">
        <h1>Phần Giới Thiệu Thêm (Learn More)</h1>
    </div>

    <div class="section-body">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Cập nhật nội dung Learn More</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.learn-more.update', 1) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    @if($learn?->image)
                                        <img src="{{ asset('storage/' . $learn->image) }}" alt="Learn More" class="img-fluid mb-2" style="max-height:200px;">
                                    @endif

                                    <label>Hình ảnh</label>
                                    <input type="file" name="image" class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}">
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Tiêu đề nhỏ</label>
                            <input type="text" name="title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" value="{{ old('title', $learn?->title) }}">
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Tiêu đề chính</label>
                            <input type="text" name="main_title" class="form-control {{ $errors->has('main_title') ? 'is-invalid' : '' }}" value="{{ old('main_title', $learn?->main_title) }}">
                            @error('main_title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Tiêu đề phụ</label>
                            <input type="text" name="sub_title" class="form-control {{ $errors->has('sub_title') ? 'is-invalid' : '' }}" value="{{ old('sub_title', $learn?->sub_title) }}">
                            @error('sub_title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Đường dẫn "Tìm hiểu thêm"</label>
                            <input type="text" name="url" class="form-control {{ $errors->has('url') ? 'is-invalid' : '' }}" value="{{ old('url', $learn?->url) }}">
                            @error('url')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
