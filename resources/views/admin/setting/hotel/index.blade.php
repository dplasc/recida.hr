@php
    $HotelBanner = json_decode(get_homepage_settings('HotelBanner') ?? '{}');
    $HotelBooking = json_decode(get_homepage_settings('HotelBooking') ?? '{}');
    $HotelExclusive = json_decode(get_homepage_settings('HotelExclusive') ?? '{}');
    $HotelSize = json_decode(get_homepage_settings('HotelSize') ?? '{}');
@endphp

<h4 class="title mt-4">{{ get_phrase('Hotel Frontend Settings') }}</h4>
<div class="row">
    <div class="col-lg-6">
        <form class="mt-5" action="{{ route('admin.homepage-setting-update') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="HotelBanner">
            <div class="fpb-7 mb-3">
                <label for="hotel_banner_title" class="form-label ol-form-label"> {{ get_phrase('Hotel Banner Title') }} </label>
                <input type="text" class="form-control ol-form-control" name="hotel_banner_title" placeholder="Enter title" value="{{ $HotelBanner->title ?? '' }}">
            </div>
            <div class="fpb-7 mb-3">
                <label for="hotel_banner_description" class="form-label ol-form-label"> {{ get_phrase('Hotel Banner Description') }} </label>
                <textarea name="hotel_banner_description" class="form-control ol-form-control">{{ $HotelBanner->description ?? '' }}</textarea>
            </div>
            <div class="fpb-7 mb-3">
                <label for="hotel_video_url" class="form-label ol-form-label"> {{ get_phrase('Hotel Video Url') }} </label>
                <input type="text" class="form-control ol-form-control" name="hotel_video_url" placeholder="Enter video url" value="{{ $HotelBanner->video_url ?? '' }}">
            </div>
            <div class="fpb-7 mb-3">
                <label for="hotel_banner" class="form-label ol-form-label"> {{ get_phrase('Hotel Banner') }} </label>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="wrapper-image-preview justify-content-center">
                            <div class="box">
                                <div class="upload-options">
                                    @if(!empty($HotelBanner->image))
                                        <img src="{{ asset('uploads/homepage/hotel/'. $HotelBanner->image) }}" alt="" class="bg-dark_2 radious-15px px-2 py-2 hotel-preview h-200 cover w-100">
                                    @else
                                    <img src="" alt="" class="bg-dark_2 radious-15px px-2 py-2 hotel-preview h-200 cover w-100">
                                    @endif
                                    <label for="hotel_banner" class="btn ol-card p-4-text">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M18 6C17.39 6 16.83 5.65 16.55 5.11L15.83 3.66C15.37 2.75 14.17 2 13.15 2H10.86C9.83005 2 8.63005 2.75 8.17005 3.66L7.45005 5.11C7.17004 5.65 6.61005 6 6.00005 6C3.83005 6 2.11005 7.83 2.25005 9.99L2.77005 18.25C2.89005 20.31 4.00005 22 6.76005 22H17.24C20 22 21.1 20.31 21.23 18.25L21.75 9.99C21.89 7.83 20.17 6 18 6ZM10.5 7.25H13.5C13.91 7.25 14.25 7.59 14.25 8C14.25 8.41 13.91 8.75 13.5 8.75H10.5C10.09 8.75 9.75005 8.41 9.75005 8C9.75005 7.59 10.09 7.25 10.5 7.25ZM12 18.12C10.14 18.12 8.62005 16.61 8.62005 14.74C8.62005 12.87 10.13 11.36 12 11.36C13.87 11.36 15.38 12.87 15.38 14.74C15.38 16.61 13.86 18.12 12 18.12Z"
                                                fill="#797c8b" />
                                        </svg>
                                        {{ get_phrase('Upload  Image') }}
                                    </label>
                                    <input id="hotel_banner" type="file" class="image-upload d-none" name="hotel_banner" accept="image/*">
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
            <input type="hidden" name="type" value="HotelBooking">
            <div class="fpb-7 mb-3">
                <label for="hotel_booking_title" class="form-label ol-form-label"> {{ get_phrase('Booking Title') }} </label>
                <input type="text" class="form-control ol-form-control" name="hotel_booking_title" placeholder="Enter title" value="{{ $HotelBooking->title ?? '' }}">
            </div>
            <div class="fpb-7 mb-3">
                <label for="hotel_booking_image" class="form-label ol-form-label"> {{ get_phrase('Booking Image') }} </label>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="wrapper-image-preview justify-content-center">
                            <div class="box">
                                <div class="upload-options">
                                    @if(!empty($HotelBooking->image))
                                        <img src="{{ asset('uploads/homepage/hotel/'. $HotelBooking->image) }}" alt="" class="bg-dark_2 radious-15px px-2 py-2 hotel-booking-preview h-200 cover w-100">
                                    @else
                                    <img src="" alt="" class="bg-dark_2 radious-15px px-2 py-2 hotel-booking-preview h-200 cover w-100">
                                    @endif
                                    <label for="hotel_booking_image" class="btn ol-card p-4-text">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M18 6C17.39 6 16.83 5.65 16.55 5.11L15.83 3.66C15.37 2.75 14.17 2 13.15 2H10.86C9.83005 2 8.63005 2.75 8.17005 3.66L7.45005 5.11C7.17004 5.65 6.61005 6 6.00005 6C3.83005 6 2.11005 7.83 2.25005 9.99L2.77005 18.25C2.89005 20.31 4.00005 22 6.76005 22H17.24C20 22 21.1 20.31 21.23 18.25L21.75 9.99C21.89 7.83 20.17 6 18 6ZM10.5 7.25H13.5C13.91 7.25 14.25 7.59 14.25 8C14.25 8.41 13.91 8.75 13.5 8.75H10.5C10.09 8.75 9.75005 8.41 9.75005 8C9.75005 7.59 10.09 7.25 10.5 7.25ZM12 18.12C10.14 18.12 8.62005 16.61 8.62005 14.74C8.62005 12.87 10.13 11.36 12 11.36C13.87 11.36 15.38 12.87 15.38 14.74C15.38 16.61 13.86 18.12 12 18.12Z"
                                                fill="#797c8b" />
                                        </svg>
                                        {{ get_phrase('Upload Image') }}
                                    </label>
                                    <input id="hotel_booking_image" type="file" class="image-upload d-none" name="hotel_booking_image" accept="image/*">
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
            <input type="hidden" name="type" value="HotelExclusive">
            <div class="fpb-7 mb-3">
                <label for="hotel_exclusive_title" class="form-label ol-form-label"> {{ get_phrase('Exclusive Deals') }} </label>
                <input type="text" class="form-control ol-form-control" name="hotel_exclusive_title" placeholder="Enter title" value="{{ $HotelExclusive->title ?? '' }}">
            </div>
            <div class="fpb-7 mb-3">
                <label for="hotel_deals_title" class="form-label ol-form-label"> {{ get_phrase('Exclusive Deals Discount') }} </label>
                <input type="text" class="form-control ol-form-control" name="hotel_deals_title" placeholder="Just For You -70%" value="{{ $HotelExclusive->description ?? '' }}">
            </div>
            <div class="fpb-7 mb-3">
                <label for="exclusive_banner" class="form-label ol-form-label"> {{ get_phrase('Exclusive Banner') }} </label>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="wrapper-image-preview justify-content-center">
                            <div class="box">
                                <div class="upload-options">
                                    @if(!empty($HotelExclusive->image))
                                        <img src="{{ asset('uploads/homepage/hotel/'. $HotelExclusive->image) }}" alt="" class="bg-dark_2 radious-15px px-2 py-2 exclusive-preview h-200 cover w-100">
                                    @else
                                    <img src="" alt="" class="bg-dark_2 radious-15px px-2 py-2 exclusive-preview h-200 cover w-100">
                                    @endif
                                    <label for="exclusive_banner" class="btn ol-card p-4-text">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M18 6C17.39 6 16.83 5.65 16.55 5.11L15.83 3.66C15.37 2.75 14.17 2 13.15 2H10.86C9.83005 2 8.63005 2.75 8.17005 3.66L7.45005 5.11C7.17004 5.65 6.61005 6 6.00005 6C3.83005 6 2.11005 7.83 2.25005 9.99L2.77005 18.25C2.89005 20.31 4.00005 22 6.76005 22H17.24C20 22 21.1 20.31 21.23 18.25L21.75 9.99C21.89 7.83 20.17 6 18 6ZM10.5 7.25H13.5C13.91 7.25 14.25 7.59 14.25 8C14.25 8.41 13.91 8.75 13.5 8.75H10.5C10.09 8.75 9.75005 8.41 9.75005 8C9.75005 7.59 10.09 7.25 10.5 7.25ZM12 18.12C10.14 18.12 8.62005 16.61 8.62005 14.74C8.62005 12.87 10.13 11.36 12 11.36C13.87 11.36 15.38 12.87 15.38 14.74C15.38 16.61 13.86 18.12 12 18.12Z"
                                                fill="#797c8b" />
                                        </svg>
                                        {{ get_phrase('Upload  Image') }}
                                    </label>
                                    <input id="exclusive_banner" type="file" class="image-upload d-none" name="exclusive_banner" accept="image/*">
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
            <input type="hidden" name="type" value="HotelSize">
            <div class="fpb-7 mb-3">
                <label for="hotel_size_title" class="form-label ol-form-label"> {{ get_phrase('Size the moment') }} </label>
                <input type="text" class="form-control ol-form-control" name="hotel_size_title" placeholder="Seize the moment" value="{{ $HotelSize->title ?? '' }}">
            </div>
            <div class="fpb-7 mb-3">
                <label for="hotel_size_discount" class="form-label ol-form-label"> {{ get_phrase('Size  Discount') }} </label>
                <input type="text" class="form-control ol-form-control" name="hotel_size_discount" placeholder="Just For You -70%" value="{{ $HotelSize->description ?? '' }}">
            </div>
            <div class="fpb-7 mb-3">
                <label for="size_banner" class="form-label ol-form-label"> {{ get_phrase('Size Banner') }} </label>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="wrapper-image-preview justify-content-center">
                            <div class="box">
                                <div class="upload-options">
                                    @if(!empty($HotelSize->image))
                                        <img src="{{ asset('uploads/homepage/hotel/'. $HotelSize->image) }}" alt="" class="bg-dark_2 radious-15px px-2 py-2 size-preview h-200 cover w-100">
                                    @else
                                    <img src="" alt="" class="bg-dark_2 radious-15px px-2 py-2 size-preview h-200 cover w-100">
                                    @endif
                                    <label for="size_banner" class="btn ol-card p-4-text">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M18 6C17.39 6 16.83 5.65 16.55 5.11L15.83 3.66C15.37 2.75 14.17 2 13.15 2H10.86C9.83005 2 8.63005 2.75 8.17005 3.66L7.45005 5.11C7.17004 5.65 6.61005 6 6.00005 6C3.83005 6 2.11005 7.83 2.25005 9.99L2.77005 18.25C2.89005 20.31 4.00005 22 6.76005 22H17.24C20 22 21.1 20.31 21.23 18.25L21.75 9.99C21.89 7.83 20.17 6 18 6ZM10.5 7.25H13.5C13.91 7.25 14.25 7.59 14.25 8C14.25 8.41 13.91 8.75 13.5 8.75H10.5C10.09 8.75 9.75005 8.41 9.75005 8C9.75005 7.59 10.09 7.25 10.5 7.25ZM12 18.12C10.14 18.12 8.62005 16.61 8.62005 14.74C8.62005 12.87 10.13 11.36 12 11.36C13.87 11.36 15.38 12.87 15.38 14.74C15.38 16.61 13.86 18.12 12 18.12Z"
                                                fill="#797c8b" />
                                        </svg>
                                        {{ get_phrase('Upload  Image') }}
                                    </label>
                                    <input id="size_banner" type="file" class="image-upload d-none" name="size_banner" accept="image/*">
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
    document.getElementById('hotel_banner').addEventListener('change', function(event) {
        handleImagePreview(event.target, '.hotel-preview');
    });
    document.getElementById('hotel_booking_image').addEventListener('change', function(event) {
        handleImagePreview(event.target, '.hotel-booking-preview');
    });
    document.getElementById('exclusive_banner').addEventListener('change', function(event) {
        handleImagePreview(event.target, '.exclusive-preview');
    });
    document.getElementById('size_banner').addEventListener('change', function(event) {
        handleImagePreview(event.target, '.size-preview');
    });
</script>