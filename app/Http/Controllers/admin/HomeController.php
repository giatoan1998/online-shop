<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index() {

        $totalOrders = Order::where('status', '!=', 'cancelled')->count();
        $totalProducts = Product::count();
        $totalCustomers= User::where('role', 1)->count();
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('grand_total');

        // This month revenue
        $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $currentDate = Carbon::now()->format('Y-m-d');

        $revenueThisMonth = Order::where('status', '!=', 'cancelled')
            ->whereDate('created_at', '>=', $startOfMonth)
            ->whereDate('created_at', '<=', $currentDate)
            ->sum('grand_total');

        // Last month revenue
        $lastMonthStartDate = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
        $lastMonthEndDate = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
        $lastMonthName = Carbon::now()->subMonth()->StartOfMonth()->format('M');

        $revenueLastMonth = Order::where('status', '!=', 'cancelled')
            ->whereDate('created_at', '>=', $lastMonthStartDate)
            ->whereDate('created_at', '<=', $lastMonthEndDate)
            ->sum('grand_total');

        // Last 15 days sale

        $date = Carbon::now()->subDay(6)->format('Y-m-d');

        $revenueLastFifteenDays = Order::where('status', '!=', 'cancelled')
            ->whereDate('created_at', '>=', $date)
            ->whereDate('created_at', '<=', $currentDate)
            ->sum('grand_total');



        return view('admin.dashboard', [
            'totalOrders' => $totalOrders,
            'totalProducts' => $totalProducts,
            'totalCustomers' => $totalCustomers,
            'totalRevenue' => $totalRevenue,
            'revenueThisMonth' => $revenueThisMonth,
            'revenueLastMonth' => $revenueLastMonth,
            'revenueLastFifteenDays' => $revenueLastFifteenDays,
            'lastMonthName' => $lastMonthName,
        ]);
        // $admin = Auth::guard('admin')->user();
        // echo 'Welcome '.$admin->name.' <a href="'.route('admin.logout').'">Logout</a>';
    }

    public function logout() {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
