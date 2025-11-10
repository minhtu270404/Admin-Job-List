<div class="tab-pane fade show active" id="home4" role="tabpanel" aria-labelledby="home-tab4">
    <div class="card">
        <form action="{{ route('admin.general-settings.update') }}" method="POST">
            @csrf
            <div class="row">

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Tên Website</label>
                        <input type="text" class="form-control {{ hasError($errors, 'site_name') }}" name="site_name"  value="{{ config('settings.site_name') }}">
                        <x-input-error :messages="$errors->get('site_name')" class="mt-2" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Email Liên Hệ</label>
                        <input type="text" class="form-control {{ hasError($errors, 'site_email') }}" name="site_email"  value="{{ config('settings.site_email') }}">
                        <x-input-error :messages="$errors->get('site_email')" class="mt-2" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Số Điện Thoại</label>
                        <input type="text" class="form-control {{ hasError($errors, 'site_phone') }}" name="site_phone"  value="{{ config('settings.site_phone') }}">
                        <x-input-error :messages="$errors->get('site_phone')" class="mt-2" />
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Bản Đồ Website</label>
                        <input type="text" class="form-control {{ hasError($errors, 'site_map') }}" name="site_map"  value="{{ config('settings.site_map') }}">
                        <x-input-error :messages="$errors->get('site_map')" class="mt-2" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Đơn Vị Tiền Tệ Mặc Định</label>
                        <select name="site_default_currency" class="form-control select2 {{ hasError($errors, 'site_default_currency') }}">
                            <option value="">Chọn</option>
                            @foreach (config('currencies.currency_list') as $key => $currency)
                                <option @selected($currency === config('settings.site_default_currency')) value="{{ $currency }}">{{ $currency }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('site_default_currency')" class="mt-2" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Biểu Tượng Tiền Tệ</label>
                        <input type="text" class="form-control {{ hasError($errors, 'site_currency_icon') }}" name="site_currency_icon"  value="{{ config('settings.site_currency_icon') }}">
                        <x-input-error :messages="$errors->get('site_currency_icon')" class="mt-2" />
                    </div>
                </div>

            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Cập Nhật</button>
            </div>
        </form>
    </div>
</div>
