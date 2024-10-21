<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\Job;
use App\Models\Order;
use App\Models\User;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    use Searchable;

    function __construct()
    {
        // $this->middleware(['permission:'])
    }

    function index() : View {
        // $amounts = Order::pluck('default_amount')->toArray();
        // $totalEarnings = calculateEarnings($amounts);
        // $totalCandidates = Candidate::count();
        // $totalCompanies = Company::count();
        $totalOrders = Order::count();
        $totalUsers = User::count();
        $deliveredRequests = Order::where('status', '=', 'delivered')->count();
        $inProcessRequests = Order::where('status', '=', 'in_progress')->count();
        $canceledRequests = Order::where('status', '=', 'canceled')->count();
        $pendingRequests = Order::where('status', '=', 'pending')->count();
        // $expiredJobs = Job::where('deadline', '<=', date('Y-m-d'))->count();
        // $pendingJobs = Job::where('status', 'pending')->count();
        // $totalBlogs = Blog::count();

        $query = Order::query();
        $this->search($query, ['pickup_location', 'delivery_location','size','weight','status']);
        $orders = $query->orderBy('status', 'DESC')->paginate(20);


        // return view('admin.dashboard.index', compact('totalEarnings', 'totalCandidates', 'totalCompanies', 'totalJobs', 'activeJobs', 'expiredJobs', 'pendingJobs', 'totalBlogs', 'jobs'));
        return view('admin.dashboard.index', compact('totalUsers','totalOrders','deliveredRequests','inProcessRequests', 'canceledRequests', 'pendingRequests','orders'));
    }
}
