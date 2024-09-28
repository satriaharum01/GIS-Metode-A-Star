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
                <?= session()->has('success') ? session()->getFlashdata('success') : '' ?>
                <?= session()->has('failed') ? session()->getFlashdata('failed') : '' ?>
                <form id="bus" method="POST" action="<?= url('admin/bus/update/'. $bus->id.'') ?>" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="patch" />
                    @include('bus._form')
                </form>
            </div>
            <div class="card-footer">
                <a href="<?= $back_url ?>" class="btn">Kembali</a>
                <button form="bus" type="submit" class="btn btn-primary">Perbarui data</button>
            </div>
        </div>
    </div>
</div>
@endSection
@section('js')
<script>
    $(function() {
        $('#foto_preview').attr('src', '<?= asset('/img/'.$bus->foto.'') ;?>');
    });
</script>
@endsection