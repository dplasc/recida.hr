@extends('layouts.frontend')
@push('title', get_phrase('Profile Update'))
@push('meta')@endpush
@section('frontend_layout')

<style>
.fz-17-sb-black {
    font-size: 1.0625rem;
    font-weight: 600;
    line-height: 1.25rem;
    color: #0b162d;
}
</style>

    <!-- Start Main Area -->
    <section class="ca-wraper-main mb-90px mt-4">
        <div class="container">
            <div class="row gx-20px">
                <div class="col-lg-4 col-xl-3">
                    @include('user.navigation')
                </div>
                <div class="col-lg-8 col-xl-9">
                    <!-- Header -->
                    <div class="d-flex align-items-start justify-content-between gap-2 mb-20px">
                        <div class="d-flex justify-content-between align-items-start gap-12px flex-column flex-lg-row w-100">
                            <h1 class="ca-title-18px">{{get_phrase('Profile update')}}</h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb cap-breadcrumb">
                                  <li class="breadcrumb-item cap-breadcrumb-item"><a href="{{route('home')}}">{{get_phrase('Home')}}</a></li>
                                  <li class="breadcrumb-item cap-breadcrumb-item active" aria-current="page">{{get_phrase('Account')}}</li>
                                </ol>
                            </nav>
                        </div>
                        <button class="btn ca-menu-btn-primary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#user-sidebar-offcanvas" aria-controls="user-sidebar-offcanvas">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 5.25H3C2.59 5.25 2.25 4.91 2.25 4.5C2.25 4.09 2.59 3.75 3 3.75H21C21.41 3.75 21.75 4.09 21.75 4.5C21.75 4.91 21.41 5.25 21 5.25Z" fill="#242D47"/>
                                <path d="M21 10.25H3C2.59 10.25 2.25 9.91 2.25 9.5C2.25 9.09 2.59 8.75 3 8.75H21C21.41 8.75 21.75 9.09 21.75 9.5C21.75 9.91 21.41 10.25 21 10.25Z" fill="#242D47"/>
                                <path d="M21 15.25H3C2.59 15.25 2.25 14.91 2.25 14.5C2.25 14.09 2.59 13.75 3 13.75H21C21.41 13.75 21.75 14.09 21.75 14.5C21.75 14.91 21.41 15.25 21 15.25Z" fill="#242D47"/>
                                <path d="M21 20.25H3C2.59 20.25 2.25 19.91 2.25 19.5C2.25 19.09 2.59 18.75 3 18.75H21C21.41 18.75 21.75 19.09 21.75 19.5C21.75 19.91 21.41 20.25 21 20.25Z" fill="#242D47"/>
                            </svg>
                        </button>
                    </div>
                    <div class="ca-content-card">
                        <form action="{{ route('customerAccountUpdate',['prefix'=>'user']) }}" enctype="multipart/form-data" method="post">
                            @csrf
                        <div class="dl_column_form d-flex flex-column rg-22">
                            <!-- Name -->
                            <div class="row justify-content-between align-items-center mb-3 mb-3">
                                <label for="name"  class="col-sm-2 cap-form-label">{{ get_phrase('Full name') }}</label>
                                <div class="col-sm-10 col-md-9 col-lg-10">
                                    <input type="text" placeholder="Your name" class="form-control cap-form-control" id="name" name="name" value="{{ $user->name }}" />
                                </div>
                            </div>
                            <!-- Email -->
                            <div class="row justify-content-between align-items-center mb-3 mb-3">
                                <label for="email" class="col-sm-2 cap-form-label">{{ get_phrase('Email') }}</label>
                                <div class="col-sm-10 col-md-9 col-lg-10">
                                    <input type="email" placeholder="example@info.com" class="form-control cap-form-control" id="email" name="email" value="{{ $user->email }}" readonly/>
                                </div>
                            </div>
                            <!-- Phone -->
                            <div class="row justify-content-between align-items-center mb-3 mb-3">
                                <label for="phone"  class="col-sm-2 cap-form-label">{{ get_phrase('Phone') }}</label>
                                <div class="col-sm-10 col-md-9 col-lg-10">
                                    <input type="text" placeholder="+88 (00) 1234 56789" class="form-control cap-form-control" id="phone" name="phone" value="{{ $user->phone }}"/>
                                </div>
                            </div>
                            <!-- Facebook -->
                            <div class="row justify-content-between align-items-center mb-3 mb-3">
                                <label for="facebook" class="col-sm-2 cap-form-label">{{ get_phrase('Facebook') }}</label>
                                <div class="col-sm-10 col-md-9 col-lg-10">
                                    <input type="text" placeholder="Write down facebook url" class="form-control cap-form-control" id="facebook" name="facebook" value="{{ $user->facebook ??"" }}"/>
                                </div>
                            </div>
                            <!-- Twitter -->
                            <div class="row justify-content-between align-items-center mb-3 mb-3">
                                <label for="twitter" class="col-sm-2 cap-form-label">{{ get_phrase('Twitter') }}</label>
                                <div class="col-sm-10 col-md-9 col-lg-10">
                                    <input type="text" placeholder="Write down twitter url" class="form-control cap-form-control" id="twitter" name="twitter" value="{{ $user->twitter ??"" }}"/>
                                </div>
                            </div>
                            <!-- Linkedin -->
                            <div class="row justify-content-between align-items-center mb-3 mb-3">
                                <label for="linkedin" class="col-sm-2 cap-form-label">{{ get_phrase('Linkedin') }}</label>
                                <div class="col-sm-10 col-md-9 col-lg-10">
                                    <input type="text" placeholder="Write down linkedin url" class="form-control cap-form-control" id="linkedin" name="linkedin" value="{{ $user->linkedin ??"" }}"/>
                                </div>
                            </div>
                            
                            <!-- Gender -->
                            <div class="row justify-content-between align-items-center mb-3 mb-3">
                                <label class="col-sm-2 cap-form-label">{{ get_phrase('Gender') }}</label>
                                <div class="col-sm-10 col-md-9 col-lg-10">
                                    <div class="dl-gender-wrap d-flex justify-content-start gap-3">
                                        <div class="gender-item">
                                            <div class="form-check">
                                                <input type="radio" name="gender" class="form-check-input dl-radio" value="male" id="male" @if($user->gender=='male') checked @endif /><label for="male" class="form-check-label">{{ get_phrase('Male') }}</label>
                                            </div>
                                        </div>
                                        <div class="gender-item">
                                            <div class="form-check">
                                                <input type="radio" name="gender" class="form-check-input dl-radio" value="female" id="female" @if($user->gender=='female') checked @endif /><label for="female" class="form-check-label">{{ get_phrase('Female') }}</label>
                                            </div>
                                        </div>
                                        <div class="gender-item">
                                            <div class="form-check">
                                                <input type="radio" name="gender" class="form-check-input dl-radio" value="other" id="other" @if($user->gender=='other') checked @endif  /><label for="other" class="form-check-label">{{ get_phrase('Other') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Bio -->
                            <input type="hidden"  name="type" value="info">
                            <div class="row justify-content-between align-items-start mb-3">
                                <label for="bio" class="col-sm-2 cap-form-label">{{ get_phrase('Bio') }}</label>
                                <div class="col-sm-10 col-md-9 col-lg-10">
                                    <textarea class="form-control cap-form-control" id="bio" name="about" placeholder="Type your keyword"> {{ $user->bio }}</textarea>
                                </div>
                            </div>
                            <!-- Profile Photo -->
                            <div class="row justify-content-between align-items-start mb-3">
                                <label class="col-sm-2 cap-form-label">{{ get_phrase('Profile Photo') }}</label>
                                <div class="col-sm-10 col-md-9 col-lg-10">
                                    <input type="hidden" class="form-control" name="old_photo" value="{{ auth()->user()->image }}"/>
                                    <input type="file" class="form-control eForm-control-file" name="photo" accept="image/*" />
                                </div>
                            </div>
                           
                        </div>
                        <!-- Button -->
                        <div class="dl_form_btn d-flex justify-content-end g-20 pt-40">
                            <button  type="submit" class="btn cap-btn-primary">{{ get_phrase('Save Changes') }}</button>
                        </div>
                        </form>
                    </div>

                    <div class="ca-content-card mt-5">
                         <!-- Address -->
                        <!-- Title -->
                        <div class="tableTitle-1">
                            <h4 class="fz-17-sb-black pb-22 mb-30 bd-b-1">{{ get_phrase('Address') }}</h4>
                        </div>
                        <!-- Form -->
                        <form action="{{ route('customerAccountUpdate',['prefix'=>'user']) }}" method="post">
                            @csrf 
                        <div class="dl_column_form d-flex flex-column rg-22">

                            <div class="row justify-content-between align-items-center mb-3">
                                <label for="country" class="col-sm-2 cap-form-label">{{ get_phrase('Country') }}</label>
                                <div class="col-sm-10 col-md-9 col-lg-10">
                                    @php
                                       $address = json_decode($user->address);
                                   @endphp
                                
                                <select name="country" id="country1" class="at-select2 cap-select2 select2-hidden-accessible" data-select2-id="select2-data-1-2ry6co" tabindex="-1" aria-hidden="true">
                                    <option value="">{{ get_phrase('Select listing country') }}</option>
                                    @foreach (App\Models\Country::get() as $country)
                                        <option value="{{ $country->id }}" {{ isset($address->country) && $address->country == $country->id ? 'selected' : '' }}>
                                            {{ get_phrase($country->name) }}
                                        </option>
                                    @endforeach
                                </select>
                                
                                </div>
                            </div>

                            <input type="hidden" name="type" value="address">
                            <!-- State -->
                            <div class="row justify-content-between align-items-center mb-3">
                                <label for="city" class="col-sm-2 cap-form-label">{{get_phrase('State')}}</label>
                                <div class="col-sm-10 col-md-9 col-lg-10">
                                    <select name="city" id="city" class="at-select2 cap-select2 select2-hidden-accessible" data-select2-id="select2-data-1-2ry6ci" tabindex="-1" aria-hidden="true">
                                        @if(isset($address->city) && $city = App\Models\City::find($address->city))
                                            <option value="{{ $address->city }}">{{ $city->name }}</option>
                                        @endif
                                    </select>

                                </div>
                            </div>
                            <!-- Address line -->
                            <div class="row justify-content-between align-items-center mb-3">
                                <label for="addressline" class="col-sm-2 cap-form-label">{{ get_phrase('Address line') }}</label>
                                <div class="col-sm-10 col-md-9 col-lg-10">
                                    <input type="text" placeholder="New york, USA" class="form-control cap-form-control" id="addressline" name="addressline" value="{{ $user->addressline ?? "" }}" />
                                </div>
                            </div>
                        </div>
                        <!-- Button -->
                        <div class="dl_form_btn d-flex justify-content-end g-20 pt-40">
                            <button type="submit" class="btn cap-btn-primary">{{ get_phrase('Save Changes') }}</button>
                        </div>
                        </form>
                    </div>

                    <div class="ca-content-card mt-5">
                        <div class="tableTitle-1">
                            <h4 class="fz-17-sb-black pb-22 mb-30 bd-b-1">{{ get_phrase('Password') }}</h4>
                        </div>
                        <form action="{{ route('customerAccountUpdate',['prefix'=>'user']) }}" method="post">
                            @csrf
                        <div class="dl_column_form d-flex flex-column rg-22">
                            <!-- Old Password -->
                            <div class="row justify-content-between align-items-center mb-3">
                                <label for="password" class="col-sm-2 cap-form-label">{{ get_phrase('Old Password') }}</label>
                                <div class="col-sm-10 col-md-9 col-lg-10">
                                    <input type="password" placeholder="********" class="form-control cap-form-control eForm-password" id="password" name="password" autocomplete="off" />
                                </div>
                            </div>
                            <input type="hidden" name="type" value="pass">
                            <!-- New Password -->
                            <div class="row justify-content-between align-items-center mb-3">
                                <label for="newpassword" class="col-sm-2 cap-form-label">{{ get_phrase('New Password') }}</label>
                                <div class="col-sm-10 col-md-9 col-lg-10">
                                    <input type="password" placeholder="********" class="form-control cap-form-control eForm-password" id="newpassword"  name="newpassword" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                        <!-- Button -->
                        <div class="dl_form_btn d-flex justify-content-end g-20 pt-40">
                            <button type="submit" class="btn cap-btn-primary">{{ get_phrase('Save Changes') }}</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('user.agent.listing.script')
    
    <script>
         "use strict";
        // depended country and state
        $("#country1").on('change', function(){
            var country = $("#country1").val();
            var url = "{{route('admin.country.city',['id'=>':id'])}}";
            url = url.replace(':id', country);
            $.ajax({
                url: url,
                success: function(result){
                    var cityDropdown = $("#city");
                    cityDropdown.html($('<option>', {
                            value: '',
                            text: "{{get_phrase('Select  City')}}"
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

@endsection