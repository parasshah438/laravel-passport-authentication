<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile(Request $request)
    {
        $user = $request->user();

        return response()->json(['user' => $user], 200);
    }

    public function logout(Request $request)
    {
        $token = \Auth::user()->tokens()->each(function($token,$key){
            $token->delete();
        });
        //$token->revoke();

        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
