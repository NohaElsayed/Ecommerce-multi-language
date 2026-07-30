<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * التحقق من البيانات
     */
    protected function credentials(Request $request)
    {
        return array_merge($request->only('email', 'password'), [
            'status' => 'active',
        ]);
    }

    /**
     * توجيه بعد تسجيل الدخول
     */
    protected function authenticated(Request $request, $user)
    {
        // ✅ منع الأدمن من الدخول من صفحة العملاء
        if ($user->hasRole(['admin', 'super-admin', 'manager'])) {
            auth()->logout();
            return redirect()->route('login')
                ->withErrors(['email' => __('auth.use_admin_login')]);
        }

        $locale = app()->getLocale();
        return redirect(url($locale))
            ->with('success', __('auth.welcome_back'));
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }
}
