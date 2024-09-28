@extends('template.layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Formulir <?= ucfirst($title) ?></h3>
            </div>
            <div class="card-body">
                <p>Berikut adalah formulir tambah  <?= strtolower($title) ?> baru </p>
                <?= session()->has('success') ? session()->getFlashdata('success') : '' ?>
                <?= session()->has('failed') ? session()->getFlashdata('failed') : '' ?>
                <form id="halte" method="POST" action="<?= url('admin/halte/update').'/'.$halte_id; ?>" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="patch" />
                    @include('halte._form')
                </form>
            </div>
            <div class="card-footer">
                <a href="<?= $back_url ?>" class="btn">Kembali</a>
                <button form="halte" type="submit" class="btn btn-primary">Perbarui data</button>
            </div>
        </div>
    </div>
</div>
@endSection