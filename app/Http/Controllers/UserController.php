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
            $user = User::whereNotIn('name',[$request->name])->get();                       
            $login = User::where('name',$request->name)->get();
            $login = $login->first();
            return $this->respondWithToken($token,$user,$login);
        }    


        protected function respondWithToken($token,$user,$login)
        {
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
                'login' => $login,
                'user' => $user
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
}