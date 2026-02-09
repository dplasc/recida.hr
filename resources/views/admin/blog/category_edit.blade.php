<form action="{{route('admin.update.blog.category',['id'=>$category->id])}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label ol-form-label"> {{get_phrase('Category name')}} </label>
        <input type="text" class="form-control ol-form-control" name="name" id="name" value="{{$category->name}}" required>
    </div>
    <button type="submit" class="btn ol-btn-primary px-4 fs-14px"> {{get_phrase('Save')}} </button>
</form>