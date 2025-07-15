@extends('admin.layout')

@section('title')
Dashboard
@endsection

@section('content')

<section class="section">
    <div class="section-header">
        <h1>Edit Kategori</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
            <div class="breadcrumb-item">Kategori</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <form action="{{ route('category.update',$data->id_category) }}" id="form" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nama Kategori</label>
                                <input value="{{ $data->name_category }}" type="text" name="name_category" id="name_category" class="form-control">
                            </div>
                        </div>
                        <div class="card-footer text-left">
                            <button type="submit" class="btn btn-primary btn-simpan">Submit</button>
                            <a href="{{ url('category') }}" class="btn btn-light ml-3" >Kembali</a>
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
        });

        $('.btn-simpan').on('click',function () {
            $('#form').ajaxForm({
                success: function(response) {
                    if (response.status==true) {
                        swal({title: "Success!", text: "Berhasil Menyimpan Data", icon: "success"})
                                .then(function(){
                                    document.location='/category';
                            });
                    } else {
                        console.log(response);

                        let pesan = "";

                        $.each(response.pesan, function(key, value) {
                            pesan += value[0] + '. ';

                            let input = $('[name="' + key + '"]');
                            input.removeClass('is-invalid');
                            input.next('.invalid-feedback').remove();
                            input.addClass('is-invalid');

                            // Append invalid-feedback message
                            input.after('<div class="invalid-feedback">' + value[0] + '</div>');
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
