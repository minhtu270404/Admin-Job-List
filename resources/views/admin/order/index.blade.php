@extends('admin.layouts.master')

@section('contents')
<section class="section">
    <div class="section-header">
        <h1>Đơn hàng</h1>
    </div>

    <div class="section-body">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Danh sách đơn hàng</h4>
                    <div class="card-header-form">
                        <form action="{{ route('admin.orders.index') }}" method="GET">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Tìm kiếm..." name="search"
                                    value="{{ request('search') }}">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-primary" style="height: 40px;">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Mã đơn / Giao dịch</th>
                                    <th>Công ty</th>
                                    <th>Gói dịch vụ</th>
                                    <th>Số tiền thanh toán</th>
                                    <th>Giá gốc</th>
                                    <th>Phương thức thanh toán</th>
                                    <th>Trạng thái thanh toán</th>
                                    <th style="width: 10%">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                <tr>
                                    <td>
                                        #{{ $order->order_id }} <br>
                                        Giao dịch: {{ $order->transaction_id }}
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-2">
                                                <img style="width: 50px; height:50px; object-fit:cover"
                                                     src="{{ asset($order->company->logo) }}" alt="Logo công ty">
                                            </div>
                                            <div>
                                                <strong>{{ $order->company->name }}</strong><br>
                                                {{ $order->company->email }}
                                            </div>
                                        </div>
                                    </td>

                                    <td>{{ $order->package_name }}</td>

                                    <td>{{ $order->amount }} {{ $order->paid_in_currency }}</td>

                                    <td>{{ $order->default_amount }}</td>

                                    <td>{{ $order->payment_provider }}</td>

                                    <td>
                                        <p class="badge bg-primary text-light m-0">{{ $order->payment_status }}</p>
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->id) }}"
                                           class="btn btn-sm btn-primary">
                                            Xem chi tiết
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">Không có đơn hàng nào!</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer text-right">
                    <nav class="d-inline-block">
                        @if ($orders->hasPages())
                            {{ $orders->withQueryString()->links() }}
                        @endif
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
