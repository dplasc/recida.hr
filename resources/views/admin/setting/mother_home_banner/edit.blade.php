<form action="{{ route('admin.mother.website-setting-update',$bannerToEdit['id']) }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group mb-3">
        <label for="title" class="form-label ol-form-label">{{ get_phrase('Title') }}</label>
        <input type="text" class="form-control" name="titles[]" value="{{$bannerToEdit['title']}}" placeholder="Enter title" >
    </div>
    <div class="form-group mb-3">
        <label for="description" class="form-label ol-form-label">{{ get_phrase('Description') }}</label>
        <textarea name="descriptions[]" class="form-control" id="description" cols="20" rows="5">{{$bannerToEdit['description']}}</textarea>
    </div>
    <div class="form-group mb-3">
        <label for="image" class="form-label ol-form-label">{{ get_phrase('Image') }}</label>
        <input type="file" class="form-control" name="images[]" value="{{$bannerToEdit['image']}}" accept="image/*">
    </div>
    <button class="btn ol-btn-primary " type="submit">{{ get_phrase('Submit') }}</button>
</form>