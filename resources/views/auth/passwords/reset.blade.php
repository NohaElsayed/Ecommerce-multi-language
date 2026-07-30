@extends('layouts.auth')
@section('title', __('auth.reset_password'))
@section('subtitle', __('auth.reset_password_subtitle'))

@section('content')
<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">

    <div class="mb-3">
        <label class="form-label">
            <i class="fas fa-envelope"></i> {{ __('auth.email') }}
        </label>
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            <input type="email" name="email" class="form-control"
                   value="{{ $email ?? old('email') }}" required>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">
            <i class="fas fa-lock"></i> {{ __('auth.new_password') }}
        </label>
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" name="password" class="form-control" required>
        </div>
    </div>

    <div class="mb-4">
        <label class="form-label">
            <i class="fas fa-lock"></i> {{ __('auth.confirm_password') }}
        </label>
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
    </div>

    <button type="submit" class="btn btn-auth">
        <i class="fas fa-save"></i> {{ __('auth.reset_password_button') }}
    </button>
</form>
@endsection
