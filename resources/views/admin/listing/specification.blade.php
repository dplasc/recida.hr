
@php $user_prefix = (user('role') == 1) ? 'admin':'agent'; @endphp
@if($page == 'add')

<form action="{{route('admin.store.listing.specification',['prefix'=>$user_prefix ,'id'=>$id])}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="title" class="form-label ol-form-label"> {{get_phrase('Specification title')}} </label>
        <input type="text" name="title" id="title" class="form-control ol-form-control" placeholder="{{get_phrase('Enter title')}}" required>
    </div>
    <div class="mb-3">
        <button type="submit" class="btn ol-btn-primary fs-14px"> {{get_phrase('Save')}} </button>
    </div>
</form>

@elseif($page == 'edit')

<form action="{{route('admin.update.listing.specification',['prefix'=>$user_prefix, 'id'=>$id, 'specification_id'=>$specification_id])}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="title" class="form-label ol-form-label"> {{get_phrase('Specification title')}} </label>
        <input type="text" name="title" id="title" class="form-control ol-form-control" value="{{$specification->title}}" required>
    </div>
    <div class="mb-3">
        <button type="submit" class="btn ol-btn-primary fs-14px"> {{get_phrase('Update')}} </button>
    </div>
</form>

@elseif($page == 'sub_add')

<form action="{{route('admin.store.listing.sub.specification',['prefix'=>$user_prefix, 'id'=>$id, 'specification_id'=>$specification_id])}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="title" class="form-label ol-form-label"> {{get_phrase('Specification title')}} </label>
        <input type="text" name="title" id="title" class="form-control ol-form-control" placeholder="{{get_phrase('Enter specification title')}}" required>
    </div>
    <div class="mb-3">
        <label for="value" class="form-label ol-form-label"> {{get_phrase('Specification value')}} </label>
        <input type="text" name="value" id="value" class="form-control ol-form-control" placeholder="{{get_phrase('Enter specification value')}}" required>
    </div>
    <div class="mb-3">
        <button type="submit" class="btn ol-btn-primary fs-14px"> {{get_phrase('Save')}} </button>
    </div>
</form>

@elseif($page == 'sub_edit')
<form action="{{route('admin.update.listing.sub.specification',['prefix'=>$user_prefix, 'id'=>$id, 'specification_id'=>$specification_id, 'parent' => $parent])}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="title" class="form-label ol-form-label"> {{get_phrase('Specification title')}} </label>
        <input type="text" name="title" id="title" class="form-control ol-form-control" value="{{$specification->title}}" placeholder="{{get_phrase('Enter specification title')}}" required>
    </div>
    <div class="mb-3">
        <label for="value" class="form-label ol-form-label"> {{get_phrase('Specification value')}} </label>
        <input type="text" name="value" id="value" value="{{$specification->value}}" class="form-control ol-form-control" placeholder="{{get_phrase('Enter specification value')}}" required>
    </div>
    <div class="mb-3">
        <button type="submit" class="btn ol-btn-primary fs-14px"> {{get_phrase('Update')}} </button>
    </div>
</form>

@endif