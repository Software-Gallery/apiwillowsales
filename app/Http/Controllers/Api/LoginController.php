<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Login;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    // 🔹 Register
    public function register(Request $request)
    {
        Log::info('register ' . 'kodekaryawan=' . $request->id_karyawan, $request->all());
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:login',
                'password' => 'required|min:6',
                'id_karyawan' => 'required|exists:mst_karyawan,id_karyawan',
            ]);

            $user = Login::create([
                'name' => $request->name,
                'email' => $request->email,
                'id_karyawan' => 'kodekaryawan=' . $request->id_karyawan,
                'password' => Hash::make($request->password),
                'api_token' => Str::random(60),
            ]);

            return response()->json([
                'message' => 'Register success',
                'token' => $user->api_token,
            ], 201);
        } catch (\Exception $e) {
            Log::error('register ' . 'kodekaryawan=' . $request->id_karyawan . ' ERROR: ' . $e->getMessage(), $request->all());
            return response()->json(['status' => 'Error', 'message' => $e->getMessage()], 500);
        }
    }

    // 🔹 Login
    public function login(Request $request)
    {
        Log::info('login ' . 'kodekaryawan=' . $request->id_karyawan, $request->all());
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
                'imei' => 'required',
            ]);

            $user = Login::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['message' => 'Email atau password salah'], 401);
            }

            if (Str::trim($user->imei) <> '' && Str::trim($user->imei) <> $request->imei) {
                return response()->json(['message' => 'Email ini sudah login di perangkat lain'], 401);
            }

            // Buat token baru setiap login
            $user->api_token = Str::random(60);
            $user->imei = $request->imei;
            $user->save();

            return response()->json([
                'message' => 'Login success',
                'token' => $user->api_token,
            ]);
        } catch (\Exception $e) {
            Log::error('login ' . 'kodekaryawan=' . $request->id_karyawan . ' ERROR: ' . $e->getMessage(), $request->all());
            return response()->json(['status' => 'Error', 'message' => $e->getMessage()], 500);
        }
    }

    public function isValidLogin(Request $request)
    {
        Log::info('isValidLogin ' . 'kodekaryawan=' . $request->id_karyawan, $request->all());
        try {
            $exists = DB::table('login')->where('api_token', $request->token)->exists();
            return response()->json([
                'exist' => $exists,
            ]);
            return $exists;
        } catch (\Exception $e) {
            Log::error('isValidLogin ' . 'kodekaryawan=' . $request->id_karyawan . ' ERROR: ' . $e->getMessage(), $request->all());
            return response()->json(['status' => 'Error', 'message' => $e->getMessage()], 500);
        }
    }

    public function isValidImei(Request $request)
    {
        Log::info('isValidImei ' . 'kodekaryawan=' . $request->id_karyawan, $request->all());
        try {
            $exists = DB::table('login')->where('imei', $request->imei)->exists();
            return response()->json([
                'exist' => $exists,
            ]);
            return $exists;
        } catch (\Exception $e) {
            Log::error('isValidImei ' . 'kodekaryawan=' . $request->id_karyawan . ' ERROR: ' . $e->getMessage(), $request->all());
            return response()->json(['status' => 'Error', 'message' => $e->getMessage()], 500);
        }
    }

    // 🔹 Logout
    public function logout(Request $request)
    {
        Log::info('logout ' . 'kodekaryawan=' . $request->id_karyawan, $request->all());
        try {
            $user = $request->user();
            $user->api_token = null;
            $user->save();

            return response()->json(['message' => 'Logout success']);
        } catch (\Exception $e) {
            Log::error('logout ' . 'kodekaryawan=' . $request->id_karyawan . ' ERROR: ' . $e->getMessage(), $request->all());
            return response()->json(['status' => 'Error', 'message' => $e->getMessage()], 500);
        }
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

    public function resetImei(int $id)
    {
        Log::info('resetImei ' . $id, ['id' => $id]);
        try {
            DB::table('login')
                ->where('id', $id)
                ->update([
                    'imei' => '',
                ]);
        } catch (\Exception $e) {
            Log::error('resetImei ' . $id . ' ERROR: ' . $e->getMessage(), ['id' => $id]);
            return response()->json(['status' => 'Error', 'message' => $e->getMessage()], 500);
        }
    }

}
