<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - Admin</title>
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
            --sidebar-bg: #1a1a2e;
            --sidebar-hover: #16213e;
            --primary: #ff6b35;
            --gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        body {
            font-family: '{{ app()->getLocale() == "ar" ? "Cairo" : "Poppins" }}', sans-serif;
            background: #f5f7fb;
        }
        .sidebar {
            position: fixed;
            top: 0;
            {{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 0;
            width: 260px;
            height: 100vh;
            background: var(--sidebar-bg);
            color: white;
            padding: 20px 0;
            overflow-y: auto;
            transition: all 0.3s;
            z-index: 1000;
        }
        .sidebar-brand {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            font-size: 1.5rem;
            font-weight: 700;
        }
        .sidebar-menu { list-style: none; padding: 0; margin: 20px 0; }
        .sidebar-menu li a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.3s;
            border-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 3px solid transparent;
        }
        .sidebar-menu li a:hover, .sidebar-menu li a.active {
            background: var(--sidebar-hover);
            color: white;
            border-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}-color: var(--primary);
        }
        .sidebar-menu li a i { width: 25px; margin-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}: 10px; }
        .main-content {
            margin-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 260px;
            padding: 20px;
            min-height: 100vh;
        }
        .topbar {
            background: white;
            padding: 15px 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: all 0.3s;
            border: none;
        }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }
        .bg-grad-1 { background: linear-gradient(135deg, #667eea, #764ba2); }
        .bg-grad-2 { background: linear-gradient(135deg, #f093fb, #f5576c); }
        .bg-grad-3 { background: linear-gradient(135deg, #4facfe, #00f2fe); }
        .bg-grad-4 { background: linear-gradient(135deg, #43e97b, #38f9d7); }
        .card-custom {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border: none;
        }
        .btn-primary-custom {
            background: var(--gradient);
            border: none;
            color: white;
        }
        @media (max-width: 768px) {
            .sidebar { transform: translateX({{ app()->getLocale() == 'ar' ? '100%' : '-100%' }}); }
            .sidebar.active { transform: translateX(0); }
            .main-content { margin: 0; }
        }
    </style>
</head>
<body>
<li>
    <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit" class="btn btn-link text-white w-100 text-start" style="padding: 12px 20px;">
            <i class="fas fa-sign-out-alt"></i> {{ __('admin.logout') }}
        </button>
    </form>
</li>
<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <i class="fas fa-store"></i> Admin Panel
    </div>
    <ul class="sidebar-menu">
        <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> {{ __('admin.dashboard') }}
        </a></li>
        <li><a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="fas fa-folder"></i> {{ __('admin.categories') }}
        </a></li>
        <li><a href="{{ route('admin.sub-categories.index') }}" class="{{ request()->routeIs('admin.sub-categories.*') ? 'active' : '' }}">
            <i class="fas fa-tags"></i> {{ __('admin.sub_categories') }}
        </a></li>
        <li><a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="fas fa-box"></i> {{ __('admin.products') }}
        </a></li>
        <li><a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="fas fa-shopping-bag"></i> {{ __('admin.orders') }}
        </a></li>
        <li><a href="{{ route('admin.reports.index') }}" class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i> {{ __('admin.reports') }}
        </a></li>
        <li><a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> {{ __('admin.users') }}
        </a></li>
        <li><a href="{{ route('admin.roles.index') }}" class="{{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
            <i class="fas fa-user-shield"></i> {{ __('admin.roles') }}
        </a></li>
        <li><a href="{{ route('home') }}"><i class="fas fa-globe"></i> {{ __('admin.view_site') }}</a></li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-link text-white w-100 text-start" style="padding: 12px 20px;">
                    <i class="fas fa-sign-out-alt"></i> {{ __('admin.logout') }}
                </button>
            </form>
        </li>
    </ul>
</aside>

<!-- Main -->
<div class="main-content">
    <div class="topbar">
        <div>
            <button class="btn btn-sm btn-outline-secondary d-md-none" onclick="document.getElementById('sidebar').classList.toggle('active')">
                <i class="fas fa-bars"></i>
            </button>
            <h4 class="mb-0 d-inline-block ms-2">@yield('page-title')</h4>
        </div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ url(app()->getLocale() == 'ar' ? 'en' : 'ar') }}" class="btn btn-sm btn-outline-primary">
                {{ app()->getLocale() == 'ar' ? 'EN' : 'AR' }}
            </a>
            <span>{{ auth()->user()->name }}</span>
            <img src="{{ auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : 'https://ui-avatars.com/api/?name='.auth()->user()->name }}" class="rounded-circle" width="40" height="40">
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
