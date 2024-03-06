<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Session;
use App\Models\Role;
use App\Models\Stock;
use DB;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    public function view() {
        if (!Auth::check()) {
            return redirect("login")->withSuccess('You are not allowed to access');
        }
        $stocks = DB::table('users')
            ->join('stocks', 'users.id', '=', 'stocks.agent_id')// joining the contacts table , where user_id and contact_user_id are same
            ->select('users.username', 'stocks.*')
            ->get();
        return view('stock.view')->with("stocks",$stocks);
    }

    public function add_stock_form($id) {
        if (!Auth::check()) {
            return redirect("login")->withSuccess('You are not allowed to access');
        }
        $stock = DB::table('users')
            ->join('stocks', 'users.id', '=', 'stocks.agent_id')// joining the contacts table , where user_id and contact_user_id are same
            ->where('stocks.id', $id)
            ->select('users.username', 'stocks.*')
            ->get();
        return view('stock.stock_edit')->with("stock",$stock[0]);
    }

    public function add_stock(Request $request) {
        if (!Auth::check()) {
            return redirect("login")->withSuccess('You are not allowed to access');
        }
        Stock::where("id", $request->id)->first()->update(array('count'=>$request->count));
        return redirect()->route('stocks')->with('success', 'Stock updated successfully');
    }
}
