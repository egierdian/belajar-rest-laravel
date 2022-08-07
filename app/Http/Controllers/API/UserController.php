<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

// class UserController extends Controller
class UserController extends BaseController 
{
    public function register(Request $request){
        try {
            // dd($request->validate());
            $request->validate([
                'name' => 'required',
                'email' => 'required|unique:users|email',
                'password' => 'required',
            ]);
    
            $params = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ];  
            
            $user = User::create($params);
    
            if($user){
                $token = $user->createToken('MyToken')->accessToken;
                $response = [
                    'token' => $token,
                    'user' => $user
                ];
                return $this->responseOk($response);
            } else {
                return $this->responseError('Registrasion failed',400);
            }
        } catch (Exception $err) {
            return $this->responseError('Registrasion failed',400, $err);
        }
    }
    public function login(Request $request){
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                $user = Auth::user();
                $token = $user->createToken('MyToken')->accessToken;
                $response = [
                    'token' => $token,
                    'name' => $user->name,
                ];
                return $this->responseOk($response);
            } else {
                return $this->responseError('Login failed',401,'Wrong email or password');
            }
        } catch (Exception $err) {
            return $this->responseError('Login failed',422, $err);
        }
    }

    public function profile(Request $request){
        return $this->responseOk($request->user());
    }
}
