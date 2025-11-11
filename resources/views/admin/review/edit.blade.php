@extends('admin.layouts.master')

@section('contents')
<section class="section">
    <div class="section-header">
        <h1>Đánh Giá</h1>
    </div>

    <div class="section-body">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Cập Nhật Đánh Giá</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.reviews.update', $review->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Hình ảnh --}}
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <x-image-preview :height="200" :width="300" :source="$review->image" />
                                    <label for="image">Hình Ảnh</label>
                                    <input type="file" id="image" class="form-control {{ hasError($errors, 'image') }}" name="image">
                                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        {{-- Tên --}}
                        <div class="form-group">
                            <label for="name">Tên</label>
                            <input type="text" id="name" class="form-control {{ hasError($errors, 'name') }}" name="name" value="{{ old('name', $review->name) }}">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- Tiêu đề --}}
                        <div class="form-group">
                            <label for="title">Tiêu Đề</label>
                            <input type="text" id="title" class="form-control {{ hasError($errors, 'title') }}" name="title" value="{{ old('title', $review->title) }}">
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        {{-- Nội dung --}}
                        <div class="form-group">
                            <label for="review">Nội Dung Đánh Giá</label>
                            <textarea id="review" name="review" class="form-control {{ hasError($errors, 'review') }}" rows="5">{{ old('review', $review->review) }}</textarea>
                            <x-input-error :messages="$errors->get('review')" class="mt-2" />
                        </div>

                        {{-- Rating --}}
                        <div class="form-group">
                            <label for="rating">Đánh Giá (Rating)</label>
                            <input type="number" id="rating" min="1" max="5" class="form-control {{ hasError($errors, 'rating') }}" name="rating" value="{{ old('rating', $review->rating) }}">
                            <x-input-error :messages="$errors->get('rating')" class="mt-2" />
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
