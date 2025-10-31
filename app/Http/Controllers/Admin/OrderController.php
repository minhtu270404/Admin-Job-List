<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\OrderService;
use App\Traits\Searchable;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    use Searchable;

    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->middleware(['permission:order index']);
        $this->orderService = $orderService;
    }

    /**
     * Danh sách đơn hàng
     */
    public function index(Request $request): View
    {
        $orders = $this->orderService->getPaginatedOrders($request);
        return view('admin.order.index', compact('orders'));
    }

    /**
     * Chi tiết đơn hàng
     */
    public function show(string $id): View
    {
        $order = $this->orderService->findOrderById($id);
        return view('admin.order.show', compact('order'));
    }

    /**
     * Tải hóa đơn PDF
     */
    public function invoice(string $id): Response
    {
        return $this->orderService->generateInvoice($id);
    }
}
