<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * إنشاء طلب جديد من السلة
     */
    public function createFromCart(Customer $customer, array $data): Order
    {
        return DB::transaction(function () use ($customer, $data) {
            $carts = Cart::where('user_id', $customer->user_id)
                ->with('product')
                ->get();

            if ($carts->isEmpty()) {
                throw new \Exception(__('cart.empty'));
            }

            $subtotal = 0;
            $items = [];

            foreach ($carts as $cart) {
                $product = $cart->product;
                if ($product->stock < $cart->quantity) {
                    throw new \Exception("Stock not enough for {$product->name}");
                }
                $itemTotal = $product->final_price * $cart->quantity;
                $subtotal += $itemTotal;
                $items[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $cart->quantity,
                    'price' => $product->final_price,
                    'total' => $itemTotal,
                ];

                // خصم من المخزون
                $product->decrement('stock', $cart->quantity);
            }

            $shipping = $data['shipping'] ?? 0;
            $tax = $subtotal * 0.15; // 15% VAT
            $total = $subtotal + $shipping + $tax;

            $order = Order::create([
                'customer_id' => $customer->id,
                'user_id' => $customer->user_id,
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'tax' => $tax,
                'total' => $total,
                'payment_method' => $data['payment_method'] ?? 'cod',
                'notes' => $data['notes'] ?? null,
                'shipping_address' => $data['shipping_address'],
                'shipping_city' => $data['shipping_city'],
                'shipping_phone' => $data['shipping_phone'],
            ]);

            foreach ($items as $item) {
                $order->items()->create($item);
            }

            // تفريغ السلة
            Cart::where('user_id', $customer->user_id)->delete();

            return $order->load('items.product');
        });
    }

    /**
     * تحديث حالة الطلب
     */
    public function updateStatus(Order $order, string $status): Order
    {
        $order->update(['status' => $status]);
        return $order;
    }

    /**
     * ✅ الدالة المفقودة: جلب جميع الطلبات مع الفلترة والترقيم
     */
    public function getAllOrders(array $filters = [], int $perPage = 15)
    {
        $query = Order::with(['customer', 'items.product']);

        // فلترة حسب الحالة
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // فلترة حسب حالة الدفع
        if (!empty($filters['payment_status'])) {
            $query->where('payment_status', $filters['payment_status']);
        }

        // بحث برقم الطلب أو اسم العميل
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($cq) use ($search) {
                      $cq->where('first_name', 'like', "%{$search}%")
                         ->orWhere('last_name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        return $query->latest()->paginate($perPage);
    }
}
