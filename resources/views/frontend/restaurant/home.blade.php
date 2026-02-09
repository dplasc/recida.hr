@extends('layouts.frontend')
@push('title', get_phrase('Restaurant'))
@push('meta')@endpush
@push('css')
    <style>
        .header-section {
            box-shadow: none !important;
        }
    </style>
@endpush
@section('frontend_layout')
    @php
        $RestaurantBanner = json_decode(get_homepage_settings('RestaurantBanner') ?? '{}');
        $RestaurantExclusive = json_decode(get_homepage_settings('RestaurantExclusive') ?? '{}');
        $RestaurantDiscount = json_decode(get_homepage_settings('RestaurantDiscount') ?? '{}');

        $title = $RestaurantBanner->title ?? '';

        $words = explode(' ', $title);

        if (count($words) > 1) {
            $last_word = array_pop($words);
            $remaining_title = implode(' ', $words);
        } else {
            $last_word = $title;
            $remaining_title = '';
        }

    @endphp

    <!-- Start Banner Area -->
    <section class="rt-banner-section mb-60px">
        <div class="rt-banner-left-shape">
            @if (!empty($RestaurantBanner->image1))
                <img src="{{ asset('uploads/homepage/restaurant/' . $RestaurantBanner->image1) }}" alt="">
            @else
                <img src="{{ asset('assets/frontend/images/restaurent/restaurant-banner-shape1.webp') }}" alt="">
            @endif
        </div>
        <div class="rt-banner-right-shape">
            @if (!empty($RestaurantBanner->image2))
                <img src="{{ asset('uploads/homepage/restaurant/' . $RestaurantBanner->image2) }}" alt="">
            @else
                <img src="{{ asset('assets/frontend/images/restaurent/restaurant-banner-shape2.webp') }}" alt="shape">
            @endif
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="rt-banner-content mx-auto">
                        <div class="rt-banner-content-shape1">
                            <img src="{{ asset('assets/frontend/images/restaurent/rt-banner-leaf2.png') }}" alt="shape">
                        </div>
                        <div class="rt-banner-content-shape2">
                            <img src="{{ asset('assets/frontend/images/restaurent/rt-banner-leaf4.png') }}" alt="shape">
                        </div>
                        <p class="fi-text-uppercase-16px text-center">{{ get_phrase('Restaurant') }}</p>
                        <h1 class="text-center fi-title-60px text-capitalize mb-20px">
                            {{ $remaining_title }}
                            <span class="rt-text-danger">{{ $last_word }}</span>
                        </h1>
                        <p class="text-center in-subtitle-16px mb-26px max-w-640px mx-auto">{{ $RestaurantBanner->description }}</p>
                        <div class="d-flex align-items-center justify-content-center gap-12px flex-wrap">
                            <a href="{{ route('listing.view', ['type' => 'restaurant', 'view' => 'grid']) }}" class="btn rt-btn-danger">{{ get_phrase('View Menu') }}</a>
                            <a href="{{ route('listing.view', ['type' => 'restaurant', 'view' => 'grid']) }}" class="btn rt-btn-outline-danger">{{ get_phrase('Book A Table') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!-- Start Restaurent Deal Area -->
    <section>
        <div class="container">
            <div class="row mb-60px">
                <div class="col-12">
                    <div class="rt-bgimg-card w-100 text-center" style="background: url('{{ isset($RestaurantExclusive->image) && $RestaurantExclusive->image ? asset('uploads/homepage/restaurant/' . $RestaurantExclusive->image) : asset('assets/frontend/images/restaurant/rt-deal-bg.webp') }}');">
                        <h2 class="text-center text-white mb-12px fi-title-30px">{{ $RestaurantExclusive->title }}</h2>
                        <h4 class="text-center text-white mb-30px fi-title-26px">{{ $RestaurantExclusive->description }}</h4>
                        <a href="{{ route('listing.view', ['type' => 'restaurant', 'view' => 'grid']) }}" class="btn rt2-btn-danger">{{ get_phrase('View More') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Restaurent Deal Area -->

    <!-- Start Country Restaurant Area -->
    <section>
        <div class="container">
            <div class="row g-4 mb-100px">
                @foreach ($countries as $country)
                    <div class="col-md-6">
                        <a href="{{ route('ListingsFilter') }}?type=restaurant&view=grid&country={{ $country->id }}" class="rt-img-card">
                            <img class="h-250px" src="{{ get_all_image('country-thumbnails/' . $country->thumbnail) }}" alt="...">
                            <p class="rt-img-card-country">{{ $country->name }}</p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End Country Restaurant Area -->

    <!-- Start Popular Restaurant Area -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="fi-title-36px text-center mb-30px">{{ get_phrase('Popular Restaurant') }}</h1>
                </div>
            </div>
            <div class="row g-4">
                @foreach ($top_listings->where('is_popular', 'featured')->sortByDesc('created_at')->take(4) as $listing)
                    <!-- Single Card -->
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="single-grid-card">
                            <!-- Banner Slider -->
                            <div class="grid-slider-area">
                                @php
                                    $images = json_decode($listing->image);
                                    $image = isset($images[0]) ? $images[0] : null;
                                    $claimStatus = App\Models\ClaimedListing::where('listing_id', $listing->id)->where('listing_type', 'restaurant')->first(); 
                                @endphp
                                <a class="w-100 h-100" href="{{ route('listing.details', ['type' => 'restaurant', 'id' => $listing->id, 'slug' => slugify($listing->title)]) }}">
                                    <img class="card-item-image" src="{{ get_all_image('listing-images/' . $image) }}">
                                </a>
                                <p class="card-light-text theme-light capitalize">{{ $listing->is_popular }}</p>
                                @php
                                    $is_in_wishlist = check_wishlist_status($listing->id, $listing->type);
                                @endphp
                                <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-title="{{ $is_in_wishlist ? get_phrase('Remove from Wishlist') : get_phrase('Add to Wishlist') }}" onclick="updateWishlist(this, '{{ $listing->id }}')" class="grid-list-bookmark white-bookmark {{ $is_in_wishlist ? 'active' : '' }}">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.4361 3C12.7326 3.01162 12.0445 3.22023 11.4411 3.60475C10.8378 3.98927 10.3407 4.53609 10 5.18999C9.65929 4.53609 9.16217 3.98927 8.55886 3.60475C7.95554 3.22023 7.26738 3.01162 6.56389 3C5.44243 3.05176 4.38583 3.57288 3.62494 4.44953C2.86404 5.32617 2.4607 6.48707 2.50302 7.67861C2.50302 10.6961 5.49307 13.9917 8.00081 16.2262C8.56072 16.726 9.26864 17 10 17C10.7314 17 11.4393 16.726 11.9992 16.2262C14.5069 13.9917 17.497 10.6961 17.497 7.67861C17.5393 6.48707 17.136 5.32617 16.3751 4.44953C15.6142 3.57288 14.5576 3.05176 13.4361 3Z" fill="#6C1CFF" />
                                    </svg>
                                </a>
                            </div>
                            <a href="{{ route('listing.details', ['type' => 'restaurant', 'id' => $listing->id, 'slug' => slugify($listing->title)]) }}" class="restaurant-grid-link">
                                <div class="restaurent-grid-details">
                                    <div class="restgrid-title-location">
                                        <h3 class="title">
                                            @if(isset($claimStatus) && $claimStatus->status == 1) 
                                            <span data-bs-toggle="tooltip" 
                                            data-bs-title=" {{ get_phrase('This listing is verified') }}">
                                            <svg fill="none" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><linearGradient id="paint0_linear_16_1334" gradientUnits="userSpaceOnUse" x1="12" x2="12" y1="-1.2" y2="25.2"><stop offset="0" stop-color="#ce9ffc"/><stop offset=".979167" stop-color="#7367f0"/></linearGradient><path d="m3.783 2.826 8.217-1.826 8.217 1.826c.2221.04936.4207.17297.563.3504.1424.17744.22.39812.22.6256v9.987c-.0001.9877-.244 1.9602-.7101 2.831s-1.14 1.6131-1.9619 2.161l-6.328 4.219-6.328-4.219c-.82173-.5478-1.49554-1.2899-1.96165-2.1605-.46611-.8707-.71011-1.8429-.71035-2.8305v-9.988c.00004-.22748.07764-.44816.21999-.6256.14235-.17743.34095-.30104.56301-.3504zm8.217 10.674 2.939 1.545-.561-3.272 2.377-2.318-3.286-.478-1.469-2.977-1.47 2.977-3.285.478 2.377 2.318-.56 3.272z" fill="url(#paint0_linear_16_1334)"/></svg>
                                            </span>
                                            @endif
                                            {{ $listing->title }}</h3>
                                    </div>
                                    <div class="restgrid-price-rating d-flex align-items-center justify-content-between">
                                        <div class="location d-flex">
                                            <img src="{{ asset('assets/frontend/images/icons/location-red2-20.svg') }}" alt="">
                                            @php
                                                $city_name = App\Models\City::where('id', $listing->city)->first()->name;
                                                $country_name = App\Models\Country::where('id', $listing->country)->first()->name;
                                            @endphp
                                            <p class="info f-14"> {{ $city_name . ', ' . $country_name }} </p>
                                        </div>
                                        <div class="ratings d-flex align-items-center">
                                            <img src="{{ asset('assets/frontend/images/icons/star-yellow-16.svg') }}" alt="">
                                            @php
                                                $reviews_count = App\Models\Review::where('listing_id', $listing->id)->where('type', 'restaurant')->where('reply_id', null)->where('user_id', '!=', $listing->user_id)->count();
                                            @endphp
                                            <p class="rating">({{ $reviews_count }})</p>
                                        </div>
                                    </div>
                                    <ul class="restgrid-list-items d-flex align-items-center flex-wrap">
                                        <li>{{ get_phrase('Dine in') }}</li>
                                        <li>{{ get_phrase('Takeaway') }}</li>
                                        <li>{{ get_phrase('Delivery') }}</li>
                                    </ul>
                                </div>
                            </a>
                        </div>
                    </div>
                    <!-- Single Card -->
                @endforeach
                <div class="col-12">
                    <div class="mb-100px">
                        <a href="{{ route('listing.view', ['type' => 'restaurant', 'view' => 'grid']) }}" class="btn rt-btn-danger d-flex align-items-center gap-2 mx-auto">
                            <span>{{ get_phrase('View More') }}</span>
                            <img src="{{ asset('assets/frontend/images/icons/arrow-right-white-20.svg') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Popular Restaurant Area -->

    <!-- Start Explore Restaurant Area -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="fi-title-36px text-center mb-30px">{{ get_phrase('Explore Restaurant') }}</h1>
                </div>
            </div>
            <div class="row g-4 mb-100px">
                @foreach ($cities as $city)
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <a href="{{ route('ListingsFilter') }}?type=restaurant&view=grid&city={{ $city->id }}" class="rt2-img-card max-md-400px mx-auto mx-md-0">
                            <img src="{{ asset('uploads/city/' . $city->image) }}" alt="">
                            <p class="rt-card-total-restaurant"> {{ App\Models\RestaurantListing::where('city', $city->id)->count() }} {{ get_phrase('Restaurants') }}</p>
                            <h3 class="fi-title-26px fw-medium text-white rt-card-place-name">{{ $city->name }}</h3>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End Explore Restaurant Area -->

    <!-- Start Trending Restaurant Area -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="fi-title-36px text-center mb-30px">{{ get_phrase('Trending Restaurant') }}</h1>
                </div>
            </div>
            <div class="row g-4">
                @foreach ($top_listings->where('is_popular', 'trending')->sortByDesc('created_at')->take(4) as $listing)
                    <!-- Single Card -->
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="single-grid-card">
                            <!-- Banner Slider -->
                            <div class="grid-slider-area">
                                @php
                                    $images = json_decode($listing->image);
                                    $image = isset($images[0]) ? $images[0] : null;
                                    $claimStatus = App\Models\ClaimedListing::where('listing_id', $listing->id)->where('listing_type', 'restaurant')->first(); 
                                @endphp
                                <a class="w-100 h-100" href="{{ route('listing.details', ['type' => 'restaurant', 'id' => $listing->id, 'slug' => slugify($listing->title)]) }}">
                                    <img class="card-item-image" src="{{ get_all_image('listing-images/' . $image) }}">
                                </a>
                                <p class="card-light-text theme-light capitalize">{{ $listing->is_popular }}</p>
                                @php
                                    $is_in_wishlist = check_wishlist_status($listing->id, $listing->type);
                                @endphp
                                <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-title="{{ $is_in_wishlist ? get_phrase('Remove from Wishlist') : get_phrase('Add to Wishlist') }}" onclick="updateWishlist(this, '{{ $listing->id }}')" class="grid-list-bookmark white-bookmark {{ $is_in_wishlist ? 'active' : '' }}">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.4361 3C12.7326 3.01162 12.0445 3.22023 11.4411 3.60475C10.8378 3.98927 10.3407 4.53609 10 5.18999C9.65929 4.53609 9.16217 3.98927 8.55886 3.60475C7.95554 3.22023 7.26738 3.01162 6.56389 3C5.44243 3.05176 4.38583 3.57288 3.62494 4.44953C2.86404 5.32617 2.4607 6.48707 2.50302 7.67861C2.50302 10.6961 5.49307 13.9917 8.00081 16.2262C8.56072 16.726 9.26864 17 10 17C10.7314 17 11.4393 16.726 11.9992 16.2262C14.5069 13.9917 17.497 10.6961 17.497 7.67861C17.5393 6.48707 17.136 5.32617 16.3751 4.44953C15.6142 3.57288 14.5576 3.05176 13.4361 3Z" fill="#6C1CFF" />
                                    </svg>
                                </a>
                            </div>
                            <a href="{{ route('listing.details', ['type' => 'restaurant', 'id' => $listing->id, 'slug' => slugify($listing->title)]) }}" class="restaurant-grid-link">
                                <div class="restaurent-grid-details">
                                    <div class="restgrid-title-location">
                                        <h3 class="title">
                                            @if(isset($claimStatus) && $claimStatus->status == 1) 
                                            <span data-bs-toggle="tooltip" 
                                            data-bs-title=" {{ get_phrase('This listing is verified') }}">
                                            <svg fill="none" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><linearGradient id="paint0_linear_16_1334" gradientUnits="userSpaceOnUse" x1="12" x2="12" y1="-1.2" y2="25.2"><stop offset="0" stop-color="#ce9ffc"/><stop offset=".979167" stop-color="#7367f0"/></linearGradient><path d="m3.783 2.826 8.217-1.826 8.217 1.826c.2221.04936.4207.17297.563.3504.1424.17744.22.39812.22.6256v9.987c-.0001.9877-.244 1.9602-.7101 2.831s-1.14 1.6131-1.9619 2.161l-6.328 4.219-6.328-4.219c-.82173-.5478-1.49554-1.2899-1.96165-2.1605-.46611-.8707-.71011-1.8429-.71035-2.8305v-9.988c.00004-.22748.07764-.44816.21999-.6256.14235-.17743.34095-.30104.56301-.3504zm8.217 10.674 2.939 1.545-.561-3.272 2.377-2.318-3.286-.478-1.469-2.977-1.47 2.977-3.285.478 2.377 2.318-.56 3.272z" fill="url(#paint0_linear_16_1334)"/></svg>
                                            </span>
                                            @endif
                                            {{ $listing->title }}</h3>

                                    </div>
                                    <div class="restgrid-price-rating d-flex align-items-center justify-content-between">
                                        <div class="location d-flex">
                                            <img src="{{ asset('assets/frontend/images/icons/location-red2-20.svg') }}" alt="">
                                            @php
                                                $city_name = App\Models\City::where('id', $listing->city)->first()->name;
                                                $country_name = App\Models\Country::where('id', $listing->country)->first()->name;
                                            @endphp
                                            <p class="info f-14"> {{ $city_name . ', ' . $country_name }} </p>
                                        </div>
                                        <div class="ratings d-flex align-items-center">
                                            <img src="{{ asset('assets/frontend/images/icons/star-yellow-16.svg') }}" alt="">
                                            @php
                                                $reviews_count = App\Models\Review::where('listing_id', $listing->id)->where('type', 'restaurant')->where('reply_id', null)->where('user_id', '!=', $listing->user_id)->count();
                                            @endphp
                                            <p class="rating">({{ $reviews_count }})</p>
                                        </div>
                                    </div>
                                    <ul class="restgrid-list-items d-flex align-items-center flex-wrap">
                                        <li>{{ get_phrase('Dine in') }}</li>
                                        <li>{{ get_phrase('Takeaway') }}</li>
                                        <li>{{ get_phrase('Delivery') }}</li>
                                    </ul>
                                </div>
                            </a>
                        </div>
                    </div>
                    <!-- Single Card -->
                @endforeach

                <div class="col-12">
                    <div class="mb-100px">
                        <a href="{{ route('listing.view', ['type' => 'restaurant', 'view' => 'grid']) }}" class="btn rt-btn-danger d-flex align-items-center gap-2 mx-auto">
                            <span>{{ get_phrase('View More') }}</span>
                            <img src="{{ asset('assets/frontend/images/icons/arrow-right-white-20.svg') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Trending Restaurant Area -->

    <!-- Start Discount Area -->
    <section>
        <div class="container">
            <div class="row justify-content-center mb-100px">
                <div class="col-xl-10">
                    <div class="rt-dark-card">
                        <div class="d-flex flex-column align-items-center align-items-sm-start">
                            <h5 class="fi-title-24px text-white mb-2">{{ $RestaurantDiscount->title }}</h5>
                            <h1 class="fi-title-48px text-white mb-2">{{ $RestaurantDiscount->description }}</h1>
                            <a href="{{ route('listing.view', ['type' => 'restaurant', 'view' => 'grid']) }}" class="btn rt-btn-outline-white">{{ get_phrase('Book A Table') }}</a>
                        </div>
                        <div class="rt-dark-cark-img">
                            @if (!empty($RestaurantDiscount->image))
                                <img src="{{ asset('uploads/homepage/restaurant/' . $RestaurantDiscount->image) }}" alt="">
                            @else
                                <img src="{{ asset('assets/frontend/images/restaurent/dark-card-img.svg') }}" alt="..">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Discount Area -->

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
                        type: 'restaurant',
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
