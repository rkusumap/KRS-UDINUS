@extends('admin.layout')

@section('title')
Dashboard
@endsection

@section('content')
<style>
    .sortable > li > div {
        margin-bottom: 10px;
        border-bottom: 1px solid #ddd;
    }

    .sortable, .sortable > li > div {
        display: block;
        width: 100%;
        float: left;
    }

    .sortable > li {
        display: block;
        width: 100%;
        margin-bottom: 5px;
        float: left;
        border: 1px solid #ddd;
        background : #fff;
        padding: 5px;
    }
    .sortable ul {
        padding: 5px;
    }
</style>
<section class="section">
    <div class="section-header">
        <h1>Module</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
            <div class="breadcrumb-item">Module</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">Module description123</h2>


        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @if (isAccess('create', $get_module, auth()->user()->level_user))
                            <a class="btn btn-primary mb-3" href="{{ url('module/create') }}">Tambah</a>
                        @endif
                        <ul class="sortable list-unstyled ui-sortable" id="sortable">
                            @foreach ($data as $module)
                            @php
                                $id_module = get_module_id('module');

                                //selalu bisa
                                $detailButton = '<a class="" href="'.route('module.show',$module->id_module).'">Detail</a>';
                                $editButton = "";
                                if (isAccess('update',$id_module,auth()->user()->level_user)){
                                    $editButton = '<a href="#" onclick="location.href='."'".route('module.edit',$module->id_module)."'".';" class="">Edit</a>';
                                }
                                $deleteButton = "";
                                if (isAccess('delete',$id_module,auth()->user()->level_user)){
                                    $deleteButton = '<a class="btn-delete" href="#hapus" data-id="'.$module->id_module.'" data-nama="'.$module->name_module.'">Hapus</a>';
                                }
                                $action  =  '
                                '.$editButton.'
                                '.$detailButton.'
                                '.$deleteButton.'
                                ';
                            @endphp
                            <li id="mdl-{{$module->id_module}}">
                                <div class="block block-title">
                                    <i class="fa fa-sort"></i>
                                    {{$module->name_module}} ({{ $module->link_module }})
                                    {!!$action!!}
                                </div>

                                <ul class="sortable list-unstyled">
                                    @foreach ($module->modules as $submodule)
                                    @php
                                        $id_module = get_module_id('module');

                                        //selalu bisa
                                        $detailButton = '<a class="" href="'.route('module.show',$submodule->id_module).'">Detail</a>';
                                        $editButton = "";
                                        if (isAccess('update',$id_module,auth()->user()->level_user)){
                                            $editButton = '<a href="#" onclick="location.href='."'".route('module.edit',$submodule->id_module)."'".';" class="">Edit</a>';
                                        }
                                        $deleteButton = "";
                                        if (isAccess('delete',$id_module,auth()->user()->level_user)){
                                            $deleteButton = '<a class="btn-delete" href="#hapus" data-id="'.$submodule->id_module.'" data-nama="'.$submodule->name_module.'">Hapus</a>';
                                        }
                                        $action  =  '
                                        '.$editButton.'
                                        '.$detailButton.'
                                        '.$deleteButton.'
                                        ';
                                    @endphp
                                    <li id="mdl-{{$submodule->id_module}}">
                                        <div class="block block-title"><i class="fa fa-sort"></i> {{$submodule->name_module}} ({{ $submodule->link_module }}) {!!$action!!}</div>
                                        <ul class="sortable list-unstyled"></ul>
                                    </li>
                                    @endforeach
                                </ul><!-- /.menu-sortable -->

                            </li>
                            @endforeach
                        </ul><!-- /.menu-sortable -->
                        <!-- /.menu-sortable -->
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


@endsection

@section('script')
<script src="custom/js/jquery-ui.min.js"></script>
<script>
    $(function () {
        $(".sortable").sortable({
            connectWith: ".sortable",
            handle: ".block-title",
            placeholder: "ui-state-highlight",
            tolerance: "pointer",
            cursor: "move",
            update: function (event, ui) {
                // Optional: Capture the new order here
                var struct = [];
                var i = 0;
                $(".sortable").each(function(ind, el) {
                    struct[ind] = {
                    index: i,
                    class: $(el).attr("class"),
                    count: $(el).children().length,
                    parent: $(el).parent().is("li") ? $(el).parent().attr("id") : "",
                    parentIndex: $(el).parent().is("li") ? $(el).parent().index() : "",
                    array: $(el).sortable("toArray"),
                    serial: $(el).sortable("serialize")
                    };
                    i++;
                });

                var orderData = {};
                $(struct).each(function(k,v){
                    var main = v.array[0];
                    orderData[v.parent] = v.array;
                });
                // var myJsonString = JSON.stringify(orderData);
                // console.log(myJsonString);
                $.ajax({
                    url:"module/sort",
                    method:"POST",
                    data:{'main':orderData,'_token':'{{csrf_token()}}'},
                    success:function(data)
                    {
                    // alert('Data berhasil diperbarui');
                    }
                });
            }
        }).disableSelection();

        //delete
        $('#sortable').on('click', '.btn-delete', function(){
            var kode 	= $(this).data('id');
            var nama 	= $(this).data('nama');
            swal({
                title: "Apakah anda yakin?",
                text: "Untuk menghapus data : " + nama,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: 		'ajax',
                        method: 	'get',
                        url: 		'/module/delete/' + kode,
                        async: 		true,
                        dataType: 	'json',
                        success: 	function(response){
                            if(response.status==true){
                                swal({title: "Success!", text: "Berhasil Menghapus Data", icon: "success"})
                                    .then(function(){
                                    location.reload(true);
                                });
                            }else{
                                swal("Hapus Data Gagal !", {
                                    icon: "warning",
                                });
                            }
                        },
                        error: function(){
                            swal("ERROR", "Hapus Data Gagal.", "error");
                        }
                    });
                } else {
                    swal("Dibatalkan!", "Hapus Data Dibatalkan.", "error");
                }
            });
        });
    });
</script>
@endsection
