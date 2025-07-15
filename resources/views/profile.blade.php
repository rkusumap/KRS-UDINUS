@extends('admin.layout')

@section('title')
Dashboard
@endsection

@section('content')

<section class="section">
    <div class="section-header">
        <h1>Profile</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
            <div class="breadcrumb-item">Profile</div>
        </div>
    </div>

    <div class="section-body">



        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <form action="{{ route('profile.update',$data->id) }}" id="form" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nama</label>
                                <input value="{{ $data->name }}" type="text" name="name" id="name" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input value="{{ $data->email }}" type="email" name="email" id="email" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Username</label>
                                <input value="{{ $data->username }}" type="text" name="username" id="username" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Password</label> <span>*Biarkan kosong jika tidak ingin mengganti password</span>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Konfirmasi Password</label> <span>*Biarkan kosong jika tidak ingin mengganti password</span>
                                <input type="password" name="password-confirmation" id="password-confirmation" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="">Photo</label>
                                @php
                                    if (str_contains($data->img_user,'.webp')) {
                                        $url_img = '/file/img/profile/'.$data->img_user;
                                    } else {
                                        $url_img = null;
                                    }
                                @endphp
                                <input type="file" id="img_user" name="img_user" class="dropify" data-default-file="{{ $url_img }}" accept=".jpg,.jpeg,.png,.webp,image/webp" />
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

        $('.dropify').dropify({
            messages: {
                'default': 'Drag and drop a file here or click',
                'replace': 'Drag and drop or click to replace',
                'remove':  'Remove',
                'error':   'Oops, something went wrong.'
            }
        });

        // Remove validation error on input change or key press
        $('#form .form-control').on('input change', function () {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();

            if ($(this).hasClass('select2-hidden-accessible')) {
                $(this).next('.select2-container').find('.select2-selection').removeClass('is-invalid');
                $(this).closest('.form-group').find('.invalid-feedback').remove();
            }
        });

        $('.btn-simpan').on('click', function (e) {
            e.preventDefault();

            let form = $('#form')[0];
            let formData = new FormData(form);

            $.ajax({
                url: $('#form').attr('action'),
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status == true) {
                        swal({
                            title: "Success!",
                            text: "Berhasil Menyimpan Data",
                            icon: "success"
                        }).then(function () {
                            window.location = '/profile';
                        });
                    } else {
                        let pesan = "";

                        $.each(response.pesan, function (key, value) {
                            pesan += value[0] + '. ';
                            let input = $('[name="' + key + '"]');

                            input.removeClass('is-invalid');
                            input.next('.invalid-feedback').remove();
                            input.addClass('is-invalid');

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
                error: function () {
                    swal("Error!", "Proses Gagal", "error");
                }
            });
        });
    });
</script>

@endsection
