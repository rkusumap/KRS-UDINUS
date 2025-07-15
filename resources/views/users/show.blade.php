@extends('admin.layout')

@section('title')
Dashboard
@endsection

@section('content')

<section class="section">
    <div class="section-header">
        <h1>Show User</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
            <div class="breadcrumb-item">User</div>
        </div>
    </div>

    <div class="section-body">

        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-stripped">
                            <tr>
                                <th width="250px">Nama</th>
                                <td>{{$data->name}}</td>
                            </tr>
                            <tr>
                                <th width="250px">Username</th>
                                <td>{{$data->username}}</td>
                            </tr>
                            <tr>
                                <th width="250px">Email</th>
                                <td>{{$data->email}}</td>
                            </tr>
                            <tr>
                                <th width="250px">Level</th>
                                <td>{{$data->level->name_level}}</td>
                            </tr>
                            <tr>
                                <th width="250px">Status</th>
                                <td>{{reference('status',$data->status_user)}}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="card-footer text-left">
                        <a href="{{ url('users') }}" class="btn btn-light ml-3" >Kembali</a>
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
