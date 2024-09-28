@extends('front.layout')
@section('main')
<div class="position-absolute d-none" style="z-index:1000;" id="detail_perhitungan">
    <div class="card rounded-0" style="height:94vh;width: 400px;overflow-y: scroll;">
        <div class="card-body">
            <div class="d-flex justify-content-center">
                <button id="btn-hitung" class="btn btn-primary mx-2 btn-hitung" onclick="perhitungan()">Perhitungan</button>
                <button class="btn btn-success mx-2 btn-navigasi" id="getNav" onclick="navigasi()">Navigasi</button>
            </div>
            <button id="handleCloseCard" class="btn btn-link"><i class="bi bi-arrow-left"></i></button>

            <div class="col-12 d-none" id="perhitungan">
                <h3>Detail Perhitungan</h3>
                <div class="row">
                    <div class="col-12 col-md-12">
                        <p>Rute yang dilewati</p>
                        <span class="" id="hasil_path">-</span>
                        <p>Jarak</p>
                        <span id="hasil_jarak">-</span>
                    </div>
                </div>
            </div>
            <div class="col-12 d-none" id="navigasi">
                <h3>Navigasi Jalan</h3>
                <div class="row">
                    <div class="col-12 col-md-12">
                        <p id="jalurNavigasi"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="" style="width:100%;height:94vh;" id="map"></div>
@endsection
@section('js')
<script>
    let formData;
    let startPoint;
    let endPoint;
    var start;
    var end;

    let handleCloseCard = document.getElementById('handleCloseCard');
    let perhitunganSection = document.getElementById('detail_perhitungan');
    let perhitunganPage = document.getElementById('perhitungan');
    let navigasiPage = document.getElementById('navigasi');
    let btnhitung = document.getElementById('btn-hitung');
    let currentLat;
    let currentLng;

    function navigasi() {
        perhitunganPage.classList.add('d-none');
        navigasiPage.classList.remove('d-none');
    }

    function perhitungan() {
        perhitunganPage.classList.remove('d-none');
        navigasiPage.classList.add('d-none');
    }
    handleCloseCard.addEventListener('click', (event) => {
        perhitunganSection.classList.add('d-none');
        directionsDisplay.set('directions', null);
        if(condition === 1){
            resetmap();
        }else{
            batalpilih();
        }
    });

    //Map

    var halte_id;
    let markers = [];
    let halte = [];
    let waypts = [];
    let geocoder;
    let map;
    let segment_point = [];
    let summary = '';
    let inputLat = document.getElementById('lat');
    let inputLng = document.getElementById('lng');
    let inputAlamat = document.getElementById('alamat');
    let infowindow;
    let markerPin;
    let existingMarkers = [];
    let condition =0;
    let reset;

    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: {
                lat: <?= env('DEFAULT_LAT') ?>,
                lng: <?= env('DEFAULT_LNG') ?>
            },
            zoom: <?= env('DEFAULT_ZOOM') ?>,
        });


        directionsService = new google.maps.DirectionsService();
        directionsDisplay = new google.maps.DirectionsRenderer();

        directionsDisplay.setMap(map);
        document.getElementById("getNav").addEventListener("click", () => {
            if(condition === 1){
                createinstantroute(directionsService, directionsDisplay);
            }else{
                dapatkanNavigasi(directionsService, directionsDisplay);
            }
        });
        polyline = new google.maps.Polyline({
            path: [],
            strokeColor: '#FF0000',
            strokeWeight: 3
        });
        map.addListener('click', (e) => {
            if(condition === 1){
               resetmap();
            }
            infowindow = new google.maps.InfoWindow({
                content: `<div class="d-flex flex-column">
                            <button class="btn btn-primary" onclick="titikmulai(this)" data-coordinates="${e.latLng.lat()},${e.latLng.lng()}">Mulai disini</button>
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
        $('#jalurNavigasi').children().remove().end();
        directionsDisplay.setPanel(document.getElementById("jalurNavigasi"));
        showAllMarkers();
        showAllHaltes();
    }
    
    function titikmulai(e) {
        let coordinate = e.getAttribute('data-coordinates');
        let coordinate_split = coordinate.split(",");
        let lat = coordinate_split[0];
        let lng = coordinate_split[1];
        reset = coordinate;
        start = coordinate_split;
        end = null;
        condition = 1;
        updateContent(coordinate_split);
        deleteHalte();
        deleteMarkers();
        showareahaltes(lat,lng);
    }
    
    function updateContent(a) {
        infowindow.setContent('<div class="d-flex flex-column">\
                        <button class="btn btn-danger" data-coordinates="'+a+'" onclick="batalmulai(this)">Batal</button>\
                    </div>');
    }
    function batalmulai(e){
        let coordinate = e.getAttribute('data-coordinates');
        let coordinate_split = coordinate.split(",");
        let lat = coordinate_split[0];
        let lng = coordinate_split[1];
        start = null;
        end = null;
        resetmap();
    }
    function resetmap(){
        deleteHalte();
        deleteMarkers()
        showAllMarkers();
        showAllHaltes();
        perhitunganSection.classList.add('d-none');
        directionsDisplay.set('directions', null);
        let coordinate_split = reset.split(",");
        let lat = coordinate_split[0];
        let lng = coordinate_split[1];
        infowindow.setContent('<div class="d-flex flex-column">\
                        <button class="btn btn-primary" onclick="titikmulai(this)" data-coordinates="'+lat+','+lng+'">Mulai disini</button>\
                    </div>');
        condition = 0;
    }
    function showareahaltes(lat,lng){
        const data = fetch('<?= url('get/halte/nearby/') ?>/' + lat + '/'+lng+'').then(res => res.json()).then(data => {
            data.map(function(e) {
                addHaltePilihan(e);
            })
        });
    }

    function instantroute(e){
        var detail_perhitungan = document.getElementById('detail_perhitungan');

        let coordinate = e.getAttribute('data-coordinate');
        let coordinate_split = coordinate.split(",");
        end = coordinate_split;
        if (start && end) {
            createinstantroute(directionsService, directionsDisplay);
            detail_perhitungan.classList.remove('d-none');
            btnhitung.classList.add('d-none');
            navigasi();
            start = null;
            end = null;
        }
    }
    function createinstantroute(directionsService, directionsRenderer) {
        waypts = [];
        var loc = new google.maps.LatLng(start[0], start[1]);
        waypts.push({
                location: loc,
                stopover: true
                });
        var loc = new google.maps.LatLng(end[0], end[1]);
        waypts.push({
                location: loc,
                stopover: true
                });
         console.log(waypts);
                var locationCount = waypts.length;
                if (locationCount > 0) {
                    var start_cords = waypts[0].location;
                    var end_cords = waypts[locationCount - 1].location;
                    delete waypts[0];
                    delete waypts[locationCount - 1];
                    waypts = waypts.filter(function(element) {
                        return element !== undefined;
                    });
                    directionsService.route({
                        origin: start_cords,
                        destination: end_cords,
                        waypoints: waypts,
                        optimizeWaypoints: true,
                        travelMode: google.maps.TravelMode.DRIVING
                    }, function(response, status) {
                        console.log(status);
                        if (status === 'OK') {
                            directionsDisplay.setDirections(response);
                        } else {
                            window.alert('Problem in showing direction due to ' + status);
                        }
                    })
                }
    }

    function setStartPoint(e) {
        start = e.getAttribute('data-id');
        if (start && end) {
            dapatkanRute();
            dapatkanNavigasi(directionsService, directionsDisplay);
            start = null;
            end = null;
        }
        deleteHalte();
        deleteMarkers();
        showHaltesPilihan(start);
        showMarkerPilihan(start);
    }

    function setEndPoint(e) {
        end = e.getAttribute('data-id');
        if (start && end) {
            dapatkanRute();
            dapatkanNavigasi(directionsService, directionsDisplay);
            start = null;
            end = null;
        }
    }

    function showAllMarkers() {
        const data = fetch('<?= url('get/node_json_map') ?>').then(res => res.json()).then(data => {
            data.map(function(e) {
                addMarker(e);
            })
        });
    }

    function showAllHaltes() {
        const data = fetch('<?= url('get/halte_json_map') ?>').then(res => res.json()).then(data => {
            data.map(function(e) {
                addHalte(e);
            })
        });
    }

    function showHaltesPilihan(pilihan) {
        const data = fetch('<?= url('get/opt/halte_json/') ?>/' + pilihan + '').then(res => res.json()).then(data => {
            data.map(function(e) {
                addHaltePilihan(e);
            })
        });
    }

    function showMarkerPilihan(pilihan) {
        const data = fetch('<?= url('get/opt/node_json/') ?>/' + pilihan + '').then(res => res.json()).then(data => {
            data.map(function(e) {
                addNodePilihan(e);
            })
        });
    }

    function addMarker(data) {

        let contentString = '';
        if (data.id == 'current') {
            contentString = `<div class="d-flex flex-column align-items-center">
            <span class="mb-2">Lokasi saat ini</span>`;
            contentString += `<button onclick="setStartPoint(this)" data-id="${data.id}" data-coordinate="${data.latitude},${data.longitude}" class="btn btn-sm btn-primary w-100">Mulai</button>`
            contentString += `</div>`;
        } else {

            contentString = `<div class="d-flex flex-column align-items-center">
				<span class="mb-2 fw-bold">${data.halte_nama ?? data.halte_id ?? 'Node '+data.id}</span>`;
            contentString += '<span class="d-flex flex-row gap-1">';
            contentString += (data.type == '-' ? `<button onclick="deleteNode(this)" data-id="${data.id}" class="btn btn-sm btn-danger">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
					<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
					<path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
				</svg>
				</button>` : ``)
            contentString += `<button onclick="setStartPoint(this)" data-id="${data.id}" data-coordinate="${data.latitude},${data.longitude}" class="btn btn-sm btn-primary">Pilih Node</button>`
            contentString += '<span>';
            contentString += `</div>`;
        }
        const infowindow = new google.maps.InfoWindow({
            content: contentString,
        });

        let icon;
        if (data.id == 'current') {
            icon = '<?= url('/static/marker-current.svg') ?>'
        } else {

            if (data.halte_id == null) {
                icon = '<?= url('/static/marker-node.svg') ?>'
            } else {
                icon = '<?= url('/static/marker-lazismu.svg') ?>'
            }
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

    function addHalte(data) {

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
        halte.push(marker);
    }

    function addHaltePilihan(data) {

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
        if(condition === 1){
            contentString += `<button onclick="instantroute(this)" data-halteid="${data.id}" data-id="${data.node_id}" data-coordinate="${data.latitude},${data.longitude}" class="btn btn-sm btn-primary">Pilih Halte</button>`
        }else{
            contentString += `<button onclick="setEndPoint(this)" data-halteid="${data.id}" data-id="${data.node_id}" data-coordinate="${data.latitude},${data.longitude}" class="btn btn-sm btn-primary">Pilih Halte</button>`
        }
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
        halte.push(marker);
    }

    function addNodePilihan(data) {

        let contentString = '';
        if (data.id == 'current') {
            contentString = `<div class="d-flex flex-column align-items-center">
            <span class="mb-2">Lokasi saat ini</span>`;
            contentString += `<button onclick="setStartPoint(this)" data-id="${data.id}" data-coordinate="${data.latitude},${data.longitude}" class="btn btn-sm btn-primary w-100">Mulai</button>`
            contentString += `</div>`;
        } else {

            contentString = `<div class="d-flex flex-column align-items-center">
				<span class="mb-2 fw-bold">${data.halte_nama ?? data.halte_id ?? 'Node '+data.id}</span>`;
            contentString += '<span class="d-flex flex-row gap-1">';
            contentString += (data.type == '-' ? `<button onclick="deleteNode(this)" data-id="${data.id}" class="btn btn-sm btn-danger">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
					<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
					<path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
				</svg>
				</button>` : ``)
            contentString += `<button onclick="batalpilih(this)" data-id="${data.id}" data-coordinate="${data.latitude},${data.longitude}" class="btn btn-sm btn-danger">Batal</button>`
            contentString += '<span>';
            contentString += `</div>`;
        }
        const infowindow = new google.maps.InfoWindow({
            content: contentString,
        });

        let icon;
        if (data.id == 'current') {
            icon = '<?= url('/static/marker-current.svg') ?>'
        } else {

            if (data.halte_id == null) {
                icon = '<?= url('/static/marker-node.svg') ?>'
            } else {
                icon = '<?= url('/static/marker-lazismu.svg') ?>'
            }
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

    function dapatkanRute() {
        var best = 10000;
        var i = 1;
        var detail_perhitungan = document.getElementById('detail_perhitungan');

        axios.get('<?= url('get/get_path') ?>/' + start + '/' + end)
            .then(function(response) {
                if (response.status == 200) {
                    if (response.data.length > 0) {
                        detail_perhitungan.classList.remove('d-none');
                        perhitunganPage.classList.remove('d-none');
                        let res = response.data;
                        hasil_path = document.getElementById('hasil_path');

                        hasil_path_html = '<ol>';

                        var resultData = response.data;
                        $.each(resultData, function(index, row) {
                            hasil_path_html += `<li>${row.rute_list}</li>`
                        })


                        hasil_path.innerHTML = hasil_path_html + '</ol>';
                    } else {
                        Swal.fire(
                            'Data Tidak Ditemukan!',
                            '',
                            'error'
                        );
                        return false;
                    }

                }

            })
            .catch(function(error) {
                console.log(error);
            });
        axios.get('<?= url('get/get_jarak') ?>/' + start + '/' + end)
            .then(function(response) {
                if (response.status == 200) {
                    console.log(response);
                    let res = response.data;
                    hasil_path = document.getElementById('hasil_jarak');
                    document.getElementById('hasil_jarak').innerHTML = `Jarak ${res.distance}`
                    hasil_path_html = '<ol>';
                    var resout;
                    var resultData = response.data;
                    $.each(resultData, function(index, row) {
                        if (parseFloat(row.jarak) <= best) {
                            best = parseFloat(row.jarak);
                            i = index + 1;
                            resout = row.jarak
                        };
                        hasil_path_html += `<li>${row.jarak}</li>`
                    })
                    hasil_path_html += `</ol>`

                    hasil_path.innerHTML = hasil_path_html + '<b>Jarak Terpendek : Rute ' + i + ' (' + resout + ')';
                } else {
                    alert('Data Tidak Ditemukan !!');
                    return false;
                }

            })
            .catch(function(error) {
                console.log(error);
            });

    }

    function dapatkanNavigasi(directionsService, directionsRenderer) {

        waypts = [];
        axios.get('<?= url('get/get_cordinats') ?>/' + start + '/' + end)
            .then(function(response) {
                if (response.status == 200) {
                    var resultData = response.data;
                    var temp = [];
                    $.each(resultData, function(index, row) {
                        var loc = new google.maps.LatLng(row.latitude, row.longitude);
                        waypts.push({
                            location: loc,
                            stopover: true
                        });
                    })
                } else {
                    alert('Data Tidak Ditemukan !!');
                    return false;
                }
                console.log(waypts);
                var locationCount = waypts.length;
                if (locationCount > 0) {
                    var start_cords = waypts[0].location;
                    var end_cords = waypts[locationCount - 1].location;
                    delete waypts[0];
                    delete waypts[locationCount - 1];
                    waypts = waypts.filter(function(element) {
                        return element !== undefined;
                    });
                    directionsService.route({
                        origin: start_cords,
                        destination: end_cords,
                        waypoints: waypts,
                        optimizeWaypoints: true,
                        travelMode: google.maps.TravelMode.DRIVING
                    }, function(response, status) {
                        console.log(status);
                        if (status === 'OK') {
                            directionsDisplay.setDirections(response);
                        } else {
                            window.alert('Problem in showing direction due to ' + status);
                        }
                    })
                }
            }).catch(function(error) {
                console.log(error);
            });

    }

    // get current position
    const options = {
        enableHighAccuracy: true,
        timeout: 5000,
        maximumAge: 0
    };

    function success(pos) {
        const crd = pos.coords;
        currentLat = crd.latitude
        currentLng = crd.longitude
        console.log('Your current position is:');
        console.log(`Latitude : ${crd.latitude}`);
        console.log(`Longitude: ${crd.longitude}`);
        console.log(`More or less ${crd.accuracy} meters.`);

        let contentString = `<div class="d-flex flex-column align-items-center">
				<span class="mb-2 fw-bold">Lokasi anda saat ini</span>`;
        contentString += '<span class="d-flex flex-row gap-1">';
        contentString += `<button onclick="setStartPoint(this)" data-id="currentLocation" data-coordinate="${crd.latitude},${crd.longitude}" class="btn btn-sm btn-primary">Mulai</button>`
        contentString += '<span>';
        contentString += `</div>`;

        addMarker({
            id: 'current',
            latitude: crd.latitude,
            longitude: crd.longitude
        });
        // markers.push(currentMarker)
    }

    function error(err) {
        console.warn(`ERROR(${err.code}): ${err.message}`);
    }

    function reMarkerKoridor(e) {
        deleteHalte();
        deleteMarkers()
        if (e.dataset.id === 0) {
            showAllHaltes();
            showAllMarkers();
        } else {
            const data = fetch('<?= url('get/filter_marker') ?>/' + e.dataset.id + '').then(res => res.json()).then(data => {
                data.map(function(e) {
                    addMarker(e);
                })
            });
            const newdata = fetch('<?= url('get/filter_halte') ?>/' + e.dataset.id + '').then(res => res.json()).then(newdata => {
                newdata.map(function(e) {
                    addHalte(e);
                })
            });
        }
    }

    function batalpilih(e) {
        start = null;
        end = null;
        deleteMarkers();
        deleteHalte();
        showAllMarkers();
        showAllHaltes();
        navigator.geolocation.getCurrentPosition(success, error, options);
    }

    function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(map);
        }
    }

    function HaltesetMapOnAll(map) {
        for (var i = 0; i < halte.length; i++) {
            halte[i].setMap(map);
        }
    }

    function deleteHalte() {
        HaltesetMapOnAll(null);
        halte = [];
    }

    function deleteMarkers() {
        setMapOnAll(null);
        markers = [];
    }

    navigator.geolocation.getCurrentPosition(success, error, options);
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDo9HRRCCPaSc56lFFDzT2V0xOYPI8OA9U&callback=initMap&libraries=places&v=weekly&language=id&region=ID" async></script>
<script src="<?= asset('/node_modules/axios/dist/axios.min.js') ?>"></script>
@endsection