@extends('admin.layout')

@section('title')
Dashboard
@endsection

@section('content')

<section class="section">
    <div class="section-header">
        <h1>Tambah Module</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
            <div class="breadcrumb-item">Module</div>
        </div>
    </div>

    <div class="section-body">
        {{-- <h2 class="section-title">Module description</h2> --}}


        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <form action="{{ route('module.store') }}" id="form" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- <div class="card-header">
                          <h4>Server-side Validation</h4>
                        </div> --}}
                        {{-- <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control is-invalid" required="" value="rizal@fakhri">
                                <div class="invalid-feedback">
                                    Oh no! Email is invalid.
                                </div>
                            </div> --}}
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nama Module</label>
                                <input type="text" name="name_module" id="name_module" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Kode Module</label>
                                <input type="text" name="code_module" id="code_module" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Induk Module</label>
                                <select name="induk_module" id="induk_module" class="form-control select2">
                                    <option value="0">New Parent</option>
                                    @foreach ($modules as $module)
                                        <option value="{{ $module->id_module }}">{{ $module->name_module }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Link Module</label>
                                <input type="text" name="link_module" id="link_module" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Deskripsi Module</label>
                                <input type="text" name="description_module" id="description_module" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Icon Module</label>
                                <input type="text" name="icon_module" id="icon_module" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Aksi Module</label>
                                <input type="text" name="action_module" id="action_module" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Urutan</label>
                                <input type="number" name="order_module" id="order_module" class="form-control">
                            </div>
                        </div>
                        <div class="card-footer text-left">
                            <button type="submit" class="btn btn-primary btn-simpan">Submit</button>
                            <a href="{{ url('module') }}" class="btn btn-light ml-3" >Kembali</a>
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
                                    document.location='/module';
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
