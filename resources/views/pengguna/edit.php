<?= $this->extend('template/layout') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Formulir <?= ucfirst($title) ?></h3>
            </div>
            <div class="card-body">
                <p>Berikut adalah formulir tambah data pengguna baru </p>
                <?= session()->has('update_success') ? session()->getFlashdata('update_success') : '' ?>
                <?= session()->has('create_failed') ? session()->getFlashdata('create_failed') : '' ?>
                <form method="POST" id="pengguna" action="<?= site_url('pengguna/' . $user->id) ?>" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="put" />
                    <input type="hidden" name="id" value="<?= $user->id ?>">
                    <?= view_cell('\App\Libraries\Widget::formUser', []) ?>
                </form>
            </div>
            <div class="card-footer">
                <a href="<?= site_url('pengguna') ?>" class="btn">Kembali</a>
                <button form="pengguna" type="submit" class="btn btn-primary">Perbarui data</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>