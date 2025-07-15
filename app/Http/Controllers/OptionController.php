<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Option;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\File;

class OptionController extends Controller
{

    public function rules($request, $id = null)
    {
        $rule = [
            'name_app_option' => 'required',
            'acronym_name_app_option' => 'required'
        ];
        $pesan = [
            'name_app_option.required' => 'Nama Aplikasi Wajib di isi',
            'acronym_name_app_option.required' => 'Nama Singkatan Aplikasi Wajib di isi'
        ];
        return Validator::make($request, $rule, $pesan);
    }

    public function index(Request $request) {
        $get_module = get_module_id('setting-website');
        if (!notAccessBackHome($get_module,'create')) {
            return redirect('/home');
        }
        $data = Option::find(1);
        return view('option',compact('data'));
    }

    public function update($id,Request $request) {
        DB::beginTransaction();
        try {
            $validator = $this->rules($request->all(), $id);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'pesan' => $validator->errors()]);
            } else {
                $new_data = Option::find($id);
                $new_data->name_app_option = $request->name_app_option;
                $new_data->acronym_name_app_option = $request->acronym_name_app_option;


                if ($request->hasFile('logo_app_option')) {

                    // Delete old image
                    File::delete(public_path("file/img/static/" . $new_data->logo_app_option));

                    // Upload new image
                    $file = $request->file('logo_app_option');
                    $extension = $file->getClientOriginalExtension();

                    // Clean & timestamp filename
                    $originalName = str_replace(' ', '-', $file->getClientOriginalName());
                    $timestampedName = 'logo-'.date('YmdHis') . '-' . $originalName;
                    $destinationPath = public_path('/file/img/static/');
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
                    $new_data->logo_app_option = $webpFilename;

                }


                if ($request->hasFile('logo_mini_app_option')) {

                    // Delete old image
                    File::delete(public_path("file/img/static/" . $new_data->logo_mini_app_option));

                    // Upload new image
                    $file = $request->file('logo_mini_app_option');
                    $extension = $file->getClientOriginalExtension();

                    // Clean & timestamp filename
                    $originalName = str_replace(' ', '-', $file->getClientOriginalName());
                    $timestampedName = 'logo-mini-'.date('YmdHis') . '-' . $originalName;
                    $destinationPath = public_path('/file/img/static/');
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
                    $new_data->logo_mini_app_option = $webpFilename;

                }

                $new_data->save();

                $dataLog = $new_data;
                insert_log('Update Option','Option',$dataLog->getKey(),json_encode($dataLog));

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
