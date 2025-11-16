<?php

namespace App\Http\Controllers\Api;

use App\Helpers\JwtHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status'  => false,
                'message' => 'Email atau password salah'
            ], 401);
        }

        $accessPayload = [
            'id_user' => $user->id,
            'email'   => $user->email,
            'level'   => $user->level == 1 ? 'Admin' : 'Staff',
            'iat'     => time(),
            'exp'     => time() + config('jwt.access_expire')
        ];

        $refreshPayload = [
            'id_user' => $user->id,
            'email'   => $user->email,
            'iat'     => time(),
            'exp'     => time() + config('jwt.refresh_expire')
        ];

        return response()->json([
            'status'  => true,
            'message' => 'Login berhasil',
            'access_token' => JwtHelper::generateToken($accessPayload),
            'refresh_token' => JwtHelper::generateToken($refreshPayload),
            'data' => [
                'id_user'   => $user->id,
                'email'     => $user->email,
                'nama_lengkap' => $user->nama_lengkap,
                'level'     => $user->level == 1 ? 'Admin' : 'Staff',
            ]
        ]);
    }

    public function refreshToken(Request $request)
    {
        $request->validate([
            'refresh_token' => 'required'
        ]);

        try {
            $decoded = JwtHelper::decodeToken($request->refresh_token);

            $user = User::find($decoded->id_user);

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Refresh token tidak valid (user tidak ditemukan)'
                ], 401);
            }

            $payload = [
                'id_user' => $user->id,
                'email'   => $user->email,
                'level'   => $user->level == 1 ? 'Admin' : 'Staff',
                'iat'     => time(),
                'exp'     => time() + config('jwt.access_expire')
            ];

            return response()->json([
                'status' => true,
                'message' => 'Access token baru dibuat',
                'access_token' => JwtHelper::generateToken($payload),
                'refresh_token' => $request->refresh_token
            ]);

        } catch (\Firebase\JWT\ExpiredException $e) {
            return response()->json([
                'status' => false,
                'message'=> 'Refresh token expired, login ulang'
            ], 401);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message'=> 'Refresh token tidak valid: '.$e->getMessage()
            ], 401);
        }
    }

    public function profile(Request $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Data profil',
            'data' => $request->auth
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'password_new1' => 'required',
            'password_new2' => 'required|same:password_new1',
        ]);

        $user = User::find($request->auth->id_user);

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Password lama salah'
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password_new1)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Password berhasil diperbarui, silakan login kembali'
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = User::find($request->auth->id_user);

       

        $user->update([
            'nik'          => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            //'email'        => $request->email,
            'no_hp'        => $request->no_hp,
            'jabatan'      => $request->jabatan,
            'instansi'     => $request->instansi,
            'alamat_user'  => $request->alamat,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Profil berhasil diperbarui',
            'data'    => $user
        ]);
    }




}
