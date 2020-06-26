<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;



class AuthController extends Controller
{
    //register
    public function register(Request $request){
       $validate = Validator::make($request->all(),[
           'name' => 'required|string',
           'email' => 'required|string|email|unique:users',
           'password' => 'required|confirmed|min:6']
        );


        if($validate->fails()){
            return response()->json([
                'status' => 'error',
                'errors' => $validate->errors()

            ],422);
        }
        $user = new User([
            'name' => $request->name,
            'email'=>$request->email,
            'password'=> bcrypt($request->password)
        ]);
        $user->save();
        return response()->json([
            'message' => 'Successfully Created User'
            ],201);
    } //end of register

    //login
    public function login(Request $request){
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = $request->only('email','password');
        if($token = $this->guard()->attempt($credentials)){
            return $this->respondWithToken($token);
        }
        return response()->json([
            'error' => 'Your Email/Password is wrong'
        ],401);
    }//end of login

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }//end of refresh

    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return response()->json(['data' => $user]);
    }//end of user

    public function logout()
    {
            $this->guard()->logout();
             return response()->json([
                 'status' => 'success',
                 'message' => 'Successfully logged out'
             ],200);
    }//end of logout

    private function guard(){
        //this methode will return adefault guard
        return Auth::guard();
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
        ]);
    }
}
