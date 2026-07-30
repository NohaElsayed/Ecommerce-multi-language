@extends('layouts.admin')
@section('title', __('admin.orders'))
@section('page-title', __('admin.orders'))

@section('content')
<div class="card-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><i class="fas fa-shopping-bag"></i> {{ __('admin.orders') }}</h4>
    </div>

    <!-- فلترة -->
    <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <input type="text" name="search" class="form-control" placeholder="{{ __('admin.search_by_order_or_customer') }}" value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">{{ __('admin.all_statuses') }}</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('admin.pending') }}</option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>{{ __('admin.processing') }}</option>
                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>{{ __('admin.shipped') }}</option>
                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>{{ __('admin.delivered') }}</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>{{ __('admin.cancelled') }}</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="payment_status" class="form-select">
                <option value="">{{ __('admin.all_payment_statuses') }}</option>
                <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>{{ __('admin.pending') }}</option>
                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>{{ __('admin.paid') }}</option>
                <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>{{ __('admin.failed') }}</option>
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary-custom w-100">
                <i class="fas fa-filter"></i> {{ __('admin.filter') }}
            </button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>{{ __('admin.order_number') }}</th>
                    <th>{{ __('admin.customer') }}</th>
                    <th>{{ __('admin.date') }}</th>
                    <th>{{ __('admin.total') }}</th>
                    <th>{{ __('admin.status') }}</th>
                    <th>{{ __('admin.payment') }}</th>
                    <th>{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>
                        <strong>{{ $order->order_number }}</strong>
                        @if($order->items->count())
                            <br>
                            <small class="text-muted">{{ $order->items->count() }} {{ __('admin.items') }}</small>
                        @endif
                    </td>
                    <td>
                        @if($order->customer)
                            <strong>{{ $order->customer->full_name }}</strong>
                            <br>
                            <small class="text-muted">{{ $order->customer->email }}</small>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                    <td><strong class="text-primary">{{ number_format($order->total, 2) }}</strong></td>
                    <td>
                        @php
                            $statusColors = [
                                'pending' => 'warning',
                                'processing' => 'info',
                                'shipped' => 'primary',
                                'delivered' => 'success',
                                'cancelled' => 'danger'
                            ];
                        @endphp
                        <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                            {{ __('admin.' . $order->status) }}
                        </span>
                    </td>
                    <td>
                        @php
                            $paymentColors = [
                                'pending' => 'warning',
                                'paid' => 'success',
                                'failed' => 'danger',
                                'refunded' => 'info'
                            ];
                        @endphp
                        <span class="badge bg-{{ $paymentColors[$order->payment_status] ?? 'secondary' }}">
                            {{ __('admin.' . $order->payment_status) }}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('admin.confirm_delete') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="fas fa-shopping-bag" style="font-size: 3rem;"></i>
                        <p class="mt-2">{{ __('admin.no_data') }}</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
        <div class="mt-4">
            {{ $orders->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
