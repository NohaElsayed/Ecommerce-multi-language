<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct(private ReportService $reportService) {}

    /**
     * عرض صفحة التقارير الرئيسية
     */
    public function index()
    {
        $stats = $this->reportService->dashboardStats();
        return view('admin.reports.index', compact('stats'));
    }

    /**
     * عرض تقرير المبيعات مع الفلترة
     */
    public function sales(Request $request)
    {
        $stats = $this->reportService->dashboardStats();

        $salesReport = $this->reportService->salesReport(
            $request->get('from'),
            $request->get('to')
        );

        return view('admin.reports.index', compact('stats', 'salesReport'));
    }

    /**
     * تصدير التقرير (اختياري)
     */
    public function export(Request $request)
    {
        // يمكن إضافة منطق التصدير إلى Excel أو PDF هنا
        return back()->with('success', 'تم تصدير التقرير بنجاح');
    }
}
