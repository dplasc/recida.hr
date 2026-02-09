@if ($page == 'add')
<form action="{{route('admin.language-store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label ol-form-label"> {{get_phrase('Language name')}}* </label>
        <input type="text" class="form-control ol-form-control" name="name" id="name" placeholder="{{get_phrase('Enter language name')}}" required>
    </div>
    <div class="mb-3">
        <button type="submit" class="btn ol-btn-primary px-4"> {{get_phrase('Create')}} </button>
    </div>
</form>
@elseif ($page == 'edit')
<form action="{{route('admin.language-update',['language'=>$language->name])}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label ol-form-label"> {{get_phrase('Language name')}}* </label>
        <input type="text" class="form-control ol-form-control" name="name" id="name" placeholder="{{get_phrase('Enter language name')}}" value="{{$language->name}}">
    </div>
    <div class="mb-3">
        <button type="submit" class="btn ol-btn-primary px-4"> {{get_phrase('Update')}} </button>
    </div>
</form>
@endif