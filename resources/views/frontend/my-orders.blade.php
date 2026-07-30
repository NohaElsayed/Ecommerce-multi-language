@extends('layouts.frontend')
@section('title', __('site.my_orders'))

@section('content')
<div class="container my-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('site.home') }}</a></li>
            <li class="breadcrumb-item active">{{ __('site.my_orders') }}</li>
        </ol>
    </nav>

    <h2 class="mb-4 fw-bold">
        <i class="fas fa-shopping-bag text-primary"></i> {{ __('site.my_orders') }}
    </h2>

    @if($orders->count() > 0)
        @foreach($orders as $order)
        <div class="card-custom mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="fw-bold mb-1">{{ __('site.order') }} #{{ $order->order_number }}</h5>
                    <small class="text-muted">
                        <i class="fas fa-calendar"></i> {{ $order->created_at->format('Y-m-d H:i') }}
                    </small>
                </div>
                <div>
                    @php
                        $statusColors = [
                            'pending' => 'warning',
                            'processing' => 'info',
                            'shipped' => 'primary',
                            'delivered' => 'success',
                            'cancelled' => 'danger'
                        ];
                        $statusLabels = [
                            'pending' => __('site.pending'),
                            'processing' => __('site.processing'),
                            'shipped' => __('site.shipped'),
                            'delivered' => __('site.delivered'),
                            'cancelled' => __('site.cancelled')
                        ];
                    @endphp
                    <span class="badge bg-{{ $statusColors[$order->status] }} fs-6">
                        {{ $statusLabels[$order->status] }}
                    </span>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('site.product') }}</th>
                            <th class="text-center">{{ __('site.quantity') }}</th>
                            <th class="text-center">{{ __('site.price') }}</th>
                            <th class="text-center">{{ __('site.total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $item->product->image ? asset('storage/'.$item->product->image) : 'https://via.placeholder.com/50' }}"
                                         class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                    <span>{{ $item->product_name }}</span>
                                </div>
                            </td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-center">{{ number_format($item->price, 2) }}</td>
                            <td class="text-center"><strong>{{ number_format($item->total, 2) }}</strong></td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>{{ __('site.subtotal') }}:</strong></td>
                            <td class="text-center"><strong>{{ number_format($order->subtotal, 2) }}</strong></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end"><strong>{{ __('site.shipping') }}:</strong></td>
                            <td class="text-center"><strong>{{ number_format($order->shipping, 2) }}</strong></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end"><strong>{{ __('site.tax') }}:</strong></td>
                            <td class="text-center"><strong>{{ number_format($order->tax, 2) }}</strong></td>
                        </tr>
                        <tr class="table-primary">
                            <td colspan="3" class="text-end"><strong>{{ __('site.total') }}:</strong></td>
                            <td class="text-center"><strong class="text-primary fs-5">{{ number_format($order->total, 2) }} {{ __('site.currency') }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        @endforeach

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-shopping-bag" style="font-size: 6rem; color: #ddd;"></i>
            <h3 class="mt-4 text-muted">{{ __('site.no_orders') }}</h3>
            <p class="text-muted">{{ __('site.no_orders_desc') }}</p>
            <a href="{{ route('shop') }}" class="btn btn-primary-custom mt-3">
                <i class="fas fa-shopping-bag"></i> {{ __('site.start_shopping') }}
            </a>
        </div>
    @endif
</div>
@endsection
