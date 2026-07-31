@extends('layouts.auth')
@section('title', __('auth.register'))
@section('subtitle', __('auth.customer_register_subtitle'))

@section('content')
{{-- <div class="text-center mb-3">
    <span class="badge bg-success" style="font-size: 0.85rem; padding: 6px 15px; border-radius: 50px;">
        <i class="fas fa-user"></i> {{ __('auth.customer_area') }}
    </span>
</div> --}}

<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">
                <i class="fas fa-user"></i> {{ __('auth.first_name') }}
            </label>
            <input type="text" name="first_name" class="form-control"
                   value="{{ old('first_name') }}"
                   placeholder="{{ __('auth.first_name_placeholder') }}" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">
                <i class="fas fa-user"></i> {{ __('auth.last_name') }}
            </label>
            <input type="text" name="last_name" class="form-control"
                   value="{{ old('last_name') }}"
                   placeholder="{{ __('auth.last_name_placeholder') }}" required>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">
            <i class="fas fa-envelope"></i> {{ __('auth.email') }}
        </label>
        <input type="email" name="email" class="form-control"
               value="{{ old('email') }}"
               placeholder="{{ __('auth.email_placeholder') }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">
            <i class="fas fa-phone"></i> {{ __('auth.phone') }}
        </label>
        <input type="tel" name="phone" class="form-control"
               value="{{ old('phone') }}"
               placeholder="{{ __('auth.phone_placeholder') }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">
            <i class="fas fa-lock"></i> {{ __('auth.password') }}
        </label>
        <input type="password" name="password" class="form-control"
               placeholder="{{ __('auth.password_placeholder') }}" required>
    </div>

    <div class="mb-4">
        <label class="form-label">
            <i class="fas fa-lock"></i> {{ __('auth.confirm_password') }}
        </label>
        <input type="password" name="password_confirmation" class="form-control"
               placeholder="{{ __('auth.confirm_password_placeholder') }}" required>
    </div>

    <button type="submit" class="btn btn-auth">
        <i class="fas fa-user-plus"></i> {{ __('auth.register_button') }}
    </button>
</form>

<div class="auth-links mt-4">
    {{ __('auth.have_account') }}
    <a href="{{ route('login') }}">{{ __('auth.login_now') }}</a>
</div>
@endsection
