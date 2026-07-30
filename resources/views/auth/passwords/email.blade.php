@extends('layouts.auth')
@section('title', __('auth.forgot_password'))
@section('subtitle', __('auth.forgot_password_subtitle'))

@section('content')
<p class="text-center text-muted mb-4">
    {{ __('auth.forgot_password_desc') }}
</p>

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <div class="mb-4">
        <label class="form-label">
            <i class="fas fa-envelope"></i> {{ __('auth.email') }}
        </label>
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            <input type="email" name="email" class="form-control"
                   value="{{ old('email') }}"
                   placeholder="{{ __('auth.email_placeholder') }}"
                   required autofocus>
        </div>
    </div>

    <button type="submit" class="btn btn-auth">
        <i class="fas fa-paper-plane"></i> {{ __('auth.send_reset_link') }}
    </button>
</form>

<div class="auth-links">
    <a href="{{ route('login') }}">
        <i class="fas fa-arrow-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}"></i>
        {{ __('auth.back_to_login') }}
    </a>
</div>
@endsection
