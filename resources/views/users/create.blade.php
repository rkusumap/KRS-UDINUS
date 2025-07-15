@extends('admin.layout')

@section('title')
Dashboard
@endsection

@section('content')

<section class="section">
    <div class="section-header">
        <h1>Tambah User</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
            <div class="breadcrumb-item">User</div>
        </div>
    </div>

    <div class="section-body">



        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <form action="{{ route('users.store') }}" id="form" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="card-body">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="name" id="name" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" id="email" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" id="username" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Level</label>
                                <select name="level_user" id="level_user" class="form-control select2">
                                    <option value="">-Pilih Level-</option>
                                    @foreach ($dataLevel as $level)
                                        <option value="{{ $level->id_level }}"> {{ $level->name_level }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Status User</label>
                                <select name="status_user" id="status_user" class="form-control select2">
                                    <option value="">-Pilih Status-</option>
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Konfirmasi Password</label>
                                <input type="password" name="password-confirmation" id="password-confirmation" class="form-control">
                            </div>

                        </div>
                        <div class="card-footer text-left">
                            <button type="submit" class="btn btn-primary btn-simpan">Submit</button>
                            <a href="{{ url('permission') }}" class="btn btn-light ml-3" >Kembali</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>



@endsection

@section('script')


<script>
    $(document).ready(function(){

        // Remove validation error on input change or key press
        $('#form .form-control').on('input change', function () {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();

            if ($(this).hasClass('select2-hidden-accessible')) {
                $(this).next('.select2-container').find('.select2-selection').removeClass('is-invalid');
                $(this).closest('.form-group').find('.invalid-feedback').remove();
            }
        });

        $('.btn-simpan').on('click',function () {
            $('#form').ajaxForm({
                success: function(response) {
                    if (response.status==true) {
                        swal({title: "Success!", text: "Berhasil Menyimpan Data", icon: "success"})
                                .then(function(){
                                    document.location='/users';
                            });
                    } else {

                        let pesan = "";

                        $.each(response.pesan, function(key, value) {
                            pesan += value[0] + '. ';

                            let input = $('[name="' + key + '"]');
                            input.removeClass('is-invalid');
                            input.next('.invalid-feedback').remove();
                            input.addClass('is-invalid');

                            // Untuk select2, tambahkan class 'is-invalid' pada .select2-selection
                            if (input.hasClass('select2-hidden-accessible')) {
                                input.next('.select2-container').find('.select2-selection').addClass('is-invalid');
                                input.closest('.form-group').append('<div class="invalid-feedback d-block">' + value[0] + '</div>');
                            } else {
                                input.after('<div class="invalid-feedback">' + value[0] + '</div>');
                            }
                        });

                        swal("Error!", pesan, "error");
                    }
                },
                error: function(){
	                swal("Error!", "Proses Gagal", "error");
	            }
            })
        });
    });
</script>

@endsection
