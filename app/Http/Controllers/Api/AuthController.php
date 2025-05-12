<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $login = $request->input('email');
        $password = $request->input('password');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'nik';
    
        $credentials = [
            $field => $login,
            'password' => $password,
        ];
    
        if (!auth('api')->attempt($credentials)) {
            // Jika dari API/Mobile
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            // Jika dari Web
            return redirect()->back()->withErrors(['login' => 'Login gagal'])->withInput();
        }
    
        $token = auth('api')->attempt($credentials);
    
        // Jika dari API/Mobile (Ionic)
        if ($request->expectsJson()) {
            $user = auth('api')->user();
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'nik' => $user->nik,
                    'phone' => $user->phone,
                    'roles' => $user->roles->pluck('name'), // jika pakai Spatie
                    'department' => optional($user->departments->first())->name, // sesuaikan relasi
                ]
            ]);
        }
    
        // Jika dari Web: login session biasa
        $user = auth('api')->user();
        Auth::loginUsingId($user->id); // masuk ke web guard
    
        // return redirect()->intended('/');
        return redirect()->route('api.home');
    }

    // public function me()
    // {
    //     return response()->json(auth('api')->user());
    // }

    public function me()
    {
        $user = auth('api')->user();

        $role = $user->getRoleNames()->first();

        $departments = $user->departments->pluck('name')->implode(', ');

        return response()->json([
            'id'         => $user->id,
            'name'       => $user->name,
            'email'      => $user->email,
            'nik'        => $user->nik,
            'phone'        => $user->phone,
            'roles'      => $role,
            'department' => $departments
        ]);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
