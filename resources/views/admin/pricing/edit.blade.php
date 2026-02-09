<!-- FontAwesome Icon Picker CSS -->
<link rel="stylesheet" href="{{asset('assets/backend/iconpicker/fontawesome-iconpicker.min.css')}}">

<style>
    .iconpicker-popover {
        visibility: visible;
        opacity: 1 !important;
    }
</style>

<form action="{{route('admin.package-update',['id'=>$package->id])}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-sm-6 mb-3">
            <label for="name" class="form-label ol-form-label"> {{get_phrase('Package name')}}* </label>
            <input type="text" class="form-control ol-form-control" name="name" id="name" value="{{$package->name}}" required>
        </div>
        <div class="col-sm-6 mb-3">
            <label for="icon" class="form-label ol-form-label"> {{get_phrase('Amenities icon')}}* </label>
            <input class="form-control ol-form-control icp icp-auto" name="icon" value="{{$package->icon}}" type="text" required>
        </div>
        <div class="col-sm-6 mb-3">
            <label for="sub_title" class="form-label ol-form-label"> {{get_phrase('Package sub title')}}* </label>
            <input type="text" class="form-control ol-form-control" name="sub_title" id="sub_title" value="{{$package->sub_title}}" required>
        </div>
        <div class="col-sm-6 mb-3">
            <label for="price" class="form-label ol-form-label"> {{get_phrase('Package Price')}}* </label>
            <input type="number" class="form-control ol-form-control" name="price" id="price" value="{{$package->price}}" required>
        </div>
        <div class="col-sm-3 mb-3">
            <label for="period" class="form-label ol-form-label"> {{get_phrase('Package Period')}} </label>
            <select name="period" id="period" class="form-control ol-form-control">
                <option value="monthly" {{$package->period == 'monthly' ? 'selected':''}}> {{get_phrase('Monthly')}} </option>
                <option value="semiannually" {{$package->period == 'semiannually' ? 'selected':''}}> {{get_phrase('Semi Annually')}} </option>
                <option value="annually" {{$package->period == 'annually' ? 'selected':''}}> {{get_phrase('Annually')}} </option>
            </select>
        </div>
        <div class="col-sm-3 mb-3">
            <label for="listing" class="form-label ol-form-label"> {{get_phrase('Listing Number')}}* </label>
            <input type="number" class="form-control ol-form-control" name="listing" id="listing" value="{{$package->listing}}" required>
        </div>
        <div class="col-sm-3 mb-3">
            <label for="category" class="form-label ol-form-label"> {{get_phrase('Category Number')}}* </label>
            <input type="number" class="form-control ol-form-control" name="category" id="category" value="{{$package->category}}" required>
        </div>
        <div class="col-sm-3 mb-3">
            <label for="feature" class="form-label ol-form-label"> {{get_phrase('Featured Listings')}} </label>
            <select name="feature" id="feature" class="form-control ol-form-control ">
                <option value="unavailable" {{$package->feature == 'unavailable'?'selected':''}}> {{get_phrase('Unavailable')}} </option>
                <option value="available" {{$package->feature == 'available'?'selected':''}}> {{get_phrase('Available')}} </option>
            </select>
        </div>
        <div class="col-sm-3 mb-3">
            <label for="contact" class="form-label ol-form-label"> {{get_phrase('Contact Form')}} </label>
            <select name="contact" id="contact" class="form-control ol-form-control ">
                <option value="unavailable" {{$package->contact == 'unavailable'?'selected':''}}> {{get_phrase('Unavailable')}} </option>
                <option value="available" {{$package->contact == 'available'?'selected':''}}> {{get_phrase('Available')}} </option>
            </select>
        </div>
        <div class="col-sm-3 mb-3">
            <label for="video" class="form-label ol-form-label"> {{get_phrase('Listings Video')}} </label>
            <select name="video" id="video" class="form-control ol-form-control ">
                <option value="unavailable" {{$package->video == 'unavailable'?'selected':''}}> {{get_phrase('Unavailable')}} </option>
                <option value="available" {{$package->video == 'available'?'selected':''}}> {{get_phrase('Available')}} </option>
            </select>
        </div>
        <div class="col-sm-3 mb-3">
            <label for="choice" class="form-label ol-form-label"> {{get_phrase('Best Choice')}} </label>
            <select name="choice" id="choice" class="form-control ol-form-control ">
                <option value="0" {{$package->choice == 0?'selected':''}}> {{get_phrase('No')}} </option>
                <option value="1" {{$package->choice == 1?'selected':''}}> {{get_phrase('Yes')}} </option>
            </select>
        </div>
        <div class="col-sm-3 mb-3">
            <label for="users" class="form-label ol-form-label"> {{ get_phrase('Specific Users') }} </label>
            <select name="users[]" id="users" class="form-control ol-form-control ol-select2" multiple>
                @php
                    $selectedUsers = json_decode($package->specific_users, true) ?? [];
                @endphp
                @foreach($users as $user)
                    <option value="{{ $user->id }}" 
                        {{ in_array((string) $user->id, $selectedUsers) ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            <small class="text-muted"> {{ get_phrase('You can select multiple users') }} </small>
        </div>
        {{-- <div class="col-sm-3 mb-3">
            <label for="users" class="form-label ol-form-label"> {{ get_phrase('Specific Users') }} </label>
            <select name="users[]" id="users" class="form-control ol-form-control ol-select2" multiple>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            <small class="text-muted"> {{ get_phrase('You can select multiple users') }} </small>
        </div> --}}
        <div class="col-sm-12">
            <button type="submit" class="btn ol-btn-primary px-3"> {{get_phrase('Update')}} </button>
        </div>
    </div>    

</form>
<script src="{{asset('assets/backend/iconpicker/fontawesome-iconpicker.min.js')}}"></script>
<script>
    "use strict";
    $(document).ready(function() {
        $('.icp-auto').iconpicker();
        $('.ol-select2').select2({
            dropdownParent: $('#ajax-modal')
        });
    });
</script>