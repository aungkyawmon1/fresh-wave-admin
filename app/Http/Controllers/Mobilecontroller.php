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

class Mobilecontroller extends Controller
{

    public function __construct()
    {
        # By default we are using here auth:api middleware
        $this->middleware('auth:api', ['except' => ['login', 'customerRegister','customerLogin']]);
    
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
    
        if(!$token = auth('api')->attempt($credentials))
        {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }

    public function test() {
        $user = User::find($request);
        $user_id = User::select('id')->where('phone_no', $request->phone_no)->first();
    
        $username = $user[0]->username;
        $password = $user[0]->password;
        $request1 = new Request([
            'username'   => $username,
            'password' => $password,
        ]);
        $credentials = $request1->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        if(!$token = Auth::attempt($credentials))
        {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }

    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }

    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth('api')->user()
        ]);
    }

    //for agent api
    public function orderList(Request $request) {
        $id = auth()->user()->id;
        $data = Order::where('agent_id', $id)->paginate(10);
        return response()->json([
            'data' => $data->items(),
            'pagination' => [
                'current_page' => $data->currentPage(),
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                // Add more pagination information as needed
            ],
        ]);
    }

    public function changeOrderStatus(Request $request) {
        $agent_id = auth()->user()->id;
        User::where("id", $request->id)->first()->update(array('status'=>$request->status));
        return response()->json([
            'status' => 'Success',
            'code' => 200,
            'message' => 'Successfully updated'
        ]);
    }

    public function requestStock(Request $request) {
        $agent_id = auth()->user()->id;
        return response()->json("successs");
    }
    //end agent api

    public function getPosts() {
        $data = Post::where('status', 1)->paginate(10);
        return response()->json([
            'data' => $data->items(),
            'pagination' => [
                'current_page' => $data->currentPage(),
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                // Add more pagination information as needed
            ],
        ]);
    }

    //customer api start
    public function customerRegister(Request $request) {
        $request->validate([
            'username' => 'required',
            'phone_no' => 'required',
            'address' => 'required'
        ]);
        $user = User::select('username')->where('phone_no', $request->phone_no)->first();
        
        if($user != null) {
            return response()->json([
                'status' => 'Success',
                'code' => 400,
                'message' => 'Phone number already exist.'
            ], 400);
        }
        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->phone_no),
            'phone_no' => $request->phone_no,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'role_id' => 2,
            'status' => 1
        ]);
            
        return response()->json([
            'status' => 'Success',
            'code' => 200,
            'message' => 'Successfully created'
        ]);
    }

    public function customerLogin(Request $request) {
        $credentials = $request->validate([
            'phone_no' => 'required'
        ]);
        $user = User::select('username')->where('phone_no', $request->phone_no)->first();
        if($user == null) {
            return response()->json([
                'status' => 'Fail',
                'code' => 401,
                'message' => 'Customer does not exist.'
            ], 401);
        }
        $username = $user->username;
        $password = $request->phone_no;
        $request1 = new Request([
            'username'   => $username,
            'password' => $password,
        ]);
        
        $credentials1 = $request1->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if(!$token = auth('api')->attempt($credentials1))
        {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }

    public function placeOrder(Request $request) {
        $user_id = auth()->user()->id;
        $request->validate([
            'agent_id' => 'required',
            'count' => 'required',
            'price' => 'required',
            'floor_price' => 'required',
            'net_price' => 'required',
            'total_price' => 'required'
        ]);
        
        Order::create([
            'agent_id' => $request->agent_id,
            'user_id' => $user_id,
            'count' => $user->count,
            'price' => $user->price,
            'floor_price' => $user->floor_price,
            'net_price' => $user->net_price,
            'total_price' => $user->total_price,
            'status' => 0
        ]);
            
        return response()->json([
            'status' => 'Success',
            'code' => 200,
            'message' => 'Successfully created'
        ]);
    }

    public function orderHistoroy() {
        $user_id = auth()->user()->id;
        $data = Order::where('user_id', $id)->paginate(10);
        return response()->json([
            'data' => $data->items(),
            'pagination' => [
                'current_page' => $data->currentPage(),
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                // Add more pagination information as needed
            ],
        ]);

    }
    //customer api end

}
