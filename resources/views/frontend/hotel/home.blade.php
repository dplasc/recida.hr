@extends('layouts.frontend')
@push('title', get_phrase('Hotel Directory Listing'))
@push('meta')@endpush
@section('frontend_layout')

    @php
        $HotelBooking = json_decode(get_homepage_settings('HotelBooking') ?? '{}');
        $HotelExclusive = json_decode(get_homepage_settings('HotelExclusive') ?? '{}');
        $HotelSize = json_decode(get_homepage_settings('HotelSize') ?? '{}');
        $HotelBanner = json_decode(get_homepage_settings('HotelBanner') ?? '{}');
    @endphp

    <section>
        <div class="container">
            <div class="row g-4 mb-100px">
                <div class="col-md-6">
                    <div class="bg-img-card h-100" style="background-image: url('{{ isset($HotelExclusive->image) && $HotelExclusive->image ? asset('uploads/homepage/hotel/' . $HotelExclusive->image) : asset('assets/frontend/images/hotel/bg-card-banner1.webp') }}');">
                        <div class="d-flex flex-column justify-content-between h-100 max-w-415px">
                            <div class="mb-30px">
                                <h2 class="text-white mb-12px dm-title-30px">{{ $HotelExclusive->title ?? '' }}</h2>
                                <h3 class="text-white dm-title-26px">{{ $HotelExclusive->description ?? '' }}</h3>
                            </div>
                            <a href="{{ route('listing.view', ['type' => 'hotel', 'view' => 'grid']) }}" class="btn ht-btn-primary2">{{ get_phrase('Find Gateway Deals') }}</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bg-img-card h-100" style="background-image: url('{{ isset($HotelSize->image) && $HotelSize->image ? asset('uploads/homepage/hotel/' . $HotelSize->image) : asset('assets/frontend/images/hotel/bg-card-banner2.webp') }}');">
                        <div class="d-flex flex-column justify-content-between h-100 max-w-415px">
                            <div class="mb-30px">
                                <h2 class="text-white mb-12px dm-title-30px">{{ $HotelSize->title ?? '' }}</h2>
                                <h4 class="text-white dm-title-20px">{{ $HotelSize->description ?? '' }}</h4>
                            </div>
                            <a href="{{ route('listing.view', ['type' => 'hotel', 'view' => 'grid']) }}" class="btn ht-btn-primary2">{{ get_phrase('Explore Hotel') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Image Card Area -->

    <!-- Start Grid Area -->
    <section>
        <div class="container">
            <div class="row g-4 mb-100px">
                @foreach ($listing_countries as $index => $country)
                    @if ($index === 0)
                        <div class="col-sm-6 col-md-4 col-lg-3 order-1">
                            <a href="{{ route('ListingsFilter') }}?type=hotel&view=grid&country={{ $country->id }}" class="ht-grid-item max-sm-350px mx-auto mx-sm-0">
                                <p class="ht-grid-country-name">{{ $country->name }}</p>
                                <img src="{{ get_all_image('country-thumbnails/' . $country->thumbnail) }}" alt="{{ $country->name }}">
                            </a>
                        </div>
                    @endif
                    <!-- Second Column -->
                    @if ($index === 1)
                        <div class="col-sm-6 col-md-4 col-lg-3 order-2">
                            <div class="row g-4">
                                @foreach ($listing_countries->slice(1, 2) as $subCountry)
                                    <div class="col-12">
                                        <a href="{{ route('ListingsFilter') }}?type=hotel&view=grid&country={{ $country->id }}" class="ht-grid-item max-sm-350px mx-auto mx-sm-0">
                                            <p class="ht-grid-country-name">{{ $subCountry->name }}</p>
                                            <img src="{{ get_all_image('country-thumbnails/' . $subCountry->thumbnail) }}" alt="{{ $subCountry->name }}">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Third Column -->
                    @if ($index === 2)
                        <div class="col-sm-6 col-md-8 col-lg-3 order-3 order-md-4 order-lg-3">
                            <div class="row g-4">
                                @foreach ($listing_countries->slice(3, 2) as $subCountry)
                                    <div class="col-12 col-md-6 col-lg-12">
                                        <a href="{{ route('ListingsFilter') }}?type=hotel&view=grid&country={{ $country->id }}" class="ht-grid-item max-sm-350px mx-auto mx-sm-0">
                                            <p class="ht-grid-country-name">{{ $subCountry->name }}</p>
                                            <img src="{{ get_all_image('country-thumbnails/' . $subCountry->thumbnail) }}" alt="{{ $subCountry->name }}">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Fourth Column -->
                    @if ($index === 5)
                        <div class="col-sm-6 col-md-4 col-lg-3 order-4 order-md-3 order-lg-4">
                            <a href="{{ route('ListingsFilter') }}?type=hotel&view=grid&country={{ $country->id }}" class="ht-grid-item max-sm-350px mx-auto mx-sm-0">
                                <p class="ht-grid-country-name">{{ $country->name }}</p>
                                <img src="{{ get_all_image('country-thumbnails/' . $country->thumbnail) }}" alt="{{ $country->name }}">
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>

        </div>
    </section>
    <!-- End Grid Area -->

    <!-- Start Top Hotels Area -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-between flex-wrap column-gap-4 row-gap-2 mb-30px">
                        <h1 class="dm-title-36px">{{ get_phrase('Top Hotels') }}</h1>
                        <a href="{{ route('listing.view', ['type' => 'hotel', 'view' => 'grid']) }}" class="ht-icontext-link d-flex align-items-center gap-1">
                            <span>{{ get_phrase('See all') }}</span>
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M8.09171 4.40833C8.01361 4.4858 7.95161 4.57796 7.9093 4.67951C7.867 4.78106 7.84521 4.88998 7.84521 4.99999C7.84521 5.11 7.867 5.21893 7.9093 5.32047C7.95161 5.42202 8.01361 5.51419 8.09171 5.59166L11.9084 9.40833C11.9865 9.48579 12.0485 9.57796 12.0908 9.67951C12.1331 9.78106 12.1549 9.88998 12.1549 9.99999C12.1549 10.11 12.1331 10.2189 12.0908 10.3205C12.0485 10.422 11.9865 10.5142 11.9084 10.5917L8.09171 14.4083C8.01361 14.4858 7.95161 14.578 7.9093 14.6795C7.867 14.7811 7.84521 14.89 7.84521 15C7.84521 15.11 7.867 15.2189 7.9093 15.3205C7.95161 15.422 8.01361 15.5142 8.09171 15.5917C8.24785 15.7469 8.45906 15.834 8.67921 15.834C8.89937 15.834 9.11058 15.7469 9.26671 15.5917L13.0917 11.7667C13.5599 11.2979 13.8228 10.6625 13.8228 9.99999C13.8228 9.33749 13.5599 8.70208 13.0917 8.23333L9.26671 4.40833C9.11058 4.25312 8.89937 4.166 8.67921 4.166C8.45906 4.166 8.24785 4.25312 8.09171 4.40833Z"
                                    fill="#060F19" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row g-4 mb-100px">
                @php
                    $topListings = $top_listings->where('is_popular', 'top')->sortByDesc('created_at')->take(4);
                @endphp
                @foreach ($topListings->sortByDesc('created_at') as $listing)
                    @php
                        $images = json_decode($listing->image) ?? [];
                        $claimStatus = App\Models\ClaimedListing::where('listing_id', $listing->id)->where('listing_type', 'hotel')->first(); 
                    @endphp
                    <!-- Single Card -->
                    <div class="col-xl-3 col-md-6 col-sm-6">
                        <div class="single-grid-card">
                            <!-- Banner Slider -->
                            <div class="grid-slider-area">
                                @php
                                    $images = json_decode($listing->image);
                                    $image = isset($images[0]) ? $images[0] : null;
                                @endphp
                                <a class="w-100 h-100" href="{{ route('listing.details', ['type' => 'hotel', 'id' => $listing->id, 'slug' => slugify($listing->title)]) }}">
                                    <img class="card-item-image" src="{{ get_all_image('listing-images/' . $image) }}">
                                </a>
                                @php
                                    $is_in_wishlist = check_wishlist_status($listing->id, $listing->type);
                                @endphp
                                <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-title="{{ $is_in_wishlist ? get_phrase('Remove from Wishlist') : get_phrase('Add to Wishlist') }}" onclick="updateWishlist(this, '{{ $listing->id }}')" class="grid-list-bookmark white-bookmark {{ $is_in_wishlist ? 'active' : '' }}">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.4361 3C12.7326 3.01162 12.0445 3.22023 11.4411 3.60475C10.8378 3.98927 10.3407 4.53609 10 5.18999C9.65929 4.53609 9.16217 3.98927 8.55886 3.60475C7.95554 3.22023 7.26738 3.01162 6.56389 3C5.44243 3.05176 4.38583 3.57288 3.62494 4.44953C2.86404 5.32617 2.4607 6.48707 2.50302 7.67861C2.50302 10.6961 5.49307 13.9917 8.00081 16.2262C8.56072 16.726 9.26864 17 10 17C10.7314 17 11.4393 16.726 11.9992 16.2262C14.5069 13.9917 17.497 10.6961 17.497 7.67861C17.5393 6.48707 17.136 5.32617 16.3751 4.44953C15.6142 3.57288 14.5576 3.05176 13.4361 3Z" fill="#6C1CFF" />
                                    </svg>
                                </a>
                            </div>
                            <div class="hotel-grid-details position-relative">
                                <a href="{{ route('listing.details', ['type' => 'hotel', 'id' => $listing->id, 'slug' => slugify($listing->title)]) }}" class="title ">
                                    @if(isset($claimStatus) && $claimStatus->status == 1) 
                                    <span data-bs-toggle="tooltip" 
                                    data-bs-title=" {{ get_phrase('This listing is verified') }}">
                                    <svg fill="none" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><linearGradient id="paint0_linear_16_1334" gradientUnits="userSpaceOnUse" x1="12" x2="12" y1="-1.2" y2="25.2"><stop offset="0" stop-color="#ce9ffc"/><stop offset=".979167" stop-color="#7367f0"/></linearGradient><path d="m3.783 2.826 8.217-1.826 8.217 1.826c.2221.04936.4207.17297.563.3504.1424.17744.22.39812.22.6256v9.987c-.0001.9877-.244 1.9602-.7101 2.831s-1.14 1.6131-1.9619 2.161l-6.328 4.219-6.328-4.219c-.82173-.5478-1.49554-1.2899-1.96165-2.1605-.46611-.8707-.71011-1.8429-.71035-2.8305v-9.988c.00004-.22748.07764-.44816.21999-.6256.14235-.17743.34095-.30104.56301-.3504zm8.217 10.674 2.939 1.545-.561-3.272 2.377-2.318-3.286-.478-1.469-2.977-1.47 2.977-3.285.478 2.377 2.318-.56 3.272z" fill="url(#paint0_linear_16_1334)"/></svg>
                                    </span>
                                    @endif
                                    {{ $listing->title }}
                                </a>
                                <div class="hotelgrid-location-rating d-flex align-items-center justify-content-between flex-wrap">
                                    <div class="location d-flex">
                                        <img src="{{ asset('assets/frontend/images/icons/location-gray-16.svg') }}" alt="">
                                        @php
                                            $city_name = App\Models\City::where('id', $listing->city)->first()->name;
                                            $country_name = App\Models\Country::where('id', $listing->country)->first()->name;
                                        @endphp
                                        <p class="name"> {{ $city_name . ', ' . $country_name }} </p>
                                    </div>
                                    @php
                                        $reviews_count = App\Models\Review::where('listing_id', $listing->id)->where('user_id', '!=', $listing->user_id)->where('type', 'hotel')->where('reply_id', null)->count();
                                        $total_ratings = App\Models\Review::where('listing_id', $listing->id)->where('user_id', '!=', $listing->user_id)->where('type', 'hotel')->where('reply_id', null)->sum('rating');
                                        $average_rating = $reviews_count > 0 ? $total_ratings / $reviews_count : 0;
                                    @endphp
                                    <div class="ratings d-flex align-items-center">
                                        <p class="rating">{{ number_format($average_rating, 1) }}</p>
                                        <img src="{{ asset('assets/frontend/images/icons/star-yellow-20.svg') }}" alt="">
                                        <p class="reviews">({{ $reviews_count }})</p>
                                    </div>
                                </div>
                                <ul class="hotelgrid-list-items d-flex align-items-center flex-wrap">
                                    @php
                                        $features = json_decode($listing->feature, true) ?? [];
                                        $displayedFeatures = array_slice($features, 0, 2);
                                        $remainingCount = count($features) - 2;
                                    @endphp
                                    @foreach ($displayedFeatures as $feature)
                                        @php
                                            $amenities = App\Models\Amenities::where('id', $feature)->first();
                                        @endphp
                                        @if ($amenities)
                                            <li>{{ $amenities->name }}</li>
                                        @endif
                                    @endforeach
                                    @if ($remainingCount > 0)
                                        <li class="more">+{{ $remainingCount }} {{ get_phrase('More') }}</li>
                                    @endif

                                </ul>
                                <div class="hotelgrid-see-price d-flex align-items-center justify-content-between">
                                    <a href="{{ route('listing.details', ['type' => 'hotel', 'id' => $listing->id, 'slug' => slugify($listing->title)]) }}" class="see-details-btn1 stretched-link">{{ get_phrase('See Details') }}</a>
                                    <div class="prices d-flex">
                                        <p class="price">{{ currency($listing->price) }}</p>
                                        <p class="time">/{{ get_phrase('night') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Single Card -->
                @endforeach
            </div>
        </div>
    </section>
    <!-- End Top Hotels Area -->

    <!-- End Hotels Count Area -->

    <section>
        <div class="container">
            <div class="row g-4 mb-100px">
                @php
                    DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
                    $cities = App\Models\City::select('cities.*', DB::raw('COUNT(hotel_listings.id) as listings_count'))->join('hotel_listings', 'hotel_listings.city', '=', 'cities.id')->groupBy('cities.id', 'cities.name', 'cities.image')->get();
                @endphp
                @if ($cities->count() > 0)
                    @foreach ($cities->take(4) as $city)
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <a href="{{ route('ListingsFilter') }}?type=hotel&view=grid&city={{ $city->id }}" class="ht-product-count scale max-md-400px mx-auto mx-md-0 h-260px">
                                <img src="{{ asset('uploads/city/' . $city->image) }}" alt=" ">
                                <div class="ht-product-count-content">
                                    <h4 class="mb-10px dm-title-20px text-white lh-1">{{ $city->name }}</h4>
                                    <p class="in-subtitle-14px text-white lh-1">{{ $city->listings_count }} {{ get_phrase('Hotels') }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    <!-- End Hotels Count Area -->

    <!-- Start Hotels In New York Area -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-between flex-wrap column-gap-4 row-gap-2 mb-30px">
                        <h1 class="dm-title-36px">{{ get_phrase('Popular Hotel') }}</h1>
                        <a href="{{ route('listing.view', ['type' => 'hotel', 'view' => 'grid']) }}" class="ht-icontext-link d-flex align-items-center gap-1">
                            <span>{{ get_phrase('See All') }}</span>
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M8.09171 4.40833C8.01361 4.4858 7.95161 4.57796 7.9093 4.67951C7.867 4.78106 7.84521 4.88998 7.84521 4.99999C7.84521 5.11 7.867 5.21893 7.9093 5.32047C7.95161 5.42202 8.01361 5.51419 8.09171 5.59166L11.9084 9.40833C11.9865 9.48579 12.0485 9.57796 12.0908 9.67951C12.1331 9.78106 12.1549 9.88998 12.1549 9.99999C12.1549 10.11 12.1331 10.2189 12.0908 10.3205C12.0485 10.422 11.9865 10.5142 11.9084 10.5917L8.09171 14.4083C8.01361 14.4858 7.95161 14.578 7.9093 14.6795C7.867 14.7811 7.84521 14.89 7.84521 15C7.84521 15.11 7.867 15.2189 7.9093 15.3205C7.95161 15.422 8.01361 15.5142 8.09171 15.5917C8.24785 15.7469 8.45906 15.834 8.67921 15.834C8.89937 15.834 9.11058 15.7469 9.26671 15.5917L13.0917 11.7667C13.5599 11.2979 13.8228 10.6625 13.8228 9.99999C13.8228 9.33749 13.5599 8.70208 13.0917 8.23333L9.26671 4.40833C9.11058 4.25312 8.89937 4.166 8.67921 4.166C8.45906 4.166 8.24785 4.25312 8.09171 4.40833Z"
                                    fill="#060F19" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row g-4 mb-100px">
                @php
                    $popularListings = $top_listings->where('is_popular', 'popular')->sortByDesc('created_at')->take(4);
                @endphp
                @foreach ($popularListings->sortByDesc('created_at') as $listing)
                    @php
                        $images = json_decode($listing->image) ?? [];
                    @endphp
                    <!-- Single Card -->
                    <div class="col-xl-3 col-md-6 col-sm-6">
                        <div class="single-grid-card">
                            <!-- Banner Slider -->
                            <div class="grid-slider-area">
                                @php
                                    $images = json_decode($listing->image);
                                    $image = isset($images[0]) ? $images[0] : null;
                                    $claimStatus = App\Models\ClaimedListing::where('listing_id', $listing->id)->where('listing_type', 'hotel')->first(); 
                                @endphp
                                <a class="w-100 h-100" href="{{ route('listing.details', ['type' => 'hotel', 'id' => $listing->id, 'slug' => slugify($listing->title)]) }}">
                                    <img class="card-item-image" src="{{ get_all_image('listing-images/' . $image) }}">
                                </a>
                                @php
                                    $is_in_wishlist = check_wishlist_status($listing->id, $listing->type);
                                @endphp
                                <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-title="{{ $is_in_wishlist ? get_phrase('Remove from Wishlist') : get_phrase('Add to Wishlist') }}" onclick="updateWishlist(this, '{{ $listing->id }}')" class="grid-list-bookmark white-bookmark {{ $is_in_wishlist ? 'active' : '' }}">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.4361 3C12.7326 3.01162 12.0445 3.22023 11.4411 3.60475C10.8378 3.98927 10.3407 4.53609 10 5.18999C9.65929 4.53609 9.16217 3.98927 8.55886 3.60475C7.95554 3.22023 7.26738 3.01162 6.56389 3C5.44243 3.05176 4.38583 3.57288 3.62494 4.44953C2.86404 5.32617 2.4607 6.48707 2.50302 7.67861C2.50302 10.6961 5.49307 13.9917 8.00081 16.2262C8.56072 16.726 9.26864 17 10 17C10.7314 17 11.4393 16.726 11.9992 16.2262C14.5069 13.9917 17.497 10.6961 17.497 7.67861C17.5393 6.48707 17.136 5.32617 16.3751 4.44953C15.6142 3.57288 14.5576 3.05176 13.4361 3Z" fill="#6C1CFF" />
                                    </svg>
                                </a>
                            </div>
                            <div class="hotel-grid-details position-relative">
                                <a href="{{ route('listing.details', ['type' => 'hotel', 'id' => $listing->id, 'slug' => slugify($listing->title)]) }}" class="title">
                                    @if(isset($claimStatus) && $claimStatus->status == 1) 
                                    <span data-bs-toggle="tooltip" 
                                    data-bs-title=" {{ get_phrase('This listing is verified') }}">
                                    <svg fill="none" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><linearGradient id="paint0_linear_16_1334" gradientUnits="userSpaceOnUse" x1="12" x2="12" y1="-1.2" y2="25.2"><stop offset="0" stop-color="#ce9ffc"/><stop offset=".979167" stop-color="#7367f0"/></linearGradient><path d="m3.783 2.826 8.217-1.826 8.217 1.826c.2221.04936.4207.17297.563.3504.1424.17744.22.39812.22.6256v9.987c-.0001.9877-.244 1.9602-.7101 2.831s-1.14 1.6131-1.9619 2.161l-6.328 4.219-6.328-4.219c-.82173-.5478-1.49554-1.2899-1.96165-2.1605-.46611-.8707-.71011-1.8429-.71035-2.8305v-9.988c.00004-.22748.07764-.44816.21999-.6256.14235-.17743.34095-.30104.56301-.3504zm8.217 10.674 2.939 1.545-.561-3.272 2.377-2.318-3.286-.478-1.469-2.977-1.47 2.977-3.285.478 2.377 2.318-.56 3.272z" fill="url(#paint0_linear_16_1334)"/></svg>
                                    </span>
                                    @endif
                                    {{ $listing->title }}</a>
                                <div class="hotelgrid-location-rating d-flex align-items-center justify-content-between flex-wrap">
                                    <div class="location d-flex">
                                        <img src="{{ asset('assets/frontend/images/icons/location-gray-16.svg') }}" alt="">
                                        @php
                                            $city_name = App\Models\City::where('id', $listing->city)->first()->name;
                                            $country_name = App\Models\Country::where('id', $listing->country)->first()->name;
                                        @endphp
                                        <p class="name"> {{ $city_name . ', ' . $country_name }} </p>
                                    </div>
                                    @php
                                        $reviews_count = App\Models\Review::where('listing_id', $listing->id)->where('user_id', '!=', $listing->user_id)->where('type', 'hotel')->where('reply_id', null)->count();
                                        $total_ratings = App\Models\Review::where('listing_id', $listing->id)->where('user_id', '!=', $listing->user_id)->where('type', 'hotel')->where('reply_id', null)->sum('rating');
                                        $average_rating = $reviews_count > 0 ? $total_ratings / $reviews_count : 0;
                                    @endphp
                                    <div class="ratings d-flex align-items-center">
                                        <p class="rating">{{ number_format($average_rating, 1) }}</p>
                                        <img src="{{ asset('assets/frontend/images/icons/star-yellow-20.svg') }}" alt="">
                                        <p class="reviews">({{ $reviews_count }})</p>
                                    </div>
                                </div>
                                <ul class="hotelgrid-list-items d-flex align-items-center flex-wrap">
                                    @php
                                        $features = json_decode($listing->feature, true) ?? [];
                                        $displayedFeatures = array_slice($features, 0, 2);
                                        $remainingCount = count($features) - 2;
                                    @endphp
                                    @foreach ($displayedFeatures as $feature)
                                        @php
                                            $amenities = App\Models\Amenities::where('id', $feature)->first();
                                        @endphp
                                        @if ($amenities)
                                            <li>{{ $amenities->name }}</li>
                                        @endif
                                    @endforeach
                                    @if ($remainingCount > 0)
                                        <li class="more">+{{ $remainingCount }} {{ get_phrase('More') }}</li>
                                    @endif

                                </ul>
                                <div class="hotelgrid-see-price d-flex align-items-center justify-content-between">
                                    <a href="{{ route('listing.details', ['type' => 'hotel', 'id' => $listing->id, 'slug' => slugify($listing->title)]) }}" class="see-details-btn1 stretched-link">{{ get_phrase('See Details') }}</a>
                                    <div class="prices d-flex">
                                        <p class="price">{{ currency($listing->price) }}</p>
                                        <p class="time">/{{ get_phrase('night') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Single Card -->
                @endforeach
            </div>
        </div>
    </section>
    <!-- End Hotels In New York Area -->

    <!-- Start Book A Room Area -->
    <section>
        <div class="container">
            <div class="row justify-content-center mb-100px">
                <div class="col-xl-10">
                    <div class="bg-img-card2" style="background-image: url('{{ isset($HotelBooking->image) && $HotelBooking->image ? asset('uploads/homepage/hotel/' . $HotelBooking->image) : asset('assets/frontend/images/hotel/book-room-banner.webp') }}');">
                        <h1 class="dm-title-36px mb-26px text-white">{{ $HotelBooking->title ?? '' }}</h1>
                        <ul class="mb-30px d-flex align-items-center flex-wrap gap-3">
                            <li class="d-flex align-items-center gap-2">
                                <img src="{{ asset('assets/frontend/images/icons/check-yellow-18.svg') }}" alt="icon">
                                <span class="in-title-18px text-white">{{ get_phrase('Flexible budget') }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-2">
                                <img src="{{ asset('assets/frontend/images/icons/check-yellow-18.svg') }}" alt="icon">
                                <span class="in-title-18px text-white">{{ get_phrase('Peaceful place') }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-2">
                                <img src="{{ asset('assets/frontend/images/icons/check-yellow-18.svg') }}" alt="icon">
                                <span class="in-title-18px text-white">{{ get_phrase('Well decorated') }}</span>
                            </li>
                        </ul>
                        <div class="d-flex align-items-center gap-14px flex-wrap">
                            <a href="{{ route('contact-us') }}" class="btn ht-btn-white">{{ get_phrase('Contact Us') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Book A Room Area -->



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
                        type: 'hotel',
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
