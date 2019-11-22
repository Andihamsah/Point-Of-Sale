<?php

namespace App\Http\Controllers;

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
            'name' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required',                
        ]); 

        if($validator->fails())
        {
            return response()->json([

                'errors' => $validator->errors()->toJson(),'status' => 400
            ]);
        }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                
            ]);
        
        $token = auth()->login($user);
        $get = User::where('name',$request->name);
        $user = $get->first();
        return $this->respondWithTokenOnRegister($token,$user->id);


    }


    public function login(Request $request)
    {

        $validator = Validator::make($request->all(),
        [
            'name' => 'required|string|max:255',
            'password' => 'required|unique:users',                
        ]);

        
        if ($validator->fails()) 
        {
            return response()->json($validator->errors()->toJson(),400);
        }

        $credentials = $request->only(['name', 'password']);

        if (!$token = auth()->attempt($credentials)) 
        {
            return response()->json(['error' => 'Unauthorized'], 401);
        }          
        // $user = User::whereNotIn('name',[$request->name])->get();
        $login = User::where('name',$request->name)->get();
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

    protected function respondWithTokenOnRegister($token,$user)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => $user
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
        $user->password =bcrypt($request->password);

        if ($user->save()) {
            return response()->json(['massage' => "succes"]);
        }
        return response()->json(['massage' => "failed"]);
    }
    
    public function index()
    {
        return response()->json(User::whereNotIn('role',['1'])->get());
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