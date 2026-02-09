@extends('layouts.frontend')
@push('title', get_phrase('Car Directory Listing'))
@push('meta')@endpush
@push('css')
    <script src="{{ asset('assets/frontend/js/mixitup.min.js') }}"></script>
    <style>
        .header-section{
            box-shadow: none !important;
        }
    </style>
@endpush
@section('frontend_layout')
    @php
        $CarBanner = json_decode(get_homepage_settings('CarBanner') ?? '{}');

        $car_types = App\Models\Amenities::where('type', 'car')->where('identifier', 'car_type')->get();
        $models = App\Models\Amenities::where('type', 'car')->where('identifier', 'model')->get();
        $brands = App\Models\Amenities::where('type', 'car')->where('identifier', 'brand')->get();
        $colors = App\Models\Amenities::where('type', 'car')->where('identifier', 'exterior_color')->get();
        $years = App\Models\CarListing::distinct()->pluck('year');

    @endphp
    <!-- Banner Area Start -->
    <section class="car-hero-section mb-100px">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="car-hero-details">
                        <h1 class="ex-title-100px text-center">{{ $CarBanner->title ?? '' }}</h1>
                        <p class="car-hero-subtitle text-center max-w-559px mx-auto">{{ $CarBanner->description ?? '' }}</p>
                        <div class="car-search-filters">

                            <form id="filter-form" action="{{ route('ListingsFilter') }}" method="get">
                                <input type="hidden" name="type" value="car">
                                <input type="hidden" name="view" value="grid">
                                <div class="car-search-filters-wrap">
                                    <div class="car-filter-selects">
                                        <select class="at-nice-select ca-select-white mt-2px" name="car_type">
                                            <option value="all">{{ get_phrase('Type') }}</option>
                                            @foreach ($car_types as $type)
                                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                        <select class="at-nice-select ca-select-white mt-2px" name="brand">
                                            <option value="all">{{ get_phrase('Brands') }}</option>
                                            @foreach ($brands as $index => $brand)
                                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                            @endforeach
                                        </select>

                                        <select class="at-nice-select ca-select-white mt-2px" name="model">
                                            <option value="all">{{ get_phrase('Model') }}</option>
                                            @foreach ($models as $model)
                                                <option value="{{ $model->id }}">{{ $model->name }}</option>
                                            @endforeach
                                        </select>

                                        <select class="at-nice-select ca-select-white mt-2px" name="year">
                                            <option value="all">{{ get_phrase('Year') }}</option>
                                            @foreach ($years as $year)
                                                <option value="{{ $year }}">{{ $year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn ca-btn-white d-flex align-items-center gap-2 justify-content-center">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.58317 18.1251C4.87484 18.1251 1.0415 14.2917 1.0415 9.58342C1.0415 4.87508 4.87484 1.04175 9.58317 1.04175C14.2915 1.04175 18.1248 4.87508 18.1248 9.58342C18.1248 14.2917 14.2915 18.1251 9.58317 18.1251ZM9.58317 2.29175C5.55817 2.29175 2.2915 5.56675 2.2915 9.58342C2.2915 13.6001 5.55817 16.8751 9.58317 16.8751C13.6082 16.8751 16.8748 13.6001 16.8748 9.58342C16.8748 5.56675 13.6082 2.29175 9.58317 2.29175Z" fill="#0F0B0B" />
                                            <path d="M18.3335 18.9583C18.1752 18.9583 18.0169 18.9 17.8919 18.775L16.2252 17.1083C15.9835 16.8666 15.9835 16.4666 16.2252 16.225C16.4669 15.9833 16.8669 15.9833 17.1085 16.225L18.7752 17.8916C19.0169 18.1333 19.0169 18.5333 18.7752 18.775C18.6502 18.9 18.4919 18.9583 18.3335 18.9583Z" fill="#0F0B0B" />
                                        </svg>
                                        <span>{{ get_phrase('Search Cars') }}</span>
                                    </button>
                                </div>
                            </form>

                        </div>
                        <div class="car-hero-banner">
                            @if (isset($CarBanner->image))
                                <img src="{{ asset('uploads/homepage/car/' . $CarBanner->image) }}" alt="">
                            @else
                                <img src="{{ asset('assets/frontend/images/car/car-hero-car.webp') }}" alt="car">
                            @endif
                            <div class="ca-hero-happy-customers d-flex align-items-center gap-14px">
                                @php
                                    $reviewList = App\Models\Review::where('type', 'car')->whereNull('reply_id')->get()->unique('user_id');
                                    $totalReviews = App\Models\Review::where('type', 'car')->where('reply_id', null)->count();
                                    $averageRating = App\Models\Review::where('type', 'car')->where('reply_id', null)->avg('rating');
                                @endphp
                                <ul class="ca-happy-customer-wrap">
                                    @foreach ($reviewList as $review)
                                        @php
                                            $users = App\Models\User::find($review->user_id);
                                        @endphp
                                        @if ($users)
                                            <li class="image-circle-52px">
                                                <img src="{{ get_all_image('users/' . $users->image) }}" alt="">
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>

                                <div>
                                    <h5 class="al-title-18px mb-12px">{{ get_phrase('Our Happy Customers') }}</h5>
                                    <div class="d-flex align-items-center gap-1">
                                        <img src="{{ asset('assets/frontend/images/icons/star-black-18.5.svg') }}" alt="star">
                                        <p class="ca-rating-review">
                                            <span>{{ number_format($averageRating, 1) }}</span>
                                            ({{ $totalReviews }} {{ get_phrase('Reviews') }})
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Area Start -->


    <!-- Start Latest Vehicles Area -->
    <section>
        <div class="container">
            <div class="row mb-30px">
                <div class="col-12">
                    <h1 class="ex-title-30px text-uppercase text-center">{{ get_phrase('Latest Vehicles on Sale') }}</h1>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex gap-14px justify-content-center flex-wrap gap-6">
                        @php
                            $parent_categories = App\Models\Category::where('type', 'car')->where('parent', 0)->orderBy('id', 'desc')->get();
                        @endphp
                        <button type="button" data-filter="all" class="btn car-filter-btn mixitup-control-active">{{ get_phrase('All') }}</button>
                        @foreach ($parent_categories as $category)
                            <button type="button" data-filter=".{{ 'category-' . $category->id }}" class="btn car-filter-btn">
                                {{ $category->name }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="mixitup row gx-28px gy-30px mb-30px">
                <!-- Single Card -->
                @foreach ($top_listings->sortByDesc('created_at') as $listing)
                    @php
                        $is_in_wishlist = check_wishlist_status($listing->id, $listing->type);
                        $claimStatus = App\Models\ClaimedListing::where('listing_id', $listing->id)->where('listing_type', 'car')->first(); 
                    @endphp
                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 mix {{ 'category-' . $listing->category }}">
                        <div class="single-grid-card Cgray">
                            <!-- Banner Slider -->
                            <div class="grid-slider-area">
                                @php
                                    $images = json_decode($listing->image);
                                    $image = isset($images[0]) ? $images[0] : null;
                                @endphp
                                <a class="w-100 h-100" href="{{route('listing.details',['type'=>'car', 'id'=>$listing->id, 'slug'=>slugify($listing->title)])}}">
                                    <img class="card-item-image" src="{{ get_all_image('listing-images/' . $image) }}">
                                </a>
                                <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-title="{{ $is_in_wishlist ? get_phrase('Remove from Wishlist') : get_phrase('Add to Wishlist') }}" onclick="updateWishlist(this, '{{ $listing->id }}')" class="grid-list-bookmark ca-bookmark-hover gray-bookmark2 {{ $is_in_wishlist ? 'active' : '' }}">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.4361 3C12.7326 3.01162 12.0445 3.22023 11.4411 3.60475C10.8378 3.98927 10.3407 4.53609 10 5.18999C9.65929 4.53609 9.16217 3.98927 8.55886 3.60475C7.95554 3.22023 7.26738 3.01162 6.56389 3C5.44243 3.05176 4.38583 3.57288 3.62494 4.44953C2.86404 5.32617 2.4607 6.48707 2.50302 7.67861C2.50302 10.6961 5.49307 13.9917 8.00081 16.2262C8.56072 16.726 9.26864 17 10 17C10.7314 17 11.4393 16.726 11.9992 16.2262C14.5069 13.9917 17.497 10.6961 17.497 7.67861C17.5393 6.48707 17.136 5.32617 16.3751 4.44953C15.6142 3.57288 14.5576 3.05176 13.4361 3Z" fill="#6C1CFF" />
                                    </svg>
                                </a>
                            </div>
                            <div class="car-grid-details position-relative">
                                <div class="cargrid-title-area">
                                    <a href="{{ route('listing.details', ['type' => 'car', 'id' => $listing->id, 'slug' => slugify($listing->title)]) }}" class="title">
                                        @if(isset($claimStatus) && $claimStatus->status == 1) 
                                        <span data-bs-toggle="tooltip" 
                                        data-bs-title=" {{ get_phrase('This listing is verified') }}">
                                            <svg fill="none" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><linearGradient id="paint0_linear_16_1334" gradientUnits="userSpaceOnUse" x1="12" x2="12" y1="-1.2" y2="25.2"><stop offset="0" stop-color="#ce9ffc"/><stop offset=".979167" stop-color="#7367f0"/></linearGradient><path d="m3.783 2.826 8.217-1.826 8.217 1.826c.2221.04936.4207.17297.563.3504.1424.17744.22.39812.22.6256v9.987c-.0001.9877-.244 1.9602-.7101 2.831s-1.14 1.6131-1.9619 2.161l-6.328 4.219-6.328-4.219c-.82173-.5478-1.49554-1.2899-1.96165-2.1605-.46611-.8707-.71011-1.8429-.71035-2.8305v-9.988c.00004-.22748.07764-.44816.21999-.6256.14235-.17743.34095-.30104.56301-.3504zm8.217 10.674 2.939 1.545-.561-3.272 2.377-2.318-3.286-.478-1.469-2.977-1.47 2.977-3.285.478 2.377 2.318-.56 3.272z" fill="url(#paint0_linear_16_1334)"/></svg>
                                        </span>
                                        @endif
                                        {{ $listing->title }}</a>
                                    <p class="info">{{ $listing->sub_title }}</p>
                                </div>
                                <ul class="cargrid-list-items d-flex align-items-center flex-wrap">
                                    <li>
                                        <img src="{{ asset('assets/frontend/images/icons/engine-black-24.svg') }}" alt="">
                                        <p class="info"> {{ App\Models\Amenities::where('id', $listing->engine_size)->first()->name }} </p>
                                    </li>
                                    <li>
                                        <img src="{{ asset('assets/frontend/images/icons/mileage-black-24.svg') }}" alt="">
                                        <p class="info"> {{ $listing->mileage }} </p>
                                    </li>
                                    <li>
                                        <img src="{{ asset('assets/frontend/images/icons/petrol-black-24.svg') }}" alt="">
                                        <p class="info"> {{ App\Models\Amenities::where('id', $listing->fuel_type)->first()->name }} </p>
                                    </li>
                                </ul>
                                <div class="cargrid-price-view d-flex align-items-end justify-content-between flex-wrap">
                                    <div class="prices">
                                        @if (!empty($listing->discount_price))
                                            <p class="new-price">{{ currency($listing->discount_price) }}</p>
                                            <p class="old-price">{{ currency($listing->price) }}</p>
                                        @elseif(!empty($listing->price))
                                            <p class="new-price">{{ currency($listing->price) }}</p>
                                        @endif
                                    </div>
                                    <a href="{{ route('listing.details', ['type' => 'car', 'id' => $listing->id, 'slug' => slugify($listing->title)]) }}" class="btn ca-btn-dark ca-btn-sm stretched-link">{{ get_phrase('See Details') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- Single Card -->
            </div>
            <div class="row mb-100px">
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('listing.view', ['type' => 'car', 'view' => 'grid']) }}" class="btn ca-btn-outline-dark">{{ get_phrase('View More') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Latest Vehicles Area -->


    <!-- Start Featured Vehicles Area -->
    <section>
        <div class="container">
            <div class="row mb-30px">
                <div class="col-12">
                    <h1 class="ex-title-30px text-uppercase text-center">{{ get_phrase('FEATURED VEHICLES') }}</h1>
                </div>
            </div>
            <div class="row mb-30px g-28px">
                <!-- Single Card -->
                @php
                    $featuredListings = $top_listings->where('is_popular', 'featured')->sortByDesc('created_at')->take(4);
                @endphp
                @foreach ($featuredListings->sortByDesc('created_at') as $listing)
                    @php
                        $is_in_wishlist = check_wishlist_status($listing->id, $listing->type);
                        $claimStatus = App\Models\ClaimedListing::where('listing_id', $listing->id)->where('listing_type', 'car')->first(); 
                    @endphp
                    @if ($listing->is_popular == 'featured')
                        @php
                            $images = json_decode($listing->image) ?? [];
                        @endphp
                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                            <div class="single-grid-card Cgray">
                                <!-- Banner Slider -->
                                <div class="grid-slider-area ">
                                    @php
                                        $images = json_decode($listing->image);
                                        $image = isset($images[0]) ? $images[0] : null;
                                    @endphp
                                    <a class="w-100 h-100" href="{{route('listing.details',['type'=>'car', 'id'=>$listing->id, 'slug'=>slugify($listing->title)])}}">
                                        <img class="card-item-image" src="{{ get_all_image('listing-images/' . $image) }}">
                                    </a>
                                    <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-title="{{ $is_in_wishlist ? get_phrase('Remove from Wishlist') : get_phrase('Add to Wishlist') }}" onclick="updateWishlist(this, '{{ $listing->id }}')" class="grid-list-bookmark ca-bookmark-hover gray-bookmark2 {{ $is_in_wishlist ? 'active' : '' }}">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.4361 3C12.7326 3.01162 12.0445 3.22023 11.4411 3.60475C10.8378 3.98927 10.3407 4.53609 10 5.18999C9.65929 4.53609 9.16217 3.98927 8.55886 3.60475C7.95554 3.22023 7.26738 3.01162 6.56389 3C5.44243 3.05176 4.38583 3.57288 3.62494 4.44953C2.86404 5.32617 2.4607 6.48707 2.50302 7.67861C2.50302 10.6961 5.49307 13.9917 8.00081 16.2262C8.56072 16.726 9.26864 17 10 17C10.7314 17 11.4393 16.726 11.9992 16.2262C14.5069 13.9917 17.497 10.6961 17.497 7.67861C17.5393 6.48707 17.136 5.32617 16.3751 4.44953C15.6142 3.57288 14.5576 3.05176 13.4361 3Z" fill="#6C1CFF" />
                                        </svg>
                                    </a>
                                </div>
                                <div class="car-grid-details position-relative">
                                    <div class="cargrid-title-area">
                                        <a href="{{ route('listing.details', ['type' => 'car', 'id' => $listing->id, 'slug' => slugify($listing->title)]) }}" class="title">
                                            @if(isset($claimStatus) && $claimStatus->status == 1) 
                                            <span data-bs-toggle="tooltip" 
                                            data-bs-title=" {{ get_phrase('This listing is verified') }}">
                                                <svg fill="none" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><linearGradient id="paint0_linear_16_1334" gradientUnits="userSpaceOnUse" x1="12" x2="12" y1="-1.2" y2="25.2"><stop offset="0" stop-color="#ce9ffc"/><stop offset=".979167" stop-color="#7367f0"/></linearGradient><path d="m3.783 2.826 8.217-1.826 8.217 1.826c.2221.04936.4207.17297.563.3504.1424.17744.22.39812.22.6256v9.987c-.0001.9877-.244 1.9602-.7101 2.831s-1.14 1.6131-1.9619 2.161l-6.328 4.219-6.328-4.219c-.82173-.5478-1.49554-1.2899-1.96165-2.1605-.46611-.8707-.71011-1.8429-.71035-2.8305v-9.988c.00004-.22748.07764-.44816.21999-.6256.14235-.17743.34095-.30104.56301-.3504zm8.217 10.674 2.939 1.545-.561-3.272 2.377-2.318-3.286-.478-1.469-2.977-1.47 2.977-3.285.478 2.377 2.318-.56 3.272z" fill="url(#paint0_linear_16_1334)"/></svg>
                                            </span>
                                            @endif
                                            {{ $listing->title }}
                                        </a>
                                        <p class="info">{{ $listing->sub_title }}</p>
                                    </div>
                                    <ul class="cargrid-list-items d-flex align-items-center flex-wrap">
                                        <li>
                                            <img src="{{ asset('assets/frontend/images/icons/engine-black-24.svg') }}" alt="">
                                            <p class="info"> {{ App\Models\Amenities::where('id', $listing->engine_size)->first()->name }} </p>
                                        </li>
                                        <li>
                                            <img src="{{ asset('assets/frontend/images/icons/mileage-black-24.svg') }}" alt="">
                                            <p class="info"> {{ $listing->mileage }} </p>
                                        </li>
                                        <li>
                                            <img src="{{ asset('assets/frontend/images/icons/petrol-black-24.svg') }}" alt="">
                                            <p class="info"> {{ App\Models\Amenities::where('id', $listing->fuel_type)->first()->name }} </p>
                                        </li>
                                    </ul>
                                    <div class="cargrid-price-view d-flex align-items-end justify-content-between flex-wrap">
                                        <div class="prices">
                                            @if (!empty($listing->discount_price))
                                                <p class="new-price">{{ currency($listing->discount_price) }}</p>
                                                <p class="old-price">{{ currency($listing->price) }}</p>
                                            @elseif(!empty($listing->price))
                                                <p class="new-price">{{ currency($listing->price) }}</p>
                                            @endif
                                        </div>
                                        <a href="{{ route('listing.details', ['type' => 'car', 'id' => $listing->id, 'slug' => slugify($listing->title)]) }}" class="btn ca-btn-dark ca-btn-sm stretched-link">{{ get_phrase('See Details') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                <!-- Single Card -->
            </div>
            <div class="row mb-100px">
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('listing.view', ['type' => 'car', 'view' => 'grid']) }}" class="btn ca-btn-outline-dark">{{ get_phrase('View More') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Featured Vehicles Area -->


    <!-- Start Top Vehicles Area -->
    <section>
        <div class="container">
            <div class="row mb-30px">
                <div class="col-12">
                    <h1 class="ex-title-30px text-uppercase text-center">{{ get_phrase('Top Cars') }}</h1>
                </div>
            </div>
            <div class="row mb-30px g-28px">
                <!-- Single Card -->
                @php
                    $topListings = $top_listings->where('is_popular', 'top')->sortByDesc('created_at')->take(4);
                @endphp
                @foreach ($topListings->sortByDesc('created_at') as $listing)
                    @php
                        $is_in_wishlist = check_wishlist_status($listing->id, $listing->type);
                        $claimStatus = App\Models\ClaimedListing::where('listing_id', $listing->id)->where('listing_type', 'car')->first();  
                    @endphp
                    @if ($listing->is_popular == 'top')
                        @php
                            $images = json_decode($listing->image) ?? [];
                        @endphp
                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                            <div class="single-grid-card Cgray">
                                <!-- Banner Slider -->
                                <div class="grid-slider-area">
                                    @php
                                        $images = json_decode($listing->image);
                                        $image = isset($images[0]) ? $images[0] : null;
                                    @endphp
                                    <a class="w-100 h-100" href="{{route('listing.details',['type'=>'car', 'id'=>$listing->id, 'slug'=>slugify($listing->title)])}}">
                                        <img class="card-item-image" src="{{ get_all_image('listing-images/' . $image) }}">
                                    </a>
                                    <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-title="{{ $is_in_wishlist ? get_phrase('Remove from Wishlist') : get_phrase('Add to Wishlist') }}" onclick="updateWishlist(this, '{{ $listing->id }}')" class="grid-list-bookmark ca-bookmark-hover gray-bookmark2 {{ $is_in_wishlist ? 'active' : '' }}">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.4361 3C12.7326 3.01162 12.0445 3.22023 11.4411 3.60475C10.8378 3.98927 10.3407 4.53609 10 5.18999C9.65929 4.53609 9.16217 3.98927 8.55886 3.60475C7.95554 3.22023 7.26738 3.01162 6.56389 3C5.44243 3.05176 4.38583 3.57288 3.62494 4.44953C2.86404 5.32617 2.4607 6.48707 2.50302 7.67861C2.50302 10.6961 5.49307 13.9917 8.00081 16.2262C8.56072 16.726 9.26864 17 10 17C10.7314 17 11.4393 16.726 11.9992 16.2262C14.5069 13.9917 17.497 10.6961 17.497 7.67861C17.5393 6.48707 17.136 5.32617 16.3751 4.44953C15.6142 3.57288 14.5576 3.05176 13.4361 3Z" fill="#6C1CFF"></path>
                                        </svg>
                                    </a>
                                </div>
                                <div class="car-grid-details position-relative">
                                    <div class="cargrid-title-area">
                                        <a href="{{ route('listing.details', ['type' => 'car', 'id' => $listing->id, 'slug' => slugify($listing->title)]) }}" class="title">
                                            @if(isset($claimStatus) && $claimStatus->status == 1) 
                                            <span data-bs-toggle="tooltip" 
                                            data-bs-title=" {{ get_phrase('This listing is verified') }}">
                                                <svg fill="none" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><linearGradient id="paint0_linear_16_1334" gradientUnits="userSpaceOnUse" x1="12" x2="12" y1="-1.2" y2="25.2"><stop offset="0" stop-color="#ce9ffc"/><stop offset=".979167" stop-color="#7367f0"/></linearGradient><path d="m3.783 2.826 8.217-1.826 8.217 1.826c.2221.04936.4207.17297.563.3504.1424.17744.22.39812.22.6256v9.987c-.0001.9877-.244 1.9602-.7101 2.831s-1.14 1.6131-1.9619 2.161l-6.328 4.219-6.328-4.219c-.82173-.5478-1.49554-1.2899-1.96165-2.1605-.46611-.8707-.71011-1.8429-.71035-2.8305v-9.988c.00004-.22748.07764-.44816.21999-.6256.14235-.17743.34095-.30104.56301-.3504zm8.217 10.674 2.939 1.545-.561-3.272 2.377-2.318-3.286-.478-1.469-2.977-1.47 2.977-3.285.478 2.377 2.318-.56 3.272z" fill="url(#paint0_linear_16_1334)"/></svg>
                                            </span>
                                            @endif
                                            {{ $listing->title }}</a>
                                        <p class="info">{{ $listing->sub_title }}</p>
                                    </div>
                                    <ul class="cargrid-list-items d-flex align-items-center flex-wrap">
                                        <li>
                                            <img src="{{ asset('assets/frontend/images/icons/engine-black-24.svg') }}" alt="">
                                            <p class="info"> {{ App\Models\Amenities::where('id', $listing->engine_size)->first()->name }} </p>
                                        </li>
                                        <li>
                                            <img src="{{ asset('assets/frontend/images/icons/mileage-black-24.svg') }}" alt="">
                                            <p class="info"> {{ $listing->mileage }} </p>
                                        </li>
                                        <li>
                                            <img src="{{ asset('assets/frontend/images/icons/petrol-black-24.svg') }}" alt="">
                                            <p class="info"> {{ App\Models\Amenities::where('id', $listing->fuel_type)->first()->name }} </p>
                                        </li>
                                    </ul>
                                    <div class="cargrid-price-view d-flex align-items-end justify-content-between flex-wrap">
                                        <div class="prices">
                                           @if (!empty($listing->discount_price))
                                                <p class="new-price">{{ currency($listing->discount_price) }}</p>
                                                <p class="old-price">{{ currency($listing->price) }}</p>
                                            @elseif(!empty($listing->price))
                                                <p class="new-price">{{ currency($listing->price) }}</p>
                                            @endif
                                        </div>
                                        <a href="{{ route('listing.details', ['type' => 'car', 'id' => $listing->id, 'slug' => slugify($listing->title)]) }}" class="btn ca-btn-dark ca-btn-sm stretched-link">{{ get_phrase('See Details') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                <!-- Single Card -->
            </div>
            <div class="row mb-100px">
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('listing.view', ['type' => 'car', 'view' => 'grid']) }}" class="btn ca-btn-outline-dark">{{ get_phrase('View More') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Top Vehicles Area -->

    <!-- Start Discount Area -->
    <section>
        <div class="container">
            <div class="row mb-100px">
                <div class="col-12">
                    <?php
                    // Retrieve and decode the JSON description
                    $CarMotion = json_decode(get_homepage_settings('CarMotion') ?? '{}');
                    $description = $CarMotion->description ?? '';
                    $words = explode(' ', $description);
                    if (count($words) >= 3) {
                        $words[2] = '<span class="ca-text-red">' . htmlspecialchars($words[2]) . '</span>';
                    }
                    $modifiedDescription = implode(' ', $words);
                    ?>
                    <div class="car-discount-area" style="background-image: url('{{ isset($CarMotion->image) && $CarMotion->image ? asset('uploads/homepage/car/' . $CarMotion->image) : asset('assets/frontend/images/car/car-discount-banner.webp') }}');">
                        <div class="car-discount-title-wrap">
                            <p class="ca-discount-subtitle">{{ $CarMotion->title ?? '' }}</p>
                            <h1 class="ca-discount-title">
                                {!! $modifiedDescription !!}
                            </h1>
                        </div>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('listing.view', ['type' => 'car', 'view' => 'grid']) }}" class="btn ca-btn-white">{{ get_phrase('Book Now') }}</a>
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
                        type: 'car',
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
