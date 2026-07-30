@extends('layouts.auth')
@section('title', __('auth.verify_email'))
@section('subtitle', __('auth.verify_email_subtitle'))

@section('content')
<div class="text-center mb-4">
    <i class="fas fa-envelope-open-text" style="font-size: 4rem; color: var(--primary);"></i>
    <p class="mt-3">
        {{ __('auth.verify_email_desc') }}
    </p>
</div>

@if(session('resent'))
    <div class="alert alert-success">
        {{ __('auth.verify_email_resent') }}
    </div>
@endif

<form method="POST" action="{{ route('verification.resend') }}">
    @csrf
    <button type="submit" class="btn btn-auth">
        <i class="fas fa-redo"></i> {{ __('auth.resend_verification') }}
    </button>
</form>
@endsection
