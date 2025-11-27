<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Login;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    // 🔹 Register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:login',
            'password' => 'required|min:6',
            'id_karyawan' => 'required|exists:mst_karyawan,id_karyawan',
        ]);

        $user = Login::create([
            'name' => $request->name,
            'email' => $request->email,
            'id_karyawan' => $request->id_karyawan,
            'password' => Hash::make($request->password),
            'api_token' => Str::random(60),
        ]);

        return response()->json([
            'message' => 'Register success',
            'token' => $user->api_token,
        ], 201);
    }

    // 🔹 Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'imei' => 'required',
        ]);

        $user = Login::where('email', $request->email)->first();

        if (Str::trim($user->imei) <> '') {
            return response()->json(['message' => 'Email ini sudah login di perangkat lain'], 401);
        }

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Email atau password salah'], 401);
        }

        // Buat token baru setiap login
        $user->api_token = Str::random(60);
        $user->save();

        return response()->json([
            'message' => 'Login success',
            'token' => $user->api_token,
        ]);
    }

    public function isValidLogin(Request $request) {
        $exists = DB::table('login')->where('api_token', $request->token)->exists();
            return response()->json([
                'exist' => $exists,
            ]);
        return $exists;
    }

    // 🔹 Logout
    public function logout(Request $request)
    {
        $user = $request->user();
        $user->api_token = null;
        $user->save();

        return response()->json(['message' => 'Logout success']);
    }

    // 🔹 Profile
    public function profile(Request $request)
    {
        // Ambil data berdasarkan api_token
        $user = Login::where('api_token', $request->token)->first();
    
        // Cek jika user ditemukan
        if ($user) {
            return response()->json([
                'status' => 'success',
                'data' => $user
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }
    }

}
