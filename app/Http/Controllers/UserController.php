<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Level;
use App\Models\Module;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function rules($request, $id = null)
    {
        $rule = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email' . ($id ? ",$id" : ''),
            'username' => 'required|unique:users,username' . ($id ? ",$id" : ''),
            'password' => $id ? 'nullable' : 'required',
            'password-confirmation' => $id ? 'nullable|same:password' : 'required|same:password',
            'level_user' => 'required',
            'status_user' => 'required',
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
            'password-confirmation.same' => 'Konfirmasi Password harus sama dengan Password',
            'level_user.required' => 'Level Wajib di isi',
            'status_user.required' => 'Status Wajib di isi',
        ];
        return Validator::make($request, $rule, $pesan);
    }
    public function index(Request $request) {
        $get_module = get_module_id('users');
        if (!notAccessBackHome($get_module)) {
            return redirect('/home');
        }
        return view('users.index',compact('get_module'));
    }

    public function json()
    {
        $datas = User::orderBy('name', 'ASC')
        ;

        return Datatables::of($datas)
            ->addColumn('action', function ($data) {
                //get module akses
                $id_module = get_module_id('users');

                //detail
                $btn_detail = '';
                if (isAccess('read', $id_module, auth()->user()->level_user)) {
                    $btn_detail = '<a class="dropdown-item" href="' . route('users.show', $data->id) . '">Detail</a>';
                }

                //edit
                $btn_edit = '';
                $btn_reset_password = '';
                if (isAccess('update', $id_module, auth()->user()->level_user)) {
                    $btn_edit = '<button type="button" onclick="location.href=' . "'" . route('users.edit', $data->id) . "'" . ';" class="btn btn-sm btn-info">Edit</button>';
                    $btn_reset_password = '<a class="dropdown-item btn-reset-password" href="#resetpassword" data-id="' . $data->id . '" data-nama="' . $data->name . '">Reset Password</a>';
                }

                //delete
                $btn_hapus = '';
                if (isAccess('delete', $id_module, auth()->user()->level_user)) {
                    $btn_hapus = '<a class="dropdown-item btn-hapus" href="#hapus" data-id="' . $data->id . '" data-nama="' . $data->name . '">Hapus</a>';
                }
                return '
                <div class="btn-group">
                    ' . $btn_edit . '
                    <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-toggle-split" id="dropdownMenuSplitButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton1">
                        ' . $btn_detail . '
                        ' . $btn_reset_password . '
                        ' . $btn_hapus . '

                    </div>
                </div>
              ';
            })
            ->addColumn('level_user', function($row) {
                return $row->level->name_level ?? '-'; // safely get name_level
            })
            ->editColumn('status_user', function ($data) {
                if ($data->status_user == 1) {
                    $btn = '<button type="button" class="btn btn-sm btn-change btn-success" data-id="' . $data->id . '" data-nama="' . $data->name . '">Aktif</button>';
                } else {
                    $btn = '<button type="button" class="btn btn-sm btn-change btn-danger" data-id="' . $data->id . '" data-nama="' . $data->name . '">Non-Aktif</button>';
                }
                return $btn;
            })
            ->rawColumns(['action', 'status_user'])
            ->addIndexColumn() //increment
            ->make(true);
    }

    public function create(Request $request) {
        $get_module = get_module_id('users');
        if (!notAccessBackHome($get_module,'create')) {
            return redirect('/home');
        }
        $dataLevel = Level::orderby('name_level', 'ASC')->get();
        return view('users.create',compact('dataLevel'));
    }

    public function store(Request $request) {
        DB::beginTransaction();
        try {
            $validator = $this->rules($request->all());
            if ($validator->fails()) {
                return response()->json(['status' => false, 'pesan' => $validator->errors()]);
            } else {
                $new_data = new User();
                $new_data->name = $request->name;
                $new_data->email = $request->email;
                $new_data->username = $request->username;

                $new_data->level_user = $request->level_user;
                $new_data->status_user = $request->status_user;
                $new_data->password = Hash::make($request->password);

                $new_data->save();

                $dataLog = $new_data;
                insert_log('Add User','User',$dataLog->getKey(),json_encode($dataLog));

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

    public function edit($id,Request $request) {
        $get_module = get_module_id('users');
        if (!notAccessBackHome($get_module,'update')) {
            return redirect('/home');
        }

        $data = User::find($id);
        $dataLevel = Level::orderby('name_level', 'ASC')->get();
        return view('users.edit',compact('data','dataLevel'));
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

                $new_data->level_user = $request->level_user;
                $new_data->status_user = $request->status_user;

                if ($request->password != null) {
                    $new_data->password = Hash::make($request->password);
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

    public function show($id) {
        $get_module = get_module_id('users');
        if (!notAccessBackHome($get_module,'read')) {
            return redirect('/home');
        }
        $data = User::find($id);
        return view('users.show',compact('data'));
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $data = User::find($id);
            $dataLog = $data;
            insert_log('Delete User','User',$dataLog->getKey(),json_encode($dataLog));
            User::destroy($id);
            DB::commit();
            return response()->json(['status' => true]);
        }
        catch (Exception  $e) {
            DB::rollBack();
            insert_log(null,'Error '.date('Y-m-d H:i:s'),'Error','error',json_encode($e));
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function change_status($id) {
        DB::beginTransaction();
        try {
            $new_data = User::find($id);

            $dataLog = $new_data;
            insert_log('Before Change Status User','User',$dataLog->getKey(),json_encode($dataLog));
            $status = null;
            if ($new_data->status_user == 1) {
                $status = 0;
            }
            else {
                $status = 1;
            }
            $new_data->status_user = $status;
            $new_data->save();

            $dataLog = $new_data;
            insert_log('After Change Status User','User',$dataLog->getKey(),json_encode($dataLog));

            DB::commit();
            return response()->json(['status' => true]);
        }
        catch (Exception  $e) {
            DB::rollBack();
            insert_log(null,'Error '.date('Y-m-d H:i:s'),'Error','error',json_encode($e));
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function reset_password($id) {
        DB::beginTransaction();
        try {
            $new_data = User::find($id);

            $dataLog = $new_data;
            insert_log('Before Reset Password User','User',$dataLog->getKey(),json_encode($dataLog));

            $new_data->password = Hash::make('pass123');
            $new_data->save();

            $dataLog = $new_data;
            insert_log('After Reset Password User','User',$dataLog->getKey(),json_encode($dataLog));

            DB::commit();
            return response()->json(['status' => true]);
        }
        catch (Exception  $e) {
            DB::rollBack();
            insert_log(null,'Error '.date('Y-m-d H:i:s'),'Error','error',json_encode($e));
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
