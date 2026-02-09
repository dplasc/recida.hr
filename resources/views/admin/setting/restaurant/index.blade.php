@php
    $RestaurantBanner = json_decode(get_homepage_settings('RestaurantBanner') ?? '{}');
    $RestaurantExclusive = json_decode(get_homepage_settings('RestaurantExclusive') ?? '{}');
    $RestaurantDiscount = json_decode(get_homepage_settings('RestaurantDiscount') ?? '{}');
@endphp

<h4 class="title mt-4">{{ get_phrase('Restaurant Frontend Settings') }}</h4>
<div class="row">
    <div class="col-lg-6">
        <form class="mt-5" action="{{ route('admin.homepage-setting-update') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="RestaurantBanner">
            <div class="fpb-7 mb-3">
                <label for="restaurant_banner_title" class="form-label ol-form-label"> {{ get_phrase('Restaurant Banner Title') }} </label>
                <input type="text" class="form-control ol-form-control" name="restaurant_banner_title" placeholder="Enter title" value="{{ $RestaurantBanner->title ?? '' }}">
            </div>
            <div class="fpb-7 mb-3">
                <label for="restaurant_banner_description" class="form-label ol-form-label"> {{ get_phrase('Hotel Banner Description') }} </label>
                <textarea name="restaurant_banner_description" class="form-control ol-form-control">{{ $RestaurantBanner->description ?? '' }}</textarea>
            </div>
            <div class="fpb-7 mb-3">
                <label for="restaurant_banner1" class="form-label ol-form-label"> {{ get_phrase('Restaurant Banner') }} </label>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="wrapper-image-preview justify-content-center">
                            <div class="box">
                                <div class="upload-options">
                                    @if(!empty($RestaurantBanner->image1))
                                        <img src="{{ asset('uploads/homepage/restaurant/'. $RestaurantBanner->image1) }}" alt="" class="bg-dark_2 radious-15px px-2 py-2 restaurant-preview1 h-200 cover w-100">
                                    @else
                                    <img src="" alt="" class="bg-dark_2 radious-15px px-2 py-2 restaurant-preview1 h-200 cover w-100">
                                    @endif
                                    <label for="restaurant_banner1" class="btn ol-card p-4-text">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M18 6C17.39 6 16.83 5.65 16.55 5.11L15.83 3.66C15.37 2.75 14.17 2 13.15 2H10.86C9.83005 2 8.63005 2.75 8.17005 3.66L7.45005 5.11C7.17004 5.65 6.61005 6 6.00005 6C3.83005 6 2.11005 7.83 2.25005 9.99L2.77005 18.25C2.89005 20.31 4.00005 22 6.76005 22H17.24C20 22 21.1 20.31 21.23 18.25L21.75 9.99C21.89 7.83 20.17 6 18 6ZM10.5 7.25H13.5C13.91 7.25 14.25 7.59 14.25 8C14.25 8.41 13.91 8.75 13.5 8.75H10.5C10.09 8.75 9.75005 8.41 9.75005 8C9.75005 7.59 10.09 7.25 10.5 7.25ZM12 18.12C10.14 18.12 8.62005 16.61 8.62005 14.74C8.62005 12.87 10.13 11.36 12 11.36C13.87 11.36 15.38 12.87 15.38 14.74C15.38 16.61 13.86 18.12 12 18.12Z"
                                                fill="#797c8b" />
                                        </svg>
                                        {{ get_phrase('Upload  Image') }}
                                    </label>
                                    <input id="restaurant_banner1" type="file" class="image-upload d-none" name="restaurant_banner1" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="wrapper-image-preview justify-content-center">
                            <div class="box">
                                <div class="upload-options">
                                    @if(!empty($RestaurantBanner->image2))
                                        <img src="{{ asset('uploads/homepage/restaurant/'. $RestaurantBanner->image2) }}" alt="" class="bg-dark_2 radious-15px px-2 py-2 restaurant-preview2 h-200 cover w-100">
                                    @else
                                    <img src="" alt="" class="bg-dark_2 radious-15px px-2 py-2 restaurant-preview2 h-200 cover w-100">
                                    @endif
                                    <label for="restaurant_banner2" class="btn ol-card p-4-text">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M18 6C17.39 6 16.83 5.65 16.55 5.11L15.83 3.66C15.37 2.75 14.17 2 13.15 2H10.86C9.83005 2 8.63005 2.75 8.17005 3.66L7.45005 5.11C7.17004 5.65 6.61005 6 6.00005 6C3.83005 6 2.11005 7.83 2.25005 9.99L2.77005 18.25C2.89005 20.31 4.00005 22 6.76005 22H17.24C20 22 21.1 20.31 21.23 18.25L21.75 9.99C21.89 7.83 20.17 6 18 6ZM10.5 7.25H13.5C13.91 7.25 14.25 7.59 14.25 8C14.25 8.41 13.91 8.75 13.5 8.75H10.5C10.09 8.75 9.75005 8.41 9.75005 8C9.75005 7.59 10.09 7.25 10.5 7.25ZM12 18.12C10.14 18.12 8.62005 16.61 8.62005 14.74C8.62005 12.87 10.13 11.36 12 11.36C13.87 11.36 15.38 12.87 15.38 14.74C15.38 16.61 13.86 18.12 12 18.12Z"
                                                fill="#797c8b" />
                                        </svg>
                                        {{ get_phrase('Upload  Image') }}
                                    </label>
                                    <input id="restaurant_banner2" type="file" class="image-upload d-none" name="restaurant_banner2" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="fpb-7 mb-3">
                <button type="submit" class="btn ol-btn-primary ">{{ get_phrase('Update Settings') }}</button>
            </div>
        </form>
    </div>
    <div class="col-lg-6">
        <form class="mt-5" action="{{ route('admin.homepage-setting-update') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="RestaurantExclusive">
            <div class="fpb-7 mb-3">
                <label for="restaurant_exclusive_title" class="form-label ol-form-label"> {{ get_phrase('Exclusive Deals') }} </label>
                <input type="text" class="form-control ol-form-control" name="restaurant_exclusive_title" placeholder="Enter title" value="{{ $RestaurantExclusive->title ?? '' }}">
            </div>
            <div class="fpb-7 mb-3">
                <label for="restaurant_deals_title" class="form-label ol-form-label"> {{ get_phrase('Exclusive Deals Discount') }} </label>
                <input type="text" class="form-control ol-form-control" name="restaurant_deals_title" placeholder="Just For You -70%" value="{{ $RestaurantExclusive->description ?? '' }}">
            </div>
            <div class="fpb-7 mb-3">
                <label for="restaurant_exclusive_banner" class="form-label ol-form-label"> {{ get_phrase('Exclusive Banner') }} </label>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="wrapper-image-preview justify-content-center">
                            <div class="box">
                                <div class="upload-options">
                                    @if(!empty($RestaurantExclusive->image))
                                        <img src="{{ asset('uploads/homepage/restaurant/'. $RestaurantExclusive->image) }}" alt="" class="bg-dark_2 radious-15px px-2 py-2 restaurant_exclusive-preview h-200 cover w-100">
                                    @else
                                    <img src="" alt="" class="bg-dark_2 radious-15px px-2 py-2 restaurant_exclusive-preview h-200 cover w-100">
                                    @endif
                                    <label for="restaurant_exclusive_banner" class="btn ol-card p-4-text">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M18 6C17.39 6 16.83 5.65 16.55 5.11L15.83 3.66C15.37 2.75 14.17 2 13.15 2H10.86C9.83005 2 8.63005 2.75 8.17005 3.66L7.45005 5.11C7.17004 5.65 6.61005 6 6.00005 6C3.83005 6 2.11005 7.83 2.25005 9.99L2.77005 18.25C2.89005 20.31 4.00005 22 6.76005 22H17.24C20 22 21.1 20.31 21.23 18.25L21.75 9.99C21.89 7.83 20.17 6 18 6ZM10.5 7.25H13.5C13.91 7.25 14.25 7.59 14.25 8C14.25 8.41 13.91 8.75 13.5 8.75H10.5C10.09 8.75 9.75005 8.41 9.75005 8C9.75005 7.59 10.09 7.25 10.5 7.25ZM12 18.12C10.14 18.12 8.62005 16.61 8.62005 14.74C8.62005 12.87 10.13 11.36 12 11.36C13.87 11.36 15.38 12.87 15.38 14.74C15.38 16.61 13.86 18.12 12 18.12Z"
                                                fill="#797c8b" />
                                        </svg>
                                        {{ get_phrase('Upload  Image') }}
                                    </label>
                                    <input id="restaurant_exclusive_banner" type="file" class="image-upload d-none" name="restaurant_exclusive_banner" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="fpb-7 mb-3">
                <button type="submit" class="btn ol-btn-primary ">{{ get_phrase('Update Settings') }}</button>
            </div>
        </form>
    </div>
    <div class="col-lg-6">
        <form class="mt-5" action="{{ route('admin.homepage-setting-update') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="RestaurantDiscount">
            <div class="fpb-7 mb-3">
                <label for="restaurant_discount_title" class="form-label ol-form-label"> {{ get_phrase('Size the moment') }} </label>
                <input type="text" class="form-control ol-form-control" name="restaurant_discount_title" placeholder="Get up to" value="{{ $RestaurantDiscount->title ?? '' }}">
            </div>
            <div class="fpb-7 mb-3">
                <label for="restaurant_discount_description" class="form-label ol-form-label"> {{ get_phrase('Size  Discount') }} </label>
                <input type="text" class="form-control ol-form-control" name="restaurant_discount_description" placeholder="Just For You -20%" value="{{ $RestaurantDiscount->description ?? '' }}">
            </div>
            <div class="fpb-7 mb-3">
                <label for="restaurant_discount_banner" class="form-label ol-form-label"> {{ get_phrase('Discount Banner') }} </label>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="wrapper-image-preview justify-content-center">
                            <div class="box">
                                <div class="upload-options">
                                    @if(!empty($RestaurantDiscount->image))
                                        <img src="{{ asset('uploads/homepage/restaurant/'. $RestaurantDiscount->image) }}" alt="" class="bg-dark_2 radious-15px px-2 py-2 restaurant_discount_preview h-200 cover w-100">
                                    @else
                                    <img src="" alt="" class="bg-dark_2 radious-15px px-2 py-2 restaurant_discount_preview h-200 cover w-100">
                                    @endif
                                    <label for="restaurant_discount_banner" class="btn ol-card p-4-text">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M18 6C17.39 6 16.83 5.65 16.55 5.11L15.83 3.66C15.37 2.75 14.17 2 13.15 2H10.86C9.83005 2 8.63005 2.75 8.17005 3.66L7.45005 5.11C7.17004 5.65 6.61005 6 6.00005 6C3.83005 6 2.11005 7.83 2.25005 9.99L2.77005 18.25C2.89005 20.31 4.00005 22 6.76005 22H17.24C20 22 21.1 20.31 21.23 18.25L21.75 9.99C21.89 7.83 20.17 6 18 6ZM10.5 7.25H13.5C13.91 7.25 14.25 7.59 14.25 8C14.25 8.41 13.91 8.75 13.5 8.75H10.5C10.09 8.75 9.75005 8.41 9.75005 8C9.75005 7.59 10.09 7.25 10.5 7.25ZM12 18.12C10.14 18.12 8.62005 16.61 8.62005 14.74C8.62005 12.87 10.13 11.36 12 11.36C13.87 11.36 15.38 12.87 15.38 14.74C15.38 16.61 13.86 18.12 12 18.12Z"
                                                fill="#797c8b" />
                                        </svg>
                                        {{ get_phrase('Upload  Image') }}
                                    </label>
                                    <input id="restaurant_discount_banner" type="file" class="image-upload d-none" name="restaurant_discount_banner" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="fpb-7 mb-3">
                <button type="submit" class="btn ol-btn-primary ">{{ get_phrase('Update Settings') }}</button>
            </div>
        </form>
    </div>

</div>



<script>
    "use strict";
    // Event listeners for 
    document.getElementById('restaurant_banner1').addEventListener('change', function(event) {
        handleImagePreview(event.target, '.restaurant-preview1');
    });
    document.getElementById('restaurant_banner2').addEventListener('change', function(event) {
        handleImagePreview(event.target, '.restaurant-preview2');
    });
    document.getElementById('restaurant_exclusive_banner').addEventListener('change', function(event) {
        handleImagePreview(event.target, '.restaurant_exclusive-preview');
    });
    document.getElementById('restaurant_discount_banner').addEventListener('change', function(event) {
        handleImagePreview(event.target, '.restaurant_discount_preview');
    });
</script>