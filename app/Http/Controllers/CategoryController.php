<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function rules($request)
    {
        $rule = [
            'name_category' => 'required',
        ];
        $pesan = [
            'name_category.required' => 'Nama Kategori Wajib di isi',
        ];
        return Validator::make($request, $rule, $pesan);
    }

    public function index(Request $request) {
        $get_module = get_module_id('category');
        if (!notAccessBackHome($get_module)) {
            return redirect('/home');
        }
        return view('category.index',compact('get_module'));
    }

    public function json()
    {
        $datas = Category::select(['id_category', 'name_category'])
        ;

        return Datatables::of($datas)
            ->addColumn('action', function ($data) {
                //get module akses
                $id_module = get_module_id('category');

                //detail
                $btn_detail = '';
                if (isAccess('read', $id_module, auth()->user()->level_user)) {
                    $btn_detail = '<a class="dropdown-item" href="' . route('category.show', $data->id_category) . '">Detail</a>';
                }

                //edit
                $btn_edit = '';
                if (isAccess('update', $id_module, auth()->user()->level_user)) {
                    $btn_edit = '<button type="button" onclick="location.href=' . "'" . route('category.edit', $data->id_category) . "'" . ';" class="btn btn-sm btn-info">Edit</button>';
                }

                //delete
                $btn_hapus = '';
                if (isAccess('delete', $id_module, auth()->user()->level_user)) {
                    $btn_hapus = '<a class="dropdown-item btn-hapus" href="#hapus" data-id="' . $data->id_category . '" data-nama="' . $data->name_category . '">Hapus</a>';
                }
                return '
                <div class="btn-group">
                    ' . $btn_edit . '
                    <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-toggle-split" id="dropdownMenuSplitButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton1">
                        ' . $btn_detail . '
                        ' . $btn_hapus . '

                    </div>
                </div>
              ';
            })
            ->addIndexColumn() //increment
            ->make(true);
    }

    public function create(Request $request) {
        $get_module = get_module_id('category');
        if (!notAccessBackHome($get_module,'create')) {
            return redirect('/home');
        }
        return view('category.create');
    }

    public function store(Request $request) {
        DB::beginTransaction();
        try {
            $validator = $this->rules($request->all());
            if ($validator->fails()) {
                return response()->json(['status'=>false,'pesan'=>$validator->errors()]);
            }else{
                $data = new Category;
                $data->name_category       = $request->post('name_category') ;
                $data->save();

                $dataLog = $data;
                insert_log('Add Category','Category',$dataLog->getKey(),json_encode($dataLog));
                DB::commit();
                return response()->json(['status'=>true]);
            }

        }
        catch (Exception  $e) {
            DB::rollBack();
            insert_log(null,'Error '.date('Y-m-d H:i:s'),'Error','error',json_encode($e));
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function edit($id) {
        $get_module = get_module_id('category');
        if (!notAccessBackHome($get_module,'create')) {
            return redirect('/home');
        }
        $data = Category::find($id);
        return view('category.edit',compact('data'));
    }

    public function update($id,Request $request) {
        DB::beginTransaction();
        try {
            $validator = $this->rules($request->all());
            if ($validator->fails()) {
                return response()->json(['status'=>false,'pesan'=>$validator->errors()]);
            }else{
                $data = Category::find($id);
                $data->name_category       = $request->post('name_category') ;
                $data->save();

                $dataLog = $data;
                insert_log('Update Category','Category',$dataLog->getKey(),json_encode($dataLog));
                DB::commit();
                return response()->json(['status'=>true]);
            }

        }
        catch (Exception  $e) {
            DB::rollBack();
            insert_log(null,'Error '.date('Y-m-d H:i:s'),'Error','error',json_encode($e));
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function show($id) {
        $get_module = get_module_id('category');
        if (!notAccessBackHome($get_module,'read')) {
            return redirect('/home');
        }
        $data = Category::find($id);
        return view('category.show',compact('data'));
    }


    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $data = Category::find($id);
            $dataLog = $data;
            insert_log('Delete Category','Category',$dataLog->getKey(),json_encode($dataLog));
            Category::destroy($id);
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
