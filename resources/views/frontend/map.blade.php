@if($type == 'car' || $type == 'beauty' || $type == 'hotel' || $type == 'real-estate' || $type == 'restaurant')
    @php $coordinates = []; @endphp
    @foreach ($listings as $listing)
        @php
            $images = json_decode($listing->image, true);
            $image = isset($images[0]) ? asset('uploads/listing-images/' . $images[0]) : asset('image/placeholder.png');

            $latitude  = $listing->Latitude;
            $longitude = $listing->Longitude;

            $country = App\Models\Country::find($listing->country);
            $city    = App\Models\City::find($listing->city);

            $name = $listing->title ?? '';

            if ($latitude && $longitude) {
                $coordinates[] = [
                    'latitude'  => $latitude,
                    'longitude' => $longitude,
                    'name'      => $name,
                    'image'     => $image,
                    'country'   => $country->name ?? '',
                    'city'      => $city->name ?? ''
                ];
            }
        @endphp
    @endforeach
@else
    @php $coordinates = []; @endphp
    @foreach ($listings as $listing)
        @php
            $images = json_decode($listing->image, true);
            $image = isset($images[0]) ? asset('uploads/listing-images/' . $images[0]) : asset('image/placeholder.png');

            $latitude  = $listing->Latitude ?? null;
            $longitude = $listing->Longitude ?? null;

            $country = App\Models\Country::find($listing->country);
            $city    = App\Models\City::find($listing->city);

            $name = $listing->title ?? '';

            if ($latitude && $longitude) {
                $coordinates[] = [
                    'latitude'  => $latitude,
                    'longitude' => $longitude,
                    'name'      => $name,
                    'image'     => $image,
                    'country'   => $country->name ?? '',
                    'city'      => $city->name ?? ''
                ];
            }
        @endphp
    @endforeach
@endif

<div class="car-map-area eRow">
    <div id="map" class="h-500"></div>
</div>

<script src="{{ asset('assets/frontend/js/mapbox-gl.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/frontend/css/mapbox-gl.css') }}">

<script>
"use strict";

mapboxgl.accessToken = '{{ get_settings('map_access_token') }}';

// IMPORTANT: use get_settings() on this project (setting() is not available on live)
var DEFAULT_MAP_ZOOM = parseInt('{{ get_settings('default_zoom_level') ?? 11 }}', 10);
if (isNaN(DEFAULT_MAP_ZOOM)) DEFAULT_MAP_ZOOM = 11;

var MAX_MAP_ZOOM = parseInt('{{ get_settings('max_zoom_level') ?? 22 }}', 10);
if (isNaN(MAX_MAP_ZOOM)) MAX_MAP_ZOOM = 22;

var coordinates = @json($coordinates);
var bounds = new mapboxgl.LngLatBounds();

// Initialize the map with safe defaults
var map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v11',
    center: [16.3738, 48.2082],
    zoom: DEFAULT_MAP_ZOOM,
    maxZoom: MAX_MAP_ZOOM
});

// If no coordinates, don't try to add markers / fit bounds
if (Array.isArray(coordinates) && coordinates.length > 0) {

    coordinates.forEach(function(coordinate) {
        var imageUrl = coordinate.image || '{{ asset("image/placeholder.png") }}';

        var popupContent = `
            <div>
                <img src="${imageUrl}" alt="Listing Image" style="width: 100%; height: 100px; border-radius: 5px; margin-bottom: 5px; object-fit:cover;">
                <div class="coorName">
                    <h3>${coordinate.name || ''}</h3>
                    <div class="mLocation">
                        <p>${coordinate.country || ''}</p>
                        <p>${coordinate.city || ''}</p>
                    </div>
                </div>
            </div>
        `;

        var popup = new mapboxgl.Popup({ offset: 25 }).setHTML(popupContent);

        new mapboxgl.Marker()
            .setLngLat([coordinate.longitude, coordinate.latitude])
            .setPopup(popup)
            .addTo(map);

        bounds.extend([coordinate.longitude, coordinate.latitude]);
    });

    if (coordinates.length > 1) {
        map.fitBounds(bounds, { padding: 50 });
    } else if (coordinates.length === 1) {
        map.setCenter([coordinates[0].longitude, coordinates[0].latitude]);
        map.setZoom(DEFAULT_MAP_ZOOM);
    }
}
</script>

<script>
"use strict";
document.addEventListener("DOMContentLoaded", function() {
    var STORAGE_KEY = "recida_show_map";
    var checkboxes = document.querySelectorAll(".switch-checkbox");
    var eRows = document.querySelectorAll(".eRow");

    function applyMapState(showMap) {
        eRows.forEach(function(eRow) {
            if (showMap) {
                eRow.classList.add("eShow");
            } else {
                eRow.classList.remove("eShow");
            }
        });
        checkboxes.forEach(function(cb) {
            cb.checked = !showMap;
        });
        if (showMap && typeof map !== "undefined") {
            requestAnimationFrame(function() {
                requestAnimationFrame(function() {
                    try { map.resize(); } catch (e) {}
                });
            });
        }
    }

    function getStoredState() {
        var val = localStorage.getItem(STORAGE_KEY);
        return val === "1";
    }

    var showMap = getStoredState();
    applyMapState(showMap);

    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener("change", function() {
            var showMap = !checkbox.checked;
            localStorage.setItem(STORAGE_KEY, showMap ? "1" : "0");
            applyMapState(showMap);
        });
    });
});
</script>
