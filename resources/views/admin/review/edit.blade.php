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
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <x-image-preview :height="200" :width="300" :source="$review->image" />
                                    <label for="">Hình Ảnh</label>
                                    <input type="file" class="form-control {{ hasError($errors, 'image') }}" name="image">
                                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Tên</label>
                            <input type="text" class="form-control {{ hasError($errors, 'name') }}" name="name" value="{{ old('name', $review->name) }}">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="form-group">
                            <label for="">Tiêu Đề</label>
                            <input type="text" class="form-control {{ hasError($errors, 'title') }}" name="title" value="{{ old('title', $review->title) }}">
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="form-group">
                            <label for="">Nội Dung Đánh Giá</label>
                            <textarea name="review" class="form-control {{ hasError($errors, 'review') }}">{{ $review->review }}</textarea>
                            <
