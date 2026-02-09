<form action="{{ route('admin.company.update',$logoEdit['id']) }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group mb-3">
        <label for="image" class="form-label ol-form-label">{{ get_phrase('Logo') }}</label>
        <input type="file" class="form-control" name="images[]" value="{{$logoEdit['image']}}" accept="image/*">
    </div>
    <button class="btn ol-btn-primary " type="submit">{{ get_phrase('Submit') }}</button>
</form>