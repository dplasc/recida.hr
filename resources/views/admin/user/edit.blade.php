@extends('layouts.admin')
@section('title', ucwords($type).' '.get_phrase('Info Update'))
@section('admin_layout')

@php
    $address = json_decode($user->address);
    $country_id = $address->country ?? "";
    $city_id = $address->city ?? '';
 
@endphp

<div class="ol-card">
    <div class="ol-card-body p-3 py-4 d-flex align-items-center justify-content-between">
        <h3 class="title fs-16px d-flex"> <i class="fi-rr-settings-sliders me-2"></i> {{ucwords($type).' '.get_phrase('Update')}} </h3>
    </div>
</div>

<div class="ol-card mt-3">
    <div class="ol-card-body p-3">
        <form action="{{route('admin.update.user',['type'=>$type, 'id'=>$user->id])}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-sm-6 mb-3">
                    <label for="name" class="form-label ol-form-label"> {{get_phrase('User Full Name *')}} </label>
                    <input type="text" class="form-control ol-form-control" name="name" id="name" placeholder="{{get_phrase('Enter name')}}" value="{{$user->name}}" required>
                </div>
                <div class="col-sm-6 mb-3">
                    <label for="email" class="form-label ol-form-label"> {{get_phrase('Email Address *')}} </label>
                    <input type="email" class="form-control ol-form-control" name="email" id="email" placeholder="{{get_phrase('Enter email')}}" value="{{$user->email}}" readonly required>
                </div>
                <div class="col-sm-6 mb-3">
                    <label for="phone" class="form-label ol-form-label"> {{get_phrase('Phone Number *')}} </label>
                    <input type="text" class="form-control ol-form-control" name="phone" id="phone" placeholder="{{get_phrase('Enter phone')}}" value="{{$user->phone}}" required>
                </div>
                <div class="col-sm-6 mb-3">
                    <label for="gender" class="form-label ol-form-label"> {{get_phrase('Gender *')}} </label>
                    <select name="gender" id="gender" class="form-control ol-select2 select2-hidden-accessible ol-form-control" required data-minimum-results-for-search="Infinity">
                        <option value=""> {{get_phrase('Select Gender')}} </option>
                        <option value="male" {{($user->gender == 'male')?'selected':''}}> {{get_phrase('Male')}} </option>
                        <option value="female" {{($user->gender == 'female')?'selected':''}}> {{get_phrase('Female')}} </option>
                    </select>
                </div>
                <div class="col-sm-6 mb-3">
                    <label for="country" class="form-label ol-form-label"> {{get_phrase('Country *')}} </label>
                    <select name="country" id="country" class="form-control ol-select2 ol-form-control">
                        <option value=""> {{get_phrase('Select Country')}} </option>
                        @foreach (App\Models\Country::get() as $country)
                            <option value="{{ $country->id }}" {{ ($country_id == $country->id) ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach
            
                    </select>
                </div>
                <div class="col-sm-6 mb-3">
                    <label for="facebook" class="form-label ol-form-label"> {{get_phrase('Facebook link')}} </label>
                    <input type="text" class="form-control ol-form-control" name="facebook" id="facebook" placeholder="{{get_phrase('Enter facebook link')}}" value="{{$user->facebook}}">
                </div>
                <div class="col-sm-6 mb-3">
                    <label for="city" class="form-label ol-form-label"> {{get_phrase('City *')}} </label>
                    <select name="city" id="city" class="form-control ol-select2 ol-form-control" data-minimum-results-for-search="Infinity">
                        <option value=""> {{get_phrase('Select City')}} </option>
                        @if(isset($address->city) && $city = App\Models\City::find($address->city))
                        <option value="{{ $address->city }}" selected>{{ $city->name }}</option>
                       @endif
                    </select>
                </div>
                <div class="col-sm-6 mb-3">
    <label for="linkedin" class="form-label ol-form-label">
        <i class="fab fa-tiktok"></i> TikTok link
    </label>
    <input type="text" class="form-control ol-form-control" name="linkedin" id="linkedin" placeholder="https://www.tiktok.com/@username" value="{{$user->linkedin}}">
</div>
                <div class="col-sm-6 mb-3">
                    <label for="image" class="form-label ol-form-label"> {{get_phrase('User Image')}} </label>
                    <input type="file" class="form-control ol-form-control" name="image" id="image">
                </div>
                <div class="col-sm-6 mb-3">
    <label for="twitter" class="form-label ol-form-label">
        <i class="fab fa-instagram"></i> Instagram link
    </label>
    <input type="text" class="form-control ol-form-control" name="twitter" id="twitter" placeholder="https://www.instagram.com/username" value="{{$user->twitter}}">
</div>

            </div>
            <button type="submit" class="btn ol-btn-primary fs-14px px-4"> {{get_phrase('Update')}} </button>
        </form>
    </div>
</div>

@endsection
@push('js')
<script>
    "use strict";
    $("#country").on('change', function(){
        var country = $("#country").val();
        var url = "{{route('admin.country.city',['id'=>':id'])}}";
        url = url.replace(':id', country);
        $.ajax({
            url: url,
            success: function(result){
                var cityDropdown = $("#city");
                cityDropdown.html($('<option>', {
                        value: '',
                        text: "{{get_phrase('Select City')}}"
                    }));
                $.each(result, function(index, city) {
                    cityDropdown.append($('<option>', {
                        value: city.id,
                        text: city.name
                    }));
                });
            }
        })
    })
</script>    
@endpush