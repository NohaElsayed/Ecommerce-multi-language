<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ config('app.name') }}</title>

    @if (app()->getLocale() == 'ar')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&family=Poppins:wght@300;400;600;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary: #ff6b35;
            --secondary: #004e89;
            --accent: #ffd23f;
            --dark: #1a1a2e;
            --light: #f8f9fa;
            --gradient: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
        }

        body {
            font-family: '{{ app()->getLocale() == 'ar' ? 'Cairo' : 'Poppins' }}', sans-serif;
            background: #fafafa;
            color: #333;
        }

        /* Navbar */
        .navbar-custom {
            background: white;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            padding: 15px 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-link {
            font-weight: 500;
            color: var(--dark) !important;
            margin: 0 10px;
            transition: all 0.3s;
        }

        .nav-link:hover {
            color: var(--primary) !important;
        }

        /* Hero */
        .hero {
            background: var(--gradient);
            color: white;
            padding: 80px 0;
            border-radius: 0 0 50px 50px;
            margin-bottom: 50px;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 700;
        }

        /* Product Card */
        .product-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.4s;
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .product-img {
            height: 250px;
            object-fit: cover;
            width: 100%;
        }

        .product-body {
            padding: 20px;
        }

        .product-title {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 10px;
        }

        .product-price {
            color: var(--primary);
            font-weight: 700;
            font-size: 1.3rem;
        }

        .old-price {
            text-decoration: line-through;
            color: #999;
            font-size: 0.9rem;
            margin-inline-start: 8px;
        }

        /* Buttons */
        .btn-primary-custom {
            background: var(--gradient);
            border: none;
            color: white;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary-custom:hover {
            transform: scale(1.05);
            color: white;
            box-shadow: 0 5px 15px rgba(255, 107, 53, 0.4);
        }

        /* Filter Sidebar */
        .filter-sidebar {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        .filter-title {
            font-weight: 700;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary);
        }

        /* Footer */
        .footer {
            background: var(--dark);
            color: white;
            padding: 50px 0 20px;
            margin-top: 80px;
        }

        /* Badge */
        .badge-sale {
            position: absolute;
            top: 15px;
            {{ app()->getLocale() == 'ar' ? 'left' : 'right' }}: 15px;
            background: #e63946;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .cart-icon {
            position: relative;
        }

        .cart-count {
            position: absolute;
            top: -8px;
            {{ app()->getLocale() == 'ar' ? 'left' : 'right' }}: -8px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-store"></i> {{ __('site.name') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">{{ __('site.home') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('shop') }}">{{ __('site.shop') }}</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#"
                            data-bs-toggle="dropdown">{{ __('site.categories') }}</a>
                        <ul class="dropdown-menu">
                            @foreach (\App\Models\Category::active()->get() as $cat)
                                <li><a class="dropdown-item"
                                        href="{{ route('shop', ['category' => $cat->id]) }}">{{ $cat->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#">{{ __('site.contact') }}</a></li>
                </ul>
                <ul class="navbar-nav">
                    <!-- Language Switcher -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-globe"></i> {{ strtoupper(app()->getLocale()) }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url('ar') }}">العربية</a></li>
                            <li><a class="dropdown-item" href="{{ url('en') }}">English</a></li>
                        </ul>
                    </li>
                    <!-- Cart -->
                    <li class="nav-item">
                        <a class="nav-link cart-icon" href="{{ route('cart') }}">
                            <i class="fas fa-shopping-cart"></i>
                            @auth
                                <span
                                    class="cart-count">{{ \App\Models\Cart::where('user_id', auth()->id())->sum('quantity') }}</span>
                            @endauth
                        </a>
                    </li>
                    @auth
                        @if (auth()->user()->hasRole(['admin', 'super-admin', 'manager']))
                            <!-- الأدمن -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                    <i class="fas fa-user-shield"></i> {{ auth()->user()->name }}
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                            <i class="fas fa-tachometer-alt"></i> {{ __('site.dashboard') }}
                                        </a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ route('admin.logout') }}">
                                            @csrf
                                            <button class="dropdown-item" type="submit">
                                                <i class="fas fa-sign-out-alt"></i> {{ __('site.logout') }}
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <!-- العميل -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                    <i class="fas fa-user"></i> {{ auth()->user()->name }}
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('my.orders') }}">
                                            <i class="fas fa-shopping-bag"></i> {{ __('site.my_orders') }}
                                        </a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button class="dropdown-item" type="submit">
                                                <i class="fas fa-sign-out-alt"></i> {{ __('site.logout') }}
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i> {{ __('site.login') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary-custom btn-sm" href="{{ route('register') }}">
                                <i class="fas fa-user-plus"></i> {{ __('site.register') }}
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5><i class="fas fa-store"></i> {{ __('site.name') }}</h5>
                    <p class="text-white-50">{{ __('site.footer_about') }}</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>{{ __('site.links') }}</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white-50">{{ __('site.home') }}</a></li>
                        <li><a href="#" class="text-white-50">{{ __('site.shop') }}</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>{{ __('site.contact') }}</h5>
                    <p class="text-white-50"><i class="fas fa-phone"></i> +966 50 000 0000</p>
                    <p class="text-white-50"><i class="fas fa-envelope"></i> info@store.com</p>
                </div>
            </div>
            <hr class="border-secondary">
            <p class="text-center text-white-50 mb-0">© 2026 {{ __('site.name') }}. {{ __('site.rights') }}</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
