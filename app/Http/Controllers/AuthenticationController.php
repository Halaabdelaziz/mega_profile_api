<?php

namespace App\Http\Controllers;
use  App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    //this method to register and create user in database
    public function createAccount(Request $request)
    {
        $attr = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|min:11|max:13|string',
        ]);


        $user = User::create([
            'name' => $attr['name'],
            'password' => bcrypt($attr['password']),
            'email' => $attr['email'],
            'phone' => $attr['phone'],
            'job_title' => $request->job_title,
            'image' => $request->image
        ]);

        $token = $user->createToken('myToken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ]; 

        return response($response, 201);
    }
    //use this method to signin users
    public function signin(Request $request)
    {
        $attr = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:6'
        ]);

        $user = User::where('email', $attr['email'])->first();
      
        if(!$user || !Hash::check($attr['password'], $user->password) ) {
            return response ([
                "Message" => "FALSE credentials",
            ],  401);
        }
        $token = $user->createToken('myAppToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ]; 

        return response($response, 201);
    }

    
    // this method signs out users by removing tokens
    public function signout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Tokens Revoked'
        ];
    }
}
