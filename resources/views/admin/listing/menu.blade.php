@php $user_prefix = (user('role') == 1) ? 'admin':'agent'; @endphp
@if ($page == 'add')
<form action="{{route('admin.store.listing.menu',['prefix'=>$user_prefix, 'id'=>$id])}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="title" class="form-label ol-form-label"> {{get_phrase('Menu title')}} </label>
        <input type="text" name="title" id="title" class="form-control ol-form-control" placeholder="{{get_phrase('Enter menu title')}}" required>
    </div>
    <div class="mb-3">
        <label for="sub_title" class="form-label ol-form-label"> {{get_phrase('Menu Sub title')}} </label>
        <input type="text" name="sub_title" id="sub_title" class="form-control ol-form-control" placeholder="{{get_phrase('Enter sub title')}}" required>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label ol-form-label"> {{get_phrase('Menu price')}} </label>
        <input type="number" name="price" id="price" class="form-control ol-form-control" placeholder="{{get_phrase('Enter menu price')}}" required>
    </div>
    <div class="mb-3">
        <label for="dis_price" class="form-label ol-form-label"> {{get_phrase('Menu discount price')}} </label>
        <input type="number" name="dis_price" id="dis_price" class="form-control ol-form-control" placeholder="{{get_phrase('Enter menu discount price')}}">
    </div> 
    <div class="mb-3">
        <label for="image" class="form-label ol-form-label"> {{get_phrase('Specification value')}} </label>
        <input type="file" name="image" id="image" class="form-control ol-form-control" required>
    </div>
    <div class="mb-3">
        <button type="submit" class="btn ol-btn-primary fs-14px"> {{get_phrase('Save')}} </button>
    </div>
</form>
@elseif ($page == 'edit')
<form action="{{route('admin.update.listing.menu',['prefix'=>$user_prefix,'id'=>$id, 'listing_id'=>$listing_id])}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="title" class="form-label ol-form-label"> {{get_phrase('Menu title')}} </label>
        <input type="text" name="title" id="title" class="form-control ol-form-control" value="{{$menu->title}}" required>
    </div>
    <div class="mb-3">
        <label for="sub_title" class="form-label ol-form-label"> {{get_phrase('Menu Sub title')}} </label>
        <input type="text" name="sub_title" id="sub_title" class="form-control ol-form-control" value="{{$menu->sub_title}}" required>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label ol-form-label"> {{get_phrase('Menu price')}} </label>
        <input type="number" name="price" id="price" class="form-control ol-form-control" value="{{$menu->price}}" required>
    </div>
    <div class="mb-3">
        <label for="dis_price" class="form-label ol-form-label"> {{get_phrase('Menu discount price')}} </label>
        <input type="number" name="dis_price" id="dis_price" class="form-control ol-form-control" value="{{$menu->dis_price}}">
    </div> 
    <div class="mb-3">
        <label for="image" class="form-label ol-form-label"> {{get_phrase('Specification value')}} </label>
        <input type="file" name="image" id="image" class="form-control ol-form-control">
    </div>
    <div class="mb-3">
        <button type="submit" class="btn ol-btn-primary fs-14px"> {{get_phrase('Save')}} </button>
    </div>
</form>
@endif