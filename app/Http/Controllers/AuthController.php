<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Level;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function rule_register($request, $id = null)
    {
        $rule = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email' . ($id ? ",$id" : ''),
            'username' => 'required|unique:users,username' . ($id ? ",$id" : ''),
            'password' => $id ? 'nullable' : 'required',
            'password-confirmation' => $id ? 'nullable|same:password' : 'required|same:password'
        ];
        $pesan = [
            'name.required' => 'Nama Wajib di isi',
            'email.required' => 'Email Wajib di isi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar, silakan gunakan email lain',
            'username.required' => 'Username Wajib di isi',
            'username.unique' => 'Username sudah terdaftar, silakan gunakan username lain',
            'password.required' => 'Password Wajib di isi',
            'password-confirmation.required' => 'Konfirmasi Password Wajib di isi',
            'password-confirmation.same' => 'Konfirmasi Password harus sama dengan Password'
        ];
        return Validator::make($request, $rule, $pesan);
    }

    public function rule_login($request)
    {
        $rule = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        $pesan = [
            'email.required' => 'Email Wajib di isi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password Wajib di isi',
        ];
        return Validator::make($request, $rule, $pesan);
    }
    public function showLogin()
    {
        return view('auth.login');
    }

    public function show_register()
    {
        return view('auth.register');
    }

    public function register(Request $request) {
        DB::beginTransaction();
        try {
            $validator = $this->rule_register($request->all());
            if ($validator->fails()) {
                return response()->json(['status' => false, 'pesan' => $validator->errors()]);
            } else {
                $dataLevel = Level::where('code_level','USR')->first();

                $new_data = new User();
                $new_data->name = $request->name;
                $new_data->email = $request->email;
                $new_data->username = $request->username;
                $new_data->status_user = '0';
                $new_data->level_user = $dataLevel->id_level;
                $new_data->password = Hash::make($request->password);

                $new_data->save();

                $dataLog = $new_data;

                insert_log('Register User','User',$dataLog->getKey(),json_encode($dataLog));

                DB::commit();
                return response()->json(['status' => true]);
            }
        }
        catch (Exception  $e) {
            DB::rollBack();
            insert_log(null,'Error '.date('Y-m-d H:i:s'),'Error','error',json_encode($e));
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function login(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = $this->rule_login($request->all());
            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'pesan' => $validator->errors()]);
            } else {
                $checkUser = User::where('email', $request->email)->first();
                if ($checkUser) {
                    if ($checkUser->status_user == '0') {
                        DB::rollBack();
                        return response()->json(['status' => false, 'message' => 'User belum diaktifkan oleh Admin']);
                    }
                }

                $credentials = $request->only('email', 'password');

                if (Auth::attempt($credentials)) {
                    $request->session()->regenerate();
                    $id_user = Auth::user()->id;
                    $dataUser = User::find($id_user);
                    $dataUser->last_login_at = now();
                    $dataUser->save();
                    DB::commit();
                    return response()->json(['status' => true]);
                }
                else{
                    DB::rollBack();
                    return response()->json(['status' => false, 'message' => 'Email atau Password Salah']);
                }
            }
        }
        catch (Exception  $e) {
            DB::rollBack();
            insert_log(null,'Error '.date('Y-m-d H:i:s'),'Error','error',json_encode($e));
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }

    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function login_api(Request $request)
    {
        $nim_dinus = md5($request->nim_dinus);

        $credentials = [
            'nim_dinus' => $nim_dinus,
            'password' => $request->pass_mhs,
        ];

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json(['message' => 'NIM atau Password Salah'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
