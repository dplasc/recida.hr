<style>
    .h-200px{
        height: 200px;
    }
    .cursor-pointer{
        cursor: pointer;
    }
</style>
@php $user_prefix = (user('role') == 1) ? 'admin':'agent'; @endphp
<form id="nearby_form" action="{{ route('saveNearByLocation',['prefix'=>$user_prefix]) }}" method="post">
    @csrf
    <div class="dl_column_form d-flex flex-column rg-22">
        <!-- Nearby Location -->
         <div class="row justify-content-between align-items-center mb-2">
            <label for="nearby_id" class="col-sm-3 pe-0 form-label cap-form-label">{{ get_phrase('Add a Nearby Location') }}</label>
            <div class="col-sm-9">
                <select class="form-select eForm-select form-control cap-form-control" id="nearby_id" name="nearby_id" data-placeholder="Type to search...">
                    <option value="0">{{get_phrase('School')}}</option>
                    <option value="1">{{get_phrase('Hospital')}}</option>
                    <option value="2">{{get_phrase('Shopping center')}}</option>
                </select>
            </div>
        </div>
          <!-- name -->
          <div class="row justify-content-between align-items-center mb-2">
            <label for="nearbyname" class="col-sm-3 pe-0 form-label cap-form-label">{{ get_phrase('Name') }}</label>
            <div class="col-sm-9">
                <input type="text" placeholder="name" class="form-control cap-form-control" id="nearbyname" name="nearbyname" required/>
            </div>
        </div>
        <input type="hidden"  id="nearby_listing_id" name="nearby_listing_id" value="{{$id}}"/>
        <input type="hidden"  id="listing_type" name="listing_type" value="real-estate"/>
        <!-- Latitude -->
        <div class="row justify-content-between align-items-center mb-2">
            <label for="nearby-latitude" class="col-sm-3 pe-0 form-label cap-form-label">{{ get_phrase('Latitude') }}</label>
            <div class="col-sm-9">
                <input type="text" placeholder="40.708621" class="form-control cap-form-control" id="nearby-latitude" name="nearby-latitude" required />
            </div>
        </div>
        <!-- Longitude -->
        <div class="row justify-content-between align-items-center mb-2">
            <label for="nearby-longitude" class="col-sm-3 pe-0 form-label cap-form-label">{{ get_phrase('Longitude') }}</label>
            <div class="col-sm-9">
                <input type="text" placeholder="-73.993994" class="form-control cap-form-control" id="nearby-longitude" name="nearby-longitude"  required />
            </div>
        </div>
        <!-- Select Location -->
        <div class="row justify-content-between align-items-start mb-2">
            <label for="inputLocation" class="col-sm-3 pe-0 form-label cap-form-label">{{ get_phrase('Select Location') }}</label>
            <div class="col-sm-10 col-md-9 col-lg-9">
                <div class="contact-map">
                    <div class="map-area">
                        <div class="map-frame">
                            <script src="{{asset('assets/backend/js/leaflet.js')}}"></script>
                            <link rel="stylesheet" href="{{asset('assets/backend/css/leaflet.css')}}">
                            <div id="nearby-map" class="h-200px cursor-pointer"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Button -->
    <div class="dl_form_btn d-flex justify-content-end g-20 pt-40">
        <button type="submit" class="btn ol-btn-primary btn-theme">{{ get_phrase('Save Nearby') }}</button>
    </div>
</form>


<!-- map start -->
<script type="text/javascript">

    "use strict";

    <?php if (get_settings("active_map") == 'openstreetmap'): ?>

        //free map
        var map = L.map('nearby-map').setView([<?=get_settings('default_location');?>], 13);
        L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '<a href="{{ route('home') }}" target="_blank"><?=get_settings("system_title");?></a>',
            gestureHandling: true
        }).addTo(map);

    <?php else: ?>

        //paid maps
        var map = L.map('nearby-map').setView([<?=get_settings('default_location');?>], 13);
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: '<a href="{{ route('home') }}" target="_blank"><?=get_settings("system_title");?></a>',
            id: 'mapbox/streets-v11',
            accessToken: '<?=get_settings("map_access_token");?>',
            gestureHandling: true
        }).addTo(map);

    <?php endif;?>

    var popup = L.popup();
    map.on('click', onNearbyMapClick);

    function onNearbyMapClick(e) {
        popup.setLatLng(e.latlng).setContent("{{ get_phrase('Your selected') }} " + e.latlng.toString()).openOn(map);

        var lat_lan_string =  e.latlng.toString();
        var lat_lan_string_arr = lat_lan_string.split(", ");
        var lat_string_arr = lat_lan_string_arr[0].split('LatLng(');
        var lan_string_arr = lat_lan_string_arr[1].split(')');
        var lat = lat_string_arr[1];
        var lan = lan_string_arr[0];
        $('#nearby-latitude').val(lat);
        $('#nearby-longitude').val(lan);
    }

</script>