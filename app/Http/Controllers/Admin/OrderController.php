<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService) {}

    /**
     * عرض جميع الطلبات
     */
    public function index(Request $request)
    {
        // ✅ استدعاء الدالة التي أضفناها للتو
        $orders = $this->orderService->getAllOrders($request->all());

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * عرض تفاصيل طلب
     */
    public function show(Order $order)
    {
        $order->load(['items.product', 'customer']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * تحديث حالة الطلب
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $this->orderService->updateStatus($order, $request->status);

        return back()->with('success', __('admin.order_status_updated'));
    }

    /**
     * حذف طلب
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', __('admin.deleted'));
    }
}
