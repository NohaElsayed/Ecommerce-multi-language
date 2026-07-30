@extends('layouts.frontend')
@section('title', __('site.checkout'))

@section('content')
<div class="container my-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('site.home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cart') }}">{{ __('site.cart') }}</a></li>
            <li class="breadcrumb-item active">{{ __('site.checkout') }}</li>
        </ol>
    </nav>

    <h2 class="mb-4 fw-bold">
        <i class="fas fa-credit-card text-primary"></i> {{ __('site.checkout') }}
    </h2>

    <form method="POST" action="{{ route('checkout.store') }}">
        @csrf
        <div class="row">
            <!-- Billing Details -->
            <div class="col-lg-8">
                <div class="card-custom mb-4">
                    <h5 class="mb-4 fw-bold">{{ __('site.shipping_details') }}</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">{{ __('site.first_name') }}</label>
                            <input type="text" name="first_name" class="form-control"
                                   value="{{ $customer->first_name ?? old('first_name') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">{{ __('site.last_name') }}</label>
                            <input type="text" name="last_name" class="form-control"
                                   value="{{ $customer->last_name ?? old('last_name') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('site.email') }}</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ $customer->email ?? old('email') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('site.phone') }}</label>
                        <input type="tel" name="shipping_phone" class="form-control"
                               value="{{ $customer->phone ?? old('shipping_phone') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('site.address') }}</label>
                        <textarea name="shipping_address" class="form-control" rows="3" required>{{ old('shipping_address') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">{{ __('site.city') }}</label>
                            <input type="text" name="shipping_city" class="form-control"
                                   value="{{ $customer->city ?? old('shipping_city') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">{{ __('site.country') }}</label>
                            <select name="country" class="form-select" required>
                                <option value="SA">{{ __('site.saudi_arabia') }}</option>
                                <option value="AE">{{ __('site.uae') }}</option>
                                <option value="KW">{{ __('site.kuwait') }}</option>
                                <option value="QA">{{ __('site.qatar') }}</option>
                                <option value="BH">{{ __('site.bahrain') }}</option>
                                <option value="OM">{{ __('site.oman') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('site.order_notes') }}</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="{{ __('site.notes_placeholder') }}"></textarea>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="card-custom">
                    <h5 class="mb-4 fw-bold">{{ __('site.payment_method') }}</h5>

                    <div class="form-check mb-3">
                        <input type="radio" name="payment_method" value="cod" id="cod" class="form-check-input" checked>
                        <label class="form-check-label" for="cod">
                            <i class="fas fa-money-bill-wave"></i>
                            <strong>{{ __('site.cash_on_delivery') }}</strong>
                            <small class="d-block text-muted">{{ __('site.cod_desc') }}</small>
                        </label>
                    </div>

                    <div class="form-check mb-3">
                        <input type="radio" name="payment_method" value="card" id="card" class="form-check-input">
                        <label class="form-check-label" for="card">
                            <i class="fas fa-credit-card"></i>
                            <strong>{{ __('site.credit_card') }}</strong>
                            <small class="d-block text-muted">{{ __('site.card_desc') }}</small>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card-custom sticky-top" style="top: 100px;">
                    <h5 class="mb-4 fw-bold">{{ __('site.your_order') }}</h5>

                    @foreach($cartItems as $item)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <img src="{{ $item->product->image ? asset('storage/'.$item->product->image) : 'https://via.placeholder.com/50' }}"
                                 class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <small class="fw-bold d-block">{{ $item->product->name }}</small>
                                <small class="text-muted">× {{ $item->quantity }}</small>
                            </div>
                        </div>
                        <strong>{{ number_format($item->subtotal, 2) }}</strong>
                    </div>
                    @endforeach

                    <hr>

                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ __('site.subtotal') }}</span>
                        <strong>{{ number_format($cartItems->sum('subtotal'), 2) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ __('site.shipping') }}</span>
                        <strong class="text-success">{{ __('site.free_shipping') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>{{ __('site.tax') }} (15%)</span>
                        <strong>{{ number_format($cartItems->sum('subtotal') * 0.15, 2) }}</strong>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-4">
                        <h5 class="fw-bold mb-0">{{ __('site.total') }}</h5>
                        <h5 class="fw-bold text-primary mb-0">
                            {{ number_format($cartItems->sum('subtotal') * 1.15, 2) }} {{ __('site.currency') }}
                        </h5>
                    </div>

                    <button type="submit" class="btn btn-primary-custom w-100">
                        <i class="fas fa-check-circle"></i> {{ __('site.place_order') }}
                    </button>

                    <p class="text-center text-muted small mt-3 mb-0">
                        <i class="fas fa-lock"></i> {{ __('site.secure_checkout') }}
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
