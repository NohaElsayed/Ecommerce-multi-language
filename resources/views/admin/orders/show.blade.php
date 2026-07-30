@extends('layouts.admin')
@section('title', __('admin.order_details'))
@section('page-title', __('admin.order_details') . ' #' . $order->order_number)

@section('content')
<div class="row">
    <!-- تفاصيل الطلب -->
    <div class="col-lg-8">
        <div class="card-custom mb-4">
            <h4 class="mb-4"><i class="fas fa-receipt"></i> {{ __('admin.order_details') }}</h4>

            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>{{ __('admin.order_number') }}:</strong> {{ $order->order_number }}</p>
                    <p><strong>{{ __('admin.date') }}:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                    <p><strong>{{ __('admin.payment_method') }}:</strong> {{ $order->payment_method == 'cod' ? __('admin.cash_on_delivery') : __('admin.credit_card') }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>{{ __('admin.status') }}:</strong>
                        <span class="badge bg-primary">{{ __('admin.' . $order->status) }}</span>
                    </p>
                    <p><strong>{{ __('admin.payment_status') }}:</strong>
                        <span class="badge bg-success">{{ __('admin.' . $order->payment_status) }}</span>
                    </p>
                </div>
            </div>

            <h5 class="mb-3">{{ __('admin.items') }}</h5>
            <div class="table-responsive">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('admin.product') }}</th>
                            <th class="text-center">{{ __('admin.quantity') }}</th>
                            <th class="text-center">{{ __('admin.price') }}</th>
                            <th class="text-center">{{ __('admin.total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                <strong>{{ $item->product_name }}</strong>
                                @if($item->product)
                                    <br>
                                    <small class="text-muted">SKU: {{ $item->product->sku }}</small>
                                @endif
                            </td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-center">{{ number_format($item->price, 2) }}</td>
                            <td class="text-center"><strong>{{ number_format($item->total, 2) }}</strong></td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>{{ __('admin.subtotal') }}:</strong></td>
                            <td class="text-center">{{ number_format($order->subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end"><strong>{{ __('admin.shipping') }}:</strong></td>
                            <td class="text-center">{{ number_format($order->shipping, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end"><strong>{{ __('admin.tax') }}:</strong></td>
                            <td class="text-center">{{ number_format($order->tax, 2) }}</td>
                        </tr>
                        <tr class="table-primary">
                            <td colspan="3" class="text-end"><strong>{{ __('admin.total') }}:</strong></td>
                            <td class="text-center"><strong class="fs-5">{{ number_format($order->total, 2) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- معلومات العميل والشحن -->
    <div class="col-lg-4">
        <div class="card-custom mb-4">
            <h5 class="mb-3"><i class="fas fa-user"></i> {{ __('admin.customer_info') }}</h5>
            @if($order->customer)
                <p><strong>{{ __('admin.name') }}:</strong> {{ $order->customer->full_name }}</p>
                <p><strong>{{ __('admin.email') }}:</strong> {{ $order->customer->email }}</p>
                <p><strong>{{ __('admin.phone') }}:</strong> {{ $order->customer->phone }}</p>
            @endif
        </div>

        <div class="card-custom mb-4">
            <h5 class="mb-3"><i class="fas fa-truck"></i> {{ __('admin.shipping_address') }}</h5>
            <p>{{ $order->shipping_address }}</p>
            <p>{{ $order->shipping_city }}</p>
            <p><strong>{{ __('admin.phone') }}:</strong> {{ $order->shipping_phone }}</p>
        </div>

        @if($order->notes)
        <div class="card-custom mb-4">
            <h5 class="mb-3"><i class="fas fa-sticky-note"></i> {{ __('admin.notes') }}</h5>
            <p class="text-muted">{{ $order->notes }}</p>
        </div>
        @endif

        <!-- تحديث الحالة -->
        <div class="card-custom">
            <h5 class="mb-3"><i class="fas fa-edit"></i> {{ __('admin.update_status') }}</h5>
            <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                @csrf
                @method('PATCH')
                <select name="status" class="form-select mb-3">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>{{ __('admin.pending') }}</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>{{ __('admin.processing') }}</option>
                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>{{ __('admin.shipped') }}</option>
                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>{{ __('admin.delivered') }}</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>{{ __('admin.cancelled') }}</option>
                </select>
                <button type="submit" class="btn btn-primary-custom w-100">
                    <i class="fas fa-save"></i> {{ __('admin.update') }}
                </button>
            </form>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}"></i> {{ __('admin.back_to_orders') }}
    </a>
</div>
@endsection
