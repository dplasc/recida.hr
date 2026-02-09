<form action="{{route('admin.custom-type.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label ol-form-label"> {{get_phrase('Name')}} </label>
        <input type="text" class="form-control ol-form-control" name="name" id="name" placeholder="{{get_phrase('Enter Type Name')}}" required>
    </div>
    <div class="mb-3">
        <label for="logo" class="form-label ol-form-label"> {{get_phrase('Logo')}} </label>
        <input type="file" class="form-control ol-form-control" name="logo" id="logo"  >
    </div>
    <div class="mb-3">
        <label for="image" class="form-label ol-form-label"> {{get_phrase('Image')}} </label>
        <input type="file" class="form-control ol-form-control" name="image" id="image"  >
    </div>
    <button type="submit" class="btn ol-btn-primary "> {{get_phrase('Save')}} </button>
</form>