@php
    $RealEstateBanner = json_decode(get_homepage_settings('RealEstateBanner') ?? '{}');
    $RealEstateDiscount = json_decode(get_homepage_settings('RealEstateDiscount') ?? '{}');
@endphp

<h4 class="title mt-4">{{ get_phrase('Real Estate Frontend Settings') }}</h4>
<div class="row">
    <div class="col-lg-6">
        <form class="mt-5" action="{{ route('admin.homepage-setting-update') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="RealEstateBanner">
            <div class="fpb-7 mb-3">
                <label for="real_banner_title" class="form-label ol-form-label"> {{ get_phrase('Real Estate  Title') }} </label>
                <input type="text" class="form-control ol-form-control" name="real_banner_title" placeholder="Enter title" value="{{ $RealEstateBanner->title ?? '' }}">
            </div>
            <div class="fpb-7 mb-3">
                <label for="hotel_banner_description" class="form-label ol-form-label"> {{ get_phrase('Real Estate Banner Description') }} </label>
                <textarea name="real_banner_description" class="form-control ol-form-control">{{ $RealEstateBanner->description ?? '' }}</textarea>
            </div>
            <div class="fpb-7 mb-3">
                <label for="real_banner" class="form-label ol-form-label"> {{ get_phrase('Real Estate Banner') }} </label>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="wrapper-image-preview justify-content-center">
                            <div class="box">
                                <div class="upload-options">
                                    @if(!empty($RealEstateBanner->image))
                                        <img src="{{ asset('uploads/homepage/real-estate/'. $RealEstateBanner->image) }}" alt="" class="bg-dark_2 radious-15px px-2 py-2 real-preview h-200 cover w-100">
                                    @else
                                    <img src="" alt="" class="bg-dark_2 radious-15px px-2 py-2 real-preview h-200 cover w-100">
                                    @endif
                                    <label for="real_banner" class="btn ol-card p-4-text">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M18 6C17.39 6 16.83 5.65 16.55 5.11L15.83 3.66C15.37 2.75 14.17 2 13.15 2H10.86C9.83005 2 8.63005 2.75 8.17005 3.66L7.45005 5.11C7.17004 5.65 6.61005 6 6.00005 6C3.83005 6 2.11005 7.83 2.25005 9.99L2.77005 18.25C2.89005 20.31 4.00005 22 6.76005 22H17.24C20 22 21.1 20.31 21.23 18.25L21.75 9.99C21.89 7.83 20.17 6 18 6ZM10.5 7.25H13.5C13.91 7.25 14.25 7.59 14.25 8C14.25 8.41 13.91 8.75 13.5 8.75H10.5C10.09 8.75 9.75005 8.41 9.75005 8C9.75005 7.59 10.09 7.25 10.5 7.25ZM12 18.12C10.14 18.12 8.62005 16.61 8.62005 14.74C8.62005 12.87 10.13 11.36 12 11.36C13.87 11.36 15.38 12.87 15.38 14.74C15.38 16.61 13.86 18.12 12 18.12Z"
                                                fill="#797c8b" />
                                        </svg>
                                        {{ get_phrase('Upload  Image') }}
                                    </label>
                                    <input id="real_banner" type="file" class="image-upload d-none" name="real_banner" accept="image/*">
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
            <input type="hidden" name="type" value="RealEstateDiscount">
            <div class="fpb-7 mb-3">
                <label for="real_discount_title" class="form-label ol-form-label"> {{ get_phrase('Real Estate Discount Title') }} </label>
                <input type="text" class="form-control ol-form-control" name="real_discount_title" placeholder="Enter title" value="{{ $RealEstateDiscount->title ?? '' }}">
            </div>
            <div class="fpb-7 mb-3">
                <label for="real_discount_description" class="form-label ol-form-label"> {{ get_phrase('Real Estate Short Description') }} </label>
                <input type="text" class="form-control ol-form-control" name="real_discount_description" placeholder="Enter title" value="{{ $RealEstateDiscount->title ?? '' }}">
            </div>
            <div class="fpb-7 mb-3">
                <label for="real_booking_image" class="form-label ol-form-label"> {{ get_phrase('Discount Image') }} </label>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="wrapper-image-preview justify-content-center">
                            <div class="box">
                                <div class="upload-options">
                                    @if(!empty($RealEstateDiscount->image))
                                        <img src="{{ asset('uploads/homepage/real-estate/'. $RealEstateDiscount->image) }}" alt="" class="bg-dark_2 radious-15px px-2 py-2 real-booking-preview h-200 cover w-100">
                                    @else
                                    <img src="" alt="" class="bg-dark_2 radious-15px px-2 py-2 real-booking-preview h-200 cover w-100">
                                    @endif
                                    <label for="real_booking_image" class="btn ol-card p-4-text">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M18 6C17.39 6 16.83 5.65 16.55 5.11L15.83 3.66C15.37 2.75 14.17 2 13.15 2H10.86C9.83005 2 8.63005 2.75 8.17005 3.66L7.45005 5.11C7.17004 5.65 6.61005 6 6.00005 6C3.83005 6 2.11005 7.83 2.25005 9.99L2.77005 18.25C2.89005 20.31 4.00005 22 6.76005 22H17.24C20 22 21.1 20.31 21.23 18.25L21.75 9.99C21.89 7.83 20.17 6 18 6ZM10.5 7.25H13.5C13.91 7.25 14.25 7.59 14.25 8C14.25 8.41 13.91 8.75 13.5 8.75H10.5C10.09 8.75 9.75005 8.41 9.75005 8C9.75005 7.59 10.09 7.25 10.5 7.25ZM12 18.12C10.14 18.12 8.62005 16.61 8.62005 14.74C8.62005 12.87 10.13 11.36 12 11.36C13.87 11.36 15.38 12.87 15.38 14.74C15.38 16.61 13.86 18.12 12 18.12Z"
                                                fill="#797c8b" />
                                        </svg>
                                        {{ get_phrase('Upload Image') }}
                                    </label>
                                    <input id="real_booking_image" type="file" class="image-upload d-none" name="real_discount_image" accept="image/*">
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
    document.getElementById('real_banner').addEventListener('change', function(event) {
        handleImagePreview(event.target, '.real-preview');
    });
    document.getElementById('real_booking_image').addEventListener('change', function(event) {
        handleImagePreview(event.target, '.real-booking-preview');
    });
  
</script>