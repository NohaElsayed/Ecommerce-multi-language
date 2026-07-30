<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * عرض صفحة تسجيل دخول الأدمن
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * تسجيل دخول الأدمن
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');
        $credentials['status'] = 'active';

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $user = Auth::user();

            // ✅ التحقق من أن المستخدم لديه دور أدمن
            if (!$user->hasRole(['admin', 'super-admin', 'manager'])) {
                Auth::logout();
                return back()
                    ->withInput($request->only('email', 'remember'))
                    ->withErrors(['email' => __('admin.not_authorized')]);
            }

            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', __('admin.welcome_back'));
        }

        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors(['email' => __('admin.invalid_credentials')]);
    }

    /**
     * تسجيل خروج الأدمن
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', __('admin.logged_out'));
    }
}
