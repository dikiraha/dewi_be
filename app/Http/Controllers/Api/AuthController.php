<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $login = $request->input('email');
        $password = $request->input('password');

        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $login)->first();
        } else {
            $user = User::whereHas('user_profile', function ($q) use ($login) {
                $q->where('nik', $login);
            })->first();
        }

        if (!$user || !Hash::check($password, $user->password)) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            return redirect()->back()->withErrors(['login' => 'Login gagal'])->withInput();
        }

        $token = auth('api')->login($user);

        if ($request->expectsJson()) {
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'nik' => $user->user_profile->nik ?? null,
                    'phone' => $user->user_profile->phone ?? null,
                    'roles' => $user->roles->pluck('name'),
                    'department' => optional($user->departments->first())->name,
                ]
            ]);
        }

        Auth::loginUsingId($user->id);
        return redirect()->route('api.home');
    }

    public function me()
    {
        $user = auth('api')->user();
        $user_profile = $user->user_profile;
        $role = $user->getRoleNames()->first();
        $departments = $user->departments->pluck('name')->implode(', ');

        return response()->json([
            'id'         => $user->id,
            'name'       => $user->name,
            'email'      => $user->email,
            'nik'        => $user_profile->nik,
            'phone'      => $user_profile->phone,
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
