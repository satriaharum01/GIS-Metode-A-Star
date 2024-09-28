@extends('front.layout')
@section('main')
<div class="container mt-5">
    <div class="mb-3">
        <h1 class="fw-bold"><?= $bus->lambung ?></h1>
        <div class="row">
            <div class="col-12 col-md-6 table-responsive">
                <table class="mt-4 table table-striped">
                    <tr>
                        <td class="col-4">Koridor</td>
                        <td><?= $bus->Koridor->nama . $bus->Koridor->kode  ?></td>
                    </tr>
                    <tr>
                        <td>Koridor Kode</td>
                        <td><?= $bus->Koridor->kode ?></td>
                    </tr>
                    <tr>
                        <td>Tipe</td>
                        <td><?= $bus->tipe ?></td>
                    </tr>
                    <tr>
                        <td>Sumber Energi</td>
                        <td><?= $bus->sumber_energi ?></td>
                    </tr>
                    <tr>
                        <td>Jam Operasional</td>
                        <td><?= $bus->jam_operasional ?></td>
                    </tr>
                    <tr>
                        <td>Muatan</td>
                        <td><?= $bus->muatan.' Orang' ?></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td><?= $bus->status ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-12 col-md-6">
                <h6>Preview Foto</h6>
                <img id="foto_preview" style="height: 390px;width: 100%;border:1px solid black;" alt="preview-foto">
            </div>
        </div>

    </div>
</div>
@endSection
@section('js')
<script>
    $(function() {
        $('#foto_preview').attr('src', '<?= asset('/img/' . $bus->foto . ''); ?>');
    });
</script>
@endsection