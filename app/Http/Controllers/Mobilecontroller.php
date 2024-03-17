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

class MobileController extends Controller
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
        if(auth('api')->user()->status != 1) {
            return $this->createNewToken($token);
            //return response()->json(['error' => 'Unauthorized'], 401); 
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

    public function updateProfile(Request $request) {
        $id = auth()->user()->id;
        User::where("id", $id)->first()->update(array('username'=>$request->username, 'phone_no'=>$request->phone_no, 'address'=>$request->address, 'latitude'=>$request->latitude, 'longitude'=>$request->longitude));
        return response()->json([
            'status' => 'Success',
            'code' => 200,
            'message' => 'Successfully updated'
        ]);
    }

    public function checkPhone(Request $request) {
        $user = User::select('username')->where('phone_no', $request->phone_no)->first();
        
        if($user != null) {
            return response()->json([
                'status' => 'Success',
                'code' => 400,
                'message' => 'Phone number already exist.'
            ], 400);
        }
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
        Order::where("id", $request->id)->first()->update(array('status'=>$request->status));
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

    public function getPosts(Request $request) {
        $req = " ";
        $des = " ";
        $data = Post::where('status', 1)->where('title', 'LIKE', "{$req}%")->orWhere('description', 'LIKE', "%{$des}%")->paginate(10);
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

    public function getNearestAgent() {
        $customer_id = auth()->user()->id;
        $customer = User::where("id", $customer_id)->get();
        // response()->json([$customer]);
        $latitude = $customer[0]->latitude;
        $longitude = $customer[0]->longitude;
        $nearestLocation = User::select('*')
            ->orderByRaw('POWER(latitude - '.$latitude.', 2) + POWER(longitude - '.$longitude.', 2)')
            ->first();
        //dd($nearestLocation->latitude, $nearestLocation->longitude, $nearestLocation->id, $nearestLocation->username);
        return response()->json([
            'id' => $nearestLocation->id,
            'username' => $nearestLocation->username,
            'latitude' => $nearestLocation->latitude,
            'longitude' => $nearestLocation->longitude,
            'address'  => $nearestLocation->address
        ]);
        
    }

    public function placeOrder(Request $request) {
        $user_id = auth()->user()->id;
        //return response()->json([$user_id]);
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
            'count' => $request->count,
            'price' => $request->price,
            'floor_price' => $request->floor_price,
            'net_price' => $request->net_price,
            'total_price' => $request->total_price,
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
        $data = Order::where('user_id', $user_id)->paginate(10);
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
