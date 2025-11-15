<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Classes\Party;

class CompanyOrderController extends Controller
{
    /**
     * GET /api/company/orders
     * List paginated orders for the authenticated company
     */
    public function index(): JsonResponse
    {
        $companyId = auth()->user()->company?->id;

        if (!$companyId) {
            return response()->json([
                'status' => false,
                'message' => 'Company not found for this user'
            ], 404);
        }

        $orders = Order::where('company_id', $companyId)->paginate(20);

        return response()->json([
            'status' => true,
            'data' => $orders,
        ]);
    }

    /**
     * GET /api/company/orders/{id}
     * Show single order details
     */
    public function show(string $id): JsonResponse
    {
        $order = Order::findOrFail($id);

        if ($order->company_id !== auth()->user()->company?->id) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access to this order'
            ], 403);
        }

        return response()->json([
            'status' => true,
            'data' => $order
        ]);
    }

    /**
     * GET /api/company/orders/{id}/invoice
     * Return invoice data in JSON format
     */
    public function invoice(string $id): JsonResponse
    {
        $order = Order::findOrFail($id);

        if ($order->company_id !== auth()->user()->company?->id) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access to this invoice'
            ], 403);
        }

        $customer = [
            'name' => $order->company->name,
            'email' => $order->company->email,
            'transaction' => $order->transaction_id,
            'payment_method' => $order->payment_provider,
        ];

        $seller = [
            'name' => config('settings.site_name'),
            'phone' => config('settings.site_phone'),
            'email' => config('settings.site_email'),
        ];

        $item = [
            'description' => $order->package_name . ' Plan',
            'price' => $order->amount,
            'currency' => $order->paid_in_currency,
        ];

        $invoice = [
            'series' => $order->order_id,
            'status' => 'paid',
            'buyer' => $customer,
            'seller' => $seller,
            'items' => [$item],
            'pay_until_days' => 0,
        ];

        return response()->json([
            'status' => true,
            'data' => $invoice,
        ]);
    }
}
