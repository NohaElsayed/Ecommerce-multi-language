<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ config('app.name') }}</title>

    @if(app()->getLocale() == 'ar')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #ff6b35;
            --secondary: #004e89;
            --gradient: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
        }

        * { box-sizing: border-box; }

        body {
            font-family: '{{ app()->getLocale() == "ar" ? "Cairo" : "Poppins" }}', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px; /* تم تقليل المساحة */
            margin: 0;
            position: relative;
            overflow-x: hidden;
        }

        /* body::before {
            content: '';
            position: absolute;
            top: -50%;
            {{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: moveBackground 20s linear infinite;
            z-index: 0;
        } */

        @keyframes moveBackground {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }

        .auth-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px; /* تم تصغير العرض قليلاً */
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
            padding: 30px 25px; /* تم تقليل المسافات الداخلية */
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .auth-logo {
            text-align: center;
            margin-bottom: 20px; /* تم تقليل المسافة */
        }

        .auth-logo .icon {
            width: 65px; /* تم تصغير الأيقونة قليلاً */
            height: 65px;
            background: var(--gradient);
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            margin-bottom: 10px;
            box-shadow: 0 8px 25px rgba(255, 107, 53, 0.4);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .auth-logo h2 {
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 5px;
            font-size: 1.5rem;
        }

        .auth-logo p {
            color: #666;
            font-size: 0.9rem;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px; /* تم تقليل المسافة */
            font-size: 0.85rem;
        }

        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            padding: 10px 12px; /* تم تقليل المسافة الداخلية */
            font-size: 0.9rem;
            transition: all 0.3s;
            background: #f9fafb;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
            background: white;
        }

        .input-group-text {
            background: #f3f4f6;
            border: 2px solid #e5e7eb;
            border-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}: none;
            color: #6b7280;
            border-radius: {{ app()->getLocale() == 'ar' ? '0 10px 10px 0' : '10px 0 0 10px' }};
            padding: 10px 12px;
        }

        .input-group .form-control {
            border-radius: {{ app()->getLocale() == 'ar' ? '10px 0 0 10px' : '0 10px 10px 0' }};
            border-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: none;
        }

        .btn-auth {
            background: var(--gradient);
            border: none;
            color: white;
            padding: 12px; /* تم تقليل المسافة */
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            width: 100%;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
        }

        .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 107, 53, 0.4);
            color: white;
        }

        .auth-links {
            text-align: center;
            margin-top: 15px; /* تم تقليل المسافة */
            color: #666;
            font-size: 0.9rem;
        }

        .auth-links a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }

        .auth-links a:hover {
            color: var(--secondary);
            text-decoration: underline;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 15px 0; /* تم تقليل المسافة */
            color: #9ca3af;
            font-size: 0.8rem;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        .divider span { padding: 0 10px; }

        .social-login {
            display: flex;
            gap: 10px;
            margin-bottom: 15px; /* تم تقليل المسافة */
        }

        .social-btn {
            flex: 1;
            padding: 10px;
            border-radius: 10px;
            border: 2px solid #e5e7eb;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s;
            text-decoration: none;
            color: #333;
        }

        .social-btn:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .social-btn.google i { color: #ea4335; }
        .social-btn.facebook i { color: #1877f2; }

        .alert {
            border-radius: 10px;
            border: none;
            padding: 10px 12px;
            font-size: 0.85rem;
        }

        .alert-danger { background: #fef2f2; color: #dc2626; }
        .alert-success { background: #f0fdf4; color: #16a34a; }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .back-home {
            position: absolute;
            top: 15px;
            {{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 15px;
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s;
        }

        .back-home:hover {
            color: white;
            transform: translateX({{ app()->getLocale() == 'ar' ? '5px' : '-5px' }});
        }

        @media (max-width: 576px) {
            .auth-card { padding: 25px 20px; }
            .auth-logo .icon { width: 55px; height: 55px; font-size: 1.8rem; }
        }
    </style>
</head>
<body>

<a href="{{ route('home') }}" class="back-home">
    <i class="fas fa-arrow-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}"></i>
    {{ __('site.back_home') }}
</a>

<!-- ✅ تم إزالة قسم تبديل اللغة من هنا -->

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-logo">
            <div class="icon">
                <i class="fas fa-store"></i>
            </div>
            <h2>{{ config('app.name') }}</h2>
            <p>@yield('subtitle')</p>
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

        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @yield('content')
    </div>

    <p class="text-center text-white mt-3 mb-0" style="font-size: 0.8rem;">
        © {{ date('Y') }} {{ config('app.name') }}. {{ __('site.rights') }}
    </p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
