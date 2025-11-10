@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Biểu Tượng Mạng Xã Hội</h1>
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Thêm Biểu Tượng Mạng Xã Hội</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.social-icon.store') }}" method="POST">
                            @csrf
                            
                            <div class="form-group">
                                <label for="">Biểu Tượng</label>
                                <div role="iconpicker" data-align="left" name="icon" class="{{ hasError($errors, 'icon') }}"></div>
                                <x-input-error :messages="$errors->get('icon')" class="mt-2" />
                            </div>

                            <div class="form-group">
                                <label for="">Đường Dẫn (URL)</label>
                                <input type="text" class="form-control {{ hasError($errors, 'url') }}" name="url" value="{{ old('url') }}">
                                <x-input-error :messages="$errors->get('url')" class="mt-2" />
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Thêm Mới</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
