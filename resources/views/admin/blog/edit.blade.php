@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Bài viết</h1>
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Cập nhật bài viết</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <x-image-preview :height="200" :width="300" :source="$blog->image" />

                                <label for="">Hình ảnh</label>
                                <input type="file" class="form-control {{ hasError($errors, 'image') }}" name="image">
                                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            </div>

                            <div class="form-group">
                                <label for="">Tiêu đề</label>
                                <input type="text" class="form-control {{ hasError($errors, 'title') }}" name="title" value="{{ old('title', $blog->title) }}">
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <div class="form-group">
                                <label for="">Mô tả <span class="text-danger">*</span></label>
                                <textarea id="editor" name="description">{!! $blog->description !!}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Nổi bật</label>
                                        <select class="form-control {{ hasError($errors, 'featured') }}" name="featured">
                                            <option @selected($blog->featured == 0) value="0">Không</option>
                                            <option @selected($blog->featured == 1) value="1">Có</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('featured')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Trạng thái</label>
                                        <select class="form-control {{ hasError($errors, 'status') }}" name="status">
                                            <option @selected($blog->status == 1) value="1">Hoạt động</option>
                                            <option @selected($blog->status == 0) value="0">Không hoạt động</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
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
