@extends('admin.layout')

@section('title')
Dashboard
@endsection


@section('content')

<section class="section">
    <div class="section-header">
        <h1>Modal</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Bootstrap Components</a></div>
            <div class="breadcrumb-item">Modal</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">Deskripsi</h2>
        <div class="card">
            <div class="card-body">
                <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Tambah</button>
                <!-- /.menu-sortable -->
            </div>
        </div>
    </div>
</section>
<div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>Modal body text goes here.</p>
        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </div>
        </div>
    </div>
</div>

@endsection

@section('script')

<script>
    $(function () {

    });
</script>
@endsection
