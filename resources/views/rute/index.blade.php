@extends('template.layout')

@section('css')
<style type="text/css">
    #direction_details,
    #directions_panel {
        font-size: 12px;
    }
</style>
@endSection()

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data <?= ucfirst($title) ?></h3>
            </div>
            <div class="card-body">
                <p>Berikut adalah semua data <?= $title ?> yang sudah terdaftar </p>
                <div class="row" style="height:400px;">
                    <div class="col-lg-12" style="position:relative;height:inherit;">
                        <div id="map" style="height:inherit;width:100%;position:absolute;"></div>
                        <div style="position:absolute;height:inherit;overflow:auto;width:30%;" id="panel" class="d-none bg-white p-3">
                            <div id="directions_panel"></div>
                            <div id="direction_details"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="" class="col-lg-12">
                        <div class="card" style="height:400px;overflow-y:auto;">
                            <div class="card-body">
                                <div class="p-0 table-responsive mt-3">
                                    <table id="datatable" class="table table-borderless dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th width="7%">#</th>
                                                <th class="text-center">Latitude</th>
                                                <th class="text-center">Longitude</th>
                                                <th class="text-center" width="50%">Keterangan</th>
                                                <th class="text-center" width="17%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endSection()

@section('js')


<script>
    $(function() {
        table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            info: false,
            ajax: {
                url: '{{url("admin/rute/getjson/0")}}'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'latitude'
                },
                {
                    data: 'longitude'
                },
                {
                    data: 'keterangan'
                },
                {
                    data: 'id_cords',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return '<a class="btn btn-danger btn-delete" data-id="' + data + '" onclick="destroyJalur(this)" data-handler="rute" href="#">\
                        <i class="fa fa-trash"></i></a>';
                    }
                },
            ]
        });
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

    // map

    var halte_id;
    var status;
    let map;
    let markers = [];
    let nodes = [];
    let jalur = [];
    let markerPin;
    let nodePin;
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

        map.addListener('click', (e) => {
            const infowindow = new google.maps.InfoWindow({
                content: `<div class="d-flex flex-column p-2">
						<span class="mb-2">Coordinat ${e.latLng}</span>
						<span class="mb-2">Keterangan : <input type="text" id="keterangan"> </span>
							<button form="form_buat_node_baru" class="btn btn-success" onclick="createRute(this)" data-halte="${halte_id}" data-coordinates="${e.latLng.lat()},${e.latLng.lng()}">Buat Jalur Baru</button>
						</div>`,
            });



            if (markerPin) {
                markerPin.setMap(null);
            }
            markerPin = new google.maps.Marker({
                position: e.latLng,
                map,
                icon: '<?= asset('static/marker-current.svg') ?>'
            });
            markerPin.addListener('click', () => {
                infowindow.open({
                    anchor: markerPin,
                    map,
                    shouldFocus: true
                });
            })

            if (status != 'true') {
                markerPin.setMap(null);
            }
        })

        showAllMarkers();
    }


    function createRute(e) {
        let coordinate = e.getAttribute('data-coordinates');
        let coordinate_split = coordinate.split(",");
        let lat = coordinate_split[0];
        let lng = coordinate_split[1];
        let keterangan = $('#keterangan').val();
        let halte_data = e.dataset.halte;

        fetch('<?= url('admin/rute/store') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    "_token": '{{ csrf_token() }}',
                    "halte_data": halte_data,
                    "keterangan": keterangan,
                    "latitude": lat,
                    "longitude": lng
                })
            }).then((res) => res.json())
            .then((data) => {
                if (data) {
                    window.location.reload()
                }
            }).catch((error) => {
                console.error('Error', error);
            })

        markerPin.setMap(null);
        deleteJalur();
        const newdata = fetch('<?= url('admin/rute/get_mark') ?>/' + halte_data + '').then(res => res.json()).then(newdata => {
            newdata.map(function(e) {
                addJalur(e);
            })
        });
        table.ajax.url("{{url('/admin/rute/getjson')}}/" + halte_data).load();
    }

    function destroyJalur(e) {
        let id = e.getAttribute('data-id');
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
                fetch('<?= url('admin/rute/delete/') ?>/' + id, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            "_token": '{{ csrf_token() }}'
                        })
                    }).then((res) => res.json())
                    .then((data) => {
                        if (data) {
                            window.location.reload()
                        }
                    }).catch((error) => {
                        console.error('Error', error);
                    })
                markerPin.setMap(null);
                deleteJalur();
                const newdata = fetch('<?= url('admin/rute/get_mark') ?>/' + halte_id + '').then(res => res.json()).then(newdata => {
                    newdata.map(function(e) {
                        addJalur(e);
                    })
                });
                table.ajax.url("{{url('/admin/rute/getjson')}}/" + halte_id).load();
            }
        });

    }

    function showAllMarkers() {
        const data = fetch('<?= url('admin/halte/json_map') ?>').then(res => res.json()).then(data => {
            data.map(function(e) {
                addMarker(e);
            })
        });
    }

    function showReMarkers(id) {
        deleteHalte();
        const data = fetch('<?= url('admin/halte/getjson') ?>/' + id + '').then(res => res.json()).then(data => {
            data.map(function(e) {
                reMarker(e);
            })
        });
    }

    function addMarker(data) {

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
        contentString += `<button onclick="pilihHalte(this)" data-halteid="${data.id}" data-id="${data.node_id}" data-coordinate="${data.latitude},${data.longitude}" class="btn btn-sm btn-primary">Pilih Halte</button>`
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
        markers.push(marker);
    }

    function setStartPoint(e) {
        start_point = e.dataset.coordinate;
        id_start_point = e.dataset.id;
        createDirection();
    }

    function setEndPoint(e) {
        end_point = e.dataset.coordinate;
        id_end_point = e.dataset.id;
        createDirection();
    }

    function pilihHalte(e) {
        status = true;
        deleteMarkers();
        deleteHalte();
        deleteJalur();
        showReMarkers(e.dataset.halteid);
        halte_id = e.dataset.halteid;
        const data = fetch('<?= url('admin/rute/find_graf') ?>/' + e.dataset.id + '').then(res => res.json()).then(data => {
            data.map(function(e) {
                addNode(e);
            })
        });
        const newdata = fetch('<?= url('admin/rute/get_mark') ?>/' + e.dataset.halteid + '').then(res => res.json()).then(newdata => {
            newdata.map(function(e) {
                addJalur(e);
            })
        });
        table.ajax.url("{{url('/admin/rute/getjson')}}/" + e.dataset.halteid).load();
    }

    function batalHalte(e) {
        status = false;
        deleteMarkers();
        deleteHalte();
        deleteJalur();
        showAllMarkers();
        markerPin.setMap(null);
        halte_id = 0;
        table.ajax.url("{{url('/admin/rute/getjson')}}/" + halte_id).load();
    }

    function createDirection() {

        segment_point = [];
        summary = '';
        if (start_point && end_point) {
            let request = {
                origin: start_point,
                destination: end_point,
                // travelMode: google.maps.DirectionsTravelMode.WALKING
                travelMode: google.maps.TravelMode['WALKING']
            }
            directionsService.route(request, function(response, status) {
                if (status == google.maps.DirectionsStatus.OK) {

                    panel.classList.remove('d-none');

                    var bounds = new google.maps.LatLngBounds();
                    var route = response.routes[0];

                    var summaryPanel = document.getElementById("directions_panel");
                    var detailsPanel = document.getElementById("direction_details");
                    startLocation = new Object();
                    endLocation = new Object();
                    summaryPanel.innerHTML = "<button class='btn btn-primary' onClick='createGraf()'>Tambah Rute</button><br/><br />";

                    for (var i = 0; i < route.legs.length; i++) {
                        var routeSegment = i + 1;
                        summaryPanel.innerHTML += route.legs[i].start_address + " Ke ";
                        summaryPanel.innerHTML += route.legs[i].end_address + "<br />";
                        summaryPanel.innerHTML += route.legs[i].distance.text + "<br />";
                        summary += route.legs[i].start_address + " Ke " + route.legs[i].end_address + "<br/>" + route.legs[i].distance.text;
                        distance = route.legs[i].distance.value;
                    }

                    var path = response.routes[0].overview_path;
                    var legs = response.routes[0].legs;

                    polyline.setPath([]);
                    detailsPanel.innerHTML = "<span style='font-size:9px;'>";

                    for (i = 0; i < legs.length; i++) {
                        if (i == 0) {
                            startLocation.latlng = legs[i].start_location;
                            startLocation.address = legs[i].start_address;
                            // createMarker(legs[i].start_location, "start", legs[i].start_address, "green");
                        }
                        endLocation.latlng = legs[i].end_location;
                        endLocation.address = legs[i].end_address;
                        var steps = legs[i].steps;
                        for (j = 0; j < steps.length; j++) {
                            detailsPanel.innerHTML += "";
                            var nextSegment = steps[j].path;
                            var dist_dur = "";
                            if (steps[j].distance && steps[j].distance.text) {
                                dist_dur += "&nbsp;" + steps[j].distance.text;
                            }
                            if (steps[j].duration && steps[j].duration.text) {
                                dist_dur += "&nbsp;" + steps[j].duration.text;
                            }
                            summary += steps[j].instructions;
                            detailsPanel.innerHTML += steps[j].instructions;
                            if (dist_dur != "") {
                                detailsPanel.innerHTML += " (" + dist_dur + ")";
                                summary += " (" + dist_dur + ")";
                            }

                            for (k = 0; k < nextSegment.length; k++) {
                                segment_point.push(nextSegment[k]);
                                polyline.getPath().push(nextSegment[k]);
                                bounds.extend(nextSegment[k]);
                            }
                            detailsPanel.innerHTML += "<hr/>";
                            summary += "<hr/>";
                        }
                    }

                    detailsPanel.innerHTML += "</span>";
                    polyline.setMap(map);
                    map.fitBounds(bounds);
                }
            })
        }
    }

    function createGraf() {
        let params = new FormData();
        params.append('start', id_start_point);
        params.append('end', id_end_point);
        params.append('rute', JSON.stringify(segment_point));
        params.append('keterangan', summary);
        params.append('jarak', distance);
        params.append('_token', '{{ csrf_token() }}');

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-light me-2'
            },
            buttonsStyling: false
        })

        axios.post('<?= url('admin/graf/store') ?>', params)
            .then(function(response) {
                console.log(response);
                start_point = '';
                end_point = '';
                polyline.setPath([]);
                polyline.setMap(map);
                panel.classList.add('d-none');
                // swalWithBootstrapButtons.fire('Sukses', 'Data berhasil disimpan!', 'success')
                window.location.reload()
            })
            .catch(function(error) {
                console.log(error);
            });
    }

    function addNode(data) {
        //Left Click
        let contentString = `<div class="d-flex flex-column align-items-center">
        <span class="mb-2 fw-bold">${data.halte_nama ?? data.halte_id ?? 'Node '+data.id}</span>`;
        contentString += '<span class="d-flex flex-row gap-1">';
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

        const node = new google.maps.Marker({
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

        node.addListener('click', () => {
            infowindow.open({
                anchor: node,
                map,
                shouldFocus: true,
            })
        })
        nodes.push(node);
    }

    function setMapOnAll(map) {
        for (var i = 0; i < nodes.length; i++) {
            nodes[i].setMap(map);
        }
    }

    function HaltesetMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(map);
        }
    }

    function JalursetMapOnAll(map) {
        for (var i = 0; i < jalur.length; i++) {
            jalur[i].setMap(map);
        }
    }

    function deleteMarkers() {
        setMapOnAll(null);
        nodes = [];
    }

    function deleteHalte() {
        HaltesetMapOnAll(null);
        markers = [];
    }

    function deleteJalur() {
        JalursetMapOnAll(null);
        jalur = [];
    }

    function reMarker(data) {

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
        contentString += `<button onclick="batalHalte(this)" data-id="${data.id}" data-coordinate="${data.latitude},${data.longitude}" class="btn btn-sm btn-danger">Batal Pilih</button>`
        contentString += '<span>';
        contentString += `</div>`;

        const infowindow = new google.maps.InfoWindow({
            content: contentString,
        });
        //End Left Click
        let icon;
        icon = '<?= asset('static/marker-lazismu.png') ?>'

        const marker = new google.maps.Marker({
            position: {
                lat: parseFloat(data.latitude),
                lng: parseFloat(data.longitude)
            },
            map,
            icon: icon,
            label: ``,
            animation: google.maps.Animation.BOUNCE,
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
        markers.push(marker);
    }

    function addJalur(data) {
        //Left Click
        let contentString = `<div class="d-flex flex-column align-items-center">
        <span class="mb-2 fw-bold">${data.keterangan ?? data.latitude ?? 'Titik '+data.id_cords}</span>`;
        contentString += '<span class="d-flex flex-row gap-1">';
        contentString += '<span>';
        contentString += `</div>`;

        const infowindow = new google.maps.InfoWindow({
            content: contentString,
        });
        //End Left Click
        let icon;
        icon = '<?= asset('static/marker-current.svg') ?>';

        const jala = new google.maps.Marker({
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

        jala.addListener('click', () => {
            infowindow.open({
                anchor: jala,
                map,
                shouldFocus: true,
            })
        })
        jalur.push(jala);
    }
</script>
<script src="<?= asset('node_modules/axios/dist/axios.min.js') ?>"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDo9HRRCCPaSc56lFFDzT2V0xOYPI8OA9U&callback=initMap&libraries=places&v=weekly&language=id&region=ID" async></script>

@endSection()