<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // ✅ Tambahkan pengecekan manual sebelum kirim reset link
        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'Email tidak ditemukan di sistem.'], 404);
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Link reset telah dikirim ke email Anda.'])
            : response()->json(['error' => 'Gagal mengirim reset link.'], 500);
    }
}
