<div class="row">
    <div class="col-12 col-md-6">
        <?= csrf_field() ?>

        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label fw-bold">Kode</label>
            <div class="col-9">
                <input type="text" class="form-control" name="kode" id="kode" value="<?= old('kode') ?? (@$koridor->kode ?? '') ?>" placeholder="Kode Koridor" autocomplete="off">
            </div>
        </div>
        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label fw-bold">Koridor</label>
            <div class="col-9">
                <input type="text" class="form-control" name="nama" id="nama" value="<?= old('nama') ?? (@$koridor->nama ?? '') ?>" placeholder="Keterangan -" autocomplete="off">
            </div>

        </div>
    </div>

</div>