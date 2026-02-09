<form action="{{route('admin.store.blog.category')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label ol-form-label"> {{get_phrase('Category name')}} </label>
        <input type="text" class="form-control ol-form-control" name="name" id="name" placeholder="{{get_phrase('Enter Category Name')}}" required>
    </div>
    <button type="submit" class="btn ol-btn-primary px-4 fs-14px"> {{get_phrase('Save')}} </button>
</form>