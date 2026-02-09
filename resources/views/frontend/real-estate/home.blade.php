@extends('layouts.frontend')
@push('title', get_phrase('Real-Estate Directory Listing'))
@push('meta')@endpush
@section('frontend_layout')
    <!-- Start Discount Area -->

    @php
        $RealEstateDiscount = json_decode(get_homepage_settings('RealEstateDiscount') ?? '{}');
        $title = $RealEstateDiscount->title ?? '';
        $lastWordStart = strrpos($title, ' ');
        $firstPart = $lastWordStart !== false ? substr($title, 0, $lastWordStart) : '';
        $lastPart = $lastWordStart !== false ? substr($title, $lastWordStart + 1) : $title;
    @endphp
    <section>
        <div class="container">
            <div class="row mb-100px">
                <div class="col-12">
                    <div class="real-discount-area" style="background-image: url('{{ isset($RealEstateDiscount->image) && $RealEstateDiscount->image ? asset('uploads/homepage/real-estate/' . $RealEstateDiscount->image) : asset('assets/frontend/images/real-estate/re-discount-banner.webp') }}');">
                        <span class="real-discount-overlay"></span>
                        <p class="real-blue-badge mb-10px mx-auto">{{ get_phrase('Discount') }}</p>
                        <h1 class="mb-12px text-white text-center bsd-title-66px text-capitalize">{{ $firstPart }} <span class="real-text-yellow">{{ $lastPart }}</span></h1>
                        <p class="text-white mb-4 text-center in-subtitle3-16px">{{ $RealEstateDiscount->description }}</p>
                        <div class="text-center">
                            <a href="{{ route('listing.view', ['type' => 'real-estate', 'view' => 'grid']) }}" class="btn real-btn-white">{{ get_phrase('Learn More') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Discount Area -->

    <!-- Start Best Properties Area -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-between flex-wrap column-gap-4 row-gap-2 mb-30px">
                        <h1 class="pop-title-30px text-capitalize">{{ get_phrase('New Properties') }}</h1>
                        <a href="{{ route('listing.view', ['type' => 'real-estate', 'view' => 'grid']) }}" class="real-icontext-link">
                            <span>{{ get_phrase('Explore All Properties') }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path
                                    d="M8.09122 4.40833C8.01312 4.4858 7.95112 4.57796 7.90881 4.67951C7.86651 4.78106 7.84473 4.88998 7.84473 4.99999C7.84473 5.11 7.86651 5.21893 7.90881 5.32047C7.95112 5.42202 8.01312 5.51419 8.09122 5.59166L11.9079 9.40833C11.986 9.48579 12.048 9.57796 12.0903 9.67951C12.1326 9.78106 12.1544 9.88998 12.1544 9.99999C12.1544 10.11 12.1326 10.2189 12.0903 10.3205C12.048 10.422 11.986 10.5142 11.9079 10.5917L8.09123 14.4083C8.01312 14.4858 7.95112 14.578 7.90882 14.6795C7.86651 14.7811 7.84473 14.89 7.84473 15C7.84473 15.11 7.86651 15.2189 7.90882 15.3205C7.95112 15.422 8.01312 15.5142 8.09123 15.5917C8.24736 15.7469 8.45857 15.834 8.67873 15.834C8.89888 15.834 9.11009 15.7469 9.26622 15.5917L13.0912 11.7667C13.5594 11.2979 13.8224 10.6625 13.8224 9.99999C13.8224 9.33749 13.5594 8.70208 13.0912 8.23333L9.26622 4.40833C9.11009 4.25312 8.89888 4.166 8.67872 4.166C8.45857 4.166 8.24736 4.25312 8.09122 4.40833Z"
                                    fill="#0F0B0B" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row g-4 mb-100px">
                @foreach ($top_listings->sortByDesc('created_at')->take(4) as $listing)
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                        <div class="single-grid-card">
                            <!-- Banner Slider -->
                            <div class="grid-slider-area">
                                @php
                                    $images = json_decode($listing->image);
                                    $image = isset($images[0]) ? $images[0] : null;
                                    $claimStatus = App\Models\ClaimedListing::where('listing_id', $listing->id)->where('listing_type', 'real-estate')->first(); 
                                @endphp
                                <a class="w-100 h-100" href="{{ route('listing.details', ['type' => 'real-estate', 'id' => $listing->id, 'slug' => slugify($listing->title)]) }}">
                                    <img class="card-item-image" src="{{ get_all_image('listing-images/' . $image) }}">
                                </a>
                                <p class="card-light-text skin6-light capitalize">{{ $listing->status }}</p>
                                @php
                                    $is_in_wishlist = check_wishlist_status($listing->id, $listing->type);
                                @endphp
                                <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-title="{{ $is_in_wishlist ? get_phrase('Remove from Wishlist') : get_phrase('Add to Wishlist') }}" onclick="updateWishlist(this, '{{ $listing->id }}')" class="grid-list-bookmark gray-bookmark {{ $is_in_wishlist ? 'active' : '' }} skin6-bookmark">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.4361 3C12.7326 3.01162 12.0445 3.22023 11.4411 3.60475C10.8378 3.98927 10.3407 4.53609 10 5.18999C9.65929 4.53609 9.16217 3.98927 8.55886 3.60475C7.95554 3.22023 7.26738 3.01162 6.56389 3C5.44243 3.05176 4.38583 3.57288 3.62494 4.44953C2.86404 5.32617 2.4607 6.48707 2.50302 7.67861C2.50302 10.6961 5.49307 13.9917 8.00081 16.2262C8.56072 16.726 9.26864 17 10 17C10.7314 17 11.4393 16.726 11.9992 16.2262C14.5069 13.9917 17.497 10.6961 17.497 7.67861C17.5393 6.48707 17.136 5.32617 16.3751 4.44953C15.6142 3.57288 14.5576 3.05176 13.4361 3Z" fill="#6C1CFF" />
                                    </svg>
                                </a>
                            </div>
                            <div class="reals-grid-details realsh-grid-details position-relative">
                                <div class="location d-flex">
                                    <img src="{{ asset('assets/frontend/images/icons/location-sky-blue2-20.svg') }}" alt="">
                                    @php
                                        $city_name = App\Models\City::where('id', $listing->city)->first()->name;
                                        $country_name = App\Models\Country::where('id', $listing->country)->first()->name;
                                    @endphp
                                    <p class="info"> {{ $city_name . ', ' . $country_name }} </p>
                                </div>
                                <div class="reals-grid-title mb-16">
                                    <a href="{{ route('listing.details', ['type' => 'real-estate', 'id' => $listing->id, 'slug' => slugify($listing->title)]) }}" class="title">
                                        @if(isset($claimStatus) && $claimStatus->status == 1) 
                                        <span data-bs-toggle="tooltip" 
                                        data-bs-title=" {{ get_phrase('This listing is verified') }}">
                                        <svg fill="none" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><linearGradient id="paint0_linear_16_1334" gradientUnits="userSpaceOnUse" x1="12" x2="12" y1="-1.2" y2="25.2"><stop offset="0" stop-color="#ce9ffc"/><stop offset=".979167" stop-color="#7367f0"/></linearGradient><path d="m3.783 2.826 8.217-1.826 8.217 1.826c.2221.04936.4207.17297.563.3504.1424.17744.22.39812.22.6256v9.987c-.0001.9877-.244 1.9602-.7101 2.831s-1.14 1.6131-1.9619 2.161l-6.328 4.219-6.328-4.219c-.82173-.5478-1.49554-1.2899-1.96165-2.1605-.46611-.8707-.71011-1.8429-.71035-2.8305v-9.988c.00004-.22748.07764-.44816.21999-.6256.14235-.17743.34095-.30104.56301-.3504zm8.217 10.674 2.939 1.545-.561-3.272 2.377-2.318-3.286-.478-1.469-2.977-1.47 2.977-3.285.478 2.377 2.318-.56 3.272z" fill="url(#paint0_linear_16_1334)"/></svg>
                                        </span>
                                        @endif
                                        {{ $listing->title }} </a>
                                    <p class="info"> {{ substr_replace($listing->description, '...', 50) }}</p>
                                </div>
                                <div class="reals-bed-bath-sqft d-flex align-items-center flex-wrap">
                                    <div class="item d-flex align-items-center">
                                        <img src="{{ asset('assets/frontend/images/icons/bed-gray-16.svg') }}" alt="">
                                        <p class="total">{{ $listing->bed . ' ' . get_phrase('Bed') }}</p>
                                    </div>
                                    <div class="item d-flex align-items-center">
                                        <img src="{{ asset('assets/frontend/images/icons/bath-gray-16.svg') }}" alt="">
                                        <p class="total">{{ $listing->bath . ' ' . get_phrase('Bath') }}</p>
                                    </div>
                                    <div class="item d-flex align-items-center">
                                        <img src="{{ asset('assets/frontend/images/icons/resize-arrows-gray-16.svg') }}" alt="">
                                        <p class="total">{{ $listing->size . ' ' . get_phrase('sqft') }}</p>
                                    </div>
                                </div>
                                <div class="reals-grid-price-see d-flex align-items-center justify-content-between">
                                    <div class="prices d-flex">
                                        @if (!empty($listing->discount))
                                            <p class="new-price">{{ currency($listing->discount) }}</p>
                                            <p class="old-price">{{ currency($listing->price) }}</p>
                                        @elseif(!empty($listing->price))
                                            <p class="new-price">{{ currency($listing->price) }}</p>
                                        @endif
                                    </div>
                                    <a href="{{ route('listing.details', ['type' => 'real-estate', 'id' => $listing->id, 'slug' => slugify($listing->title)]) }}" class="reals-grid-view realsn-grid-view stretched-link">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.6499 9.33752H6.8999C6.5924 9.33752 6.3374 9.08252 6.3374 8.77502C6.3374 8.46752 6.5924 8.21252 6.8999 8.21252H10.6499C10.9574 8.21252 11.2124 8.46752 11.2124 8.77502C11.2124 9.08252 10.9574 9.33752 10.6499 9.33752Z" fill="#555558" />
                                            <path d="M8.7749 11.2125C8.4674 11.2125 8.2124 10.9575 8.2124 10.65V6.90002C8.2124 6.59252 8.4674 6.33752 8.7749 6.33752C9.0824 6.33752 9.3374 6.59252 9.3374 6.90002V10.65C9.3374 10.9575 9.0824 11.2125 8.7749 11.2125Z" fill="#555558" />
                                            <path d="M8.625 16.3125C4.3875 16.3125 0.9375 12.8625 0.9375 8.625C0.9375 4.3875 4.3875 0.9375 8.625 0.9375C12.8625 0.9375 16.3125 4.3875 16.3125 8.625C16.3125 12.8625 12.8625 16.3125 8.625 16.3125ZM8.625 2.0625C5.0025 2.0625 2.0625 5.01 2.0625 8.625C2.0625 12.24 5.0025 15.1875 8.625 15.1875C12.2475 15.1875 15.1875 12.24 15.1875 8.625C15.1875 5.01 12.2475 2.0625 8.625 2.0625Z" fill="#555558" />
                                            <path d="M16.5001 17.0625C16.3576 17.0625 16.2151 17.01 16.1026 16.8975L13.5003 14.2955C13.2828 14.078 13.2828 13.718 13.5003 13.5005C13.7178 13.283 14.0778 13.283 14.2953 13.5005L16.8976 16.1025C17.1151 16.32 17.1151 16.68 16.8976 16.8975C16.7851 17.01 16.6426 17.0625 16.5001 17.0625Z" fill="#555558" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End Best Properties Area -->

    <!-- End Real Estate Count Area -->
    <section>
        <div class="container">
            <div class="row g-4 mb-100px">
                @foreach ($listing_cities as $city)
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <a href="{{ route('ListingsFilter') }}?type=real-estate&view=grid&city={{ $city->id }}" class="real-product-count h-320 max-md-400px mx-auto mx-md-0">
                            <img src="{{ asset('uploads/city/' . $city->image) }}" alt="{{ $city->name }}">
                            <div class="real-product-count-content">
                                <h4 class="mb-10px dm-title-20px text-white lh-1 fw-bold">{{ $city->name }}</h4>
                                <p class="in-subtitle-14px text-white lh-1">
                                    {{ App\Models\RealEstateListing::where('city', $city->id)->count() }} {{ get_phrase('Property') }}
                                </p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End Real Estate Count Area -->

    <!-- Start For Sell Area -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-between flex-wrap column-gap-4 row-gap-2 mb-30px">
                        <h1 class="pop-title-30px text-capitalize">{{ get_phrase('For Sell') }}</h1>
                        <a href="{{ route('listing.view', ['type' => 'real-estate', 'view' => 'grid']) }}" class="real-icontext-link">
                            <span>{{ get_phrase('Explore All Properties') }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path
                                    d="M8.09122 4.40833C8.01312 4.4858 7.95112 4.57796 7.90881 4.67951C7.86651 4.78106 7.84473 4.88998 7.84473 4.99999C7.84473 5.11 7.86651 5.21893 7.90881 5.32047C7.95112 5.42202 8.01312 5.51419 8.09122 5.59166L11.9079 9.40833C11.986 9.48579 12.048 9.57796 12.0903 9.67951C12.1326 9.78106 12.1544 9.88998 12.1544 9.99999C12.1544 10.11 12.1326 10.2189 12.0903 10.3205C12.048 10.422 11.986 10.5142 11.9079 10.5917L8.09123 14.4083C8.01312 14.4858 7.95112 14.578 7.90882 14.6795C7.86651 14.7811 7.84473 14.89 7.84473 15C7.84473 15.11 7.86651 15.2189 7.90882 15.3205C7.95112 15.422 8.01312 15.5142 8.09123 15.5917C8.24736 15.7469 8.45857 15.834 8.67873 15.834C8.89888 15.834 9.11009 15.7469 9.26622 15.5917L13.0912 11.7667C13.5594 11.2979 13.8224 10.6625 13.8224 9.99999C13.8224 9.33749 13.5594 8.70208 13.0912 8.23333L9.26622 4.40833C9.11009 4.25312 8.89888 4.166 8.67872 4.166C8.45857 4.166 8.24736 4.25312 8.09122 4.40833Z"
                                    fill="#0F0B0B" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row g-4 mb-100px">
                @foreach ($top_listings->where('status', 'sell')->take(4) as $listing)
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                        <div class="single-grid-card">
                            <!-- Banner Slider -->
                            <div class="grid-slider-area">
                                @php
                                    $images = json_decode($listing->image);
                                    $image = isset($images[0]) ? $images[0] : null;
                                    $claimStatus = App\Models\ClaimedListing::where('listing_id', $listing->id)->where('listing_type', 'real-estate')->first(); 
                                @endphp
                                <a class="w-100 h-100" href="{{ route('listing.details', ['type' => 'real-estate', 'id' => $listing->id, 'slug' => slugify($listing->title)]) }}">
                                    <img class="card-item-image" src="{{ get_all_image('listing-images/' . $image) }}">
                                </a>
                                <p class="card-light-text skin6-light capitalize">{{ $listing->status }}</p>
                                @php
                                    $is_in_wishlist = check_wishlist_status($listing->id, $listing->type);
                                @endphp
                                <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-title="{{ $is_in_wishlist ? get_phrase('Remove from Wishlist') : get_phrase('Add to Wishlist') }}" onclick="updateWishlist(this, '{{ $listing->id }}')" class="grid-list-bookmark gray-bookmark {{ $is_in_wishlist ? 'active' : '' }} skin6-bookmark">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.4361 3C12.7326 3.01162 12.0445 3.22023 11.4411 3.60475C10.8378 3.98927 10.3407 4.53609 10 5.18999C9.65929 4.53609 9.16217 3.98927 8.55886 3.60475C7.95554 3.22023 7.26738 3.01162 6.56389 3C5.44243 3.05176 4.38583 3.57288 3.62494 4.44953C2.86404 5.32617 2.4607 6.48707 2.50302 7.67861C2.50302 10.6961 5.49307 13.9917 8.00081 16.2262C8.56072 16.726 9.26864 17 10 17C10.7314 17 11.4393 16.726 11.9992 16.2262C14.5069 13.9917 17.497 10.6961 17.497 7.67861C17.5393 6.48707 17.136 5.32617 16.3751 4.44953C15.6142 3.57288 14.5576 3.05176 13.4361 3Z" fill="#6C1CFF" />
                                    </svg>
                                </a>
                            </div>
                            <div class="reals-grid-details realsh-grid-details position-relative">
                                <div class="location d-flex">
                                    <img src="{{ asset('assets/frontend/images/icons/location-sky-blue2-20.svg') }}" alt="">
                                    @php
                                        $city_name = App\Models\City::where('id', $listing->city)->first()->name;
                                        $country_name = App\Models\Country::where('id', $listing->country)->first()->name;
                                    @endphp
                                    <p class="info"> {{ $city_name . ', ' . $country_name }} </p>
                                </div>
                                <div class="reals-grid-title mb-16">
                                    <a href="{{ route('listing.details', ['type' => 'real-estate', 'id' => $listing->id, 'slug' => slugify($listing->title)]) }}" class="title">
                                        @if(isset($claimStatus) && $claimStatus->status == 1) 
                                        <span data-bs-toggle="tooltip" 
                                        data-bs-title=" {{ get_phrase('This listing is verified') }}">
                                        <svg fill="none" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><linearGradient id="paint0_linear_16_1334" gradientUnits="userSpaceOnUse" x1="12" x2="12" y1="-1.2" y2="25.2"><stop offset="0" stop-color="#ce9ffc"/><stop offset=".979167" stop-color="#7367f0"/></linearGradient><path d="m3.783 2.826 8.217-1.826 8.217 1.826c.2221.04936.4207.17297.563.3504.1424.17744.22.39812.22.6256v9.987c-.0001.9877-.244 1.9602-.7101 2.831s-1.14 1.6131-1.9619 2.161l-6.328 4.219-6.328-4.219c-.82173-.5478-1.49554-1.2899-1.96165-2.1605-.46611-.8707-.71011-1.8429-.71035-2.8305v-9.988c.00004-.22748.07764-.44816.21999-.6256.14235-.17743.34095-.30104.56301-.3504zm8.217 10.674 2.939 1.545-.561-3.272 2.377-2.318-3.286-.478-1.469-2.977-1.47 2.977-3.285.478 2.377 2.318-.56 3.272z" fill="url(#paint0_linear_16_1334)"/></svg>
                                        </span>
                                        @endif
                                        {{ $listing->title }} </a>
                                    <p class="info"> {{ substr_replace($listing->description, '...', 50) }}</p>
                                </div>
                                <div class="reals-bed-bath-sqft d-flex align-items-center flex-wrap">
                                    <div class="item d-flex align-items-center">
                                        <img src="{{ asset('assets/frontend/images/icons/bed-gray-16.svg') }}" alt="">
                                        <p class="total">{{ $listing->bed . ' ' . get_phrase('Bed') }}</p>
                                    </div>
                                    <div class="item d-flex align-items-center">
                                        <img src="{{ asset('assets/frontend/images/icons/bath-gray-16.svg') }}" alt="">
                                        <p class="total">{{ $listing->bath . ' ' . get_phrase('Bath') }}</p>
                                    </div>
                                    <div class="item d-flex align-items-center">
                                        <img src="{{ asset('assets/frontend/images/icons/resize-arrows-gray-16.svg') }}" alt="">
                                        <p class="total">{{ $listing->size . ' ' . get_phrase('sqft') }}</p>
                                    </div>
                                </div>
                                <div class="reals-grid-price-see d-flex align-items-center justify-content-between">
                                    <div class="prices d-flex">
                                        @if (!empty($listing->discount))
                                            <p class="new-price">{{ currency($listing->discount) }}</p>
                                            <p class="old-price">{{ currency($listing->price) }}</p>
                                        @elseif(!empty($listing->price))
                                            <p class="new-price">{{ currency($listing->price) }}</p>
                                        @endif
                                    </div>
                                    <a href="{{ route('listing.details', ['type' => 'real-estate', 'id' => $listing->id, 'slug' => slugify($listing->title)]) }}" class="reals-grid-view realsn-grid-view stretched-link">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.6499 9.33752H6.8999C6.5924 9.33752 6.3374 9.08252 6.3374 8.77502C6.3374 8.46752 6.5924 8.21252 6.8999 8.21252H10.6499C10.9574 8.21252 11.2124 8.46752 11.2124 8.77502C11.2124 9.08252 10.9574 9.33752 10.6499 9.33752Z" fill="#555558" />
                                            <path d="M8.7749 11.2125C8.4674 11.2125 8.2124 10.9575 8.2124 10.65V6.90002C8.2124 6.59252 8.4674 6.33752 8.7749 6.33752C9.0824 6.33752 9.3374 6.59252 9.3374 6.90002V10.65C9.3374 10.9575 9.0824 11.2125 8.7749 11.2125Z" fill="#555558" />
                                            <path d="M8.625 16.3125C4.3875 16.3125 0.9375 12.8625 0.9375 8.625C0.9375 4.3875 4.3875 0.9375 8.625 0.9375C12.8625 0.9375 16.3125 4.3875 16.3125 8.625C16.3125 12.8625 12.8625 16.3125 8.625 16.3125ZM8.625 2.0625C5.0025 2.0625 2.0625 5.01 2.0625 8.625C2.0625 12.24 5.0025 15.1875 8.625 15.1875C12.2475 15.1875 15.1875 12.24 15.1875 8.625C15.1875 5.01 12.2475 2.0625 8.625 2.0625Z" fill="#555558" />
                                            <path d="M16.5001 17.0625C16.3576 17.0625 16.2151 17.01 16.1026 16.8975L13.5003 14.2955C13.2828 14.078 13.2828 13.718 13.5003 13.5005C13.7178 13.283 14.0778 13.283 14.2953 13.5005L16.8976 16.1025C17.1151 16.32 17.1151 16.68 16.8976 16.8975C16.7851 17.01 16.6426 17.0625 16.5001 17.0625Z" fill="#555558" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End For Sell Area -->

    <!-- Start For Rent Area -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-between flex-wrap column-gap-4 row-gap-2 mb-30px">
                        <h1 class="pop-title-30px text-capitalize">{{ get_phrase('For Rent') }}</h1>
                        <a href="{{ route('listing.view', ['type' => 'real-estate', 'view' => 'grid']) }}" class="real-icontext-link">
                            <span>{{ get_phrase('Explore All Properties') }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path
                                    d="M8.09122 4.40833C8.01312 4.4858 7.95112 4.57796 7.90881 4.67951C7.86651 4.78106 7.84473 4.88998 7.84473 4.99999C7.84473 5.11 7.86651 5.21893 7.90881 5.32047C7.95112 5.42202 8.01312 5.51419 8.09122 5.59166L11.9079 9.40833C11.986 9.48579 12.048 9.57796 12.0903 9.67951C12.1326 9.78106 12.1544 9.88998 12.1544 9.99999C12.1544 10.11 12.1326 10.2189 12.0903 10.3205C12.048 10.422 11.986 10.5142 11.9079 10.5917L8.09123 14.4083C8.01312 14.4858 7.95112 14.578 7.90882 14.6795C7.86651 14.7811 7.84473 14.89 7.84473 15C7.84473 15.11 7.86651 15.2189 7.90882 15.3205C7.95112 15.422 8.01312 15.5142 8.09123 15.5917C8.24736 15.7469 8.45857 15.834 8.67873 15.834C8.89888 15.834 9.11009 15.7469 9.26622 15.5917L13.0912 11.7667C13.5594 11.2979 13.8224 10.6625 13.8224 9.99999C13.8224 9.33749 13.5594 8.70208 13.0912 8.23333L9.26622 4.40833C9.11009 4.25312 8.89888 4.166 8.67872 4.166C8.45857 4.166 8.24736 4.25312 8.09122 4.40833Z"
                                    fill="#0F0B0B" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row g-4 mb-100px">
                @foreach ($top_listings->where('status', 'rent')->take(4) as $listing)
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                        <div class="single-grid-card">
                            <!-- Banner Slider -->
                            <div class="grid-slider-area">
                                @php
                                    $images = json_decode($listing->image);
                                    $image = isset($images[0]) ? $images[0] : null;
                                    $claimStatus = App\Models\ClaimedListing::where('listing_id', $listing->id)->where('listing_type', 'real-estate')->first(); 
                                @endphp
                                <a class="w-100 h-100" href="{{ route('listing.details', ['type' => 'real-estate', 'id' => $listing->id, 'slug' => slugify($listing->title)]) }}">
                                    <img class="card-item-image" src="{{ get_all_image('listing-images/' . $image) }}">
                                </a>
                                <p class="card-light-text skin6-light capitalize">{{ $listing->status }}</p>
                                @php
                                    $is_in_wishlist = check_wishlist_status($listing->id, $listing->type);
                                @endphp
                                <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-title="{{ $is_in_wishlist ? get_phrase('Remove from Wishlist') : get_phrase('Add to Wishlist') }}" onclick="updateWishlist(this, '{{ $listing->id }}')" class="grid-list-bookmark gray-bookmark {{ $is_in_wishlist ? 'active' : '' }} skin6-bookmark">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.4361 3C12.7326 3.01162 12.0445 3.22023 11.4411 3.60475C10.8378 3.98927 10.3407 4.53609 10 5.18999C9.65929 4.53609 9.16217 3.98927 8.55886 3.60475C7.95554 3.22023 7.26738 3.01162 6.56389 3C5.44243 3.05176 4.38583 3.57288 3.62494 4.44953C2.86404 5.32617 2.4607 6.48707 2.50302 7.67861C2.50302 10.6961 5.49307 13.9917 8.00081 16.2262C8.56072 16.726 9.26864 17 10 17C10.7314 17 11.4393 16.726 11.9992 16.2262C14.5069 13.9917 17.497 10.6961 17.497 7.67861C17.5393 6.48707 17.136 5.32617 16.3751 4.44953C15.6142 3.57288 14.5576 3.05176 13.4361 3Z" fill="#6C1CFF" />
                                    </svg>
                                </a>
                            </div>
                            <div class="reals-grid-details realsh-grid-details position-relative">
                                <div class="location d-flex">
                                    <img src="{{ asset('assets/frontend/images/icons/location-sky-blue2-20.svg') }}" alt="">
                                    @php
                                        $city_name = App\Models\City::where('id', $listing->city)->first()->name;
                                        $country_name = App\Models\Country::where('id', $listing->country)->first()->name;
                                    @endphp
                                    <p class="info"> {{ $city_name . ', ' . $country_name }} </p>
                                </div>
                                <div class="reals-grid-title mb-16">
                                    <a href="{{ route('listing.details', ['type' => 'real-estate', 'id' => $listing->id, 'slug' => slugify($listing->title)]) }}" class="title">
                                        @if(isset($claimStatus) && $claimStatus->status == 1) 
                                        <span data-bs-toggle="tooltip" 
                                        data-bs-title=" {{ get_phrase('This listing is verified') }}">
                                        <svg fill="none" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><linearGradient id="paint0_linear_16_1334" gradientUnits="userSpaceOnUse" x1="12" x2="12" y1="-1.2" y2="25.2"><stop offset="0" stop-color="#ce9ffc"/><stop offset=".979167" stop-color="#7367f0"/></linearGradient><path d="m3.783 2.826 8.217-1.826 8.217 1.826c.2221.04936.4207.17297.563.3504.1424.17744.22.39812.22.6256v9.987c-.0001.9877-.244 1.9602-.7101 2.831s-1.14 1.6131-1.9619 2.161l-6.328 4.219-6.328-4.219c-.82173-.5478-1.49554-1.2899-1.96165-2.1605-.46611-.8707-.71011-1.8429-.71035-2.8305v-9.988c.00004-.22748.07764-.44816.21999-.6256.14235-.17743.34095-.30104.56301-.3504zm8.217 10.674 2.939 1.545-.561-3.272 2.377-2.318-3.286-.478-1.469-2.977-1.47 2.977-3.285.478 2.377 2.318-.56 3.272z" fill="url(#paint0_linear_16_1334)"/></svg>
                                        </span>
                                        @endif
                                        {{ $listing->title }} </a>
                                    <p class="info"> {{ substr_replace($listing->description, '...', 50) }}</p>
                                </div>
                                <div class="reals-bed-bath-sqft d-flex align-items-center flex-wrap">
                                    <div class="item d-flex align-items-center">
                                        <img src="{{ asset('assets/frontend/images/icons/bed-gray-16.svg') }}" alt="">
                                        <p class="total">{{ $listing->bed . ' ' . get_phrase('Bed') }}</p>
                                    </div>
                                    <div class="item d-flex align-items-center">
                                        <img src="{{ asset('assets/frontend/images/icons/bath-gray-16.svg') }}" alt="">
                                        <p class="total">{{ $listing->bath . ' ' . get_phrase('Bath') }}</p>
                                    </div>
                                    <div class="item d-flex align-items-center">
                                        <img src="{{ asset('assets/frontend/images/icons/resize-arrows-gray-16.svg') }}" alt="">
                                        <p class="total">{{ $listing->size . ' ' . get_phrase('sqft') }}</p>
                                    </div>
                                </div>
                                <div class="reals-grid-price-see d-flex align-items-center justify-content-between">
                                    <div class="prices d-flex">
                                        @if (!empty($listing->discount))
                                            <p class="new-price">{{ currency($listing->discount) }}</p>
                                            <p class="old-price">{{ currency($listing->price) }}</p>
                                        @elseif(!empty($listing->price))
                                            <p class="new-price">{{ currency($listing->price) }}</p>
                                        @endif
                                    </div>
                                    <a href="{{ route('listing.details', ['type' => 'real-estate', 'id' => $listing->id, 'slug' => slugify($listing->title)]) }}" class="reals-grid-view realsn-grid-view stretched-link">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.6499 9.33752H6.8999C6.5924 9.33752 6.3374 9.08252 6.3374 8.77502C6.3374 8.46752 6.5924 8.21252 6.8999 8.21252H10.6499C10.9574 8.21252 11.2124 8.46752 11.2124 8.77502C11.2124 9.08252 10.9574 9.33752 10.6499 9.33752Z" fill="#555558" />
                                            <path d="M8.7749 11.2125C8.4674 11.2125 8.2124 10.9575 8.2124 10.65V6.90002C8.2124 6.59252 8.4674 6.33752 8.7749 6.33752C9.0824 6.33752 9.3374 6.59252 9.3374 6.90002V10.65C9.3374 10.9575 9.0824 11.2125 8.7749 11.2125Z" fill="#555558" />
                                            <path d="M8.625 16.3125C4.3875 16.3125 0.9375 12.8625 0.9375 8.625C0.9375 4.3875 4.3875 0.9375 8.625 0.9375C12.8625 0.9375 16.3125 4.3875 16.3125 8.625C16.3125 12.8625 12.8625 16.3125 8.625 16.3125ZM8.625 2.0625C5.0025 2.0625 2.0625 5.01 2.0625 8.625C2.0625 12.24 5.0025 15.1875 8.625 15.1875C12.2475 15.1875 15.1875 12.24 15.1875 8.625C15.1875 5.01 12.2475 2.0625 8.625 2.0625Z" fill="#555558" />
                                            <path d="M16.5001 17.0625C16.3576 17.0625 16.2151 17.01 16.1026 16.8975L13.5003 14.2955C13.2828 14.078 13.2828 13.718 13.5003 13.5005C13.7178 13.283 14.0778 13.283 14.2953 13.5005L16.8976 16.1025C17.1151 16.32 17.1151 16.68 16.8976 16.8975C16.7851 17.01 16.6426 17.0625 16.5001 17.0625Z" fill="#555558" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
    <!-- End For Rent Area -->
    <!-- Scroll btn -->
    <div class="scroll-icon-area d-none">
        <a href="javascript:;" class="scroll-btn">
            <i class="fas fa-arrow-up"></i>
        </a>
    </div>

@endsection
@push('js')

    @if (Auth::check())
        <script>
            "use strict";

            function updateWishlist(button, listingId) {
                const bookmarkButton = $(button);
                const isActive = bookmarkButton.hasClass('active');
                bookmarkButton.toggleClass('active');
                const newTooltipText = isActive ? 'Add to Wishlist' : 'Remove from Wishlist';
                bookmarkButton.attr('data-bs-title', newTooltipText);

                const tooltipInstance = bootstrap.Tooltip.getInstance(button);
                if (tooltipInstance) tooltipInstance.dispose();
                new bootstrap.Tooltip(button);

                $.ajax({
                    url: '{{ route('wishlist.update') }}',
                    method: 'POST',
                    data: {
                        listing_id: listingId,
                        type: 'real-estate',
                        user_id: {{ auth()->check() ? auth()->id() : 'null' }},
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            success(response.message);
                        } else if (response.status === 'error') {
                            bookmarkButton.toggleClass('active');
                            const revertTooltipText = isActive ? 'Remove from Wishlist' : 'Add to Wishlist';
                            bookmarkButton.attr('data-bs-title', revertTooltipText);
                            const revertTooltipInstance = bootstrap.Tooltip.getInstance(button);
                            if (revertTooltipInstance) revertTooltipInstance.dispose();
                            new bootstrap.Tooltip(button);
                        }
                    },
                    error: function(xhr) {
                        bookmarkButton.toggleClass('active');
                        const revertTooltipText = isActive ? 'Remove from Wishlist' : 'Add to Wishlist';
                        bookmarkButton.attr('data-bs-title', revertTooltipText);
                        const revertTooltipInstance = bootstrap.Tooltip.getInstance(button);
                        if (revertTooltipInstance) revertTooltipInstance.dispose();
                        new bootstrap.Tooltip(button);
                    },
                });
            }
        </script>
    @else
        <script>
            "use strict";

            function updateWishlist(listing_id) {
                warning("Please login first!");
            }
        </script>
    @endif


@endpush
