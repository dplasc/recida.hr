
<!-- DETEKTIV KOJI SE VIDI SVUGDJE -->
<div style="position: fixed; top: 100px; right: 20px; z-index: 9999; background: yellow; border: 5px solid red; padding: 20px; width: 300px; color: black; font-weight: bold; box-shadow: 0 0 20px rgba(0,0,0,0.5);">
    <h3>🕵️ DETEKTIV</h3>
    @php
        $d_user = auth()->id();
        $d_sub = \App\Models\Subscription::where('user_id', $d_user)->where('status', 1)->orderBy('id', 'DESC')->first();
    @endphp

    @if($d_sub)
        @php $d_pkg = \App\Models\Pricing::where('id', $d_sub->package_id)->first(); @endphp
        ID Paketa: {{ $d_pkg->id }} <br>
        Ime: {{ $d_pkg->name }} <br>
        Cijena (Price): '{{ $d_pkg->price }}' <br>
        Plaćeno (Paid): '{{ $d_sub->paid_amount }}' <br>
        <hr>
        FUNKCIJA KAŽE: <br>
        <span style="font-size: 20px; background: white; color: blue;">
        {{ has_paid_subscription() ? 'TRUE (Imaš pristup)' : 'FALSE (Nemaš pristup)' }}
        </span>
    @else
        NEMA PRETPLATE!
    @endif
</div>
<script type="text/javascript">
"use strict";
    $(document).ready(function() {
        $('.ol-select22').select2();
    });

    function listing_image_delete(url, key){
        $.ajax({
            url: url,
            success: function(result){
                if(result == 1){
                    $("#image-icon"+key).hide();
                }
            }
        });
    }

    function listing_floor_plan_delete(url, key){
        $.ajax({
            url: url,
            success: function(result){
                if(result == 1){
                    $("#floor-plan-icon"+key).hide();
                }
            }
        });
    }


    document.getElementById('listing-icon-image').addEventListener('change', function(event) {
        const imageContainer = document.getElementById('image-container');
        const files = event.target.files;

        for (const file of files) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const imageIcon = document.createElement('div');
                imageIcon.classList.add('image-icon');
                
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Selected image';
                
                const trashIcon = document.createElement('i');
                trashIcon.classList.add('fas', 'fa-trash-alt');
                trashIcon.addEventListener('click', function() {
                    imageIcon.remove();
                });

                imageIcon.appendChild(img);
                imageIcon.appendChild(trashIcon);
                imageContainer.appendChild(imageIcon);
            }
            
            reader.readAsDataURL(file);
        }
    }); 

    $("#country").on('change', function(){
        var country = $("#country").val();
        var url = "{{route('admin.country.city',['id'=>':id'])}}";
        url = url.replace(':id', country);
        $.ajax({
            url: url,
            success: function(result){
                var cityDropdown = $("#city");
                cityDropdown.html($('<option>', {
                        value: '',
                        text: "{{get_phrase('Select listing City')}}"
                    }));
                $.each(result, function(index, city) {
                    cityDropdown.append($('<option>', {
                        value: city.id,
                        text: city.name
                    }));
                });
            }
        })
    })

    function team_select(key) {
        var checkbox = document.getElementById('flexCheckDefault' + key);
        document.getElementById('team-checked' + key).classList.toggle('d-none');
    }
    function menu_select(key) {
        var checkbox = document.getElementById('flexCheckDefault' + key);
        document.getElementById('menu-checked' + key).classList.toggle('d-none');
    }
    function service_select(key) {
        var checkbox = document.getElementById('flexCheckDefau' + key);
        document.getElementById('service-checked' + key).classList.toggle('d-none');
    }
    function feature_select(key) {
        var checkbox = document.getElementById('flexCheckDefau' + key);
        document.getElementById('feature-checked' + key).classList.toggle('d-none');
    }
    function room_select(key) {
        var checkbox = document.getElementById('flckDefault' + key);
        document.getElementById('room-checked' + key).classList.toggle('d-none');
    }

</script>
