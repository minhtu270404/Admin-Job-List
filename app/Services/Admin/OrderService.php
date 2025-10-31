<?php

namespace App\Services\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;
use Exception;

class OrderService
{
    /**
     * Lấy danh sách đơn hàng có phân trang & search
     */
    public function getPaginatedOrders(Request $request)
    {
        $query = Order::query()
            ->with(['company', 'plan'])
            ->orderBy('id', 'DESC');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('package_name', 'like', "%{$request->search}%")
                    ->orWhere('transaction_id', 'like', "%{$request->search}%")
                    ->orWhere('order_id', 'like', "%{$request->search}%")
                    ->orWhere('payment_provider', 'like', "%{$request->search}%")
                    ->orWhere('payment_status', 'like', "%{$request->search}%");
            });
        }

        return $query->paginate(20);
    }

    /**
     * Lấy thông tin chi tiết đơn hàng
     */
    public function findOrderById(string $id): Order
    {
        return Order::with(['company', 'plan'])->findOrFail($id);
    }

    /**
     * Tạo & tải hóa đơn PDF
     */
    public function generateInvoice(string $id): Response
    {
        try {
            $order = $this->findOrderById($id);

            $customer = new Buyer([
                'name'          => $order->company->name,
                'custom_fields' => [
                    'email'            => $order->company->email,
                    'transaction'      => $order->transaction_id,
                    'payment method'   => $order->payment_provider,
                ],
            ]);

            $seller = new Party([
                'name'          => config('settings.site_name'),
                'phone'         => config('settings.site_phone'),
                'custom_fields' => [
                    'email' => config('settings.site_email')
                ],
            ]);

            $item = InvoiceItem::make($order->package_name . ' Plan')
                ->pricePerUnit($order->amount);

            $invoice = Invoice::make()
                ->series($order->order_id)
                ->currencyCode($order->paid_in_currency)
                ->currencySymbol($order->paid_in_currency)
                ->buyer($customer)
                ->seller($seller)
                ->status('paid')
                ->payUntilDays(0)
                ->addItem($item);

            return $invoice->download();
        } catch (Exception $e) {
            Log::error('Invoice generation failed', [
                'order_id' => $id,
                'error' => $e->getMessage(),
            ]);

            abort(500, 'Không thể tạo hóa đơn. Vui lòng thử lại sau.');
        }
    }
}
