@extends('template.layout')


@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header justify-content-between">
                <h3 class="card-title"><?= ucfirst($title) ?></h3>
                <a class="float-right btn btn-primary" href="<?= $add_url ?>"><i class="fas fa-plus"></i> Tambah <?= $title ?></a>
            </div>
            <div class="card-body">
                <p>Berikut adalah semua data <?= $title ?> yang sudah terdaftar </p>
                <?= session()->has('success') ? session()->getFlashdata('success') : '' ?>
                <div class="row">
                    <div class="col-12 col-sm-10 col-md-10 col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table" id="datatable" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Koridor</th>
                                        <th>Jumlah Halte</th>
                                        <th>Jumlah Bus</th>
                                        <th width="25%"></th>
                                    </tr>
                                </thead>
                                <tbody class="text-left">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endSection

@section('js')
<script>
    $(function() {
        table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            info: true,
            ajax: {
                url: '{{url("admin/koridor/json")}}'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'kode'
                },
                {
                    data: 'nama'
                },
                {
                    data: 'halte_count'
                },
                {
                    data: 'bus_count'
                },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return '<button type="button" class="btn btn-success btn-edit" data-id="' + data + '"><span class="fa fa-edit"></span></button>\
                        <a class="btn btn-danger btn-hapus" data-id="' + data + '" data-handler="koridor" href="<?= url('admin/koridor/delete') ?>/' + data + '">\
                        <i class="fa fa-trash"></i></a> \
					    <form id="delete-form-' + data + '-koridor" action="<?= url('admin/koridor/delete') ?>/' + data + '" \
                        method="GET" style="display: none;"> \
                        </form>'
                    }
                },
            ]
        });
    });

    $("body").on("click", ".btn-edit", function() {
        var id = jQuery(this).attr("data-id");
        window.location.href = '{{url("admin/koridor/edit/")}}/' + id;
    });

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
@endSection