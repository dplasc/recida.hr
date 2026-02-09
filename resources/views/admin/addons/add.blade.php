<form  action="{{ route('admin.addon.update') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="purchase_code" class="form-label ol-form-label"> {{get_phrase('Purchase code')}} </label>
        <input type="text" class="form-control ol-form-control" name="purchase_code" id="purchase_code" placeholder="{{get_phrase('Enter addon purchase code')}}" required>
    </div>
    <div class="mb-3">
        <label for="addon_file" class="form-label ol-form-label"> {{get_phrase('Zip file')}} </label>
        <input type="file" class="form-control ol-form-control" name="file" id="addon_file" placeholder="{{get_phrase('Upload addon file')}}" required>
    </div>
  
    <button type="submit" class="btn ol-btn-primary "> {{get_phrase('Install Addon')}} </button>
</form>

