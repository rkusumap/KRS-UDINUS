@extends('admin.layout')

@section('title')
Dashboard
@endsection

@section('content')

<section class="section">
    <div class="section-header">
        <h1>Data User</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
            <div class="breadcrumb-item">Data User</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">Data User description</h2>


        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @if (isAccess('create', $get_module, auth()->user()->level_user))
                            <a class="btn btn-primary mb-3" href="{{ url('users/create') }}">Tambah</a>
                        @endif
                        <div class="">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pengguna</th>
                                        <th>Email</th>
                                        <th>Username</th>
                                        <th>Status</th>
                                        <th>Level</th>
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
                    ajax: '/users/json',
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
                        { data: 'name', name: 'name' },
                        { data: 'email', name: 'email' },
                        { data: 'username', name: 'username' },
                        { data: 'status_user', name: 'status_user' },
                        { data: 'level_user', name: 'level_user' },
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
                        url: 		'/users/delete/' + kode,
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

        //change status
        $('#tabel-body').on('click', '.btn-change', function(){
            var kode 	= $(this).data('id');
            var nama 	= $(this).data('nama');
            swal({
                title: "Apakah anda yakin?",
                text: "Untuk merubah status user : " + nama,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: 		'ajax',
                        method: 	'get',
                        url: 		'/users/change-status/' + kode,
                        async: 		true,
                        dataType: 	'json',
                        success: 	function(response){
                            if(response.status==true){
                                swal({title: "Success!", text: "Berhasil Rubah Status User " + nama , icon: "success"})
                                    .then(function(){
                                    location.reload(true);
                                });
                            }else{
                                swal("Gagal !", {
                                    icon: "warning",
                                });
                            }
                        },
                        error: function(){
                            swal("ERROR", "Gagal.", "error");
                        }
                    });
                } else {
                    swal("Cancelled", "Dibatalkan.", "error");
                }
            });
        });

        //reset password
        $('#tabel-body').on('click', '.btn-reset-password', function(){
            var kode 	= $(this).data('id');
            var nama 	= $(this).data('nama');
            swal({
                title: "Apakah anda yakin?",
                text: "Untuk reset password user : " + nama,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: 		'ajax',
                        method: 	'get',
                        url: 		'/users/reset-password/' + kode,
                        async: 		true,
                        dataType: 	'json',
                        success: 	function(response){
                            if(response.status==true){
                                swal({title: "Success!", text: "Berhasil Reset Password User " + nama + " dengan password pass123", icon: "success"})
                                    .then(function(){
                                    location.reload(true);
                                });
                            }else{
                                swal("Gagal !", {
                                    icon: "warning",
                                });
                            }
                        },
                        error: function(){
                            swal("ERROR", "Gagal.", "error");
                        }
                    });
                } else {
                    swal("Cancelled", "Dibatalkan.", "error");
                }
            });
        });
    });
</script>
@endsection
