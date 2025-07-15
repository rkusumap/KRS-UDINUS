@extends('admin.layout')

@section('title')
Dashboard
@endsection

@section('content')

<section class="section">
    <div class="section-header">
        <h1>Show Hak Akses</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
            <div class="breadcrumb-item">Hak Akses</div>
        </div>
    </div>

    <div class="section-body">

        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-stripped">
                            <tr>
                                <th width="250px">Nama Level</th>
                                <td>{{$data->name_level}}</td>
                            </tr>
                            <tr>
                                <th width="250px">Kode Level</th>
                                <td>{{$data->code_level}}</td>
                            </tr>
                        </table>
                        <hr>
                        <h6>Data Module</h6>
                        <div class="col-md-12">
                            @foreach ($dataModule as $module)
                                <div class="form-group row">
                                    <label class="col-sm-12 pb-0 col-form-label font-weight-bold">
                                        {{$module->name_module}}
                                        <span class="font-weight-normal">({{$module->action_module}})</span>
                                    </label>
                                    <div class="col-sm-10 input-gmd">
                                        <input readonly type="text" value="{{$module->role($data->id_level)->first()->action_gmd ?? ''}}" name="action_gmd[{{$module->id_module}}]" class="form-control input-tags" aria-describedby="action_gmd">
                                    </div>
                                </div>
                                @if ($module->modules->count() > 0)
                                    @foreach ($module->modules as $mod)
                                        <div class="form-group row ml-3">
                                            <label class="col-sm-12 pb-0 col-form-label font-weight-bold">
                                                {{$mod->name_module}}
                                                <span class="font-weight-normal">({{$mod->action_module}})</span>
                                            </label>
                                            <div class="col-sm-10 input-gmd">
                                                <input readonly type="text" value="{{$mod->role($data->id_level)->first()->action_gmd ?? ''}}" name="action_gmd[{{$mod->id_module}}]" class="form-control input-tags" aria-describedby="action_gmd">
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer text-left">
                        <a href="{{ url('permission') }}" class="btn btn-light ml-3" >Kembali</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>



@endsection

@section('script')


<script>
    $(document).ready(function(){

    });
</script>

@endsection
