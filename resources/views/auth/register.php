<?= $this->extend('auth/template/layout') ?>

<?= $this->section('content') ?>

<div class="text-center mb-4">
    <a href="." class="navbar-brand navbar-brand-autodark"><img src="<?= base_url() ?>/public/static/logo.svg" height="36" alt=""></a>
</div>
<form class="card card-md" action="<?= base_url('login') ?>" method="POST" autocomplete="off">
    <?= csrf_field() ?>
    <div class="card-body">
        <h2 class="card-title text-center mb-4">Masuk menggunakan Akunmu</h2>
        <?= view('Myth\Auth\Views\_message_block') ?>
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="login" class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" value="<?php if (old('login')) echo old('login') ?>" placeholder="Masukan email atau username" autocomplete="off">
            <div class="invalid-feedback">
                <?= session('errors.login') ?>
            </div>
        </div>
        <div class="mb-2">
            <label class="form-label">
                Password
            </label>
            <div class="input-group input-group-flat">
                <input type="password" name="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="Password" autocomplete="off">
            </div>
            <div class="invalid-feedback">
                <?= session('errors.password') ?>
            </div>
        </div>
        <div class="mb-2">
            <label class="form-check">
                <input type="checkbox" name="remember" class="form-check-input" <?php if (old('remember')) : ?> checked <?php endif ?> />
                <span class="form-check-label">Ingat saya</span>
            </label>
        </div>
        <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </div>
    </div>
</form>

<?= $this->endSection() ?>