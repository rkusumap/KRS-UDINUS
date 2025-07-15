<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\File;


class ProfileController extends Controller
{
    public function rules($request, $id = null)
    {
        $rule = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email' . ($id ? ",$id" : ''),
            'username' => 'required|unique:users,username' . ($id ? ",$id" : ''),
            'password' => $id ? 'nullable' : 'required',
            'password-confirmation' => $id ? 'nullable|same:password' : 'required|same:password',

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
    public function index(Request $request) {
        $data = Auth::user();
        return view('profile',compact('data'));
    }

    public function update($id,Request $request) {
        DB::beginTransaction();
        try {
            $validator = $this->rules($request->all(), $id);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'pesan' => $validator->errors()]);
            } else {
                $new_data = User::find($id);
                $new_data->name = $request->name;
                $new_data->email = $request->email;
                $new_data->username = $request->username;

                if ($request->password != null) {
                    $new_data->password = Hash::make($request->password);
                }

                if ($request->hasFile('img_user')) {

                    // Delete old image
                    File::delete(public_path("file/img/profile/" . $new_data->img_user));

                    // Upload new image
                    $file = $request->file('img_user');
                    $extension = $file->getClientOriginalExtension();

                    // Clean & timestamp filename
                    $originalName = str_replace(' ', '-', $file->getClientOriginalName());
                    $timestampedName = date('YmdHis') . '-' . $originalName;
                    $destinationPath = public_path('/file/img/profile/');
                    $fullPath = $destinationPath . $timestampedName;

                    // Move original file (temp before conversion)
                    $file->move($destinationPath, $timestampedName);

                    // Convert and save as webp
                    $fileNameNoExt = pathinfo($timestampedName, PATHINFO_FILENAME);
                    $webpFilename = $fileNameNoExt . '.webp';

                    Image::read($fullPath)
                        ->toWebp(90)
                        ->save($destinationPath . $webpFilename);

                    // Delete original
                    File::delete($fullPath);

                    // Update model
                    $new_data->img_user = $webpFilename;

                }

                $new_data->save();

                $dataLog = $new_data;
                insert_log('Update User','User',$dataLog->getKey(),json_encode($dataLog));

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
}
