@extends('layouts.admin')
@section('title', __('admin.reports'))
@section('page-title', __('admin.reports'))

@section('content')
<!-- إحصائيات سريعة -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
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
    <div class="col-md-3">
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
    <div class="col-md-3">
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
    <div class="col-md-3">
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

<div class="row g-4">
    <!-- تقرير المبيعات -->
    <div class="col-lg-8">
        <div class="card-custom">
            <h5 class="mb-4"><i class="fas fa-chart-line"></i> {{ __('admin.sales_report') }}</h5>

            <form method="GET" action="{{ route('admin.reports.sales') }}" class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">{{ __('admin.from_date') }}</label>
                    <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">{{ __('admin.to_date') }}</label>
                    <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary-custom w-100">
                        <i class="fas fa-filter"></i> {{ __('admin.filter') }}
                    </button>
                </div>
            </form>

            @if(isset($salesReport))
                <div class="row text-center mb-4">
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded">
                            <p class="text-muted mb-1">{{ __('admin.total_orders') }}</p>
                            <h4 class="fw-bold text-primary">{{ $salesReport['total_orders'] }}</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded">
                            <p class="text-muted mb-1">{{ __('admin.total_revenue') }}</p>
                            <h4 class="fw-bold text-success">{{ number_format($salesReport['total_revenue'], 2) }}</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded">
                            <p class="text-muted mb-1">{{ __('admin.average_order') }}</p>
                            <h4 class="fw-bold text-info">{{ number_format($salesReport['average_order'], 2) }}</h4>
                        </div>
                    </div>
                </div>
            @endif

            <canvas id="salesChart" height="100"></canvas>
        </div>
    </div>

    <!-- أفضل المنتجات -->
    <div class="col-lg-4">
        <div class="card-custom">
            <h5 class="mb-4"><i class="fas fa-trophy"></i> {{ __('admin.top_products') }}</h5>
            <ul class="list-group list-group-flush">
                @foreach($stats['top_products'] as $index => $p)
                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary rounded-circle">{{ $index + 1 }}</span>
                        <span>{{ $p['name'] ?? 'Product' }}</span>
                    </div>
                    <span class="badge bg-success">{{ $p['order_items_count'] ?? 0 }}</span>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('salesChart').getContext('2d');
new Chart(ctx, {
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
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: { display: true }
        }
    }
});
</script>
@endpush
@endsection
