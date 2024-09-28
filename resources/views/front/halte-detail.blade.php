@extends('front.layout')
@section('main')
<div class="container mt-5">
    <div class="mb-3">
        <h1 class="fw-bold"><?= $halte->nama ?> (<?= $halte->kode ?>)</h1>
        <div class="row">
            <div class="col-12 col-md-6 table-responsive">
                <table class="mt-4 table table-striped">
                    <tr>
                        <td class="col-4">Koridor</td>
                        <td><?= $halte->Koridor->nama .$halte->Koridor->kode  ?></td>
                    </tr>
                    <tr>
                        <td>Koridor Kode</td>
                        <td><?= $halte->Koridor->kode ?></td>
                    </tr>
                    <tr>
                        <td>Lokasi</td>
                        <td><?= $halte->lokasi ?></td>
                    </tr>
                    <tr>
                        <td>Latitude</td>
                        <td><?= $halte->Node->latitude ?></td>
                    </tr>
                    <tr>
                        <td>Longitude</td>
                        <td><?= $halte->Node->longitude ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-12 col-md-6">
                <div id="map" style="height: 390px;width: 100%;"></div>
            </div>
        </div>

    </div>
</div>
<script>
    function initMap() {
        let markers = [];

        center = {
            lat: <?= @$halte->Node->latitude?? env('DEFAULT_LAT') ?>,
            lng: <?= @$halte->Node->longitude ?? env('DEFAULT_LNG') ?>
        }

        map = new google.maps.Map(document.getElementById("map"), {
            zoom: <?= @$halte ? 18 : env('DEFAULT_ZOOM') ?>,
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
        getNodes();
    }

    function addMarker(position) {
        const marker = new google.maps.Marker({
            position,
            map,
        });

        markers.push(marker);
    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDo9HRRCCPaSc56lFFDzT2V0xOYPI8OA9U&callback=initMap&libraries=places&v=weekly&language=id&region=ID" async></script>

@endSection