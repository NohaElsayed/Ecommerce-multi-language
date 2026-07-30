<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportService
{
    public function dashboardStats(): array
    {
        return [
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total'),
            'total_customers' => Customer::count(),
            'total_products' => Product::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'monthly_sales' => $this->monthlySales(),
            'top_products' => $this->topProducts(),
        ];
    }

    public function monthlySales(int $months = 12): array
    {
        $data = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $data[] = [
                'month' => $date->format('M Y'),
                'total' => Order::where('payment_status', 'paid')
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->sum('total'),
            ];
        }
        return $data;
    }

    public function topProducts(int $limit = 5): array
    {
        return Product::withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    public function salesReport(?string $from, ?string $to): array
    {
        $query = Order::where('payment_status', 'paid');
        if ($from) $query->whereDate('created_at', '>=', $from);
        if ($to) $query->whereDate('created_at', '<=', $to);

        return [
            'total_orders' => $query->count(),
            'total_revenue' => $query->sum('total'),
            'average_order' => $query->avg('total') ?? 0,
            'orders' => $query->with('customer')->latest()->get(),
        ];
    }
}
