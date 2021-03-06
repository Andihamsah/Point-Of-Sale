<?php

namespace App\Http\Controllers;

use App\Store;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users',   
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'store' => 'required'                
        ]);

        if($validator->fails())
        {
            return response()->json([

                'errors' => $validator->errors()->toJson(),'status' => 400
            ], 400);
        }
            $store = Store::create([
                'name' => $request->store
            ]);
            $id_store = Store::orderBy('created_at', 'desc')->first();
                // dd($id_store->id);
            $user = User::create([
                'id_store' => $id_store->id,
                'username' => $request->username,
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => '1'
            ]);
        
        $token = auth()->login($user);
        $username = User::orderBy('created_at', 'desc')->first();
        return $this->respondWithTokenOnRegister($token,$username->id);
    }

    public function registerKasir(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_store' => 'required',  
            'username' => 'required|string|unique:users',        
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json([

                'errors' => $validator->errors()->toJson(),'status' => 400
            ], 400);
        }
            // $store = Store::find($request->id_store);
            // $id_store = Store::orderBy('created_at', 'desc')->first();
                // dd($id_store->id);
            $user = User::create([
                'id_store' => $request->id_store,
                'username' => $request->username,
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => '2'
            ]);
        
        $token = auth()->login($user);
        $username = User::orderBy('created_at', 'desc')->first();
        return $this->respondWithTokenOnRegister($token,$username->id);
    }

    public function showLoginKasir() 
    {

    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(),
        [
            'username' => 'required|string|max:255',
            'password' => 'required',                
        ]);

        
        if ($validator->fails()) 
        {
            return response()->json($validator->errors()->toJson(),400);
        }

        $credentials = $request->only(['username', 'password']);

        if (!$token = auth()->attempt($credentials))
        {
            return response()->json(['error' => 'Unauthorized'], 401);
        }          
        // $user = User::whereNotIn('name',[$request->name])->get();
        $login = User::where('username',$request->username)->get();
        $login = $login->first();
        return $this->respondWithToken($token,$login);
    }    

    public function loginKasir(Request $request)
    {

        $validator = Validator::make($request->all(),
        [
            'username' => 'required|string|max:255',
            'password' => 'required',                
        ]);

        
        if ($validator->fails()) 
        {
            return response()->json($validator->errors()->toJson(),400);
        }

        $credentials = $request->only(['username', 'password']);

        if (!$token = auth()->attempt($credentials)) 
        {
            return response()->json(['error' => 'Unauthorized'], 401);
        }          
        // $user = User::whereNotIn('name',[$request->name])->get();
        $login = User::where('username',$request->username)->get();
        $login = $login->first();
        return $this->respondWithToken($token,$login);
    }
    
    protected function respondWithToken($token,$login)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'login' => $login,
            // 'user' => $user
        ]);
    }

    protected function respondWithTokenOnRegister($token,$user_id)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user_id' => $user_id
        ]);
    }

    public function update(Request $request)
    {
        $admin = User::find($request->id);
        if (isset($request->name) && is_null($request->email)) {
            $admin->name =$request->name;

            if ($admin->save()) {
                return response()->json(['massage' => "succes"]);
            }
            return response()->json(['massage' => "failed"]);

        }elseif (isset($request->email) && is_null($request->name)) {
            $admin->email=$request->email;

            if ($admin->save()) {
                return response()->json(['massage' => "succes"]);
            }
            return response()->json(['massage' => "failed"]);

        }else{
            $admin->name = $request->name;
            $admin->email = $request->email;

            if ($admin->save()) {
                return response()->json(['massage' => "succes"]);
            }
            return response()->json(['massage' => "failed"]);

        }
    }

    public function updateprivasi(Request $request)
    {
        $user = User::find($request->id);
        if (isset($request->password) && is_null($request->username)) {
            $user->password =bcrypt($request->password);
    
            if ($user->save()) {
                return response()->json(['massage' => "succes"]);
            }
            return response()->json(['massage' => "failed"]);            
        }elseif (isset($request->username) && is_null($request->password)) {
            $user->username = $request->username;
            
            if ($user->save()) {
                return response()->json(['massage' => "succes"]);
            }
            return response()->json(['massage' => "failed"]);                        
        }else {
            $user->username = $request->username;
            $user->password = bcrypt($request->password);
            
            if ($user->save()) {
                return response()->json(['massage' => "succes"]);
            }
            return response()->json(['massage' => "failed"]);                        
        }
    }
    
    public function index($store_id)
    {
        $kasir = User::where('id_store',[$store_id])
                        ->whereNotIn('role',['1', '0'])->get();        
        if (count($kasir) == null) {
            return response()->json(['msg' => "users not avaible"]);
        }else {
            return response()->json($kasir);            
        }
    }
    
    public function deletekasir($id)
    {
        $kasir = User::find($id);
        if ($kasir->delete()) {
            return response()->json(['massage' => "succes"]);            
        }
        return response()->json(['massage' => "failed"]);
    }


}