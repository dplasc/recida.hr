@php $user_prefix = (user('role') == 1) ? 'admin':'agent'; @endphp
@if ($page == 'edit')

<form action="{{route('admin.listing.feature.update',['prefix'=>$user_prefix, 'id'=>$id, 'feature_id'=>$feature_id])}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="title" class="form-label ol-form-label"> {{get_phrase('Feature title')}} </label>
        <input type="text" name="title" id="title" class="form-control ol-form-control" value="{{$feature->title}}" required>
    </div>
    <div class="mb-3">
        <button type="submit" class="btn ol-btn-primary fs-14px"> {{get_phrase('Update')}} </button>
    </div>
</form>

@elseif($page == 'add')
<form action="{{route('admin.store-listing-feature',['prefix' => $user_prefix,'id'=>$id])}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="title" class="form-label ol-form-label"> {{get_phrase('Feature title')}} </label>
        <input type="text" name="title" id="title" class="form-control ol-form-control" placeholder="{{get_phrase('Enter title')}}" required>
    </div>
    <div class="mb-3">
        <button type="submit" class="btn ol-btn-primary fs-14px"> {{get_phrase('Save')}} </button>
    </div>
</form>

@elseif($page == 'sub_add')

<form action="{{route('admin.listing.sub-feature.store',['prefix'=>$user_prefix,'id'=>$id, 'feature_id'=>$feature_id])}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="title" class="form-label ol-form-label"> {{get_phrase('Feature title')}} </label>
        <input type="text" name="title" id="title" class="form-control ol-form-control" placeholder="{{get_phrase('Enter title')}}" required>
    </div>
    <div class="mb-3">
        <button type="submit" class="btn ol-btn-primary fs-14px"> {{get_phrase('Save')}} </button>
    </div>
</form>
    
@else

@endif