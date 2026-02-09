<form action="{{ route('admin.website-setting-update') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="type" value="company_images">
    <div class="form-group mb-3">
        <label for="image" class="form-label ol-form-label">{{ get_phrase('Logo') }}</label>
        <input type="file" class="form-control" name="images[]" accept="image/*" required>
    </div>
    <button class="btn ol-btn-primary " type="submit">{{ get_phrase('Submit') }}</button>
</form>