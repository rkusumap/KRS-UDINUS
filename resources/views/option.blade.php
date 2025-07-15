@extends('admin.layout')

@section('title')
Dashboard
@endsection

@section('content')

<section class="section">
    <div class="section-header">
        <h1>Setting Website</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
            <div class="breadcrumb-item">Setting Website</div>
        </div>
    </div>

    <div class="section-body">



        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <form action="{{ route('setting-website.update',$data->id_option) }}" id="form" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Aplikasi</label>
                                        <input value="{{ $data->name_app_option }}" type="text" name="name_app_option" id="name_app_option" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Singkatan Nama Aplikasi</label>
                                        <input value="{{ $data->acronym_name_app_option }}" type="text" name="acronym_name_app_option" id="acronym_name_app_option" class="form-control">
                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Warna Utama</label>
                                        <input value="{{ $data->primary_color_option }}" type="text" name="primary_color_option" id="primary_color_option" class="form-control colorpickerinput">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Warna Bayangan Utama</label>
                                        <input value="{{ $data->primary_color_shadow_option }}" type="text" name="primary_color_shadow_option" id="primary_color_shadow_option" class="form-control colorpickerinput">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Warna Tombol Fokus Utama</label>
                                        <input value="{{ $data->primary_color_focus_button_option }}" type="text" name="primary_color_focus_button_option" id="primary_color_focus_button_option" class="form-control colorpickerinput">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Warna Border Input Fokus Utama</label>
                                        <input value="{{ $data->primary_color_focus_input_border_option }}" type="text" name="primary_color_focus_input_border_option" id="primary_color_focus_input_border_option" class="form-control colorpickerinput">
                                    </div>
                                </div> --}}
                            </div>






                            <div class="form-group">
                                <label for="">Logo Aplikasi</label>
                                @php
                                    if (str_contains($data->logo_app_option,'.webp')) {
                                        $url_logo_app_option = '/file/img/static/'.$data->logo_app_option;
                                    } else {
                                        $url_logo_app_option = null;
                                    }
                                @endphp
                                <input type="file" id="logo_app_option" name="logo_app_option" class="dropify" data-default-file="{{ $url_logo_app_option }}" accept=".jpg,.jpeg,.png,.webp" />
                            </div>


                            <div class="form-group">
                                <label for="">Logo Mini Aplikasi</label>
                                @php
                                    if (str_contains($data->logo_mini_app_option,'.webp')) {
                                        $url_logo_mini_app_option = '/file/img/static/'.$data->logo_mini_app_option;
                                    } else {
                                        $url_logo_mini_app_option = null;
                                    }
                                @endphp
                                <input type="file" id="logo_mini_app_option" name="logo_mini_app_option" class="dropify" data-default-file="{{ $url_logo_mini_app_option }}" accept=".jpg,.jpeg,.png,.webp" />
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

        $(".colorpickerinput").colorpicker({
            format: 'hex',
            component: '.input-group-append',
        });

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
                            window.location = '/setting-website';
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
