<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\DashboardService;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class DashboardController extends Controller
{
    use Searchable;

    protected DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index(Request $request)
    {
        try {
            $stats = $this->dashboardService->getDashboardStats();
            $jobs = $this->dashboardService->getPendingJobs($request, ['title', 'slug']);

            return view('admin.dashboard.index', [
                ...$stats,
                'jobs' => $jobs
            ]);

        } catch (\Throwable $e) {
            Log::error('Dashboard error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            abort(500, 'Không thể tải dữ liệu Dashboard.');
        }
    }
}
