<form action="{{ route('admin.website-setting-update') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="type" value="mother_homepage_banner">
    <div class="form-group mb-3">
        <label for="title" class="form-label ol-form-label">{{ get_phrase('Title') }}</label>
        <input type="text" class="form-control" name="titles[]" placeholder="Enter title" required>
    </div>
    <div class="form-group mb-3">
        <label for="description" class="form-label ol-form-label">{{ get_phrase('Description') }}</label>
        <textarea name="descriptions[]" class="form-control" id="description" cols="20" rows="5"></textarea>
    </div>
    <div class="form-group mb-3">
        <label for="image" class="form-label ol-form-label">{{ get_phrase('Image') }}</label>
        <input type="file" class="form-control" name="images[]" accept="image/*" required>
    </div>
    <button class="btn ol-btn-primary " type="submit">{{ get_phrase('Submit') }}</button>
</form>