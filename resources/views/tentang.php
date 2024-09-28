<?= $this->extend('template/layout') ?>


<?= $this->section('content') ?>

<div class="container-narrow">
    <div class="card card-md">
        <div class="card-body">
            <h4 class="card-title">Tentang <?= APP_NAME ?></h4>
            <hr>
            <div class="markdown">
                <p>
                    <b><?= APP_NAME ?></b>Aplikasi astar pencarian rute terdekat menggunakan algoritma Astar.
                </p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>