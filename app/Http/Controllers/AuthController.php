<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', [
            'except' => [
                'login',
                'register'
            ]
            ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::login($user);

        return response()->json([
            'status' => 'success',
            'message' => 'user registered successfully!',
            'user' => $user,
            'token' => $token
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => 'required',
            "password" => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        $token = Auth::attempt($credentials, $remember);

        if(!$token)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'login failed'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'logged in succesfully!',
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return response()->json([
            'status' => 'success',
            'message' => 'logged out successfully!'
        ]);
    }
}
