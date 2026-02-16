{{--
    Reusable Mapbox GL map + Geocoder for listing create/edit forms.
    Pulls location into latitude, longitude, and optionally address inputs.

    Fixed IDs: #listing-map (container), #latitude, #longitude, #address (or addressInputId)
    Optional: latitude, longitude (initial values), addressInputId (default 'address'), mapClass
--}}
@php
    $mapToken = get_mapbox_token();
    $latitude = $latitude ?? '';
    $longitude = $longitude ?? '';
    $addressInputId = isset($addressInputId) ? $addressInputId : 'address';
    $mapClass = $mapClass ?? 'rounded h-400';
    $defaultLocation = get_settings('default_location');
    $defaultCoords = $defaultLocation ? array_map('trim', explode(',', $defaultLocation)) : [];
    $defaultLat = (isset($defaultCoords[0]) && is_numeric(trim($defaultCoords[0]))) ? floatval($defaultCoords[0]) : 45.1;
    $defaultLng = (isset($defaultCoords[1]) && is_numeric(trim($defaultCoords[1]))) ? floatval($defaultCoords[1]) : 15.2;
@endphp

<link rel="stylesheet" href="{{ asset('assets/frontend/css/mapbox-gl.css') }}">
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css" type="text/css">
<script src="{{ asset('assets/frontend/js/mapbox-gl.js') }}"></script>
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script>

<div id="listing-map" class="{{ $mapClass }}"></div>

<script>
(function() {
    "use strict";

    function initListingMap() {
        var token = @json($mapToken);
        var addressInputId = @json($addressInputId);
        var defaultLat = {{ $defaultLat }};
        var defaultLng = {{ $defaultLng }};
        var initialLat = {{ is_numeric($latitude) ? floatval($latitude) : 'null' }};
        var initialLng = {{ is_numeric($longitude) ? floatval($longitude) : 'null' }};

        if (!token) {
            console.warn('[Listing Map] Mapbox token missing. Set map_access_token in System Settings or MAPBOX_ACCESS_TOKEN in .env');
            return;
        }

        var mapEl = document.getElementById('listing-map');
        var latEl = document.getElementById('latitude');
        var lngEl = document.getElementById('longitude');
        var addrEl = addressInputId ? document.getElementById(addressInputId) : null;

        if (!mapEl) {
            console.warn('[Listing Map] Map container #listing-map not found');
            return;
        }

        var hasCoords = initialLat !== null && initialLng !== null;
        var centerLng = hasCoords ? initialLng : defaultLng;
        var centerLat = hasCoords ? initialLat : defaultLat;

        mapboxgl.accessToken = token;
        var map = new mapboxgl.Map({
            container: 'listing-map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [centerLng, centerLat],
            zoom: hasCoords ? 14 : 10
        });

        var marker = new mapboxgl.Marker({ draggable: true })
            .setLngLat([centerLng, centerLat])
            .addTo(map);

        function updateInputs(lng, lat, placeName) {
            if (latEl) latEl.value = typeof lat === 'number' ? lat.toFixed(6) : String(lat);
            if (lngEl) lngEl.value = typeof lng === 'number' ? lng.toFixed(6) : String(lng);
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
                var target = e.target.getAttribute ? (e.target.getAttribute('data-bs-target') || e.target.getAttribute('href')) : null;
                if (target && (target === '#' + tabPane.id || target === tabPane.id)) {
                    if (typeof map.resize === 'function') map.resize();
                }
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initListingMap);
    } else {
        initListingMap();
    }
})();
</script>
