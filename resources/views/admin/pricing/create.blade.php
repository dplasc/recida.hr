<!-- FontAwesome Icon Picker CSS -->
<link rel="stylesheet" href="{{asset('assets/backend/iconpicker/fontawesome-iconpicker.min.css')}}">

<style>
    .iconpicker-popover {
        visibility: visible;
        opacity: 1 !important;
    }
</style>

<form action="{{route('admin.store-package')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-sm-6 mb-3">
            <label for="name" class="form-label ol-form-label"> {{get_phrase('Package name')}}* </label>
            <input type="text" class="form-control ol-form-control" name="name" id="name" placeholder="{{get_phrase('Enter package name')}}" required>
        </div>
        <div class="col-sm-6 mb-3">
            <label for="icon" class="form-label ol-form-label"> {{get_phrase('Amenities icon')}}* </label>
            <input class="form-control ol-form-control icp icp-auto" name="icon" placeholder="{{get_phrase('Pick an Icon')}}" type="text" required>
        </div>
        <div class="col-sm-6 mb-3">
            <label for="sub_title" class="form-label ol-form-label"> {{get_phrase('Package sub title')}}* </label>
            <input type="text" class="form-control ol-form-control" name="sub_title" id="sub_title" placeholder="{{get_phrase('Enter sub title')}}" required>
        </div>
        <div class="col-sm-6 mb-3">
            <label for="price" class="form-label ol-form-label"> {{get_phrase('Package Price')}}* </label>
            <input type="number" class="form-control ol-form-control" name="price" id="price" placeholder="{{get_phrase('Enter price')}}" required>
        </div>
        <div class="col-sm-3 mb-3">
            <label for="period" class="form-label ol-form-label"> {{get_phrase('Package Period')}} </label>
            <select name="period" id="period" class="form-control ol-form-control ol-select2">
                <option value="monthly"> {{get_phrase('Monthly')}} </option>
                <option value="semiannually"> {{get_phrase('Semi Annually')}} </option>
                <option value="annually"> {{get_phrase('Annually')}} </option>
            </select>
        </div>
        <div class="col-sm-3 mb-3">
            <label for="listing" class="form-label ol-form-label"> {{get_phrase('Listing Number')}}* </label>
            <input type="number" class="form-control ol-form-control" name="listing" id="listing" placeholder="{{get_phrase('Enter listing number')}}" required>
        </div>
        <div class="col-sm-3 mb-3">
            <label for="category" class="form-label ol-form-label"> {{get_phrase('Category Number')}}* </label>
            <input type="number" class="form-control ol-form-control" name="category" id="category" placeholder="{{get_phrase('Enter category number')}}" required>
        </div>
        <div class="col-sm-3 mb-3">
            <label for="feature" class="form-label ol-form-label"> {{get_phrase('Featured Listings')}} </label>
            <select name="feature" id="feature" class="form-control ol-form-control ol-select2">
                <option value="unavailable"> {{get_phrase('Unavailable')}} </option>
                <option value="available"> {{get_phrase('Available')}} </option>
            </select>
        </div>
        <div class="col-sm-3 mb-3">
            <label for="contact" class="form-label ol-form-label"> {{get_phrase('Contact Form')}} </label>
            <select name="contact" id="contact" class="form-control ol-form-control ol-select2">
                <option value="unavailable"> {{get_phrase('Unavailable')}} </option>
                <option value="available"> {{get_phrase('Available')}} </option>
            </select>
        </div>
        <div class="col-sm-3 mb-3">
            <label for="video" class="form-label ol-form-label"> {{get_phrase('Listings Video')}} </label>
            <select name="video" id="video" class="form-control ol-form-control ol-select2">
                <option value="unavailable"> {{get_phrase('Unavailable')}} </option>
                <option value="available"> {{get_phrase('Available')}} </option>
            </select>
        </div>
        <div class="col-sm-3 mb-3">
            <label for="choice" class="form-label ol-form-label"> {{get_phrase('Best Choice')}} </label>
            <select name="choice" id="choice" class="form-control ol-form-control ol-select2">
                <option value="0"> {{get_phrase('No')}} </option>
                <option value="1"> {{get_phrase('Yes')}} </option>
            </select>
        </div>
        <div class="col-sm-3 mb-3">
            <label for="users" class="form-label ol-form-label"> {{ get_phrase('Specific Users') }} </label>
            <select name="users[]" id="users" class="form-control ol-form-control ol-select2" multiple>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            <small class="text-muted"> {{ get_phrase('You can select multiple users') }} </small>
        </div>

        <div class="col-sm-12">
            <button type="submit" class="btn ol-btn-primary px-3"> {{get_phrase('Create')}} </button>
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