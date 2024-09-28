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
                <form id="pengguna" method="POST" action="<?= site_url('pengguna') ?>" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <?= view_cell('\App\Libraries\Widget::formUser', []) ?>
                </form>
            </div>
            <div class="card-footer">
                <a href="<?= site_url('pengguna') ?>" class="btn">Kembali</a>
                <button form="pengguna" type="submit" class="btn btn-primary">Tambah data</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>