@extends('admin.layouts.master')

@section('contents')
<section class="section">
    <div class="section-header">
        <h1>Chi tiết đơn hàng</h1>
    </div>

    <div class="section-body">
        <div class="row">
            {{-- Thông tin đơn hàng --}}
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body p-0">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th scope="row">Mã đơn hàng</th>
                                    <td>{{ $order->order_id }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Mã giao dịch</th>
                                    <td>{{ $order->transaction_id }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Ngày tạo</th>
                                    <td>{{ formatDate($order->created_at) }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Hành động</th>
                                    <td>
                                        <b>
                                            <a href="{{ route('admin.orders.invoice', $order->id) }}">
                                                Tải hóa đơn
                                            </a>
                                        </b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Thông tin thanh toán & công ty --}}
            <div class="col-md-4">
                <div class="card">
                    <h5 class="pl-4 pt-4">Thông tin thanh toán & công ty</h5>
                    <div class="card-body p-0">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th scope="row">Công ty</th>
                                    <td>{{ $order->company?->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Email</th>
                                    <td>{{ $order->company?->email }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Phương thức thanh toán</th>
                                    <td>{{ $order->payment_provider }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Thông tin gói dịch vụ --}}
            <div class="col-md-4">
                <div class="card">
                    <h5 class="pl-4 pt-4">Thông tin gói dịch vụ</h5>
                    <div class="card-body p-0">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th scope="row">Tên gói</th>
                                    <td>{{ $order->plan?->label }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Giá</th>
                                    <td>{{ $order->default_amount }}</td>
                                </tr>
                                <tr>
                                    <th scope="row"><b>Quyền lợi của gói</b></th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th scope="row">Giới hạn đăng tin tuyển dụng</th>
                                    <td>{{ $order->plan?->job_limit }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Giới hạn tin nổi bật</th>
                                    <td>{{ $order->plan?->featured_job_limit }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Giới hạn tin được đánh dấu</th>
                                    <td>{{ $order->plan?->highlight_job_limit }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Xác minh hồ sơ</th>
                                    <td>{{ $order->plan?->profile_verified ? 'Có' : 'Không' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
