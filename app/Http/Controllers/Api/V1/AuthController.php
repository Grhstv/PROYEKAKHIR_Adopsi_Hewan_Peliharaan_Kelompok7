<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $data['email'])->first();

        // Pesan sama untuk email tidak ada dan password salah (tidak membocorkan email terdaftar).
        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Email atau password salah.'], 401);
        }

        return response()->json([
            'message'    => 'Login berhasil.',
            'token'      => $user->createToken('api-adopsi')->plainTextToken,
            'token_type' => 'Bearer',
            'user'       => $user->only(['id', 'name', 'email']),
            'roles'      => $user->getRoleNames(),
        ]);
    }

    public function me(Request $request)
    {
        return response()->json([
            'data' => $request->user()->only(['id', 'name', 'email']) + ['roles' => $request->user()->getRoleNames()],
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete(); // hanya token yang sedang dipakai

        return response()->json(['message' => 'Logout berhasil.']);
    }
}
