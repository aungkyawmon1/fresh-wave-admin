<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Hash;
use Session;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{

    public function show () {
        return view('login');
    }

    public function login (Request $request) {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials))
        {
            $request->session()->regenerate();
            return redirect()->route('dashboard')
                ->withSuccess('You have successfully logged in!');
        }

        return back()->withErrors([
            'email' => 'Your provided credentials do not match in our records.',
        ]);
    }

    public function logout() {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }

    public function dashboard () {
        if (Auth::check()) {
            return view('dashboard');
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function register_show() {
        return view('register');
    }

    public function register(Request $request) {
        $request->validate([
            'username' => 'required|string|max:250',
            'password' => 'required|min:2'
        ]);

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'status' => 1
        ]);

        $credentials = $request->only('username', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        return redirect()->route('dashboard')
        ->withSuccess('You have successfully registered & logged in!');
    }
 }
