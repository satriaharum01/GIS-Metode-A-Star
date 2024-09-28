@extends('template.layout')

@section('content')

<div class="row row-cards">
    <div class="col-sm-6 col-lg-3">
        <div class="card card-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-primary text-white avatar">
                            <i class="fas fa-landmark"></i>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            <?= $count_halte ?>
                        </div>
                        <div class="text-muted">
                            Data Halte
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card card-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-green text-white avatar">
                            <i class="fas fa-road"></i>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            <?= $count_koridor ?>
                        </div>
                        <div class="text-muted">
                            Data Koridor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card card-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-red text-white avatar">
                            <i class="fas fa-bus"></i>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            <?= $count_bus ?>
                        </div>
                        <div class="text-muted">
                            Data Bus
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card card-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-yellow text-white avatar">
                            <i class="fas fa-route"></i>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            <?= $count_graf ?>
                        </div>
                        <div class="text-muted">
                            Data Graf
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid p-0 mt-3">
    <div class="card-body bg-white">
        <p>Berikut adalah semua data <?= $title ?> yang sudah terdaftar</p>
        <?= session()->has('success') ? session()->getFlashdata('success') : '' ?>
        <form id="start"></form>
        <form id="end"></form>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <div id="map" style="height: 500px;width: 100%;"></div>
            </div>
        </div>
        <hr />
        <div class="row d-none" id="detail_perhitungan">
            <div class="col-12">
                <h3>Detail Perhitungan</h3>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <span id="hasil_jarak"></span>
                        <span id="hasil_perhitungan"></span>
                    </div>
                    <div class="col-12 col-md-6">
                        <h3>Keterangan Rute</h3>
                        <span class="p-2" id="hasil_path"></span>
                        <span class="p-2" id="hasil_keterangan"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endSection
@section('js')
<script>
    let map;
    let markers = [];
    let nodes = [];
    let jalur = [];
    let markerPin;
    let directionsService;
    let polyline;
    let id_start_point;
    let start_point;
    let id_end_point;
    let end_point;
    let segment_point = [];
    let summary = '';
    let distance = 0;
    let btnCreateGraf;
    let panel = document.getElementById("panel");


    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: {
                lat: <?= env('DEFAULT_LAT') ?>,
                lng: <?= env('DEFAULT_LNG') ?>
            },
            zoom: <?= env('DEFAULT_ZOOM') ?>,
        });


        directionsService = new google.maps.DirectionsService();

        polyline = new google.maps.Polyline({
            path: [],
            strokeColor: '#FF0000',
            strokeWeight: 3
        });

        showAllMarkers();
        showAllNodes();
    }


    function showAllNodes() {
        const data = fetch('<?= url('admin/node/json_map') ?>').then(res => res.json()).then(data => {
            data.map(function(e) {
                addNode(e);
            })
        });
    }

    function showAllMarkers() {
        const data = fetch('<?= url('admin/halte/json_map') ?>').then(res => res.json()).then(data => {
            data.map(function(e) {
                addMarker(e);
            })
        });
    }

    function addMarker(data) {

        console.log(data)
        //Left Click
        let contentString = `<div class="d-flex flex-column align-items-center">
				<span class="mb-2 fw-bold">${data.nama ?? data.halte_id ?? 'Node '+data.id}</span>`;
        contentString += '<span class="d-flex flex-row gap-1">';
        contentString += (data.type == '-' ? `<button onclick="deleteNode(this)" data-id="${data.id}" class="btn btn-sm btn-danger">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
					<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
					<path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
				</svg>
				</button>` : ``)
        contentString += '<span>';
        contentString += `</div>`;

        const infowindow = new google.maps.InfoWindow({
            content: contentString,
        });
        //End Left Click
        let icon;
        icon = '<?= asset('static/marker-lazismu.png') ?>';

        const marker = new google.maps.Marker({
            position: {
                lat: parseFloat(data.latitude),
                lng: parseFloat(data.longitude)
            },
            map,
            icon: icon,
            label: ``,
            'labelClass': 'labels', // the CSS class for the label
            'labelInBackground': false
        });

        marker.addListener('click', () => {
            infowindow.open({
                anchor: marker,
                map,
                shouldFocus: true,
            })
        })
        marker.addListener('rightclick', () => {
            deletewindow.open({
                anchor: marker,
                map,
                shouldFocus: true,
            })
        })
        markers.push(marker);
    }

    function addNode(data) {

        console.log(data)
        //Left Click
        let contentString = `<div class="d-flex flex-column align-items-center">
        <span class="mb-2 fw-bold">${data.halte_nama ?? data.halte_id ?? 'Node '+data.id}</span>`;
        contentString += '<span class="d-flex flex-row gap-1">';
        contentString += (data.type == '-' ? `<button onclick="deleteNode(this)" data-id="${data.id}" class="btn btn-sm btn-danger">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
        </svg>
        </button>` : ``)
        contentString += '<span>';
        contentString += `</div>`;

        const infowindow = new google.maps.InfoWindow({
            content: contentString,
        });
        //End Left Click
        let icon;
        if (data.halte_id == null) {
            icon = '<?= asset('static/marker-node.svg') ?>'
        } else {
            icon = '<?= asset('static/marker-lazismu.png') ?>'
        }

        const marker = new google.maps.Marker({
            position: {
                lat: parseFloat(data.latitude),
                lng: parseFloat(data.longitude)
            },
            map,
            icon: icon,
            label: ``,
            'labelClass': 'labels', // the CSS class for the label
            'labelInBackground': false
        });

        marker.addListener('click', () => {
            infowindow.open({
                anchor: marker,
                map,
                shouldFocus: true,
            })
        })
        marker.addListener('rightclick', () => {
            deletewindow.open({
                anchor: marker,
                map,
                shouldFocus: true,
            })
        })
        nodes.push(marker);
    }
</script>
<script src="<?= asset('node_modules/axios/dist/axios.min.js') ?>"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDo9HRRCCPaSc56lFFDzT2V0xOYPI8OA9U&callback=initMap&libraries=places&v=weekly&language=id&region=ID" async></script>

@endsection