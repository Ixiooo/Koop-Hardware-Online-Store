<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;

use Illuminate\Support\Carbon;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    //
    public function showAdminDashboard()
    {
        $latest_orders= Order::orderBy('created_at', 'ASC')->get()->take(5);
        $registered_accounts = User::where('user_type', '=', 'user')->count();
        $low_on_stock= Product::where('product_stock', '<', '20')->count();
        $pending_orders= Order::where('status', '=', 'ordered')->count();
        $being_delivered= Order::where('status', '=', 'shipped')->count();
        $todays_sales= Order::where('status', '=', 'delivered')->whereDate('created_at', Carbon::today())->count();
        $todays_revenue= Order::where('status', '=', 'delivered')->whereDate('created_at', Carbon::today())->sum('total');
        $total_sales= Order::where('status', '=', 'delivered')->count();
        $total_revenue= Order::where('status', '=', 'delivered')->sum('total');

        $current_month_orders = Order::where('status', '=', 'delivered')->whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();
        $last_month_orders = Order::where('status', '=', 'delivered')->whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(1))->count();
        $last_2_month_orders = Order::where('status', '=', 'delivered')->whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->subMonth(2))->count();

        $data = array
        (
            'latest_orders' =>  $latest_orders,
            'registered_accounts' =>  $registered_accounts,
            'low_on_stock' =>  $low_on_stock,
            'pending_orders' =>  $pending_orders,
            'being_delivered' =>  $being_delivered,
            'todays_sales' =>  $todays_sales,
            'todays_revenue' =>  $todays_revenue,
            'total_sales' =>  $total_sales,
            'total_revenue' =>  $total_revenue,
            'title' =>  'Admin Dashboard',
            
            'current_month_orders' =>  $current_month_orders,
            'last_month_orders' =>  $last_month_orders,
            'last_2_month_orders' =>  $last_2_month_orders
        );

        return view('admin.dashboard')->with($data);
    }
    
}
