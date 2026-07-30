<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('admin.login') }} - {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @if(app()->getLocale() == 'ar')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
            --gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        body {
            font-family: '{{ app()->getLocale() == "ar" ? "Cairo" : "Poppins" }}', sans-serif;
            background: var(--gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: move 20s linear infinite;
        }
        @keyframes move {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }
        .login-card {
            background: white;
            border-radius: 25px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.3);
            position: relative;
            z-index: 1;
            animation: slideUp 0.6s ease-out;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .admin-badge {
            display: inline-block;
            background: var(--gradient);
            color: white;
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 15px;
        }
        .login-icon {
            width: 80px;
            height: 80px;
            background: var(--gradient);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: white;
            margin: 0 auto 20px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }
        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 12px 15px;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }
        .btn-login {
            background: var(--gradient);
            border: none;
            color: white;
            padding: 14px;
            border-radius: 12px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
            color: white;
        }
        .alert { border-radius: 12px; border: none; }
        .back-to-site {
            position: absolute;
            top: 20px;
            {{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 20px;
            color: white;
            text-decoration: none;
            font-weight: 600;
            z-index: 2;
        }
        .language-switch {
            position: absolute;
            top: 20px;
            {{ app()->getLocale() == 'ar' ? 'left' : 'right' }}: 20px;
            z-index: 2;
        }
        .language-switch a {
            color: white;
            background: rgba(255,255,255,0.2);
            padding: 8px 15px;
            border-radius: 50px;
            text-decoration: none;
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body>

<a href="{{ route('home') }}" class="back-to-site">
    <i class="fas fa-arrow-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}"></i>
    {{ __('admin.back_to_site') }}
</a>

<div class="language-switch">
    <a href="{{ url(app()->getLocale() == 'ar' ? 'en' : 'ar') }}/admin/login">
        {{ app()->getLocale() == 'ar' ? 'English' : 'العربية' }}
    </a>
</div>

<div class="login-card">
    <div class="text-center">
        <div class="login-icon">
            <i class="fas fa-user-shield"></i>
        </div>
        <span class="admin-badge">
            <i class="fas fa-lock"></i> {{ __('admin.admin_panel') }}
        </span>
        <h3 class="fw-bold mb-2">{{ __('admin.login_title') }}</h3>
        <p class="text-muted">{{ __('admin.login_subtitle') }}</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login.post') }}" class="mt-4">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-bold">
                <i class="fas fa-envelope"></i> {{ __('admin.email') }}
            </label>
            <input type="email" name="email" class="form-control"
                   value="{{ old('email') }}"
                   placeholder="admin@example.com" required autofocus>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">
                <i class="fas fa-lock"></i> {{ __('admin.password') }}
            </label>
            <input type="password" name="password" class="form-control"
                   placeholder="••••••••" required>
        </div>

        <div class="form-check mb-4">
            <input type="checkbox" name="remember" class="form-check-input" id="remember">
            <label class="form-check-label" for="remember">
                {{ __('admin.remember_me') }}
            </label>
        </div>

        <button type="submit" class="btn btn-login">
            <i class="fas fa-sign-in-alt"></i> {{ __('admin.login_button') }}
        </button>
    </form>

    <div class="text-center mt-4">
        <small class="text-muted">
            <i class="fas fa-info-circle"></i>
            {{ __('admin.demo_credentials') }}<br>
            <strong>admin@admin.com</strong> / <strong>12345678</strong>
        </small>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
