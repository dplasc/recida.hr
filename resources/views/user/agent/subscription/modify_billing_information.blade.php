@extends('layouts.frontend')
@push('title', get_phrase('Subscription Renew'))
@push('meta')@endpush
@section('frontend_layout')
    @include('user.agent.subscription.style')
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
                            <h1 class="ca-title-18px">{{ get_phrase('Agent Subscription') }}</h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb cap-breadcrumb">
                                    <li class="breadcrumb-item cap-breadcrumb-item"><a href="{{ route('home') }}">{{ get_phrase('Home') }}</a></li>
                                    <li class="breadcrumb-item cap-breadcrumb-item active" aria-current="page">{{ get_phrase('subscription') }}</li>
                                </ol>
                            </nav>
                        </div>
                        <button class="btn ca-menu-btn-primary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#user-sidebar-offcanvas" aria-controls="user-sidebar-offcanvas">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 5.25H3C2.59 5.25 2.25 4.91 2.25 4.5C2.25 4.09 2.59 3.75 3 3.75H21C21.41 3.75 21.75 4.09 21.75 4.5C21.75 4.91 21.41 5.25 21 5.25Z" fill="#242D47" />
                                <path d="M21 10.25H3C2.59 10.25 2.25 9.91 2.25 9.5C2.25 9.09 2.59 8.75 3 8.75H21C21.41 8.75 21.75 9.09 21.75 9.5C21.75 9.91 21.41 10.25 21 10.25Z" fill="#242D47" />
                                <path d="M21 15.25H3C2.59 15.25 2.25 14.91 2.25 14.5C2.25 14.09 2.59 13.75 3 13.75H21C21.41 13.75 21.75 14.09 21.75 14.5C21.75 14.91 21.41 15.25 21 15.25Z" fill="#242D47" />
                                <path d="M21 20.25H3C2.59 20.25 2.25 19.91 2.25 19.5C2.25 19.09 2.59 18.75 3 18.75H21C21.41 18.75 21.75 19.09 21.75 19.5C21.75 19.91 21.41 20.25 21 20.25Z" fill="#242D47" />
                            </svg>
                        </button>
                    </div>
                    <div class="dl_column_content d-flex flex-column rg-30">
                        <!-- Billing Information -->
                        <div class="dl_column_item pt-22 px-30 pb-30 boxShadow-06 bg-white">
                            <!-- Title -->
                            <div class="tableTitle-2 pb-30">
                                <h4 class="fz-17-sb-black pb-8">{{ get_phrase('Billing Information') }}</h4>
                                <p class="fz-15-r-gray">
                                    {{ get_phrase('Please enter accurate billing information. This will be used to issue official invoices and maintain your payment history.') }}
                                </p>
                            </div>
                            <!-- Form -->
                            <form id="update_form" action="{{ route('updateUserInfo') }}" method="post">
                                @csrf
                                <div class="dl_column_form d-flex flex-column rg-22">
                                    <!-- Customer Name -->
                                    <div class="row justify-content-between align-items-center">
                                        <label for="inputCustomerName" class="col-sm-3 col-eForm-label">{{ get_phrase('Customer name') }}</label>
                                        <div class="col-sm-9 col-md-9 col-lg-9">
                                            <input type="text" placeholder="Your name" class="form-control eForm-control2" id="name" name="name" value="{{ $user_details->name }}" />
                                        </div>
                                    </div>
                                    <!-- Billing Email -->
                                    <div class="row justify-content-between align-items-center">
                                        <label for="inputBillingEmail" class="col-sm-3 col-eForm-label">{{ get_phrase('Billing Email') }}</label>
                                        <div class="col-sm-9 col-md-9 col-lg-9">
                                            <input type="email" placeholder="example@info.com" class="form-control eForm-control2" id="inputEmail" readonly value="{{ $user_details->email }}" />
                                        </div>
                                    </div>
                                    @php
                                        $address = json_decode($user_details->address);
                                        
                                    @endphp
                                    <!-- Billing Address -->
                                    <div class="row justify-content-between align-items-center">
                                        <label for="inputBillingAddress" class="col-sm-3 col-eForm-label">{{ get_phrase('Address') }}</label>
                                        <div class="col-sm-9 col-md-9 col-lg-9">
                                            <input type="text" placeholder="New york, 5th Avenue" class="form-control eForm-control2" id="addressline" name="addressline" value="{{ $user_details->addressline ?? "" }}" />
                                        </div>
                                    </div>
                                    <!-- Country -->
                                    <div class="row justify-content-between align-items-center">
                                        <label for="countries" class="col-sm-3 col-eForm-label">{{ get_phrase('Country') }}</label>
                                        <div class="col-sm-9 col-md-9 col-lg-9">
                                            <select id="country1" name="country_code" class="form-select eForm-select eChoice-multiple-without-remove" data-placeholder="Type to search...">
                                                <option value="NN">
                                                    {{ get_phrase('Select a Country') }}
                                                </option>
                                                @foreach (App\Models\Country::get() as $country)
                                                <option value="{{ $country->id }}" {{ isset($address->country) && $address->country == $country->id ? 'selected' : '' }}>
                                                    {{ get_phrase($country->name) }}
                                                </option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- city -->
                                    <div class="row justify-content-between align-items-center">
                                        <label for="countries" class="col-sm-3 col-eForm-label">{{ get_phrase('City') }}</label>
                                        <div class="col-sm-9 col-md-9 col-lg-9">
                                            <select id="city" name="city" class="form-select eForm-select eChoice-multiple-without-remove" data-placeholder="Type to search...">
                                                @if(isset($address->city) && $city = App\Models\City::find($address->city))
                                                        <option value="{{ $address->city }}">{{ $city->name }}</option>
                                                    @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- Button -->
                                <div class="dl_form_btn d-flex justify-content-end g-20 pt-40">
                                    <button type="submit" class=" cap2-btn-primary cap-btn-sm gap-1 mt-3">{{ get_phrase('Save Changes') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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

@endsection
