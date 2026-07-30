<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\{HomeController, ShopController, CartController, CheckoutController};

// ✅ Middleware اللغة
Route::middleware([\App\Http\Middleware\SetLocale::class])->group(function () {

    // الصفحة الرئيسية
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/{locale?}', [HomeController::class, 'index'])
        ->where('locale', 'ar|en')
        ->name('home.lang');

    // المتجر
    Route::get('/shop', [ShopController::class, 'index'])->name('shop');
    Route::get('/product/{slug}', [ShopController::class, 'show'])->name('product.show');

    // السلة
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('cart.remove');

    // ✅ الدفع يتطلب تسجيل دخول عميل
    Route::middleware('auth')->group(function () {
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
        Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
        Route::get('/order/success/{order}', [CheckoutController::class, 'success'])->name('order.success');
        Route::get('/my-orders', [CheckoutController::class, 'myOrders'])->name('my.orders');
    });
});

// ✅ Routes المصادقة للعملاء
Auth::routes(['verify' => false]);

// ✅ Routes الأدمن
require base_path('routes/admin.php');
