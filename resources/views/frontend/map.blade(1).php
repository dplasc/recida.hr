{{-- 
@if($type == 'car' || $type == 'beauty' || $type == 'hotel' || $type == 'real-estate' || $type == 'restaurant')
    @php
        $coordinates = [];
    @endphp
    @foreach ($listings as $listing)
        @php
            $images = json_decode($listing->image, true); 
            $image = isset($images[0]) ? asset('uploads/listing-images/' . $images[0]) : asset('image/placeholder.png');

            $latitude = $listing->Latitude;
            $longitude = $listing->Longitude;
            // $country  = $listing->country;
            $country = App\Models\Country::where('id', $listing->country)->first(); 
            $city = App\Models\City::where('id', $listing->city)->first(); 

            $name = $listing->title ?? ''; 

            if ($latitude && $longitude) {
                $coordinates[] = [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'name' => $name,
                    'image' => $image,
                    'country' => $country->name,
                    'city' => $city->name
                ];
            }
        @endphp
    @endforeach
@endif --}}

@if($type == 'car' || $type == 'beauty' || $type == 'hotel' || $type == 'real-estate' || $type == 'restaurant')
    @php
        $coordinates = [];
    @endphp
    @foreach ($listings as $listing)
        @php
            $images = json_decode($listing->image, true); 
            $image = isset($images[0]) ? asset('uploads/listing-images/' . $images[0]) : asset('image/placeholder.png');

            $latitude = $listing->Latitude;
            $longitude = $listing->Longitude;
            $country = App\Models\Country::find($listing->country); 
            $city = App\Models\City::find($listing->city); 
            $name = $listing->title ?? ''; 

            if ($latitude && $longitude) {
                $coordinates[] = [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'name' => $name,
                    'image' => $image,
                    'country' => $country->name ?? '',
                    'city' => $city->name ?? ''
                ];
            }
        @endphp
    @endforeach
@else
    @php
        $coordinates = [];
    @endphp
    @foreach ($listings as $listing)
        @php
            $images = json_decode($listing->image, true); 
            $image = isset($images[0]) ? asset('uploads/listing-images/' . $images[0]) : asset('image/placeholder.png');

            $latitude = $listing->Latitude ?? null;
            $longitude = $listing->Longitude ?? null;
            $country = App\Models\Country::find($listing->country); 
            $city = App\Models\City::find($listing->city); 
            $name = $listing->title ?? ''; 

            if ($latitude && $longitude) {
                $coordinates[] = [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'name' => $name,
                    'image' => $image,
                    'country' => $country->name ?? '',
                    'city' => $city->name ?? ''
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

    {{-- <script>
        "use strict";
        mapboxgl.accessToken = '{{get_settings('map_access_token')}}';
        var zoom = '{{get_settings('max_zoom_level')}}';
        var coordinates = @json($coordinates);
        var bounds = new mapboxgl.LngLatBounds();

        // Initialize the map
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            zoom: 1
        });
        coordinates.forEach(function(coordinate) {
            var popup = new mapboxgl.Popup({ offset: 25 })
                .setHTML('<h3>' + coordinate.name + '</h3>'); 
            new mapboxgl.Marker()
                .setLngLat([coordinate.longitude, coordinate.latitude])
                .setPopup(popup)
                .addTo(map);
            bounds.extend([coordinate.longitude, coordinate.latitude]);
        });

        // Fit the map to the bounds
        map.fitBounds(bounds);
    </script> --}}


    <script>
        "use strict";
        mapboxgl.accessToken = '{{ get_settings('map_access_token') }}';
        var zoom = '{{ get_settings('max_zoom_level') }}';
        var coordinates = @json($coordinates);
        var bounds = new mapboxgl.LngLatBounds();
    
        // Initialize the map
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            zoom: 1
        });
    
        coordinates.forEach(function(coordinate) {
            var imageUrl = coordinate.image || '{{ asset("image/placeholder.png") }}';
    
            var popupContent = `
                <div>
                    <img src="${imageUrl}" alt="Listing Image" style="width: 100%; height: 100px; border-radius: 5px; margin-bottom: 5px; object-fit:cover;">
                    <div class="coorName">
                      <h3>${coordinate.name}</h3>
                        <div class="mLocation">
                            <p>${coordinate.country}</p>
                            <p>${coordinate.city}</p>     
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
    
        // Fit the map to the bounds
        map.fitBounds(bounds);
    </script>
    

<script>
    "use strict";
    document.addEventListener("DOMContentLoaded", function() {
        var checkboxes = document.querySelectorAll(".switch-checkbox");
        var eRows = document.querySelectorAll(".eRow");
        eRows.forEach(function(eRow) {
            eRow.classList.remove("eShow");
        });
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener("change", function() {
                if (checkbox.checked) {
                    eRows.forEach(function(eRow) {
                        eRow.classList.remove("eShow");
                    });
                } else {
                    eRows.forEach(function(eRow) {
                        eRow.classList.add("eShow");
                    });
                }
            });
        });
    });
</script>

