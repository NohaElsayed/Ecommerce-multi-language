<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * الحصول على استعلام السلة بناءً على حالة المستخدم
     */
    private function getCartQuery()
    {
        $query = Cart::with('product');

        if (auth()->check()) {
            return $query->where('user_id', auth()->id());
        }

        return $query->where('session_id', session()->getId());
    }

    public function index()
    {
        $items = $this->getCartQuery()->get();
        return view('frontend.cart', compact('items'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1',
        ]);

        $product = \App\Models\Product::find($request->product_id);
        if ($product->stock < ($request->quantity ?? 1)) {
            return back()->with('error', __('site.out_of_stock'));
        }

        // البحث عن المنتج في سلة المستخدم الحالي أو الزائر
        $query = Cart::where('product_id', $request->product_id);
        if (auth()->check()) {
            $query->where('user_id', auth()->id());
        } else {
            $query->where('session_id', session()->getId());
        }

        $cart = $query->first();

        if ($cart) {
            $cart->increment('quantity', $request->quantity ?? 1);
        } else {
            Cart::create([
                'user_id' => auth()->id(), // سيكون null للزوار
                'session_id' => session()->getId(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity ?? 1,
            ]);
        }

        return back()->with('success', __('site.added_to_cart'));
    }

    public function update(Request $request, Cart $cart)
    {
        // التحقق من أن العنصر يخص المستخدم أو الجلسة الحالية
        if (auth()->check() && $cart->user_id !== auth()->id()) {
            abort(403);
        }
        if (!auth()->check() && $cart->session_id !== session()->getId()) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart->update(['quantity' => $request->quantity]);
        return back()->with('success', __('site.cart_updated'));
    }

    public function remove(Cart $cart)
    {
        // التحقق من أن العنصر يخص المستخدم أو الجلسة الحالية
        if (auth()->check() && $cart->user_id !== auth()->id()) {
            abort(403);
        }
        if (!auth()->check() && $cart->session_id !== session()->getId()) {
            abort(403);
        }

        $cart->delete();
        return back()->with('success', __('site.item_removed'));
    }
}
