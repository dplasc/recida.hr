@extends('layouts.admin')
@section('title', ucwords($type).' '.get_phrase('Info'))
@section('admin_layout')

<div class="ol-card radius-8px">
    <div class="ol-card-body my-2 py-20px px-20px">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
            <h4 class="title fs-16px">
                <i class="fi-rr-settings-sliders me-2"></i>
                {{ ucwords($type).' '.get_phrase('Create') }}
            </h4>
        </div>
    </div>
</div>

<div class="ol-card mt-3">
    <div class="ol-card-body p-3">
        <form action="{{route('admin.create.user',['type'=>$type])}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-sm-6 mb-3">
                    <label for="name" class="form-label ol-form-label"> {{get_phrase('User Full Name *')}} </label>
                    <input type="text" class="form-control ol-form-control" name="name" id="name" placeholder="{{get_phrase('Enter name')}}" value="{{old('name')}}" required>
                </div>
                <div class="col-sm-6 mb-3">
                    <label for="email" class="form-label ol-form-label"> {{get_phrase('Email Address *')}} </label>
                    <input type="email" class="form-control ol-form-control" name="email" id="email" placeholder="{{get_phrase('Enter email')}}" value="{{old('email')}}" required>
                </div>
                <div class="col-sm-6 mb-3">
                    <label for="phone" class="form-label ol-form-label"> {{get_phrase('Phone Number *')}} </label>
                    <input type="text" class="form-control ol-form-control" name="phone" id="phone" placeholder="{{get_phrase('Enter phone')}}" value="{{old('phone')}}" required>
                </div>
                <div class="col-sm-6 mb-3">
                    <label for="gender" class="form-label ol-form-label"> {{get_phrase('Gender *')}} </label>
                    <select name="gender" id="gender" class="form-control ol-select2 select2-hidden-accessible ol-form-control" required data-minimum-results-for-search="Infinity">
                        <option value=""> {{get_phrase('Select Gender')}} </option>
                        <option value="male"> {{get_phrase('Male')}} </option>
                        <option value="male"> {{get_phrase('Female')}} </option>
                    </select>
                </div>
                <div class="col-sm-6 mb-3">
                    <label for="country" class="form-label ol-form-label"> {{get_phrase('Country *')}} </label>
                    <select name="country" id="country" class="form-control ol-select2 ol-form-control">
                        <option value=""> {{get_phrase('Select Country')}} </option>
                        @foreach (App\Models\Country::get() as $country)
                            <option value="{{$country->id}}"> {{$country->name}} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-6 mb-3">
                    <label for="facebook" class="form-label ol-form-label"> {{get_phrase('Facebook link')}} </label>
                    <input type="text" class="form-control ol-form-control" name="facebook" id="facebook" placeholder="{{get_phrase('Enter facebook link')}}" value="{{old('facebook')}}">
                </div>
                <div class="col-sm-6 mb-3">
                    <label for="city" class="form-label ol-form-label"> {{get_phrase('City *')}} </label>
                    <select name="city" id="city" class="form-control ol-select2 ol-form-control" data-minimum-results-for-search="Infinity">
                        <option value=""> {{get_phrase('Select City')}} </option>
                        
                    </select>
              </div>
        
        <div class="col-sm-6 mb-3">
            <label for="linkedin" class="form-label ol-form-label"> 
                <i class="fab fa-tiktok me-2"></i> {{get_phrase('TikTok link')}} 
            </label>
            <input type="text" class="form-control ol-form-control" name="linkedin" id="linkedin" placeholder="https://www.tiktok.com/@..." value="{{old('linkedin')}}">
        </div>

        <div class="col-sm-6 mb-3">
            <label for="image" class="form-label ol-form-label"> {{get_phrase('User Image')}} </label>
            <input type="file" class="form-control ol-form-control" name="image" id="image">
        </div>

        <div class="col-sm-6 mb-3">
            <label for="twitter" class="form-label ol-form-label"> 
                <i class="fab fa-instagram me-2"></i> {{get_phrase('Instagram link')}} 
            </label>
            <input type="text" class="form-control ol-form-control" name="twitter" id="twitter" placeholder="https://www.instagram.com/..." value="{{old('twitter')}}">
        </div>
        
        <div class="col-sm-6 mb-3">
            <label for="password" class="form-label ol-form-label"> {{get_phrase('Password *')}} </label>
            <input type="password" class="form-control ol-form-control" name="password" id="password" placeholder="{{get_phrase('Enter password')}}" value="{{old('password')}}">
        </div>
        <div class="col-sm-6 mb-3">
            <label for="confirm_password" class="form-label ol-form-label"> {{get_phrase('Confirm Password *')}} </label>
            <input type="password" class="form-control ol-form-control" name="confirm_password" id="confirm_password" placeholder="{{get_phrase('Confirm password')}}" value="{{old('confirm_password')}}">
        </div>
    </div>
            <button type="submit" class="btn ol-btn-primary fs-14px px-4"> {{get_phrase('Create')}} </button>
        </form>
    </div>
</div>
<script>
    "use strict";
    $(document).ready(function() {
    $("#country").on('change', function() {
        var country = $("#country").val();
        var url = "{{ route('admin.country.city', ['id' => ':id']) }}";
        url = url.replace(':id', country);
        $.ajax({
            url: url,
            method: 'GET',
            success: function(result) {
                var cityDropdown = $("#city");
                cityDropdown.html('<option value="">{{ get_phrase("City") }}</option>');
                $.each(result, function(index, city) {
                    cityDropdown.append('<option value="' + city.id + '">' + city.name + '</option>');
                });
            },
        });
    });
});

</script>    


@endsection

