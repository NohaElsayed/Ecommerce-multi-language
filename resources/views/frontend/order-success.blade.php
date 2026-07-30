@extends('layouts.frontend')
@section('title', __('site.order_success'))

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-custom text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
                </div>

                <h2 class="fw-bold mb-3">{{ __('site.thank_you') }}</h2>
                <p class="text-muted mb-4">{{ __('site.order_placed_successfully') }}</p>

                <div class="bg-light rounded p-4 mb-4">
                    <h5 class="fw-bold mb-3">{{ __('site.order_details') }}</h5>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <strong>{{ __('site.order_number') }}:</strong>
                            <span class="text-primary">{{ $order->order_number }}</span>
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>{{ __('site.order_date') }}:</strong>
                            <span>{{ $order->created_at->format('Y-m-d') }}</span>
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>{{ __('site.total') }}:</strong>
                            <span class="text-primary fw-bold">{{ number_format($order->total, 2) }} {{ __('site.currency') }}</span>
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>{{ __('site.payment_method') }}:</strong>
                            <span>{{ $order->payment_method == 'cod' ? __('site.cash_on_delivery') : __('site.credit_card') }}</span>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    {{ __('site.order_confirmation_email') }}
                </div>

                <div class="d-flex gap-3 justify-content-center">
                    <a href="{{ route('my.orders') }}" class="btn btn-primary-custom">
                        <i class="fas fa-shopping-bag"></i> {{ __('site.view_orders') }}
                    </a>
                    <a href="{{ route('shop') }}" class="btn btn-outline-primary">
                        <i class="fas fa-shopping-bag"></i> {{ __('site.continue_shopping') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
