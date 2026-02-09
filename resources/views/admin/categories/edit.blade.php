<form action="{{route('admin.update-category',['id'=>$category_details->id])}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label ol-form-label"> {{get_phrase('Category name')}} </label>
        <input type="text" class="form-control ol-form-control" name="name" id="name" value="{{$category_details->name}}" required>
    </div>
    <div class="mb-3">
        <label for="parent" class="form-label ol-form-label"> {{get_phrase('Category parent')}} </label>
        <select name="parent" id="parent" class="ol-select2" data-minimum-results-for-search="Infinity">
            <option value="0"> {{get_phrase('Select Category parent')}} </option>
            @foreach ($parents as $parent)
                <option value="{{$parent->id}}" {{($category_details->parent == $parent->id)?'selected':''}}> {{$parent->name}} </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn ol-btn-primary "> {{get_phrase('Update')}} </button>
</form>

<script>
    "use strict";
    $('.ol-select2').select2({
        dropdownParent: $('#edit-modal')
    });
</script>