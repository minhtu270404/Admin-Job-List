@extends('admin.layouts.master')

@section('contents')
<section class="section">
    <div class="section-header">
        <h1>Cài đặt cổng thanh toán</h1>
    </div>

    <div class="section-body">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                  <h4>Tất cả cổng thanh toán</h4>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-12 col-sm-12 col-md-2">
                      <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="home-tab4" data-toggle="tab" href="#home4" role="tab" aria-controls="home" aria-selected="true">Paypal</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="profile-tab4" data-toggle="tab" href="#profile4" role="tab" aria-controls="profile" aria-selected="false">Stripe</a>
                        </li>
                       
                      </ul>
                    </div>
                    <div class="col-12 col-sm-12 col-md-10">
                      <div class="tab-content no-padding" id="myTab2Content">

                        @include('admin.payment-setting.sections.paypal-section')
                        @include('admin.payment-setting.sections.stripe-section')

                      </div>
                    </div>
                  </div>
                </div>
              </div>
        </div>
    </div>
</section>
@endsection
