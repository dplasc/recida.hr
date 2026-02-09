<form action="{{route('admin.store-city')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label ol-form-label"> {{get_phrase('City name')}} </label>
        <input type="text" class="form-control ol-form-control" name="name" id="name" placeholder="{{get_phrase('Enter City Name')}}" required>
    </div>
    <div class="mb-3">
        <label for="country" class="form-label ol-form-label"> {{get_phrase('Country Name')}} </label>
        <select name="country" id="country" class="ol-select2" data-minimum-results-for-search="Infinity" required>
            <option value="0"> {{get_phrase('Select Country Name')}} </option>
            @foreach ($countries as $country)
                <option value="{{$country->id}}"> {{$country->name}} </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label ol-form-label"> {{get_phrase('City Image')}} </label>
        <input type="file" class="form-control ol-form-control" name="image" id="image"  required>
    </div>
    <button type="submit" class="btn ol-btn-primary "> {{get_phrase('Save')}} </button>
</form>

<script>
    "use strict";
    $('.ol-select2').select2({
        dropdownParent: $('#ajax-modal')
    });
</script>