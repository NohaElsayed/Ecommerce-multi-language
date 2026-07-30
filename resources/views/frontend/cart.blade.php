@extends('layouts.frontend')
@section('title', __('site.cart'))

@section('content')
<div class="container my-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('site.home') }}</a></li>
            <li class="breadcrumb-item active">{{ __('site.cart') }}</li>
        </ol>
    </nav>

    <h2 class="mb-4 fw-bold">
        <i class="fas fa-shopping-cart text-primary"></i> {{ __('site.cart') }}
    </h2>

    @if($items->count() > 0)
    <div class="row">
        <!-- Cart Items -->
        <div class="col-lg-8">
            <div class="card-custom mb-4">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('site.product') }}</th>
                                <th class="text-center">{{ __('site.price') }}</th>
                                <th class="text-center">{{ __('site.quantity') }}</th>
                                <th class="text-center">{{ __('site.total') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ $item->product->image ? asset('storage/'.$item->product->image) : 'https://via.placeholder.com/80' }}"
                                             alt="{{ $item->product->name }}"
                                             class="rounded"
                                             style="width: 80px; height: 80px; object-fit: cover;">
                                        <div>
                                            <h6 class="mb-1 fw-bold">{{ $item->product->name }}</h6>
                                            <small class="text-muted">{{ $item->product->category->name ?? '' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <strong class="text-primary">{{ number_format($item->product->final_price, 2) }}</strong>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('cart.update', $item) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <div class="input-group input-group-sm" style="max-width: 120px; margin: 0 auto;">
                                            <button type="button" class="btn btn-outline-secondary" onclick="this.parentNode.querySelector('input').stepDown(); this.closest('form').submit();">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="number" name="quantity" value="{{ $item->quantity }}"
                                                   min="1" max="{{ $item->product->stock }}"
                                                   class="form-control text-center"
                                                   onchange="this.closest('form').submit();">
                                            <button type="button" class="btn btn-outline-secondary" onclick="this.parentNode.querySelector('input').stepUp(); this.closest('form').submit();">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </form>
                                </td>
                                <td class="text-center">
                                    <strong>{{ number_format($item->subtotal, 2) }}</strong>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('cart.remove', $item) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('{{ __('site.confirm_delete') }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Continue Shopping -->
            <a href="{{ route('shop') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}"></i>
                {{ __('site.continue_shopping') }}
            </a>
        </div>

        <!-- Cart Summary -->
        <div class="col-lg-4">
            <div class="card-custom sticky-top" style="top: 100px;">
                <h5 class="mb-4 fw-bold">{{ __('site.order_summary') }}</h5>

                <div class="d-flex justify-content-between mb-3">
                    <span>{{ __('site.subtotal') }}</span>
                    <strong>{{ number_format($items->sum('subtotal'), 2) }} {{ __('site.currency') }}</strong>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <span>{{ __('site.shipping') }}</span>
                    <strong class="text-success">{{ __('site.free_shipping') }}</strong>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <span>{{ __('site.tax') }} (15%)</span>
                    <strong>{{ number_format($items->sum('subtotal') * 0.15, 2) }} {{ __('site.currency') }}</strong>
                </div>

                <hr>

                <div class="d-flex justify-content-between mb-4">
                    <h5 class="fw-bold mb-0">{{ __('site.total') }}</h5>
                    <h5 class="fw-bold text-primary mb-0">
                        {{ number_format($items->sum('subtotal') * 1.15, 2) }} {{ __('site.currency') }}
                    </h5>
                </div>

                {{-- ✅ هذا الجزء يتعامل بذكاء مع الزوار والمسجلين دون تغيير التصميم --}}
                @auth
                    <a href="{{ route('checkout') }}" class="btn btn-primary-custom w-100 mb-3">
                        <i class="fas fa-credit-card"></i> {{ __('site.proceed_to_checkout') }}
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary-custom w-100 mb-3">
                        <i class="fas fa-sign-in-alt"></i> {{ __('site.login_to_checkout') }}
                    </a>
                    <p class="text-center text-muted small">
                        {{ __('site.need_account') }}
                    </p>
                @endauth

                <!-- Coupon Code (Optional) -->
                <div class="mt-4">
                    <label class="form-label fw-bold">{{ __('site.coupon_code') }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="{{ __('site.enter_coupon') }}">
                        <button class="btn btn-outline-primary" type="button">{{ __('site.apply') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
        <!-- Empty Cart -->
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart" style="font-size: 6rem; color: #ddd;"></i>
            <h3 class="mt-4 text-muted">{{ __('site.cart_empty') }}</h3>
            <p class="text-muted">{{ __('site.cart_empty_desc') }}</p>
            <a href="{{ route('shop') }}" class="btn btn-primary-custom mt-3">
                <i class="fas fa-shopping-bag"></i> {{ __('site.start_shopping') }}
            </a>
        </div>
    @endif
</div>
@endsection
