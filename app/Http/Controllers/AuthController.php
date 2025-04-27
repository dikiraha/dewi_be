<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    // public function login(Request $request)
    // {
    //     $credentials = $request->only('email', 'password');

    //     if (!$token = JWTAuth::attempt($credentials)) {
    //         return response()->json(['error' => 'Email atau password salah'], 401);
    //     }

    //     return response()->json(compact('token'));
    // }

    // public function authenticate(Request $request)
    // {
    //     $login = $request->input('email');
    //     $password = $request->input('password');
        
    //     $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'nik';
        
    //     $credentials = [
    //         $field => $login,
    //         'password' => $password,
    //     ];
        
    //     if (Auth::attempt($credentials)) {
    //         return redirect()->route('website.home');
    //     } else {
    //         return redirect()->back()->withErrors(['unauthenticate' => 'Wrong email or NPK and password']);
    //     }
    // }

    public function login(Request $request)
    {
        $login = $request->input('email');
        $password = $request->input('password');
        
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'nik';
        
        $credentials = [
            $field => $login,
            'password' => $password,
        ];
        
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = JWTAuth::fromUser($user);
    
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'token' => $token,
                ]);
            } else {
                return redirect()->route('website.home');
            }
        } else {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'error' => 'Email/NIK atau password salah',
                ], 401);
            } else {
                return redirect()->back()->withErrors([
                    'unauthenticate' => 'Wrong email or NPK and password'
                ]);
            }
        }
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function loginPage()
    {
        return view('website.auth.login');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('website.login');
    }
}
