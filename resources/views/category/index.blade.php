@extends('admin.layout')

@section('title')
Dashboard
@endsection

@section('content')

<section class="section">
    <div class="section-header">
        <h1>Kategori</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
            <div class="breadcrumb-item">Kategori</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">Kategori description</h2>


        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @if (isAccess('create', $get_module, auth()->user()->level_user))
                            <a class="btn btn-primary mb-3" href="{{ url('category/create') }}">Tambah</a>
                        @endif
                        <div class="">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                    <th class="text-center">
                                        No
                                    </th>
                                    <th>Nama Level</th>
                                    <th>Action</th>
                                    </tr>
                                </thead>

                                    <tbody id="tabel-body"></tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


@endsection

@section('script')

<script>
    $(function () {

        var table = $('#table-1').DataTable( {
                    processing: true,
                    serverSide: true,
                    stateSave : true,
                    ajax: '/category/json',
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
                        { data: 'name_category', name: 'name_category' },
                        { data: 'action', name: 'action', orderable: false, searchable: false}
                    ]
                });
        table.on( 'draw', function () {
            $('[data-toggle="tooltip"]').tooltip();
        });

        //delete
        $('#tabel-body').on('click', '.btn-hapus', function(){
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
                        url: 		'/category/delete/' + kode,
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
                    swal("Cancelled", "Hapus Data Dibatalkan.", "error");
                }
            });
        });
    });
</script>
@endsection
