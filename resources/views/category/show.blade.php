@extends('admin.layout')

@section('title')
Dashboard
@endsection

@section('content')

<section class="section">
    <div class="section-header">
        <h1>Detail Kategori</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
            <div class="breadcrumb-item">Kategori</div>
        </div>
    </div>

    <div class="section-body">

        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-stripped">
                            <tr>
                                <th width="250px">Nama Kategori</th>
                                <td>{{$data->name_category}}</td>
                            </tr>

                        </table>
                    </div>
                    <div class="card-footer text-left">
                        <a href="{{ url('category') }}" class="btn btn-light ml-3" >Kembali</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>



@endsection

@section('script')


<script>
    $(document).ready(function(){

    });
</script>

@endsection
