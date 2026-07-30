<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // ✅ التحقق من تسجيل الدخول
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        $user = Auth::user();

        // ✅ التحقق من دور الأدمن
        if (!$user->hasRole(['admin', 'super-admin', 'manager'])) {
            Auth::logout();
            return redirect()->route('admin.login')
                ->withErrors(['email' => __('admin.not_authorized')]);
        }

        // ✅ التحقق من حالة المستخدم
        if ($user->status !== 'active') {
            Auth::logout();
            return redirect()->route('admin.login')
                ->withErrors(['email' => __('admin.account_inactive')]);
        }

        return $next($request);
    }
}
