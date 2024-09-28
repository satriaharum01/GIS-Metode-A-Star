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
                <div class="card-title mb-4">
                    Berikut adalah semua data <?= $title ?> yang sudah terdaftar
                    <div class="float-right">
                        <button class="btn btn-primary" disabled id="btn-save"><i class="fa fa-save"></i> Simpan</button>
                        <button class="btn btn-danger btn-kosongkan"><i class="fa fa-refresh"></i> Kosongkan</button>
                    </div>
                </div>
                <div class="row" style="height:400px;">
                    <div class="col-lg-7" style="position:relative;height:inherit;">
                        <div id="map" style="height:inherit;width:100%;position:absolute;"></div>
                        <div style="position:absolute;height:inherit;overflow:auto;width:30%;" id="panel" class="d-none bg-white p-3">
                            <div id="directions_panel"></div>
                            <div id="direction_details"></div>
                        </div>
                    </div>
                    <div id="" class="col-lg-5">
                        <div class="card" style="height:400px;overflow-y:auto;">
                            <div class="card-body">
                                <div class="p-0 table-responsive mt-3">
                                    <table id="datatable" class="table table-borderless dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Jalur</th>
                                                <th>Aksi</th>
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

                <div class="row">
                    <div id="" class="col-lg-12">
                        <div class="card" style="height:400px;overflow-y:auto;">
                            <div class="card-body">
                                <div class="p-0 table-responsive mt-3">
                                    <table id="datatable2" class="table table-borderless dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th width="7%">#</th>
                                                <th class="text-center">Start</th>
                                                <th class="text-center">End</th>
                                                <th class="text-center" width="50%">Rute Dilewati</th>
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
                url: '{{url("admin/graf/detail_rute/0")}}'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama'
                },
                {
                    data: 'cords_id',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return '<a class="btn btn-danger btn-hapus" data-id="' + data + '" data-handler="graf" href="<?= url('admin/graf/patch_rute') ?>/' + data + '">\
                        <i class="fa fa-trash"></i></a> \
					    <form id="delete-form-' + data + '-graf" action="<?= url('admin/graf/patch_rute') ?>/' + data + '" \
                        method="GET" style="display: none;"> \
                        </form>'
                    }
                },
            ]
        });
        table2 = $('#datatable2').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            info: false,
            ajax: {
                url: '{{url("admin/graf/get_halte/0")}}'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'start_nama',
                },
                {
                    data: 'end_nama'
                },
                {
                    data: 'rute_list'
                },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return '<!--<button class="btn btn-success btn-edit" data-id="' + data + '" ><i class="fa fa-pencil-square"></i></button>-->\
                        <a class="btn btn-danger btn-hapus" data-id="' + data + '" data-handler="graf" href="<?= url('admin/graf/delete') ?>/' + data + '">\
                        <i class="fa fa-trash"></i></a> \
					    <form id="delete-form-' + data + '-graf" action="<?= url('admin/graf/delete') ?>/' + data + '" \
                        method="GET" style="display: none;"> \
                        </form>'
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


    var keranjang = Array();
    var Tempkeranjang = Array();
    var halte_id;
    var indexCol = 0;
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

        map.addListener('click', (e) => {

            const infowindow = new google.maps.InfoWindow({
                content: `<div class="d-flex flex-column p-2">
						<span class="mb-2">Coordinat ${e.latLng}</span>
							<button form="form_buat_node_baru" class="btn btn-success" onclick="createNode(this)" data-coordinates="${e.latLng.lat()},${e.latLng.lng()}">Buat Node Baru</button>
						</div>`,
            });


            if (markerPin) {
                markerPin.setMap(null);
            }
            markerPin = new google.maps.Marker({
                position: e.latLng,
                map,
                icon: '<?= asset('static/marker-node.svg') ?>'
            });

            markerPin.addListener('click', () => {
                infowindow.open({
                    anchor: markerPin,
                    map,
                    shouldFocus: true
                });
            })
        })

        showAllMarkers();
        showAllNodes();
    }


    function createNode(e) {
        let coordinate = e.getAttribute('data-coordinates');
        let coordinate_split = coordinate.split(",");
        let lat = coordinate_split[0];
        let lng = coordinate_split[1];

        fetch('<?= url('admin/node/store') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    "_token": '{{ csrf_token() }}',
                    "lat": lat,
                    "lng": lng
                })
            }).then((res) => res.json())
            .then((data) => {
                if (data) {
                    window.location.reload()
                }
            }).catch((error) => {
                console.error('Error', error);
            })
        initMap();
    }

    function deleteNode(e) {
        let id = e.getAttribute('data-id');

        fetch('<?= url('admin/node/delete/') ?>/' + id, {
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
        initMap();
    }

    function showAllMarkers() {
        const data = fetch('<?= url('admin/halte/json_map') ?>').then(res => res.json()).then(data => {
            data.map(function(e) {
                addMarker(e);
            })
        });
    }

    function showAllNodes() {
        const data = fetch('<?= url('admin/node/json_map') ?>').then(res => res.json()).then(data => {
            data.map(function(e) {
                addNode(e);
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
        contentString += `<button onclick="pilihHalte(this)" data-halteid="${data.id}" data-id="${data.node_id}" data-coordinate="${data.latitude},${data.longitude}" class="btn btn-sm btn-primary">Pilih Halte</button>`
        contentString += '<span>';
        contentString += `</div>`;

        const infowindow = new google.maps.InfoWindow({
            content: contentString,
        });
        //End Left Click
        //Right Click
        let contentString2 = `<div class="d-flex flex-column align-items-center">
				<span class="mb-2 fw-bold">${data.halte_nama ?? data.halte_id ?? 'Node '+data.id}</span>`;
        contentString2 += '<span class="d-flex flex-row gap-1">';
        contentString2 += (data.type == '-' ? `<button onclick="deleteNode(this)" data-id="${data.id}" class="btn btn-sm btn-danger">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
					<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
					<path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
				</svg>
				</button>` : ``)
        contentString2 += `<button onclick="deleteNode(this)" data-id="${data.id}" data-coordinate="${data.latitude},${data.longitude}" class="btn btn-sm btn-danger">Hapus</button>`
        contentString2 += '<span>';
        contentString2 += `</div>`;

        const deletewindow = new google.maps.InfoWindow({
            content: contentString2,
        });
        //END Right Click
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
        contentString += `<button onclick="pilihJalurStart(this)" data-name="Node ${data.id}" data-id="${data.id}" data-coordinate="${data.latitude},${data.longitude}" class="btn btn-sm btn-success">Titik Mulai</button>`
        contentString += '<span>';
        contentString += `</div>`;

        const infowindow = new google.maps.InfoWindow({
            content: contentString,
        });
        //End Left Click
        //Right Click
        let contentString2 = `<div class="d-flex flex-column align-items-center">
        <span class="mb-2 fw-bold">${data.halte_nama ?? data.halte_id ?? 'Node '+data.id}</span>`;
        contentString2 += '<span class="d-flex flex-row gap-1">';
        contentString2 += (data.type == '-' ? `<button onclick="deleteNode(this)" data-id="${data.id}" class="btn btn-sm btn-danger">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
        </svg>
        </button>` : ``)
        contentString2 += `<button onclick="deleteNode(this)" data-id="${data.id}" data-coordinate="${data.latitude},${data.longitude}" class="btn btn-sm btn-danger">Hapus</button>`
        contentString2 += '<span>';
        contentString2 += `</div>`;

        const deletewindow = new google.maps.InfoWindow({
            content: contentString2,
        });
        //END Right Click
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


    function pilihJalurStart(e) {
        start_point = e.dataset.name;
        id_start_point = e.dataset.id;
        addKeranjang();
    }

    function pilihJalurEnd(e) {
        end_point = e.dataset.name;
        if (e.dataset.node) {
            id_end_point = e.dataset.node;
        } else {
            id_end_point = e.dataset.id;
        };
        addKeranjang();
    }

    function addKeranjang() {
        var before = keranjang;
        var temp = new Array();
        if (start_point && end_point) {
            temp['start'] = id_start_point;
            temp['end'] = id_end_point;
            temp['nama'] = start_point + '->' + end_point;
            temp['index'] = indexCol;
            before.push(temp);
            start_point = null;
            end_point = null;
            keranjang = before;
            console.log(keranjang);
            indexCol++;
            refreshtable(keranjang);
        }
    }

    function deletekeranjang(id) {
        delete keranjang[id];
        indexCol--;
        keranjang = keranjang.filter(function(element) {
            return element !== undefined;
        });
        refreshtable(keranjang);
    }

    function refreshtable(data) {
        var html1 = "";
        data.forEach(function(item, index) {
            html1 += '<tr><td>' + item.index + '</td><td class="text-center">' + item.nama + '</td></td><td class="text-center"><button type="button" class="btn btn-sm btn-danger" onclick="deletekeranjang(' + item.index + ')"><i class="fa fa-trash"></i></button></td></tr>';
        })

        if (data.length === 0) {
            $("#btn-save").prop('disabled', true);
        } else {
            $("#btn-save").prop('disabled', false);
        }
        jQuery("#datatable tbody").html(html1);
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
        //params.append('keterangan', summary);
        //params.append('jarak', distance);
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

    function showReMarkers(id) {
        deleteHalte();
        const data = fetch('<?= url('admin/halte/getjson') ?>/' + id + '').then(res => res.json()).then(data => {
            data.map(function(e) {
                reMarker(e);
            })
        });
    }

    function pilihHalte(e) {
        status = true;
        deleteHalte();
        deleteJalur();
        showReMarkers(e.dataset.halteid);
        halte_id = e.dataset.halteid;
        const newdata = fetch('<?= url('admin/rute/get_mark') ?>/' + e.dataset.halteid + '').then(res => res.json()).then(newdata => {
            newdata.map(function(e) {
                addJalur(e);
            })
        });
        table2.ajax.url("{{url('/admin/graf/get_halte')}}/" + e.dataset.id).load();
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
        contentString += `<button onclick="batalHalte(this)" data-id="${data.id}"  data-coordinate="${data.latitude},${data.longitude}" class="btn btn-sm btn-danger">Batal Pilih</button>`
        contentString += `<button onclick="pilihJalurEnd(this)" data-name="${data.nama}" data-node="${data.node_id}" ata-id="${data.id}" data-coordinate="${data.latitude},${data.longitude}" class="btn btn-sm btn-warning">Akhir</button>`
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
        contentString += `<button onclick="pilihJalurStart(this)" data-name="${data.keterangan}" data-id="${data.id_cords}" data-coordinate="${data.latitude},${data.longitude}" class="btn btn-sm btn-primary">Mulai</button>`
        contentString += `<button onclick="pilihJalurEnd(this)" data-name="${data.keterangan}" data-id="${data.id_cords}" data-coordinate="${data.latitude},${data.longitude}" class="btn btn-sm btn-danger">Akhir</button>`
        contentString += '</span>';
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

    function batalHalte(e) {
        status = false;
        deleteHalte();
        deleteJalur();
        showAllMarkers();
        halte_id = 0;
        table.ajax.url("{{url('/admin/graf/detail_rute/0')}}").load();
        table2.ajax.url("{{url('/admin/graf/get_halte/0')}}").load();
    }

    function deleteHalte() {
        HaltesetMapOnAll(null);
        markers = [];
    }

    function deleteJalur() {
        JalursetMapOnAll(null);
        jalur = [];
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
</script>
<script>
    $("body").on("click", ".btn-edit", function() {
        Tempkeranjang = [];
        var id = jQuery(this).attr("data-id");
        table.ajax.url("{{url('/admin/graf/detail_rute/')}}/" + id).load();
        $.ajax({
            url: "{{url('/admin/graf/detail_rute/')}}/" + id,
            type: "GET",
            cache: false,
            dataType: 'json',
            success: function(dataResult) {
                console.log(dataResult);
                var resultData = dataResult.data;
                $.each(resultData, function(index, row) {
                    Tempkeranjang.push(row.cords_id);
                })
            }
        });
    });
    $("body").on("click", "#btn-save", function() {
        var start_id = keranjang[0]['start'];
        var end_id = keranjang[keranjang.length - 1]['end'];
        var rute = new Array();
        for (var i = 1; i < keranjang.length; i++) {
            rute.push(keranjang[i]['start']);
        }

        Swal.fire({
            title: 'Tambah Data Graf ?',
            text: "Validasi Titik Rute",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.value) {
                fetch('<?= url('admin/graf/store') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            "_token": '{{ csrf_token() }}',
                            "start": start_id,
                            "end": end_id,
                            "rute": rute
                        })
                    }).then((res) => res.json())
                    .then((data) => {
                        if (data) {
                            keranjang = [];
                            refreshtable(keranjang);
                            table2.ajax.url("{{url('/admin/graf/get_halte')}}/" + end_id).load();
                            // swalWithBootstrapButtons.fire('Sukses', 'Data berhasil disimpan!', 'success')
                            initMap();
                        }
                    }).catch((error) => {
                        console.error('Error', error);
                    })
            }
        });

        //params.append('keterangan', summary);
        //params.append('jarak', distance);

    })
    $("body").on("click", ".btn-kosongkan", function() {
        Tempkeranjang = [];
        keranjang = [];
        table.ajax.url("{{url('/admin/graf/detail_rute/0')}}/").load();
    });
</script>
<script src="<?= asset('node_modules/axios/dist/axios.min.js') ?>"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDo9HRRCCPaSc56lFFDzT2V0xOYPI8OA9U&callback=initMap&libraries=places&v=weekly&language=id&region=ID" async></script>

@endSection()