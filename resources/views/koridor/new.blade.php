@extends('template.layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Formulir <?= ucfirst($title) ?></h3>
            </div>
            <div class="card-body">
                <p>Berikut adalah formulir tambah data <?= ucfirst($title) ?> baru </p>
                <form id="koridor" method="POST" action="<?= url('admin/koridor/store') ?>" enctype="multipart/form-data">
                    @include('koridor._form')
                </form>
            </div>
            <div class="card-footer">
                <a href="<?= $back_url ?>" class="btn">Kembali</a>
                <button form="koridor" type="submit" class="btn btn-primary">Tambah data</button>
            </div>
        </div>
    </div>
</div>
@endSection