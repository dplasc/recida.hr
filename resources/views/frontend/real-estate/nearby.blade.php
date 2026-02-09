<style>
    .h-450 {
        height: 450px !important;
        border-radius: 7px 0 0 7px;
    }
    .mapboxgl-canvas {
        width: 100%;
    }
</style>

@php
    $nearbyLocations = App\Models\NearByLocation::where('listing_id', $listing->id)->get();
@endphp

@php
    $coordinates = $nearbyLocations->map(function ($location) {
        return [
            'latitude' => $location->latitude,
            'longitude' => $location->longitude,
            'name' => $location->name,
            'type' => $location->type,
        ];
    });
@endphp

<div class="realdetails-nearby-area mb-50px">
    <h2 class="in-title3-24px mb-20">{{ get_phrase('Nearby') }}</h2>
    <div class="realdetails-nearby-grid">
        @foreach (['school', 'hospital', 'shopping_center'] as $type)
            @if ($nearbyLocations->where('type', $type)->isNotEmpty())
                <a href="#" class="realdetails-nearby-item" data-bs-toggle="modal" data-bs-target="#nearbyModal-{{ $type }}">
                    <div class="d-flex align-items-center justify-content-between gap-10px">
                        <div class="d-flex align-items-center gap-10px">
                            <img src="{{ asset('assets/frontend/images/'. $type. '-sky-blue-30.svg') }}" alt="">
                            <p class="nearby-item-name">{{ get_phrase(ucfirst(str_replace('_', ' ', $type))) }}</p>
                        </div>
                        <div class="nearby-item-arrow">
                            <span><svg xmlns="http://www.w3.org/2000/svg" id="Bold" viewBox="0 0 24 24" width="16" height="16"><path d="M6.079,22.5a1.5,1.5,0,0,1,.44-1.06l7.672-7.672a2.5,2.5,0,0,0,0-3.536L6.529,2.565A1.5,1.5,0,0,1,8.65.444l7.662,7.661a5.506,5.506,0,0,1,0,7.779L8.64,23.556A1.5,1.5,0,0,1,6.079,22.5Z"/></svg></span>
                        </div>
                    </div>
                </a>
            @endif
        @endforeach
    </div>
</div>

<!-- Dynamic Nearby Modals -->
@foreach (['school', 'hospital', 'shopping_center'] as $type)
    @if ($nearbyLocations->where('type', $type)->isNotEmpty())
        <div class="modal fade nearby-modal" id="nearbyModal-{{ $type }}" tabindex="-1" aria-labelledby="nearbyModalLabel-{{ $type }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title nearby-modal-title" id="nearbyModalLabel-{{ $type }}">
                            <span class="icon">
                                <img src="{{ asset('assets/frontend/images/icons/location-white2-14.svg') }}" alt="">
                            </span>
                            <span>{{ ucfirst(str_replace('_', ' ', $type)) }}</span>
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-0">
                            <div class="col-lg-8">
                                <div class="map-view">
                                    <div class="map-container h-450 w-100"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <ul>
                                    @foreach ($nearbyLocations->where('type', $type) as $location)
                                        <li class="nearby-map-listitem">
                                            <div class="bgcolor-iconbox2">
                                                <img src="{{ asset('assets/frontend/images/icons/graduation-white-20.svg') }}" alt="">
                                            </div>
                                            <span>{{ $location->name }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

<script src="{{ asset('assets/frontend/js/mapbox-gl.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/frontend/css/mapbox-gl.css') }}">
<script>
    "use strict";
    mapboxgl.accessToken = '{{ get_settings('map_access_token') }}';
    var zoom = Number('{{ get_settings('max_zoom_level') }}');
    var coordinates = @json($coordinates);

    var mapContainers = document.querySelectorAll('.map-container');

    var mapTypes = ['school', 'hospital', 'shopping_center'];

    mapContainers.forEach((container, index) => {
    var bounds = new mapboxgl.LngLatBounds();
    var currentType = mapTypes[index]; 

    var filteredCoordinates = coordinates.filter(coord => coord.type === currentType);
    var map = new mapboxgl.Map({
        container: container, // Use the container element
        style: 'mapbox://styles/mapbox/streets-v11',
        zoom: 1
    });

    // Add markers for the filtered coordinates
    filteredCoordinates.forEach(function (coordinate) {
        var popup = new mapboxgl.Popup({ offset: 25 })
            .setHTML('<h3>' + coordinate.name + '</h3>');

        new mapboxgl.Marker()
            .setLngLat([coordinate.longitude, coordinate.latitude])
            .setPopup(popup)
            .addTo(map);

        bounds.extend([coordinate.longitude, coordinate.latitude]);
    });

    // Adjust map bounds
    if (filteredCoordinates.length === 1) {
        map.setCenter([filteredCoordinates[0].longitude, filteredCoordinates[0].latitude]);
        map.setZoom(zoom);
    } else if (filteredCoordinates.length > 1) {
        map.fitBounds(bounds, { padding: 20 });
    }

    const modal = container.closest('.modal'); 
    if (modal) {
        modal.addEventListener('shown.bs.modal', function () {
            map.resize(); 
        });
    }
});

</script>
