<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Session;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class AgentController extends Controller
{
    public function view() {
        if (!Auth::check()) {
            return redirect("login")->withSuccess('You are not allowed to access');
        }
        $agents = User::where("role_id", 1)->get();
        return view('agent.view')->with("agents",$agents);
    }

    public function add_form() {
        if (!Auth::check()) {
            return redirect("login")->withSuccess('You are not allowed to access');
        }
        $roles = Role::all();
        return view('agent.agent_add')->with("roles", $roles);
    }

    public function add(Request $request) {
        if (!Auth::check()) {
            return redirect("login")->withSuccess('You are not allowed to access');
        }
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'phone_no' => 'required',
            'address' => 'required',
        ]);

        $user = User::select('username')->where('phone_no', $request->phone_no)->first();
        
        if($user != null) {
            return back()->withErrors([
                'error' => 'Phone number already exist.',
            ]);
        }
        //$request->password = Hash::make($request->password);
        
        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'phone_no' => $request->phone_no,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'role_id' => $request->role_id,
            'status' => 1
        ]);
        return redirect()->route('agents')->with('success','Agent has been created successfully.');

    }

    public function edit_form($id) {
        if (!Auth::check()) {
            return redirect("login")->withSuccess('You are not allowed to access');
        }
        $agent = User::find($id);
        $roles = Role::all();
        return view('agent.agent_edit')->with("agent", $agent)->with("roles", $roles);
    }

    public function edit(Request $request) {
        if (!Auth::check()) {
            return redirect("login")->withSuccess('You are not allowed to access');
        }
        $user = User::select('username')->where('phone_no', $request->phone_no)->first();
        
        if($user != null) {
            return back()->withErrors([
                'error' => 'Phone number already exist.',
            ]);
        }
        User::where("id", $request->id)->first()->update(array('username'=>$request->username, 'phone_no'=>$request->phone_no, 'address'=>$request->address));
        return redirect()->route('agents')->with('success', 'Agent updated successfully');
    }


    public function delete(Request $request) {
        
    }
}
