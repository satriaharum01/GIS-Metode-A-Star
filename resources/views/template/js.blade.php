    <!-- jQuery 3 -->
    <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets/js/sb-admin-2.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- Page level plugins -->
    <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <script src="<?= asset('/dist/libs/apexcharts/dist/apexcharts.min.js') ?> " defer></script>
    <script src="<?= asset('/dist/libs/jsvectormap/dist/js/jsvectormap.min.js') ?>" defer></script>
    <script src="<?= asset('/dist/libs/jsvectormap/dist/maps/world.js') ?>" defer></script>
    <script src="<?= asset('/dist/libs/jsvectormap/dist/maps/world-merc.js') ?>" defer></script>

    <script src="<?= asset('/dist/js/tabler.min.js') ?>" defer></script>
    <script>
        $('#foto').change(function() {

            let reader = new FileReader();

            reader.onload = (e) => {

                $('#foto_preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(this.files[0]);

        });
        
        $("body").on("click", ".btn-hapus", function() {
            var x = jQuery(this).attr("data-id");
            var y = jQuery(this).attr("data-handler");
            var xy = x + '-' + y;
            event.preventDefault()
            Swal.fire({
                title: 'Hapus Data ?',
                text: "Data yang dihapus tidak dapat dikembalikan !",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.value) {
                    Swal.fire(
                        'Data Dihapus!',
                        '',
                        'success'
                    );
                    document.getElementById('delete-form-' + xy).submit();
                }
            });

        })
    </script>