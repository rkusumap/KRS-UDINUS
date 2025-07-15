<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Register &mdash; Stisla</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="/stisla/dist/assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="/stisla/dist/assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="/stisla/dist/assets/modules/jquery-selectric/selectric.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="/stisla/dist/assets/css/style.css">
  <link rel="stylesheet" href="/stisla/dist/assets/css/components.css">

  {{-- icon aplikasi --}}
  <link rel="icon" type="image/png" href="{{ '/file/img/static/'. $optionAppServiceProvider->logo_mini_app_option }}">


</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
            <div class="login-brand">
              <img src="{{ '/file/img/static/'. $optionAppServiceProvider->logo_app_option }}" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>

            <div class="card card-primary">
              <div class="card-header"><h4>Register</h4></div>

              <div class="card-body">
                <form method="POST" action="{{ route('register') }}" id="form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input id="name" type="text" class="form-control" name="name" autofocus>
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input id="username" type="text" class="form-control" name="username" autofocus>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" class="form-control" name="email">
                    </div>

                    <div class="row">
                        <div class="form-group col-6">
                            <label for="password" class="d-block">Password</label>
                            <input id="password" type="password" class="form-control" name="password">

                        </div>
                        <div class="form-group col-6">
                            <label for="password-confirmation" class="d-block">Password Confirmation</label>
                            <input id="password-confirmation" type="password" class="form-control" name="password-confirmation">
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="button" class="btn btn-primary btn-lg btn-block btn-simpan">
                            Register
                        </button>
                    </div>
                </form>
              </div>
            </div>
            <div class="simple-footer">
              Copyright &copy; Stisla 2018
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="/stisla/dist/assets/modules/jquery-3.7.1.min.js"></script>
  <script src="/stisla/dist/assets/modules/popper.js"></script>
  <script src="/stisla/dist/assets/modules/tooltip.js"></script>
  <script src="/stisla/dist/assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="/stisla/dist/assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="/stisla/dist/assets/modules/moment.min.js"></script>
  <script src="/stisla/dist/assets/js/stisla.js"></script>

  <!-- JS Libraies -->
  <script src="/stisla/dist/assets/modules/jquery-pwstrength/jquery.pwstrength.min.js"></script>
  <script src="/stisla/dist/assets/modules/jquery-selectric/jquery.selectric.min.js"></script>

  <!-- Page Specific JS File -->
  <script src="/stisla/dist/assets/js/page/auth-register.js"></script>

  <!-- Template JS File -->
  <script src="/stisla/dist/assets/js/scripts.js"></script>
  <script src="/stisla/dist/assets/js/custom.js"></script>
  <script src="/custom/js/jquery.form.4.3.0.min.js"></script>
  <script src="/stisla/dist/assets/modules/sweetalert/sweetalert.min.js"></script>

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
                        swal({title: "Success!", text: "Berhasil Registrasi, Tunggu Konfirmasi Admin", icon: "success"})
                                .then(function(){
                                    document.location='/login';
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
            $('#form').submit();
        });
    });
  </script>
</body>
</html>
