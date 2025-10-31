<?php

namespace App\Services\Admin;

use App\Models\Order;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\Job;
use App\Models\Blog;
use App\Traits\Searchable;
use Illuminate\Http\Request;

class DashboardService
{
    use Searchable;

    public function getDashboardStats(): array
    {
        // Tổng doanh thu
        $totalEarnings = calculateEarnings(
            Order::pluck('default_amount')->toArray()
        );

        // Đếm thống kê
        $totalCandidates = Candidate::count();
        $totalCompanies = Company::count();
        $totalJobs = Job::count();
        $totalBlogs = Blog::count();

        // Thống kê việc làm
        $today = now()->format('Y-m-d');
        $activeJobs = Job::where('deadline', '>=', $today)->count();
        $expiredJobs = Job::where('deadline', '<', $today)->count();
        $pendingJobs = Job::where('status', 'pending')->count();

        return [
            'totalEarnings'   => $totalEarnings,
            'totalCandidates' => $totalCandidates,
            'totalCompanies'  => $totalCompanies,
            'totalJobs'       => $totalJobs,
            'totalBlogs'      => $totalBlogs,
            'activeJobs'      => $activeJobs,
            'expiredJobs'     => $expiredJobs,
            'pendingJobs'     => $pendingJobs,
        ];
    }

    public function getPendingJobs(Request $request, array $searchableColumns)
    {
        $query = Job::query()
            ->where('status', 'pending')
            ->orderByDesc('id');

        $this->search($query, $searchableColumns);

        return $query->paginate(20);
    }
}
