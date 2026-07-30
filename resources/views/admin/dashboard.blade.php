@extends('layouts.admin')
@section('title', __('admin.dashboard'))
@section('page-title', __('admin.dashboard'))

@section('content')
<!-- Stats -->
<div class="row g-4 mb-4">
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="text-muted mb-1">{{ __('admin.total_orders') }}</p>
                    <h3 class="mb-0 fw-bold">{{ $stats['total_orders'] }}</h3>
                </div>
                <div class="stat-icon bg-grad-1"><i class="fas fa-shopping-bag"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="text-muted mb-1">{{ __('admin.revenue') }}</p>
                    <h3 class="mb-0 fw-bold">{{ number_format($stats['total_revenue'], 2) }}</h3>
                </div>
                <div class="stat-icon bg-grad-2"><i class="fas fa-dollar-sign"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="text-muted mb-1">{{ __('admin.customers') }}</p>
                    <h3 class="mb-0 fw-bold">{{ $stats['total_customers'] }}</h3>
                </div>
                <div class="stat-icon bg-grad-3"><i class="fas fa-users"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="text-muted mb-1">{{ __('admin.products') }}</p>
                    <h3 class="mb-0 fw-bold">{{ $stats['total_products'] }}</h3>
                </div>
                <div class="stat-icon bg-grad-4"><i class="fas fa-box"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card-custom">
            <h5 class="mb-4">{{ __('admin.monthly_sales') }}</h5>
            <canvas id="salesChart" height="100"></canvas>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card-custom">
            <h5 class="mb-4">{{ __('admin.top_products') }}</h5>
            <ul class="list-group list-group-flush">
                @foreach($stats['top_products'] as $p)
                <li class="list-group-item d-flex justify-content-between px-0">
                    <span>{{ $p['name'] ?? 'Product' }}</span>
                    <span class="badge bg-primary">{{ $p['order_items_count'] }}</span>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('salesChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode(array_column($stats['monthly_sales'], 'month')) !!},
        datasets: [{
            label: '{{ __("admin.sales") }}',
            data: {!! json_encode(array_column($stats['monthly_sales'], 'total')) !!},
            borderColor: '#667eea',
            backgroundColor: 'rgba(102,126,234,0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: { responsive: true, maintainAspectRatio: true }
});
</script>
@endpush
