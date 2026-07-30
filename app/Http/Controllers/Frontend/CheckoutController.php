<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use App\Models\Customer;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(private OrderService $orderService)
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $customer = Customer::where('user_id', auth()->id())->first();
        $cartItems = Cart::where('user_id', auth()->id())
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')
                ->with('error', __('site.cart_empty'));
        }

        return view('frontend.checkout', compact('customer', 'cartItems'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'shipping_phone' => 'required|string',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string',
            'country' => 'required|string',
            'payment_method' => 'required|in:cod,card',
            'notes' => 'nullable|string',
        ]);

        $customer = Customer::where('user_id', auth()->id())->first();

        if (!$customer) {
            $customer = Customer::create([
                'user_id' => auth()->id(),
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'phone' => $data['shipping_phone'],
                'address' => $data['shipping_address'],
                'city' => $data['shipping_city'],
                'country' => $data['country'],
            ]);
        }

        $order = $this->orderService->createFromCart($customer, $data);

        return redirect()->route('order.success', $order)
            ->with('success', __('site.order_placed_successfully'));
    }

    public function success(Order $order)
    {
        // التحقق من أن الطلب يخص المستخدم الحالي
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('frontend.order-success', compact('order'));
    }

    public function myOrders()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('items.product')
            ->latest()
            ->paginate(10);

        return view('frontend.my-orders', compact('orders'));
    }
}
