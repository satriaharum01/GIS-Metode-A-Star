<div class="row">
    <div class="col-12 col-md-7">
        <?= csrf_field() ?>
        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label fw-bold">Koridor</label>
            <div class="col-9">
                <select class="form-control" id="kabupaten_kota_id" name="koridor" onChange="ubahKabKota(this)">
                    <option value="">- Pilih Koridor -</option>
                    <?php foreach ($koridor_load as $koridor) : ?>
                        <option value="<?= $koridor->id ?>" <?= old('koridor_id') ? (old('koridor_id') == $koridor->id ? 'selected' : '') : (@$bus->koridor_id == $koridor->id ? 'selected' : '') ?>><?= $koridor->nama ?> (<?= $koridor->kode ?>)</option>
                    <?php endforeach; ?>
                </select>
                <div class="mt-2">
                    <a class="" href="<?= url('/admin/koridor') ?>">+ Tambah koridor baru</a>
                </div>
            </div>
        </div>
        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label fw-bold">Tipe</label>
            <div class="col-9 ">
                <input type="text" class="form-control" name="tipe" value="<?= old('tipe') ?? (@$bus->tipe ?? '') ?>" placeholder="Tipe Bus" autocomplete="off">
            </div>
        </div>
        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label fw-bold">Nomor Lambung</label>
            <div class="col-9">
                <input type="text" class="form-control" name="lambung" value="<?= old('lambung') ?? (@$bus->lambung ?? '') ?>" placeholder="Nomor Lambung" autocomplete="off">
            </div>
        </div>
        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label fw-bold">Sumber Energi</label>
            <div class="col-9">
                <input type="text" class="form-control" name="sumber_energi" value="<?= old('sumber_energi') ?? (@$bus->sumber_energi ?? '') ?>" placeholder="Sumber Energi" autocomplete="off">
            </div>
        </div>
        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label fw-bold">Jam Operasional</label>
            <div class="col-9 d-flex justify-content-between">
                <input type="time" class="form-control-2" name="jam_start" value="<?= old('jam_start') ?? (@$bus->jam_start ?? '') ?>" placeholder="12:00" autocomplete="off">
                <label for="" class="p-2">Sd</label>
                <input type="time" class="form-control-2" name="jam_end" value="<?= old('jam_end') ?? (@$bus->jam_end ?? '') ?>" placeholder="12:00" autocomplete="off">
            </div>
        </div>
        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label fw-bold">Muatan</label>
            <div class="col-9">
                <input type="number" class="form-control" name="muatan" value="<?= old('muatan') ?? (@$bus->muatan ?? '') ?>" placeholder="Muatan : xx Orang" autocomplete="off">
            </div>
        </div>
        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label fw-bold">Foto</label>
            <div class="col-9">
                <label for="foto">Nama File : (<?= old('foto') ?? (@$bus->foto ?? '') ?>)</label>
                <input type="file" accept="image/*" class="form-control" value="Upload Publication" name="foto" value="<?= old('foto') ?? (@$bus->foto ?? '') ?>" placeholder="Upload Foto" autocomplete="off" id="foto">
                <input type="text" hidden class="form-control" name="filename_old" value="<?= old('foto') ?? (@$bus->foto ?? '') ?>" placeholder="Karoseri" autocomplete="off">
            </div>
        </div>
    </div>
    <div class="col-12 col-md-5">
        <h6>Preview Foto</h6>
        <img id="foto_preview" style="height: 390px;width: 100%;border:1px solid black;" alt="preview-foto">
    </div>
</div>
</div>