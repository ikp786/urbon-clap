<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalUsers         = User::where('role_id',2)->count();
        $technicians        = User::where('role_id',3)->count();
        $totalAdminIncome   = Order::where('status','Completed')->sum('final_payment');
        $todayIncome        = Order::where('status','Completed')->whereDate('created_at', Carbon::today())->sum('final_payment');
        $totalTransaction   = Order::where('status','Completed')->count();
        $todayTransaction   = Order::whereDate('created_at', Carbon::today())->count();
        // dd($todayTransaction);
        $data = compact('totalUsers','technicians','totalAdminIncome','totalTransaction','todayTransaction','todayIncome');
        return view('admin.home',$data);
    }
}
