@extends('admin.layout')

@section('title')
Dashboard
@endsection

@section('content')

<section class="section">
    <div class="section-header">
        <h1>Tambah Hak Akses</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
            <div class="breadcrumb-item">Hak Akses</div>
        </div>
    </div>

    <div class="section-body">



        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <form action="{{ route('permission.store') }}" id="form" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="card-body">
                            <div class="form-group">
                                <label>Nama Level</label>
                                <input type="text" name="name_level" id="name_level" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Kode Level</label>
                                <input type="text" name="code_level" id="code_level" class="form-control">
                            </div>

                            <hr>
                            <h5>Module Aplikasi</h5>
                            <div class="col-md-12">
                                @foreach ($dataModule as $module)
                                    <div class="form-group row">
                                        <label class="col-sm-12 pb-0 col-form-label font-weight-bold">
                                            {{$module->name_module}} - Link : {{$module->link_module}}
                                            <span class="font-weight-normal">({{$module->action_module}})</span>
                                            <button type="button" value="{{$module->action_module}}" class="btn btn-sm btn-primary btn-same mb-2">SAME</button>
                                        </label>
                                        <div class="col-sm-10 input-gmd">
                                            <input type="text" value="" name="action_gmd[{{$module->id_module}}]" class="form-control input-tags" aria-describedby="action_gmd">
                                        </div>
                                    </div>
                                    @if ($module->modules->count() > 0)
                                        @foreach ($module->modules as $mod)
                                            <div class="form-group row ml-3">
                                                <label class="col-sm-12 pb-0 col-form-label font-weight-bold">
                                                    {{$mod->name_module}} - Link : {{$mod->link_module}}
                                                    <span class="font-weight-normal">({{$mod->action_module}})</span>
                                                    <button type="button" value="{{$mod->action_module}}" class="btn btn-sm btn-primary btn-same mb-2">SAME</button>
                                                </label>
                                                <div class="col-sm-10 input-gmd">
                                                    <input type="text" value="" name="action_gmd[{{$mod->id_module}}]" class="form-control input-tags" aria-describedby="action_gmd">
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                @endforeach
                            </div>


                        </div>
                        <div class="card-footer text-left">
                            <button type="button" class="btn btn-primary btn-simpan">Submit</button>
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
        $(document).on('click','.btn-same',function () {
            var sameValue = $(this).val(); // get the action_module value
            var input = $(this).closest('.form-group').find('.input-tags'); // find the related input

            // Add the value to the tagsinput input
            input.tagsinput('add', sameValue);
        })

        $(".input-tags").tagsinput('items');

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
                                    document.location='/permission';
                            });
                    } else {

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
            $('#form').submit();
        });
    });
</script>

@endsection
