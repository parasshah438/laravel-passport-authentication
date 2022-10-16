<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use App\Models\User;
use Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3|max:30|alpha',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed'
        ]);
        

        if ($validator->fails()) {
            return response()->json(['success'=>false,'message' => $validator->errors()], 422);
        }

        $user = new User();
        $user->name  = $request->name;
        $user->email  = $request->email;
        $user->password  = Hash::make($request->password); 
        $user->save();
        
        return response()->json(['success'=>True,'message' => 'You are successfully register','user' => $user],200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'email|required',
            'password' => 'required'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        
        $login_details = ['email'=>$request->email,'password'=>$request->password];

        if(!auth()->attempt($login_details)){
            return response()->json(['error' => 'UnAuthorised Access'], 401);
        }

        $token = auth()->user()->createToken('MyauthToken')->accessToken;
        return response()->json(['success'=>true,'message' => 'You are successfully login','user' => auth()->user(),'token'=>$token],200);
    }
}
