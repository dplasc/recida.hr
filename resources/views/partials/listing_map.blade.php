{{--
    Reusable Mapbox GL map + Geocoder for listing create/edit forms.
    Pulls location into latitude, longitude, and optionally address inputs.

    Required: none (all have defaults)
    Optional:
        - latitude: initial latitude value
        - longitude: initial longitude value
        - mapContainerId: div id for map (default: 'map')
        - latitudeInputId: input id for latitude (default: 'latitude')
        - longitudeInputId: input id for longitude (default: 'longitude')
        - addressInputId: input id for address, or null to skip (default: 'address')
        - mapClass: CSS class for map div (default: 'rounded h-400')
--}}
@php
    $mapToken = get_mapbox_token();
    $latitude = $latitude ?? '';
    $longitude = $longitude ?? '';
    $mapContainerId = $mapContainerId ?? 'map';
    $latitudeInputId = $latitudeInputId ?? 'latitude';
    $longitudeInputId = $longitudeInputId ?? 'longitude';
    $addressInputId = isset($addressInputId) ? $addressInputId : 'address';
    $mapClass = $mapClass ?? 'rounded h-400';
    $defaultLocation = get_settings('default_location') ?? '45.1, 15.2';
    $defaultCoords = array_map('trim', explode(',', $defaultLocation));
    $defaultLat = isset($defaultCoords[0]) ? floatval($defaultCoords[0]) : 45.1;
    $defaultLng = isset($defaultCoords[1]) ? floatval($defaultCoords[1]) : 15.2;
@endphp

<link rel="stylesheet" href="{{ asset('assets/frontend/css/mapbox-gl.css') }}">
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css" type="text/css">
<script src="{{ asset('assets/frontend/js/mapbox-gl.js') }}"></script>
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script>

<div id="{{ $mapContainerId }}" class="{{ $mapClass }}"></div>

<script>
(function() {
    "use strict";
    var token = @json($mapToken);
    var mapContainerId = @json($mapContainerId);
    var latitudeInputId = @json($latitudeInputId);
    var longitudeInputId = @json($longitudeInputId);
    var addressInputId = @json($addressInputId);
    var defaultLat = {{ $defaultLat }};
    var defaultLng = {{ $defaultLng }};
    var initialLat = {{ is_numeric($latitude) ? floatval($latitude) : 'null' }};
    var initialLng = {{ is_numeric($longitude) ? floatval($longitude) : 'null' }};

    if (!token) {
        console.warn('[Listing Map] Mapbox token missing. Set map_access_token in System Settings or MAPBOX_ACCESS_TOKEN in .env');
        return;
    }

    var mapEl = document.getElementById(mapContainerId);
    var latEl = document.getElementById(latitudeInputId);
    var lngEl = document.getElementById(longitudeInputId);
    var addrEl = addressInputId ? document.getElementById(addressInputId) : null;

    if (!mapEl) {
        console.warn('[Listing Map] Map container #' + mapContainerId + ' not found');
        return;
    }

    var centerLng = (initialLng !== null && initialLat !== null) ? initialLng : defaultLng;
    var centerLat = (initialLat !== null && initialLng !== null) ? initialLat : defaultLat;

    mapboxgl.accessToken = token;
    var map = new mapboxgl.Map({
        container: mapContainerId,
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [centerLng, centerLat],
        zoom: (initialLat !== null && initialLng !== null) ? 14 : 10
    });

    var marker = new mapboxgl.Marker({ draggable: true })
        .setLngLat([centerLng, centerLat])
        .addTo(map);

    function updateInputs(lng, lat, placeName) {
        if (latEl) latEl.value = typeof lat === 'number' ? lat.toFixed(6) : lat;
        if (lngEl) lngEl.value = typeof lng === 'number' ? lng.toFixed(6) : lng;
        if (addrEl && placeName) addrEl.value = placeName;
    }

    marker.on('dragend', function() {
        var lngLat = marker.getLngLat();
        updateInputs(lngLat.lng, lngLat.lat);
    });

    map.on('click', function(e) {
        var lng = e.lngLat.lng;
        var lat = e.lngLat.lat;
        marker.setLngLat([lng, lat]);
        updateInputs(lng, lat);
    });

    var geocoder = new MapboxGeocoder({
        accessToken: token,
        mapboxgl: mapboxgl,
        marker: false
    });

    geocoder.on('result', function(ev) {
        var result = ev.result;
        var coords = result.geometry.coordinates;
        var lng = coords[0];
        var lat = coords[1];
        var placeName = result.place_name || result.text || '';
        marker.setLngLat([lng, lat]);
        map.flyTo({ center: [lng, lat], zoom: 14 });
        updateInputs(lng, lat, placeName);
    });

    map.addControl(geocoder, 'top-right');

    var tabPane = mapEl.closest('.tab-pane');
    if (tabPane && tabPane.id) {
        document.addEventListener('shown.bs.tab', function tabShownHandler(e) {
            var target = e.target.getAttribute ? e.target.getAttribute('data-bs-target') || e.target.getAttribute('href') : null;
            if (target && (target === '#' + tabPane.id || target === tabPane.id)) {
                if (typeof map.resize === 'function') map.resize();
            }
        });
    }
})();
</script>
