@extends('admin.layout')

@section('title')
Dashboard
@endsection

@section('content')

<section class="section">
    <div class="section-header">
        <h1>Show Module</h1>
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
                    <form action="{{ route('module.update',$data->id_module) }}" id="form" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <table class="table table-stripped">
                                <tr>
                                    <th width="250px">Parent Module</th>
                                    <td>{{$data->module->name_module ?? "Parent"}}</td>
                                </tr>
                                <tr>
                                    <th width="250px">Module Name</th>
                                    <td>{{$data->name_module}}</td>
                                </tr>
                                <tr>
                                    <th width="250px">Module Link</th>
                                    <td>{{$data->link_module}}</td>
                                </tr>
                                <tr>
                                    <th width="250px">Icon</th>
                                    <td>{{$data->icon_module}}</td>
                                </tr>
                                <tr>
                                    <th width="250px">Order Number</th>
                                    <td>{{$data->order_module}}</td>
                                </tr>
                                <tr>
                                    <th width="250px">Action Module</th>
                                    <td>{{$data->action_module}}</td>
                                </tr>
                                <tr>
                                    <th width="250px">Description</th>
                                    <td>{{$data->description_module}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="card-footer text-left">
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

    });
</script>

@endsection
