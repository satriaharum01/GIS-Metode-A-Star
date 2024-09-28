     <?= csrf_field() ?>
     <div class="form-group mb-3 row">
         <label class="form-label col-3 col-form-label fw-bold">Role</label>
         <div class="col-4">
             <select class="form-control<?php if ($validation->hasError('username')) : ?> is-invalid<?php endif; ?>" name="role">
                 <option <?= @$user->role != 'user' ?: 'selected' ?> value="user">User</option>
                 <option <?= @$user->role != 'admin' ?: 'selected' ?> value="admin">Administrator</option>
             </select>
             <?php if ($validation->hasError('role')) : ?>
                 <div id="" class="text-danger">
                     <?= $validation->getError('role') ?>
                 </div>
             <?php endif; ?>
         </div>
     </div>
     <div class="form-group mb-3 row">
         <label class="form-label col-3 col-form-label fw-bold">Email address</label>
         <div class="col-4">
             <input type="email" class="form-control<?php if ($validation->hasError('username')) : ?> is-invalid<?php endif; ?>" name="email" id="email" value="<?= old('email') ?? (@$user->email ?? '') ?>" placeholder="Email" autocomplete="off">
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
             <input type="text" class="form-control<?php if ($validation->hasError('username')) : ?> is-invalid<?php endif; ?>" name="username" id="username" value="<?= old('username') ?? (@$user->username ?? '') ?>" placeholder="Username" autocomplete="off">
             <?php if ($validation->hasError('username')) : ?>
                 <div id="" class="text-danger">
                     <?= $validation->getError('username') ?>
                 </div>
             <?php endif; ?>
         </div>
     </div>
     <div class="form-group mb-3 row">
         <label class="form-label col-3 col-form-label fw-bold">Password</label>
         <div class="col-4">
             <input type="password" class="form-control<?php if ($validation->hasError('username')) : ?> is-invalid<?php endif; ?>" name="password" id="password" placeholder="Password" autocomplete="off">
             <?php if ($validation->hasError('password')) : ?>
                 <div id="" class="text-danger">
                     <?= $validation->getError('password') ?>
                 </div>
             <?php endif; ?>
         </div>
     </div>
     <div class="form-group mb-3 row">
         <label class="form-label col-3 col-form-label fw-bold">Password Konfirmasi</label>
         <div class="col-4">
             <input type="password" class="form-control<?php if ($validation->hasError('username')) : ?> is-invalid<?php endif; ?>" name="pass_confirm" id="pass_confirm" placeholder="Password Konfirmasi" autocomplete="off">
             <?php if ($validation->hasError('pass_confirm')) : ?>
                 <div id="" class="text-danger">
                     <?= $validation->getError('pass_confirm') ?>
                 </div>
             <?php endif; ?>
         </div>
     </div>
     <div class="form-group mb-3 row">
         <label class="form-label col-3 col-form-label fw-bold">Foto Profil</label>
         <div class="col-4">
             <input type="file" onchange="previewImage()" class="form-control <?= $validation->hasError('gambar') ? 'is-invalid' : '' ?>" name="gambar" id="gambar" />
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
         <?php if ($validation->hasError('gambar')) : ?>
             <div id="validationServer05Feedback" class="invalid-feedback">
                 <?= $validation->getError('gambar') ?>
             </div>
         <?php endif; ?>
     </div>

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