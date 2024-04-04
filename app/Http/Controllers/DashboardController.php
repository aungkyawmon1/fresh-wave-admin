<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Order;
use App\Models\Post;
use Validator;
use Hash;
use DB;

class DashboardController extends Controller
{
    public function dashboard () {
        $user_id = auth()->user()->id;
        $results = DB::table('orders')
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as created_at, MONTH(created_at) as month, COUNT(*) as count')
            ->where('status', 5)
            ->groupBy('created_at', DB::raw('MONTH(created_at)'))
            ->get();
        return view('dashboard')->with("data",$results);
    }
}
