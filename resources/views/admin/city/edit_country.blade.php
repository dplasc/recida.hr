<form action="{{route('admin.update-country',['id'=>$country_details->id])}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label ol-form-label"> {{get_phrase('Country name')}} </label>
        <input type="text" class="form-control ol-form-control" name="name" id="name" value="{{$country_details->name}}" readonly>
    </div>
    <div class="mb-3">
        <label for="thumbnail" class="form-label ol-form-label">{{ get_phrase('Choose country thumbnail') }} <small class="text-muted">({{ get_phrase('optional') }})</small></label>
        <input type="file" name="thumbnail" class="form-control ol-form-control" id="thumbnail" accept="image/*" />
    </div>

    <button type="submit" class="btn ol-btn-primary "> {{get_phrase('Save')}} </button>
</form>

<script>
    "use strict";
    $('.ol-select2').select2({
        dropdownParent: $('#edit-modal')
    });
</script>