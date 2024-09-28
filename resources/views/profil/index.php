<?= $this->extend('template/layout') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data <?= ucfirst($title) ?></h3>
            </div>
            <div class="card-body">
                <p>Berikut adalah informasi mengenai profil anda. Untuk memperbarui profil anda silahkan masuk ke menu <a href="<?= site_url('pengaturan') ?>">Pengaturan</a></p>
                <div class="row">
                    <div class="col-12 col-sm-2 col-md-2 col-lg-1">
                        <?php if (@$user) : ?>
                            <img id="imgPreview" class="rounded" src="<?= $user->url != '' && $user->url != 'default.png' ? base_url('public/upload/' . $user->url) : base_url('public/default.png') ?>" style="width:80px;height:100px;object-fit:cover;" />
                        <?php else : ?>
                            <img id="imgPreview" class="rounded" src="<?= base_url('public/default.png') ?>" style="width:120px;height:150px;object-fit:cover;" />
                        <?php endif; ?>
                    </div>
                    <div class="col-12 col-sm-10 col-md-10 col-lg-11">
                        <table class="table table-stripped table-borderless">
                            <tr>
                                <th>Username</th>
                                <td><span class="fw-bold"><?= $user->username ?></span></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?= $user->email ?></td>
                            </tr>
                            <tr>
                                <th>Role</th>
                                <td><span class="badge bg-primary"><?= $user->role ?></span></td>
                            </tr>
                            <tr>
                                <th>Terdaftar</th>
                                <td><i><?= $user->dibuatPada ?></i></td>
                            </tr>
                            <tr>
                                <th>Terakhir Diperbarui</th>
                                <td><i><?= $user->diperbaruiPada ?></i></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>