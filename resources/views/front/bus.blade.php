@extends('front.layout')
@section('main')
<div class="container mt-4">
    <div class="mb-2">
        <h1 class="fw-bold">Data Bus</h1>
        <form method="get" action="<?= url('bus/search') ?>">
            <input type="search" id="search_val"class="form-control" name="search" value="" />
            <button class="btn btn-primary mt-2 btn-search" type="button">Cari Bus</button>
        </form>
    </div>
    <div class="row" id="ClassContent">
        <?php foreach ($buses as $bus) : ?>
            <div class="col-12 col-md-3 mb-4">
                <div class="card">
                    <div class="card-body d-flex flex-column justify-content-between" style="height:240px;">
                        <div>
                            <h5 class="card-title fw-bold"><?= $bus->lambung ?></h5>
                            <h6 class="card-title"><?= $bus->Koridor->nama . $bus->Koridor->kode ?></h6>
                            <p class="card-text"><?= $bus->tipe ?></p>
                        </div>
                        <a href="<?= url('bus/detail/' . $bus->id) ?>" class="btn btn-primary">Detail</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="container">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3" id="content_halte">
        </div>
        <div class="py-3 text-center">
            <button type="button" class="btn btn-primary btn-load" onclick="load_more()">Load More
                <i class="fas fa-plus-circle"></i>
            </button>
        </div>
    </div>
</div>

@endSection()
@section('js')
<script>
    var loadmore = 1;

    function load_more() {
        loadmore++;
        $('#ClassContent').html("");
        $.ajax({
            url: "{{ url('/bus/json/')}}/" + loadmore,
            type: "GET",
            cache: false,
            dataType: 'json',
            success: function(dataResult) {
                console.log(dataResult);
                var resultData = dataResult;
                $.each(resultData, function(index, row) {
                    //alert(row.to_html);
                    $('#ClassContent').append(row.to_html);
                })
            }
        });
    }
    $('.btn-search').on('click', function() {
        var key = $('#search_val').val();
        $('#ClassContent').html("");
        $.ajax({
            url: "{{ url('/bus/search/')}}/" + key,
            type: "GET",
            cache: false,
            dataType: 'json',
            success: function(dataResult) {
                console.log(dataResult);
                var resultData = dataResult;
                $.each(resultData, function(index, row) {
                    //alert(row.to_html);
                    $('#ClassContent').append(row.to_html);
                })
            }
        });
    });
</script>
@endsection