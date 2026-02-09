@php $user_prefix = (user('role') == 1) ? 'admin':'agent'; @endphp

@if ($action == 'add')
<form action="{{route('admin.store.listing.room',['prefix'=>$user_prefix, 'id'=>$id])}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-sm-6">
            <div class="mb-3">
                <label for="title" class="form-label ol-form-label"> {{get_phrase('Room Title')}}</label>
                <input type="text" name="title" id="title" class="form-control ol-form-control" placeholder="{{get_phrase('Enter room title')}}" required >
            </div>
            <div class="mb-3">
                <label for="person" class="form-label ol-form-label"> {{get_phrase('Number of persons')}}</label>
                <input type="number" name="person" id="person" class="form-control ol-form-control" placeholder="{{get_phrase('Enter number of person')}}" required>
            </div>
            <div class="mb-3">
                <label for="child" class="form-label ol-form-label"> {{get_phrase('Number of Child')}}</label>
                <input type="number" name="child" id="child" class="form-control ol-form-control" placeholder="{{get_phrase('Enter number of child')}}">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label ol-form-label"> {{get_phrase('Room Price')}}</label>
                <input type="number" name="price" id="price" class="form-control ol-form-control" placeholder="{{get_phrase('Enter room price')}}" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label ol-form-label"> {{get_phrase('Room Images')}}</label>
                <input type="file" name="image[]" id="image" class="form-control ol-form-control" multiple required>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="mb-3">
                <label for="feature" class="form-label ol-form-label"> {{get_phrase('Features')}}</label>
                @php
                    $features = App\Models\Amenities::where('type', 'hotel')->where('identifier', 'feature')->get();
                @endphp
                <div class="real-estate-feature">
                    @foreach ($features as $key => $feature)
                        <div class="feature-item">
                            <input class="form-check-input d-none" name="feature[]" type="checkbox" value="{{$feature->id}}" id="flexCheck{{$key}}">
                        <label class="form-check-label w-100" onclick="hotel_feature_checked('{{$key}}')" for="flexCheck{{$key}}">
                            <div class="card mb-3 team-checkbox me-2">
                                <div class="col-md-12 team-body feature-body">
                                    <div class="card-body py-2 px-2 ms-1">
                                        {{-- <i class="{{$feature->icon}}"></i> --}}
                                        <span> {{$feature->name}} </span>
                                    </div>
                                    <div class="checked d-none" id="hotel-feature-checked{{$key}}">
                                        <i class="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                        </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn ol-btn-primary fs-14"> {{get_phrase('Create')}} </button>      
</form>    
@elseif ($action == 'edit')
<form action="{{route('admin.update.listing.room',['prefix'=>$user_prefix,'id'=>$id,'room_id'=>$room->id])}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-sm-6">
            <div class="mb-3">
                <label for="title" class="form-label ol-form-label"> {{get_phrase('Room Title')}}</label>
                <input type="text" name="title" id="title" class="form-control ol-form-control" value="{{$room->title}}" required>
            </div>
            <div class="mb-3">
                <label for="person" class="form-label ol-form-label"> {{get_phrase('Number of persons')}}</label>
                <input type="number" name="person" id="person" class="form-control ol-form-control" value="{{$room->person}}" required>
            </div>
            <div class="mb-3">
                <label for="child" class="form-label ol-form-label"> {{get_phrase('Number of Child')}}</label>
                <input type="number" name="child" id="child" value="{{$room->child}}" class="form-control ol-form-control">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label ol-form-label"> {{get_phrase('Room Price')}}</label>
                <input type="number" name="price" id="price" class="form-control ol-form-control" value="{{$room->price}}" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label ol-form-label"> {{get_phrase('Room Images')}}</label>
                <input type="file" name="image[]" id="image" class="form-control ol-form-control" multiple>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="mb-3">
                <label for="feature" class="form-label ol-form-label"> {{get_phrase('Features')}}</label>
                @php
                    $features = App\Models\Amenities::where('type', 'hotel')->where('identifier', 'feature')->get();
                @endphp
                <div class="real-estate-feature">
                    @foreach ($features as $key => $feature)
                        <div class="feature-item">
                            <input class="form-check-input d-none" name="feature[]" type="checkbox" value="{{$feature->id}}" id="flexCheck{{$key}}" @if($room->feature && $room->feature != 'null' && in_array($feature->id, json_decode($room->feature))) checked @endif>
                        <label class="form-check-label w-100" onclick="hotel_feature_checked('{{$key}}')" for="flexCheck{{$key}}">
                            <div class="card mb-3 team-checkbox me-2">
                                <div class="col-md-12 team-body feature-body">
                                    <div class="card-body py-2 px-2 ms-1">
                                        <span> {{$feature->name}} </span>
                                    </div>
                                    <div class="checked @if($room->feature && $room->feature != 'null' && in_array($feature->id, json_decode($room->feature))) @else d-none @endif" id="hotel-feature-checked{{$key}}">
                                        <i class="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                        </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn ol-btn-primary fs-14"> {{get_phrase('Submit')}} </button>      
</form>  
@endif

<script>
    "use strict";
    function hotel_feature_checked(key) {
        var checkbox = document.getElementById('flexCheckDefau' + key);
        document.getElementById('hotel-feature-checked' + key).classList.toggle('d-none');
    }
</script>