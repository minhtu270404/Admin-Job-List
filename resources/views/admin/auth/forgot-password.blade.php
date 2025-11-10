@extends('admin.auth.layouts.auth-master')

@section('contents')
<section class="section">
    <div class="container mt-5">
      <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
          <div class="login-brand">
            <img src="assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle">
          </div>

          <div class="alert alert-warning">
            Quên mật khẩu? Không sao cả. Chỉ cần cho chúng tôi biết địa chỉ email của bạn, chúng tôi sẽ gửi cho bạn một liên kết để đặt lại mật khẩu và tạo mật khẩu mới.
          </div>

          <div class="card card-primary">
            <div class="card-header"><h4>Quên mật khẩu?</h4></div>

            <div class="card-body">
            <!-- Trạng thái phiên -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

              <form method="POST" action="{{ route('admin.password.email') }}">
                @csrf

                <div class="form-group">
                  <label for="email">Địa chỉ Email</label>
                  <input id="email" type="email" value="{{ old('email') }}" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" tabindex="1" required autofocus>

                  <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                    Gửi liên kết đặt lại mật khẩu
                  </button>
                </div>
              </form>

            </div>
          </div>

          <div class="simple-footer">
            Bản quyền &copy; websolutionus {{ date('Y') }}
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
