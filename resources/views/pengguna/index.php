<?= $this->extend('template/layout') ?>

<?= $this->section('css') ?>
<link href="<?= base_url() ?>/public/node_modules/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<?= $this->endSection(); ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data <?= ucfirst($title) ?> </h3>
            </div>
            <div class="card-body">
                <p>Berikut adalah semua data pengguna yang sudah terdaftar </p>
                <?= session()->has('delete_success') ? session()->getFlashdata('delete_success') : '' ?>
                <?= session()->has('create_success') ? session()->getFlashdata('create_success') : '' ?>
                <div class="row">
                    <div class="col-12 col-sm-10 col-md-10 col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-vcenter table-mobile-md card-table">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Role</th>
                                        <th class="w-1"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user) : ?>
                                        <tr>
                                            <td data-label="Name">
                                                <div class="d-flex py-1 align-items-center">
                                                    <span class="avatar me-2" style="background-image: url(<?= $user->url != '' && $user->url != 'default.png' ? base_url('public/upload/' . $user->url) : base_url('public/default.png') ?>)"></span>
                                                    <div class="flex-fill">
                                                        <div class="font-weight-medium"><?= $user->username ?></div>
                                                        <div class="text-muted fst-italic"><a href="#" class="text-reset"><?= $user->email ?></a></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-muted" data-label="Role">
                                                <?= $user->roleCast ?>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <a href="<?= site_url("pengguna/$user->id/edit") ?>" class="btn text-primary me-1"><svg xmlns="http://www.w3.org/2000/svg" class="icon p-0 m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4"></path>
                                                            <line x1="13.5" y1="6.5" x2="17.5" y2="10.5"></line>
                                                        </svg></a>
                                                    <form onSubmit="event.preventDefault();deleteHandler(this);" class="d-inline" method="POST" action="<?= site_url("pengguna/$user->id") ?>">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="btn text-danger"><svg xmlns="http://www.w3.org/2000/svg" class="icon p-0 m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                <line x1="4" y1="7" x2="20" y2="7"></line>
                                                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                                                <line x1="14" y1="11" x2="14" y2="17"></line>
                                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                            </svg></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between align-items-center">
                    <?php if ($pager->getPageCount() > 1) : ?>
                        <?= $pager->makeLinks($pager->getCurrentPage(), $pager->getPerPage(), $pager->getTotal(), 'my_pager') ?>
                        <span class="text-muted small">
                            Total data <?= $pager->getTotal() ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="<?= base_url() ?>/public/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
<script>
    function deleteHandler(e) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-light me-2'
            },
            buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                e.submit();
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                dialogShowDelete = true;
            }
        })
    }
</script>
<?= $this->endSection() ?>