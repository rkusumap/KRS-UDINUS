<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController
{
    public function rule_login($request)
    {
        $rule = [
            'nim' => 'required',
            'password' => 'required',
        ];
        $pesan = [
            'nim.required' => 'NIM Wajib di isi',
            'password.required' => 'Password Wajib di isi',
        ];
        return Validator::make($request, $rule, $pesan);
    }


    public function login(Request $request)
    {
        $validator = $this->rule_login($request->all());
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        else{
            $nim_dinus = md5($request->nim);

            $credentials = [
                'nim_dinus' => $nim_dinus,
                'password' => $request->password,
            ];

            if (!$token = Auth::guard('api')->attempt($credentials)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'NIM atau Password Salah'
                ], 401);
            }

            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60
            ]);
        }

    }


    public function logout(Request $request)
    {
        try {
            Auth::guard('api')->logout();

            return response()->json([
                'status' => 'success',
                'message' => 'Logout berhasil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal logout',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}
