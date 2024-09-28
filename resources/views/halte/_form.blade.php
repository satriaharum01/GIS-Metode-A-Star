@section('css')
<style>
    /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
    #map {
        height: 100%;
    }

    /* Optional: Makes the sample page fill the window. */
    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    #map input[type="text"] {
        background-color: #fff;
        border: 0;
        border-radius: 2px;
        box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
        margin: 10px;
        padding: 0 0.5em;
        font: 400 18px Roboto, Arial, sans-serif;
        /* overflow: hidden; */
        line-height: 40px;
        margin-right: 0;
        min-width: 25%;
    }

    #map input[type="button"] {
        background-color: #fff;
        border: 0;
        border-radius: 2px;
        box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
        margin: 10px;
        padding: 0 0.5em;
        font: 400 18px Roboto, Arial, sans-serif;
        overflow: hidden;
        height: 40px;
        cursor: pointer;
        margin-left: 5px;
    }

    #map input[type="button"]:hover {
        background: #ebebeb;
    }

    #map input[type="button"].button-primary {
        background-color: #1a73e8;
        color: white;
    }

    #map input[type="button"].button-primary:hover {
        background-color: #1765cc;
    }

    #map input[type="button"].button-secondary {
        background-color: white;
        color: #1a73e8;
    }

    #map input[type="button"].button-secondary:hover {
        background-color: #d2e3fc;
    }

    #map #response-container {
        background-color: #fff;
        border: 0;
        border-radius: 2px;
        box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
        margin: 10px;
        padding: 0 0.5em;
        font: 400 18px Roboto, Arial, sans-serif;
        overflow: hidden;
        overflow: auto;
        max-height: 50%;
        max-width: 90%;
        background-color: rgba(255, 255, 255, 0.95);
        font-size: small;
    }

    #map #instructions {
        background-color: #fff;
        border: 0;
        border-radius: 2px;
        box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
        margin: 10px;
        padding: 0 0.5em;
        font: 400 18px Roboto, Arial, sans-serif;
        overflow: hidden;
        padding: 1rem;
        font-size: medium;
    }
</style>
@endSection
<div class="row">
    <div class="col-12 col-md-6">
        <?= csrf_field() ?>
        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label fw-bold">Koridor</label>
            <div class="col-9">
                <select class="form-control" id="kabupaten_kota_id" name="koridor" onChange="ubahKabKota(this)">
                    <option value="">- Pilih Koridor -</option>
                    <?php foreach ($koridor_load as $koridor) : ?>
                        <option value="<?= $koridor->id ?>" <?= old('koridor') ? (old('koridor') == $koridor->id ? 'selected' : '') : (@$halte->koridor == $koridor->id ? 'selected' : '') ?>><?= $koridor->nama ?> (<?= $koridor->kode ?>)</option>
                    <?php endforeach; ?>
                </select>
                <div class="mt-2">
                    <a class="" href="<?= url('/admin/koridor') ?>">+ Tambah koridor baru</a>
                </div>
            </div>

        </div>
        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label fw-bold">Kode</label>
            <div class="col-9">
                <input type="text" class="form-control" name="kode" id="kode" value="<?= old('kode') ?? (@$halte->kode ?? '') ?>" placeholder="Kode halte" autocomplete="off">
            </div>
        </div>
        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label fw-bold">Nama halte</label>
            <div class="col-9">
                <input type="text" class="form-control" name="nama" id="nama" value="<?= old('nama') ?? (@$halte->nama ?? '') ?>" placeholder="Nama halte" autocomplete="off">

            </div>

        </div>

        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label fw-bold">Lokasi</label>
            <div class="col-9">
                <textarea class="form-control" rows="3" placeholder="Lokasi" id="alamat" name="lokasi"><?= old('lokasi') ?? (@$halte->lokasi ?? '') ?></textarea>

            </div>
        </div>
        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label fw-bold">Keterangan</label>
            <div class="col-9">
                <select class="form-control" name="keterangan">
                    <option value="0">- Pilih Keterangan -</option>
                    <?php foreach ($ket_load as $ket) : ?>
                        <option value="<?= $ket['value'] ?>" <?= old('keterangan') ? (old('keterangan') == $ket['value'] ? 'selected' : '') : (@$halte->keterangan == $ket['value'] ? 'selected' : '') ?>><?= $ket['value'] ?> ( Halte <?= $ket['value'] ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-group mb-3 row">
            <label class="form-label col-3 col-form-label fw-bold">Kordinat</label>
            <div class="col-9">
                <div class="row">
                    <div class="col-6">
                        <input type="text" class="form-control" id="lat" name="latitude" id="latitude" value="<?= old('latitude') ?? (@$node_latitude ?? '') ?>" placeholder="latitude" autocomplete="off">

                    </div>
                    <div class="col-6">
                        <input type="text" class="form-control" id="lng" name="longitude" id="longitude" value="<?= old('longitude') ?? (@$node_longitude ?? '') ?>" placeholder="longitude" autocomplete="off">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div id="map" style="height: 390px;width: 100%;"></div>
    </div>
</div>
@section('js')
<script>
    //Map

    let markers = [];
    let geocoder;
    let map;
    let inputLat = document.getElementById('lat');
    let inputLng = document.getElementById('lng');
    let inputAlamat = document.getElementById('alamat');

    let existingMarkers = [];

    function setInputLatLng(lat, lng) {
        inputLat.value = lat;
        inputLng.value = lng;
    }

    function addMarker(position) {
        const marker = new google.maps.Marker({
            position,
            map,
            draggable: true,
        });

        marker.addListener('dragend', (e) => {
            setInputLatLng(parseFloat(e.latLng.lat().toFixed(7)), parseFloat(e.latLng.lng().toFixed(7)));
            geocode({
                location: e.latLng
            }, function(results, status) {
                console.log(status);
                if (status == 'OK') {
                    map.setCenter(results[0].geometry.location);
                    var marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location
                    });
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });
        })

        markers.push(marker);
        console.log(markers);
    }

    function setMapOnAll(map) {
        for (let i = 0; i < markers.length; i++) {
            markers[i].setMap(map);
        }
    }


    // Removes the markers from the map, but keeps them in the array.
    function hideMarkers() {
        setMapOnAll(null);
    }
    // Deletes all markers in the array by removing references to them.
    function deleteMarkers() {
        hideMarkers();
        markers = [];
    }

    function clear() {
        marker.setMap(null);
        responseDiv.style.display = "none";
    }

    function geocode(request) {
        clear();
        deleteMarkers()
        geocoder
            .geocode(request)
            .then((result) => {
                const {
                    results
                } = result;

                inputAlamat.value = results[0].formatted_address;
                clear();

                map.setCenter(results[0].geometry.location);
                addMarker(results[0].geometry.location)

                setInputLatLng(results[0].geometry.location.lat().toFixed(7), results[0].geometry.location.lng().toFixed(7))

            })
            .catch((e) => {
                alert("Geocode was not successful for the following reason: " + e);
            });
    }

    function getNodes() {
        fetch('<?= url('/admin/halte/getjson/' . $halte_id . '') ?>')
            .then(res => res.json())
            .then(data => {
                data.map(function(e) {
                    console.log(e);
                    new google.maps.Marker({
                        position: {
                            lat: parseFloat(e.latitude),
                            lng: parseFloat(e.longitude)
                        },
                        map,
                    });
                })
            });
    }

    function initMap() {


        center = {
            lat: <?= @$node_latitude ?? env('DEFAULT_LAT') ?>,
            lng: <?= @$node_longitude ?? env('DEFAULT_LNG') ?>
        }

        map = new google.maps.Map(document.getElementById("map"), {
            zoom: 18,
            center: center,
        });

        addMarker(center)

        geocoder = new google.maps.Geocoder();


        const inputText = document.createElement("input");

        inputText.type = "text";
        inputText.placeholder = "Enter a location";

        const submitButton = document.createElement("input");

        submitButton.type = "button";
        submitButton.value = "Geocode";
        submitButton.classList.add("button", "button-primary");

        const clearButton = document.createElement("input");

        clearButton.type = "button";
        clearButton.value = "Clear";
        clearButton.classList.add("button", "button-secondary");
        response = document.createElement("pre");
        response.id = "response";
        response.innerText = "";
        responseDiv = document.createElement("div");
        responseDiv.id = "response-container";
        responseDiv.appendChild(response);

        const instructionsElement = document.createElement("p");

        instructionsElement.id = "instructions";
        instructionsElement.innerHTML =
            "<strong>Instructions</strong>: Enter an address in the textbox to geocode or click on the map to reverse geocode.";
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(inputText);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(submitButton);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(clearButton);
        marker = new google.maps.Marker({
            map,
        });
        map.addListener("click", (e) => {
            geocode({
                location: e.latLng
            }, function(results, status) {
                console.log(status);
                if (status == 'OK') {
                    map.setCenter(results[0].geometry.location);
                    var marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location
                    });
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });
        });

        submitButton.addEventListener("click", () =>
            geocode({
                address: inputText.value
            })
        );

        clearButton.addEventListener("click", () => {
            clear();
        });


        clear();
        //getNodes();
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDo9HRRCCPaSc56lFFDzT2V0xOYPI8OA9U&callback=initMap&libraries=places&v=weekly&language=id&region=ID"></script>
<script src="<?= asset('/node_modules/axios/dist/axios.min.js') ?>"></script>
@endSection