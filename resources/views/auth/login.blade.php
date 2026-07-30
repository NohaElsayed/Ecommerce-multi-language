@extends('layouts.auth')
@section('title', __('auth.login'))
@section('subtitle', __('auth.customer_login_subtitle'))

@section('content')
<div class="text-center mb-3">
    <span class="badge bg-success" style="font-size: 0.85rem; padding: 6px 15px; border-radius: 50px;">
        <i class="fas fa-user"></i> {{ __('auth.customer_area') }}
    </span>
</div>

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">
            <i class="fas fa-envelope"></i> {{ __('auth.email') }}
        </label>
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            <input type="email" name="email" class="form-control"
                   value="{{ old('email') }}"
                   placeholder="{{ __('auth.email_placeholder') }}" required autofocus>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">
            <i class="fas fa-lock"></i> {{ __('auth.password') }}
        </label>
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" name="password" class="form-control"
                   placeholder="{{ __('auth.password_placeholder') }}" required>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="form-check">
            <input type="checkbox" name="remember" class="form-check-input" id="remember">
            <label class="form-check-label" for="remember">
                {{ __('auth.remember_me') }}
            </label>
        </div>
    </div>

    <button type="submit" class="btn btn-auth">
        <i class="fas fa-sign-in-alt"></i> {{ __('auth.login_button') }}
    </button>
</form>

<div class="auth-links mt-4">
    {{ __('auth.no_account') }}
    <a href="{{ route('register') }}">{{ __('auth.register_now') }}</a>
</div>

<div class="text-center mt-3">
    <small class="text-muted">
        <i class="fas fa-info-circle"></i>
        {{ __('auth.admin_note') }}<br>
        <a href="{{ route('admin.login') }}" style="color: var(--primary); font-weight: 600;">
            {{ __('auth.admin_login_link') }}
        </a>
    </small>
</div>
@endsection
