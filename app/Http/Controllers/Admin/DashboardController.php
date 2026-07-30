<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ReportService;

class DashboardController extends Controller
{
    public function __construct(private ReportService $reportService) {}

    public function index()
    {
        $stats = $this->reportService->dashboardStats();
        return view('admin.dashboard', compact('stats'));
    }
}
