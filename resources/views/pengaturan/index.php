<?= $this->extend('template/layout') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= ucfirst($title) ?> Profil</h3>
            </div>
            <div class="card-body">
                <p class="">Berikut adalah informasi mengenai profil anda. Untuk memperbarui profil anda silahkan masukan informasi baru mengenai profil anda di form dibawah ini</p>
                <?= session()->has('update_success') ? session()->getFlashdata('update_success') : '' ?>
                <!-- create sample table bootstrap -->
                <?= session()->has('update_failed') ? session()->getFlashdata('update_failed') : '' ?>
                <div class="row">
                    <div class="col-8">
                        <form method="POST" action="<?= site_url("pengaturan/$user->id/profil") ?>" class="mb-2">
                            <?= csrf_field() ?>
                            <input type="hidden" name="_method" value="PUT">
                            <div class="form-group mb-3 row">
                                <label class="form-label col-3 col-form-label fw-bold">Role</label>
                                <div class="col-4">
                                    <p><?= @$user->roleCast ?></p>
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <label class="form-label col-3 col-form-label fw-bold">Email address</label>
                                <div class="col-4">
                                    <input type="email" class="form-control" name="email" id="email" value="<?= old('email') ?? ($user->email ?? '') ?>" placeholder="Email" autocomplete="off">
                                    <?php if ($validation->hasError('email')) : ?>
                                        <div id="" class="text-danger">
                                            <?= $validation->getError('email') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <label class="form-label col-3 col-form-label fw-bold">Username</label>
                                <div class="col-4">
                                    <input type="text" class="form-control" name="username" id="username" value="<?= old('username') ?? ($user->username ?? '') ?>" placeholder="Username" autocomplete="off">
                                    <?php if ($validation->hasError('username')) : ?>
                                        <div id="" class="text-danger">
                                            <?= $validation->getError('username') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <label class="form-label col-3 col-form-label fw-bold">Terdaftar</label>
                                <div class="col-4">
                                    <p><i><?= @$user->dibuatPada ?></i></p>
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <label class="form-label col-3 col-form-label fw-bold">Terakhir Diperbarui</label>
                                <div class="col-4">
                                    <p><i><?= @$user->diperbaruiPada ?></i></p>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Ubah profil</button>
                        </form>
                    </div>
                    <div class="col-12 col-sm-2 col-md-2 col-lg-1">
                        <?php if (@$user) : ?>
                            <img id="" class="rounded" src="<?= $user->url != '' && $user->url != 'default.png' ? base_url('public/upload/' . $user->url) : base_url('public/default.png') ?>" style="width:80px;height:100px;object-fit:cover;" />
                        <?php else : ?>
                            <img id="" class="rounded" src="<?= base_url('public/default.png') ?>" style="width:120px;height:150px;object-fit:cover;" />
                        <?php endif; ?>
                        <i>Foto profil</i>
                    </div>
                </div>
                <hr />
                <p>Ubah password</p>
                <form method="POST" action="<?= site_url("pengaturan/$user->id/password") ?>" class="mb-2">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="PUT">
                    <div class="form-group mb-3 row">
                        <label class="form-label col-2 col-form-label fw-bold">Password</label>
                        <div class="col-3">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" autocomplete="off">
                            <?php if ($validation->hasError('password')) : ?>
                                <div id="" class="text-danger">
                                    <?= $validation->getError('password') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <label class="form-label col-2 col-form-label fw-bold">Konfirmasi Password</label>
                        <div class="col-3">
                            <input type="password" class="form-control" name="pass_confirm" id="pass_confirm" placeholder="Password Konfirmasi" autocomplete="off">
                            <?php if ($validation->hasError('pass_confirm')) : ?>
                                <div id="" class="text-danger">
                                    <?= $validation->getError('pass_confirm') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Ubah password</button>
                </form>
                <hr />
                <p>Ubah foto profil</p>

                <form method="POST" action="<?= site_url("pengaturan/$user->id/foto-profil") ?>" enctype="multipart/form-data" class="mb-2">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="PUT">
                    <div class="row">
                        <label for="gambar" class="form-label">Foto Profil *</label>
                        <div class="col-3">
                            <input type="file" onchange="previewImage()" class="form-control <?= $validation->hasError('gambar') ? 'is-invalid' : '' ?>" name="gambar" id="gambar" />
                        </div>
                        <?php if ($validation->hasError('gambar')) : ?>
                            <div id="validationServer05Feedback" class="invalid-feedback">
                                <?= $validation->getError('gambar') ?>
                            </div>
                        <?php endif; ?>
                        <div class="row mt-3 mb-3">
                            <div class="col-12 col-sm-8 col-md-10 col-lg-6">
                                <?php if (@$user) : ?>
                                    <img id="imgPreview" class="rounded" src="<?= $user->url != '' && $user->url != 'default.png' ? base_url('public/upload/' . $user->url) : base_url('public/default.png') ?>" style="width:120px;height:150px;object-fit:cover;" />
                                <?php else : ?>
                                    <img id="imgPreview" class="rounded" src="<?= base_url('public/default.png') ?>" style="width:120px;height:150px;object-fit:cover;" />
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Ubah foto profil</button>
                </form>
            </div>
        </div>
        <div class="card-footer">
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    function previewImage() {
        const gambar = document.querySelector("#gambar");
        const gambarPreview = document.querySelector("#imgPreview");
        const fr = new FileReader();

        console.log(gambar);
        fr.readAsDataURL(gambar.files[0]);
        fr.onload = function(e) {
            gambarPreview.src = e.target.result;
        }

    }
</script>
<?= $this->endSection() ?>