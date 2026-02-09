@extends('layouts.frontend')
@section('title', get_phrase('Car Listing Details'))
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/venobox.min.css') }}">
    <script src="{{ asset('assets/frontend/js/venobox.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/flatpickr.min.css') }}">
    <script src="{{ asset('assets/frontend/js/flatpickr.min.js') }}"></script>
@endpush
@section('frontend_layout')
    @php
        $listing_feature = App\Models\Listing_Feature::where('listing_id', $listing->id);
        $listing_specification = App\Models\Listing_Specification::where('listing_id', $listing->id);
    @endphp
    <!-- Start Bread Crumb  -->
    <section class="mt-20px mb-20px">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb atn-breadcrumb">
                            <li class="breadcrumb-item atn-breadcrumb-item"><a href="{{route('car.home')}}">{{ get_phrase('Home') }}</a></li>
                            <li class="breadcrumb-item atn-breadcrumb-item"><a href="{{route('listing.view', ['type' => 'car', 'view' => 'grid'])}}">{{ get_phrase('Cars') }}</a></li>
                            <li class="breadcrumb-item atn-breadcrumb-item active" aria-current="page">{{ get_phrase('Car Details') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Bread Crumb  -->
    <!-- Start Top Title and Back -->
    <section>
        <div class="container">
            <div class="row row-28 mb-24 align-items-center">
                <div class="col-xl-8 col-lg-7">
                    <div class="d-flex justify-content-between align-items-baseline detailstop-title-prices">
                        <div class="detailstop-title-location1">
                            <div class="detailstop-title1 d-flex align-items-center flex-wrap">
                                @php 
                                $claimStatus = App\Models\ClaimedListing::where('listing_id', $listing->id)->where('listing_type', 'car')->first();  
                               @endphp
                                <h1 class="title">
                                    @if(isset($claimStatus) && $claimStatus->status == 1) 
                                    <span data-bs-toggle="tooltip" 
                                    data-bs-title=" {{ get_phrase('This listing is verified') }}">
                                        <svg fill="none" height="34" viewBox="0 0 24 24" width="34" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><linearGradient id="paint0_linear_16_1334" gradientUnits="userSpaceOnUse" x1="12" x2="12" y1="-1.2" y2="25.2"><stop offset="0" stop-color="#ce9ffc"/><stop offset=".979167" stop-color="#7367f0"/></linearGradient><path d="m3.783 2.826 8.217-1.826 8.217 1.826c.2221.04936.4207.17297.563.3504.1424.17744.22.39812.22.6256v9.987c-.0001.9877-.244 1.9602-.7101 2.831s-1.14 1.6131-1.9619 2.161l-6.328 4.219-6.328-4.219c-.82173-.5478-1.49554-1.2899-1.96165-2.1605-.46611-.8707-.71011-1.8429-.71035-2.8305v-9.988c.00004-.22748.07764-.44816.21999-.6256.14235-.17743.34095-.30104.56301-.3504zm8.217 10.674 2.939 1.545-.561-3.272 2.377-2.318-3.286-.478-1.469-2.977-1.47 2.977-3.285.478 2.377 2.318-.56 3.272z" fill="url(#paint0_linear_16_1334)"/></svg>
                                    </span>
                                    @endif
                                    {{ $listing->title }}</h1>
                            </div>
                            <div class="location d-flex align-items-center">
                                <img src="{{ asset('assets/frontend/images/icons/location-gray-17.svg') }}" alt="location">
                                @php
                                    $city_name = App\Models\City::where('id', $listing->city)->first()->name;
                                    $country_name = App\Models\Country::where('id', $listing->country)->first()->name;
                                @endphp
                                <p class="name"> {{ $city_name . ', ' . $country_name }} </p>
                            </div>
                        </div>
                        <div class="car-detailstop-prices">
                            {{-- <p class="old-price mb-2">{{ currency($listing->price) }}</p>
                            <p class="new-price">{{ currency($listing->discount_price) }}</p>  --}}
                            @if(!empty($listing->discount_price))
                            <p class="new-price mb-2">{{ currency($listing->discount_price) }}</p>
                            <p class="old-price">{{ currency($listing->price) }}</p>
                            @elseif(!empty($listing->price))
                                <p class="new-price">{{ currency($listing->price) }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5">
                    <div class="detailstop-share-back d-flex align-items-center justify-content-end flex-wrap">
                        <a href="javascript:;" id="shareButton" class="save-share" data-bs-toggle="tooltip" data-bs-title="{{ get_phrase('Copy link to share') }}">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M18.7259 14.4443C18.0336 14.4448 17.3519 14.614 16.7395 14.9373C16.1271 15.2605 15.6025 15.728 15.2109 16.2995L9.25111 13.6056C9.67441 12.5823 9.67606 11.4329 9.25569 10.4084L15.2072 7.70071C15.7876 8.54103 16.6496 9.14527 17.6369 9.40383C18.6241 9.66239 19.6713 9.55815 20.5884 9.11001C21.5055 8.66187 22.2317 7.89952 22.6354 6.96124C23.0392 6.02296 23.0936 4.9709 22.7888 3.9959C22.4841 3.02089 21.8403 2.18752 20.9744 1.64695C20.1085 1.10638 19.0777 0.894424 18.069 1.04952C17.0603 1.20461 16.1406 1.71649 15.4766 2.4923C14.8126 3.26811 14.4484 4.25647 14.45 5.27809C14.4539 5.51989 14.4784 5.76092 14.5232 5.99855L8.19632 8.87673C7.58867 8.3068 6.82794 7.92697 6.00761 7.78391C5.18728 7.64084 4.34307 7.74078 3.5787 8.07144C2.81432 8.40211 2.16308 8.94909 1.70497 9.64519C1.24686 10.3413 1.00184 11.1562 1.00001 11.9898C0.998181 12.8234 1.23962 13.6394 1.69467 14.3375C2.14972 15.0356 2.79856 15.5854 3.56147 15.9195C4.32439 16.2535 5.16815 16.3571 5.9891 16.2177C6.81005 16.0782 7.57243 15.7017 8.18259 15.1345L14.526 18.0017C14.4819 18.2391 14.4577 18.4798 14.4536 18.7212C14.4535 19.5674 14.7039 20.3946 15.1734 21.0982C15.6429 21.8018 16.3103 22.3503 17.0911 22.6742C17.872 22.9981 18.7313 23.0829 19.5603 22.9178C20.3893 22.7528 21.1507 22.3454 21.7484 21.747C22.3461 21.1487 22.7531 20.3864 22.9179 19.5565C23.0828 18.7266 22.9981 17.8664 22.6745 17.0846C22.351 16.3029 21.8032 15.6348 21.1003 15.1648C20.3974 14.6949 19.5711 14.4441 18.7259 14.4443ZM18.7259 2.83346C19.2089 2.83328 19.6811 2.9765 20.0828 3.24501C20.4845 3.51352 20.7977 3.89526 20.9826 4.34194C21.1676 4.78862 21.2161 5.28018 21.122 5.75445C21.0278 6.22872 20.7953 6.66439 20.4539 7.00637C20.1124 7.34835 19.6773 7.58127 19.2036 7.67567C18.7298 7.77007 18.2388 7.72171 17.7925 7.53671C17.3463 7.35171 16.9648 7.03838 16.6965 6.63634C16.4281 6.23431 16.2849 5.76163 16.2849 5.27809C16.2854 4.63004 16.5427 4.00866 17.0003 3.55034C17.458 3.09201 18.0786 2.83419 18.7259 2.83346ZM5.29748 14.4443C4.81447 14.4445 4.34226 14.3012 3.94056 14.0327C3.53886 13.7642 3.22573 13.3825 3.04077 12.9358C2.8558 12.4891 2.80731 11.9976 2.90143 11.5233C2.99555 11.049 3.22805 10.6133 3.56953 10.2714C3.911 9.92939 4.34611 9.69647 4.81983 9.60207C5.29355 9.50767 5.78459 9.55603 6.23085 9.74103C6.67711 9.92603 7.05854 10.2394 7.32691 10.6414C7.59527 11.0434 7.73851 11.5161 7.73851 11.9997C7.73779 12.6476 7.4804 13.2689 7.02281 13.7271C6.56521 14.1854 5.94475 14.4433 5.29748 14.4443ZM18.7259 21.1658C18.2429 21.1658 17.7708 21.0225 17.3692 20.7539C16.9677 20.4852 16.6547 20.1034 16.4698 19.6567C16.285 19.21 16.2367 18.7185 16.3309 18.2443C16.4251 17.7701 16.6577 17.3345 16.9992 16.9926C17.3407 16.6507 17.7758 16.4179 18.2495 16.3236C18.7232 16.2292 19.2142 16.2777 19.6604 16.4627C20.1066 16.6477 20.488 16.961 20.7563 17.3631C21.0246 17.7651 21.1679 18.2377 21.1679 18.7212C21.1674 19.3694 20.9099 19.9909 20.4521 20.4493C19.9942 20.9076 19.3734 21.1654 18.7259 21.1658Z"
                                    fill="#7E7E89" />
                            </svg>
                        </a>
                        @php
                            $is_in_wishlist = check_wishlist_status($listing->id, $listing->type);
                        @endphp
                        <a href="javascript:;" data-bs-toggle="tooltip" data-bs-title="{{ $is_in_wishlist ? get_phrase('Remove from Wishlist') : get_phrase('Add to Wishlist') }}" class="save-share {{ $is_in_wishlist ? 'active' : '' }}" onclick="updateWishlist(this, '{{ $listing->id }}')">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 21.6501C11.69 21.6501 11.39 21.6101 11.14 21.5201C7.32 20.2101 1.25 15.5601 1.25 8.6901C1.25 5.1901 4.08 2.3501 7.56 2.3501C9.25 2.3501 10.83 3.0101 12 4.1901C13.17 3.0101 14.75 2.3501 16.44 2.3501C19.92 2.3501 22.75 5.2001 22.75 8.6901C22.75 15.5701 16.68 20.2101 12.86 21.5201C12.61 21.6101 12.31 21.6501 12 21.6501ZM7.56 3.8501C4.91 3.8501 2.75 6.0201 2.75 8.6901C2.75 15.5201 9.32 19.3201 11.63 20.1101C11.81 20.1701 12.2 20.1701 12.38 20.1101C14.68 19.3201 21.26 15.5301 21.26 8.6901C21.26 6.0201 19.1 3.8501 16.45 3.8501C14.93 3.8501 13.52 4.5601 12.61 5.7901C12.33 6.1701 11.69 6.1701 11.41 5.7901C10.48 4.5501 9.08 3.8501 7.56 3.8501Z" fill="#7E7E89" />
                            </svg>
                        </a>
                        <a href="{{ route('listing.view', ['type' => 'car', 'view' => 'grid']) }}" class="back-btn1">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.9752 15.6834C7.81686 15.6834 7.65853 15.6251 7.53353 15.5001L2.4752 10.4418C2.23353 10.2001 2.23353 9.8001 2.4752 9.55843L7.53353 4.5001C7.7752 4.25843 8.1752 4.25843 8.41686 4.5001C8.65853 4.74176 8.65853 5.14176 8.41686 5.38343L3.8002 10.0001L8.41686 14.6168C8.65853 14.8584 8.65853 15.2584 8.41686 15.5001C8.3002 15.6251 8.13353 15.6834 7.9752 15.6834Z" fill="#7E7E89" />
                                <path d="M17.0831 10.625H3.05811C2.71644 10.625 2.43311 10.3417 2.43311 10C2.43311 9.65833 2.71644 9.375 3.05811 9.375H17.0831C17.4248 9.375 17.7081 9.65833 17.7081 10C17.7081 10.3417 17.4248 10.625 17.0831 10.625Z" fill="#7E7E89" />
                            </svg>
                            <span>{{ get_phrase('Back to listing') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Top Title and Back -->

    <!-- Start Main Content Area -->
    <section>
        <div class="container">
            <div class="row row-28 mb-80px">
                <div class="col-xl-8 col-lg-7">
                    <!-- Banners -->
                    <div class="cardetails-banners-area mb-30px">
                        <div class="banner-top mb-12">
                            @foreach (json_decode($listing->image) as $key => $image)
                                @php
                                    if ($key >= 1) {
                                        break;
                                    }
                                @endphp
                                <img class="big-image-view" src="{{ get_all_image('listing-images/' . $image) }}" alt="">
                            @endforeach
                        </div>
                        <ul class="cardetails-banner-list">

                            @foreach (json_decode($listing->image) as $key => $image)
                                @php
                                    if ($key == 0) {
                                        continue;
                                    } elseif ($key > 3) {
                                        break;
                                    }
                                @endphp
                                @if ($key > 0 && $key <= 2)
                                    <li>
                                        <img class="small-image-view" src="{{ get_all_image('listing-images/' . $image) }}" alt="">
                                    </li>
                                @else
                                    <li class="last-child small-image-view">
                                        <img src="{{ get_all_image('listing-images/' . $image) }}" alt="">
                                        <a href="javascript:;" class="see-more" data-bs-toggle="modal" data-bs-target="#imageViewModal"> {{ get_phrase('View all photos') }}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <!-- Tab Overview -->
                    <div>
                        <!-- Tab Content -->
                        <div class="overview-tab-content mt-5">
                            <h3 class="title mb-16">{{ get_phrase('Overview') }}</h3>
                            <div class="overview-items-wrap d-flex justify-content-between flex-wrap">
                                <ul class="car-overview-items">
                                    <li class="car-overview-item">
                                        <div class="icon">
                                            <img src="{{ asset('assets/frontend/images/icons/car-32.svg') }}" alt="">
                                        </div>
                                        <div class="details">
                                            <p class="info">{{ get_phrase('Condition') }}</p>
                                            <p class="info-value capitalize">{{ $listing->status }}</p>
                                        </div>
                                    </li>
                                    <li class="car-overview-item">
                                        <div class="icon">
                                            <img src="{{ asset('assets/frontend/images/icons/drive-train-32.svg') }}" alt="">
                                        </div>
                                        <div class="details">
                                            <p class="info">{{ get_phrase('Drive train') }}</p>
                                            <p class="info-value">{{ App\Models\Amenities::where('id', $listing->drive_train)->first()->name }}</p>
                                        </div>
                                    </li>
                                    <li class="car-overview-item">
                                        <div class="icon">
                                            <img src="{{ asset('assets/frontend/images/icons/stock-32.svg') }}" alt="">
                                        </div>
                                        <div class="details">
                                            <p class="info">{{ get_phrase('Stock') }}</p>
                                            <p class="info-value">{{ $listing->stock }}</p>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="car-overview-items">
                                    <li class="car-overview-item">
                                        <div class="icon">
                                            <img src="{{ asset('assets/frontend/images/icons/transmission-32.svg') }}" alt="">
                                        </div>
                                        <div class="details">
                                            <p class="info">{{ get_phrase('Transmission') }}</p>
                                            <p class="info-value">{{ App\Models\Amenities::where('id', $listing->transmission)->first()->name }}</p>
                                        </div>
                                    </li>
                                    <li class="car-overview-item">
                                        <div class="icon">
                                            <img src="{{ asset('assets/frontend/images/icons/mileage-32.svg') }}" alt="">
                                        </div>
                                        <div class="details">
                                            <p class="info">{{ get_phrase('Mileage') }}</p>
                                            <p class="info-value">{{ $listing->mileage }}</p>
                                        </div>
                                    </li>
                                    <li class="car-overview-item">
                                        <div class="icon">
                                            <img src="{{ asset('assets/frontend/images/icons/interior-colo-32.svg') }}" alt="">
                                        </div>
                                        <div class="details">
                                            <p class="info">{{ get_phrase('Interior color') }}</p>
                                            <p class="info-value">{{ App\Models\Amenities::where('id', $listing->interior_color)->first()->name }}</p>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="car-overview-items">
                                    <li class="car-overview-item">
                                        <div class="icon">
                                            <img src="{{ asset('assets/frontend/images/icons/trim-car-32.svg') }}" alt="">
                                        </div>
                                        <div class="details">
                                            <p class="info">{{ get_phrase('Trim') }}</p>
                                            <p class="info-value">{{ App\Models\Amenities::where('id', $listing->trim)->first()->name }}</p>
                                        </div>
                                    </li>
                                    <li class="car-overview-item">
                                        <div class="icon">
                                            <img src="{{ asset('assets/frontend/images/icons/exterior-color-32.svg') }}" alt="">
                                        </div>
                                        <div class="details">
                                            <p class="info">{{ get_phrase('Exterior color') }}</p>
                                            <p class="info-value">{{ App\Models\Amenities::where('id', $listing->exterior_color)->first()->name }}</p>
                                        </div>
                                    </li>
                                    <li class="car-overview-item">
                                        <div class="icon">
                                            <img src="{{ asset('assets/frontend/images/icons/fuel-petrol-32.svg') }}" alt="">
                                        </div>
                                        <div class="details">
                                            <p class="info">{{ get_phrase('Fuel') }}</p>
                                            <p class="info-value">{{ App\Models\Amenities::where('id', $listing->fuel_type)->first()->name }}</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Description -->
                        <div class="at-details-description mt-5">
                            <h3 class="title mb-16">{{ get_phrase('Description') }}</h3>
                            <p class="info mb-16">
                                <span id="short-description" class="d-block">{{ Str::limit($listing->description, 400) }}</span>
                                <span id="full-description" class="d-none">{!! removeScripts($listing->description) !!}</span>
                            </p>
                            @if (strlen($listing->description) > 400)
                                <a href="javascript:void(0);" id="read-more-btn" class="icontext-link-btn cd-icontext-hover mt-3" onclick="toggleDescription()">
                                    <span>{{ get_phrase('Read More') }}</span>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M1.33217 8.33306H13.0562L9.52751 4.8044C9.46383 4.7429 9.41304 4.66933 9.37811 4.588C9.34317 4.50666 9.32478 4.41918 9.32401 4.33066C9.32324 4.24214 9.34011 4.15436 9.37363 4.07243C9.40715 3.9905 9.45665 3.91606 9.51924 3.85347C9.58184 3.79087 9.65627 3.74137 9.7382 3.70785C9.82014 3.67433 9.90792 3.65746 9.99644 3.65823C10.085 3.659 10.1724 3.67739 10.2538 3.71233C10.3351 3.74727 10.4087 3.79806 10.4702 3.86173L15.1368 8.5284C15.2618 8.65341 15.332 8.82295 15.332 8.99973C15.332 9.17651 15.2618 9.34604 15.1368 9.47106L10.4702 14.1377C10.3444 14.2592 10.176 14.3264 10.0012 14.3248C9.82644 14.3233 9.65923 14.2532 9.53563 14.1296C9.41202 14.006 9.34191 13.8388 9.34039 13.664C9.33887 13.4892 9.40607 13.3208 9.52751 13.1951L13.0562 9.6664H1.33217C1.15536 9.6664 0.985792 9.59616 0.860768 9.47113C0.735744 9.34611 0.665506 9.17654 0.665506 8.99973C0.665506 8.82292 0.735744 8.65335 0.860768 8.52832C0.985792 8.4033 1.15536 8.33306 1.33217 8.33306Z"
                                            fill="#242D3D"></path>
                                    </svg>
                                </a>
                            @endif
                        </div>
                          {{-- Shop Addon --}}
                          @if (addon_status('shop') == 1)
                                @php 
                                $shopItems = App\Models\Inventory::where('type', $listing->type)->where('listing_id', $listing->id)->where('availability', 1)->get();
                                $shopCategories = App\Models\InventoryCategory::where('type', $listing->type)->where('listing_id', $listing->id)->get();

                                @endphp
                            @if($shopItems && $shopItems->count() > 0)
                                @include('frontend.shop')
                            @endif
                        @endif
                        {{-- Shop Addon --}}
                         {{-- Service Selling Addon --}}
                            @if (addon_status('service_selling') == 1)
                                    @php 
                                        $serviceSselling = App\Models\ServiceSelling::where('type', $listing->type)->where('listing_id', $listing->id)->where('status', 1)->get();
                                        @endphp
                                    @if($serviceSselling && $serviceSselling->count() > 0)
                                        @include('frontend.service_selling.services')
                                    @endif
                            @endif
                        {{-- Service Selling Addon --}}
                        <!-- Features -->
                        <div class="car-details-features mt-5">
                            <h3 class="in-title3-24px mb-16">{{ get_phrase('Features') }}</h3>
                            <div class="cardetails-feature-area mb-16 d-flex justify-content-between flex-wrap">
                                @foreach ($listing_feature->where('feature_id', 0)->get() as $feature)
                                    <div class="cardetails-feature-wrap">
                                        <h6 class="sub-title mb-12">{{ $feature->title }}</h6>
                                        <ul class="cardetails-feature-list">
                                            @foreach (App\Models\Listing_Feature::where('listing_id', $listing->id)->where('feature_id', $feature->id)->get() as $value)
                                                <li>{{ $value->title }} </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- Specification -->
                        <div class="car-details-specification mt-5">
                            <h3 class="in-title3-24px mb-16">{{ get_phrase('Specification') }}</h3>
                            <div class="accordion specification-accordion" id="accordionExample">
                                <!-- Accordion item -->
                                @foreach ($listing_specification->where('specification_id', 0)->get() as $key => $specification)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{ $specification->id }}" aria-expanded="true" aria-controls="collapseOne{{ $specification->id }}"> {{ $specification->title }}</button>
                                        </h2>
                                        <div id="collapseOne{{ $specification->id }}" class="accordion-collapse collapse {{ $key == 0 ? 'show' : '' }}" data-bs-parent="#accordionExample">
                                            <div class="accordion-body d-flex">
                                                <ul class="accordion-body-list">
                                                    @foreach (App\Models\Listing_Specification::where('listing_id', $listing->id)->where('specification_id', $specification->id)->get() as $item)
                                                        <li>
                                                            <span class="info">{{ $item->title }}</span>
                                                            <span class="value">{{ $item->value }}</span>
                                                        </li>
                                                    @endforeach

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <!-- Accordion item -->
                            </div>
                        </div>
                        <!-- Seller Information -->
                        <div class="hoteldetails-agent-details mb-50px mt-5">
                            <div class="hoteldetails-agent-header mb-16 d-flex align-items-center justify-content-between flex-wrap">
                                <h3 class="title">{{ get_phrase('Agent Contact Details') }}</h3>
                            </div>
                            <div class="hoteldetails-agent-area d-flex align-items-center">
                                @php
                                    $agentInfo = App\Models\User::where('id', $listing->user_id)->first();
                                    $address = json_decode($agentInfo->address);
                                    $countries = isset($address->country) ? App\Models\Country::where('id', $address->country)->first()?->name : '';
                                    $city = isset($address->city) ? App\Models\City::where('id', $address->city)->first()?->name : '';
                                @endphp
                                <div class="profile">
                                    <img src="{{ get_all_image('users/' . $agentInfo->image) }}" alt="">
                                </div>
                                <div class="details">

                                    <div class="hotel-details-contacts">
                                        <p class="contact">{{ get_phrase('Listing by') }} <span>{{ $agentInfo->name }}</span></p>
                                        <p class="contact">{{ get_phrase('Phone:') }} <span>{{ $agentInfo->phone }}</span></p>
                                        <p class="contact">{{ get_phrase('Email:') }} <span>{{ $agentInfo->email }}</span></p>
                                    </div>
                                </div>
                            </div>
                            <form>
                                <div class="mb-20 mt-3">
                                    <label for="message" class="form-label smform-label2 mb-16">{{ get_phrase('Message*') }}</label>
                                    <textarea class="form-control mform-control review-textarea" name="message" id="message" required></textarea>
                                </div>
                              
                                <div class="d-flex justify-content-between">
                                    <button class="theme-btn1" type="button" onclick="send_message('{{ $listing->user_id }}')">{{ get_phrase('Submit') }}</button>
    
                                    @if (Auth::check())
                                       @if (isset(auth()->user()->id) && auth()->user()->id !== $listing->user_id)
                                        @php
                                            $existingReport = \App\Models\ReportedListing::where('listing_id', $listing->id)->where('type', $listing->type)->where('reporter_id', auth()->user()->id)->exists();
                                        @endphp
                                        @if (!$existingReport)
                                           <a href="javascript:;" onclick="edit_modal('modal-md','{{ route('reportListingForm',['type'=>$listing->type ,'id'=>$listing->id]) }}','{{ get_phrase('Report this listing') }}')"   class="report-text">{{get_phrase('Report this listing')}}</a>
                                           @else 
                                           <a href="javascript:;"  class="report-text">{{get_phrase('Already Reported')}}</a>
                                           @endif
                                        @endif
                                    @endif
                                </div>
                            </form>
                        </div>
                        <!-- Customer Reviews -->
                        <div class="car-customer-edit-review mt-5">
                            <!-- Reviews -->
                            <div class="car-details-reviews mb-50px">
                                <div class="review-title-button d-flex align-items-center justify-content-between flex-wrap">
                                    @php
                                        $totalReview = App\Models\Review::where('listing_id', $listing->id)->where('type', 'car')->where('reply_id', null)->get();
                                    @endphp
                                    <h2 class="title">{{ count($totalReview) }} {{ get_phrase('Reviews') }}</h2>
                                    @if (auth()->check())
                                        @php
                                            $user_review_count = App\Models\Review::where('listing_id', $listing->id)
                                                ->where('type', 'car')
                                                ->where('user_id', auth()->user()->id)->whereNull('reply_id')
                                                ->first();
                                        @endphp
                                        @if (auth()->user() && auth()->user()->id !== $listing->user_id)
                                            @if (!$user_review_count)
                                                <a href="#add_review" id="" class="white-btn1">{{ get_phrase('Add Reviews') }}</a>
                                            @else
                                                <a href="#update_review" id="" class="white-btn1">{{ get_phrase('Update Reviews') }}</a>
                                            @endif
                                        @endif
                                    @endif
                                </div>
                                <!-- Single comment wrapper -->

                                @php
                                    $reviews = App\Models\Review::where('listing_id', $listing->id)->where('reply_id', null)->where('type', 'car')->get();
                                @endphp

                                @foreach ($reviews as $review)
                                    @php
                                        $users = App\Models\User::where('id', $review->user_id)->first();
                                        $replies = App\Models\Review::where('reply_id', $review->id)->get();
                                        $userReplyExists = auth()->check()
                                            ? App\Models\Review::where('reply_id', $review->id)
                                                ->where('user_id', auth()->user()->id)
                                                ->exists()
                                            : false;
                                    @endphp
                                    <div class="single-comment-wrap">
                                        <!-- Comment -->
                                        <div class="single-comment d-flex">
                                            <div class="comment-profile">
                                                <img src="{{ get_all_image('users/' . $users['image']) }}" alt="">
                                            </div>
                                            <div class="comment-details">
                                                <div class="commentator-name-dropdown d-flex justify-content-between">
                                                    <div class="commentator-name-date">
                                                        <h3 class="name">{{ $users->name }}</h3>
                                                        <p class="date">{{ \Carbon\Carbon::parse($review->created_at)->format('F j, Y . g:i a') }}</p>
                                                    </div>
                                                </div>
                                                <div class="comment-content">
                                                    <ul class="d-flex eClass gap-1 mb-2">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= $review->rating)
                                                                <img src="{{ asset('assets/frontend/images/icons/star-yellow-17.svg') }}" alt="">
                                                            @else
                                                                <img src="{{ asset('assets/frontend/images/icons/star-gray-17.svg') }}" alt="">
                                                            @endif
                                                        @endfor
                                                    </ul>
                                                    <p class="info">{{ $review->review }}</p>
                                                </div>
                                                @if (auth()->user() && auth()->user()->id == $listing->user_id && !$userReplyExists)
                                                    <button class="comment-reply-btn" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $review->id }}">{{ get_phrase('Reply') }}</button>
                                                @endif
                                            </div>
                                        </div>
                                        {{-- Reply Modal --}}
                                        <form action="{{ route('listing.review.reply', ['id' => $review->id]) }}" method="POST" class="modal fade" id="exampleModal{{ $review->id }}" tabindex="-1" aria-labelledby="exampleModalLabel{{ $review->id }}" aria-hidden="true">
                                            @csrf
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel{{ $review->id }}">{{ get_phrase('Reply Review') }}</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-20">
                                                            <label class="form-label smform-label2 mb-16">{{ get_phrase('Review*') }}</label>
                                                            <textarea class="form-control mform-control review-textarea" name="review" required></textarea>
                                                            <input type="hidden" name="reply_id" value="{{ $review->id }}">
                                                            <input type="hidden" name="agent_id" value="{{ $review->agent_id }}">
                                                            <input type="hidden" name="listing_id" value="{{ $review->listing_id }}">
                                                            <input type="hidden" name="listing_types" value="{{ $review->type }}">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ get_phrase('Close') }}</button>
                                                        <button type="submit" class="btn btn-primary">{{ get_phrase('Save changes') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- All Reply -->

                                        <!-- Display Replies -->
                                        @if ($replies->count() > 0)
                                            <ul class="comment-replies">
                                                @foreach ($replies as $reply)
                                                    @php
                                                        $reply_user = App\Models\User::where('id', $reply->user_id)->first();
                                                    @endphp
                                                    <li>
                                                        <div class="single-comment d-flex">
                                                            <div class="comment-profile">
                                                                <img src="{{ get_all_image('users/' . $reply_user['image']) }}" alt="">
                                                            </div>
                                                            <div class="comment-details">
                                                                <div class="commentator-name-dropdown d-flex justify-content-between">
                                                                    <div class="commentator-name-date">
                                                                        <h3 class="name">{{ $reply_user->name }}</h3>
                                                                        <p class="date">{{ \Carbon\Carbon::parse($reply->created_at)->format('F j, Y . g:i a') }}</p>
                                                                    </div>
                                                                    @if (auth()->user() && auth()->user()->id == $listing->user_id)
                                                                        <div class="dropdown">
                                                                            <button type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                <img src="{{ asset('assets/frontend/images/icons/menu-dots-vertical.svg') }}" alt="">
                                                                            </button>
                                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                                <li><a class="dropdown-item" href="javascript:;" onclick="edit_modal('modal-md','{{ route('listing.review.edit', ['id' => $reply->id]) }}','{{ get_phrase('Update Review') }}')">{{ get_phrase('Edit') }}</a></li>
                                                                                <li><a class="dropdown-item" href="javascript:;" onclick="delete_modal('{{ route('listing.review.delete', ['id' => $reply->id]) }}')" href="javascript:void(0);">{{ get_phrase('Delete') }}</a></li>
                                                                            </ul>
                                                                        </div>
                                                                    @endif

                                                                </div>
                                                                <div class="comment-content">
                                                                    <p class="info">{{ $reply->review }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <!-- Edit Review -->
                            @php
                                $ownReview = null;
                                if (auth()->check()) {
                                    $ownReview = App\Models\Review::where('listing_id', $listing->id)
                                        ->where('type', 'car')
                                        ->where('user_id', auth()->user()->id)->whereNull('reply_id')
                                        ->first();
                                }
                            @endphp
                            @if (auth()->user() && auth()->user()->id !== $listing->user_id)
                                @if (!$user_review_count)
                                    <div class="atndetails-edit-reviews" id="add_review">
                                        <h2 class="title mb-20">{{ get_phrase('Add Your Review') }}</h2>
                                        <form action="{{ route('listing.review', ['id' => $listing->id]) }}" method="post">
                                            @csrf
                                            <div class="cardetails-review-form">
                                                <input type="hidden" name="agent_id" value="{{ $listing->user_id }}">
                                                <input type="hidden" name="listing_type" value="{{ $listing->type }}">
                                                <div class="mb-16">

                                                    <label class="form-label smform-label2 mb-16">{{ get_phrase('Rating') }}</label>
                                                    <select class="mNiceSelect review-select mform-control" name="rating" required>
                                                        <option selected>{{ get_phrase('Select Rating') }}</option>
                                                        <option value="1">{{ get_phrase('1') }}</option>
                                                        <option value="2">{{ get_phrase('2') }}</option>
                                                        <option value="3">{{ get_phrase('3') }}</option>
                                                        <option value="4">{{ get_phrase('4') }}</option>
                                                        <option value="5">{{ get_phrase('5') }}</option>
                                                    </select>
                                                </div>
                                                <div class="mb-20">
                                                    <label for="textarea1" class="form-label smform-label2 mb-16">{{ get_phrase('Review') }}</label>
                                                    <textarea class="form-control mform-control review-textarea" name="review" id="textarea1" required></textarea>
                                                </div>
                                                <button class="theme-btn1" type="submit">{{ get_phrase('Submit') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                @elseif(auth()->check() && $ownReview && auth()->user()->id == $ownReview->user_id)
                                    {{-- Update Review --}}
                                    <div class="atndetails-edit-reviews" id="update_review">
                                        <h2 class="title mb-20">{{ get_phrase('Update Your Review') }}</h2>
                                        <form action="{{ route('listing.review.update', ['id' => $listing->id]) }}" method="post">
                                            @csrf
                                            <input type="hidden" name="agent_id" value="{{ $listing->user_id }}">
                                            <input type="hidden" name="listing_type" value="{{ $listing->type }}">
                                            <div class="cardetails-review-form">
                                                <div class="mb-16">

                                                    <label class="form-label smform-label2 mb-16">{{ get_phrase('Rating') }}</label>
                                                    <select class="mNiceSelect review-select mform-control" name="rating" required>
                                                        <option value="1" {{ isset($user_review_count) && $user_review_count->rating == 1 ? 'selected' : '' }}>{{ get_phrase('1') }}</option>
                                                        <option value="2" {{ isset($user_review_count) && $user_review_count->rating == 2 ? 'selected' : '' }}>{{ get_phrase('2') }}</option>
                                                        <option value="3" {{ isset($user_review_count) && $user_review_count->rating == 3 ? 'selected' : '' }}>{{ get_phrase('3') }}</option>
                                                        <option value="4" {{ isset($user_review_count) && $user_review_count->rating == 4 ? 'selected' : '' }}>{{ get_phrase('4') }}</option>
                                                        <option value="5" {{ isset($user_review_count) && $user_review_count->rating == 5 ? 'selected' : '' }}>{{ get_phrase('5') }}</option>
                                                    </select>
                                                </div>
                                                <div class="mb-20">
                                                    <label for="textarea1" class="form-label smform-label2 mb-16">{{ get_phrase('Review') }}</label>
                                                    <textarea class="form-control mform-control review-textarea" name="review" id="textarea1" required>{{ $user_review_count->review }}</textarea>
                                                </div>
                                                <button class="theme-btn1" type="submit">{{ get_phrase('Update') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                @else
                                @endif

                                {{-- Update Review --}}
                            @endif
                        </div>
                    </div>
                      {{-- Custom Field --}}
                  
                            @include('frontend.custom_field')
                   
                     {{-- Custom Field --}}
                </div>
                <!-- Sidebar -->
                <div class="col-xl-4 col-lg-5">
                    <div class="sticky-class">
                        <div class="cardetails-form-sidebar mb-24">
                            <h1 class="title">{{ get_phrase('Book inspection') }}</h1>
                            @if (addon_status('form_builder') == 1 && get_settings('form_builder') == 1)
                                 @include('frontend.form_builder.form')  
                           @else
                                <form action="{{ route('customerBookAppointment') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="type" value="person">
                                    <input type="hidden" name="listing_type" value="car">
                                    <input type="hidden" name="listing_id" value="{{ $listing->id }}">
                                    <input type="hidden" name="agent_id" value="{{ $listing->user_id }}">

                                    <div class="cardetails-book-form">
                                        <div class="mb-16">
                                            <label for="datetime" class="form-label smform-label mb-12">{{ get_phrase('Select date & time') }}</label>
                                            <input type="text" name="date"  placeholder="{{get_phrase('Select date')}}" class="form-control mform-control flat-input-picker3 input-calendar-icon" id="datetime" required />
                                        </div>
                                      
                                        <input type="text" class="form-control mform-control mb-14" name="name" placeholder="Name" required>
                                        <input type="number" class="form-control mform-control mb-14" name="phone" placeholder="Phone" required>
                                        <input type="email" class="form-control mform-control mb-14" name="email" placeholder="Email" required>
                                        <textarea class="form-control mform-control review-textarea mb-14" name="message" placeholder="Message" required></textarea>
                                        <button type="submit" class="submit-fluid-btn2">{{ get_phrase('Submit Now') }}</button>
                                    </div>
                                </form>
                            @endif
                             @if (Auth::check())
                                @if (isset(auth()->user()->id) && auth()->user()->id == $listing->user_id)
                                    @php
                                        
                                        $existingClaim = \App\Models\ClaimedListing::where('listing_id', $listing->id)
                                            ->where('listing_type', $listing->type)
                                            ->where('user_id', auth()->user()->id)
                                            ->exists();
                                    @endphp

                                    @if (!$existingClaim)
                                        <a href="javascript:;" onclick="edit_modal('modal-md','{{ route('claimListingForm',['type'=>$listing->type ,'id'=>$listing->id]) }}','{{ get_phrase('Claim Listing') }}')" class="fluid-white-btn mt-2">
                                            {{ get_phrase('Claim Listing') }}
                                        </a>
                                    @else
                                        <button type="button" class="submit-fluid-btn2 mt-2" disabled>
                                            {{ get_phrase('Already Claimed') }}
                                        </button>
                                    @endif
                                @endif
                            @endif
                        </div>
                        <div class="cardetails-contact-dealer">
                            <h4 class="title mb-10px">{{ get_phrase('Contact Dealer') }}</h4>
                            <div class="car-dealer-contacts mb-12">
                                <h5 class="sub-title mb-12">{{ $agentInfo->name }} {{ get_phrase('Car Dealer') }}</h5>
                                <a href="tel:" class="single-cardealer-contact mb-12">
                                    <img src="{{ asset('assets/frontend/images/icons/call-gray-20.svg') }}" alt="">
                                    <span>{{ $agentInfo->phone }}</span>
                                </a>
                                <a href="mailto:" class="single-cardealer-contact mb-12">
                                    <img src="{{ asset('assets/frontend/images/icons/sms-gray-20.svg') }}" alt="">
                                    <span>{{ $agentInfo->email }}</span>
                                </a>
                                <div class="single-cardealer-contact">
                                    <img src="{{ asset('assets/frontend/images/icons/location-gray-20.svg') }}" alt="">
                                    <span>{{ $city . ' ' . $countries }}</span>
                                </div>
                            </div>
                            @php
                                $isFollowing = in_array($listing->user_id, json_decode(auth()->user()->following_agent ?? '[]'));
                                $text = $isFollowing ? 'Unfollow' : 'Follow';
                                $activeClass = $isFollowing ? 'active' : '';
                            @endphp
                            <a href="{{ route('agent.details', ['id' => $listing->user_id, 'slug' => slugify($listing->title)]) }}" class="submit-fluid-btn2 mb-12">{{ get_phrase('View Details') }}</a>
                            <a href="javascript:;" onclick="followers('{{ $listing->user_id }}')" id="followStatus" class="fluid-white-btn  {{ $activeClass }}"> {{ $text }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Main Content Area -->

    <!-- Start Modal Area -->
    <div class="modal modal-main-xl fade" id="imageViewModal" tabindex="-1" aria-labelledby="imageViewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="alm-header-wrap d-flex align-items-center">
                        <div class="alm-header-title-wrap d-flex align-items-center justify-content-between">
                            <h3 class="xl-modal-title">{{ $listing->title }}</h3>
                            <div class="alm-rating-review d-flex align-items-center gap-1">
                                <span><img src="{{ asset('assets/frontend/images/icons/star-yellow-20.svg') }}" alt=""></span>
                                <p>({{ count($totalReview) }} {{ get_phrase('REVIEWS)') }})</p>
                            </div>
                            <ul class="alm-hlist-group align-items-center d-flex">
                                <li class="alm-hlist-item align_self">
                                    <img src="{{ asset('assets/frontend/images/icons/car-32.svg') }}" alt="">
                                    <p class="alm-hlist-totalitem">{{ get_phrase('Condition') }}</p>
                                    <h4 class="alm-hlist-title capitalize">{{ $listing->status }}</h4>
                                </li>
                                <li class="alm-hlist-item align_self">
                                    <img src="{{ asset('assets/frontend/images/icons/drive-train-32.svg') }}" alt="">
                                    <p class="alm-hlist-totalitem">{{ get_phrase('Drive train') }}</p>
                                    <h4 class="alm-hlist-title">{{ App\Models\Amenities::where('id', $listing->drive_train)->first()->name }}</h4>
                                </li>
                                <li class="alm-hlist-item align_self">
                                    <img src="{{ asset('assets/frontend/images/icons/stock-32.svg') }}" alt="">
                                    <p class="alm-hlist-totalitem">{{ get_phrase('Stock') }}</p>
                                    <h4 class="alm-hlist-title">{{ $listing->stock }}</h4>
                                </li>
                                <li class="alm-hlist-item align_self">
                                    <img src="{{ asset('assets/frontend/images/icons/transmission-32.svg') }}" alt="">
                                    <p class="alm-hlist-totalitem">{{ get_phrase('Transmission') }}</p>
                                    <h4 class="alm-hlist-title">{{ App\Models\Amenities::where('id', $listing->transmission)->first()->name }}</h4>
                                </li>
                                <li class="alm-hlist-item align_self">
                                    <img src="{{ asset('assets/frontend/images/icons/mileage-32.svg') }}" alt="">
                                    <p class="alm-hlist-totalitem">{{ get_phrase('Mileage') }}</p>
                                    <h4 class="alm-hlist-title">{{ $listing->mileage }}</h4>
                                </li>
                                <li class="alm-hlist-item align_self">
                                    <img src="{{ asset('assets/frontend/images/icons/interior-colo-32.svg') }}" alt="">
                                    <p class="alm-hlist-totalitem">{{ get_phrase('Interior color') }}</p>
                                    <h4 class="alm-hlist-title">{{ App\Models\Amenities::where('id', $listing->interior_color)->first()->name }}</h4>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="row mt-2 gx-3 row-gap-3">
                        @foreach (json_decode($listing->image) as $key => $image)
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="sing-gallery">
                                    <div class="gallery-head">
                                        <a class="veno-gallery-img" href="{{ get_all_image('listing-images/' . $image) }}"><img src="{{ get_all_image('listing-images/' . $image) }}" alt=""></a>
                                    </div>
                                    <p>{{ $listing->title }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Area -->


    <!-- Start Related Product Area -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
                        <h4 class="in-title3-24px">{{ get_phrase('More cars from this seller') }}</h4>
                        <a href="{{ route('listing.view', ['type' => 'car', 'view' => 'grid']) }}" class="icon-link-sm2">
                            <span>{{ get_phrase('View all') }}</span>
                            <span class="mt-2px">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row row-28 mb-80px">
                @php
                    $relatedListing = App\Models\CarListing::where('user_id', $listing->user_id)->where('visibility', 'visible')->where('id', '!=', $listing->id)->take(4)->get();
                @endphp
                @foreach ($relatedListing->sortByDesc('created_at') as $listings)
                 @php 
                    $claimStatus = App\Models\ClaimedListing::where('listing_id', $listings->id)->where('listing_type', 'car')->first();  
                @endphp
                    <!-- Single Card -->
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="single-grid-card Cgray">
                            <!-- Banner Slider -->
                            <div class="grid-slider-area">
                                @php
                                    $images = json_decode($listings->image);
                                    $image = isset($images[0]) ? $images[0] : null;
                                @endphp
                                <a class="w-100 h-100" href="{{ route('listing.details', ['type' => 'car', 'id' => $listings->id, 'slug' => slugify($listings->title)]) }}">
                                    <img class="card-item-image" src="{{ get_all_image('listing-images/' . $image) }}">
                                </a>
                                <!-- if you need featured you can use  -->
                                @php
                                    $is_in_wishlist = check_wishlist_status($listings->id, $listings->type);
                                @endphp

                                <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-title="{{ $is_in_wishlist ? get_phrase('Remove from Wishlist') : get_phrase('Add to Wishlist') }}" onclick="RelatedupdateWishlist(this, '{{ $listings->id }}')" class="grid-list-bookmark ca-bookmark-hover gray-bookmark2 {{ $is_in_wishlist ? 'active' : '' }}">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.4361 3C12.7326 3.01162 12.0445 3.22023 11.4411 3.60475C10.8378 3.98927 10.3407 4.53609 10 5.18999C9.65929 4.53609 9.16217 3.98927 8.55886 3.60475C7.95554 3.22023 7.26738 3.01162 6.56389 3C5.44243 3.05176 4.38583 3.57288 3.62494 4.44953C2.86404 5.32617 2.4607 6.48707 2.50302 7.67861C2.50302 10.6961 5.49307 13.9917 8.00081 16.2262C8.56072 16.726 9.26864 17 10 17C10.7314 17 11.4393 16.726 11.9992 16.2262C14.5069 13.9917 17.497 10.6961 17.497 7.67861C17.5393 6.48707 17.136 5.32617 16.3751 4.44953C15.6142 3.57288 14.5576 3.05176 13.4361 3Z" fill="#6C1CFF" />
                                    </svg>
                                </a>
                            </div>
                            <div class="car-grid-details position-relative">
                                <div class="cargrid-title-area">
                                    <a href="{{ route('listing.details', ['type' => 'car', 'id' => $listings->id, 'slug' => slugify($listings->title)]) }}" class="title">
                                        <span data-bs-toggle="tooltip" 
                                        data-bs-title=" {{ get_phrase('This listing is verified') }}">
                                        @if(isset($claimStatus) && $claimStatus->status == 1) 
                                        <svg fill="none" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><linearGradient id="paint0_linear_16_1334" gradientUnits="userSpaceOnUse" x1="12" x2="12" y1="-1.2" y2="25.2"><stop offset="0" stop-color="#ce9ffc"/><stop offset=".979167" stop-color="#7367f0"/></linearGradient><path d="m3.783 2.826 8.217-1.826 8.217 1.826c.2221.04936.4207.17297.563.3504.1424.17744.22.39812.22.6256v9.987c-.0001.9877-.244 1.9602-.7101 2.831s-1.14 1.6131-1.9619 2.161l-6.328 4.219-6.328-4.219c-.82173-.5478-1.49554-1.2899-1.96165-2.1605-.46611-.8707-.71011-1.8429-.71035-2.8305v-9.988c.00004-.22748.07764-.44816.21999-.6256.14235-.17743.34095-.30104.56301-.3504zm8.217 10.674 2.939 1.545-.561-3.272 2.377-2.318-3.286-.478-1.469-2.977-1.47 2.977-3.285.478 2.377 2.318-.56 3.272z" fill="url(#paint0_linear_16_1334)"/></svg>
                                        @endif
                                        </span>
                                        {{ $listings->title }}
                                    </a>
                                    <p class="info">{{ $listings->sub_title }}</p>
                                </div>
                                <ul class="cargrid-list-items d-flex align-items-center flex-wrap">
                                    <li>
                                        <img src="{{ asset('assets/frontend/images/icons/engine-black-24.svg') }}" alt="">
                                        <p class="info"> {{ App\Models\Amenities::where('id', $listings->engine_size)->first()->name }} </p>
                                    </li>
                                    <li>
                                        <img src="{{ asset('assets/frontend/images/icons/mileage-black-24.svg') }}" alt="">
                                        <p class="info"> {{ $listings->mileage }} </p>
                                    </li>
                                    <li>
                                        <img src="{{ asset('assets/frontend/images/icons/petrol-black-24.svg') }}" alt="">
                                        <p class="info"> {{ App\Models\Amenities::where('id', $listings->fuel_type)->first()->name }} </p>
                                    </li>
                                </ul>
                                <div class="cargrid-price-view d-flex align-items-end justify-content-between flex-wrap">
                                    <div class="prices">
                                        @if(!empty($listings->discount_price))
                                        <p class="new-price">{{ currency($listings->discount_price) }}</p>
                                        <p class="old-price">{{ currency($listings->price) }}</p>
                                        @elseif(!empty($listings->price))
                                            <p class="new-price">{{ currency($listings->price) }}</p>
                                        @endif
                                    </div>
                                    <a href="{{ route('listing.details', ['type' => 'car', 'id' => $listings->id, 'slug' => slugify($listings->title)]) }}" class="btn ca-btn-dark ca-btn-sm stretched-link">{{ get_phrase('See Details') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Single Card -->
                @endforeach

            </div>
        </div>
    </section>
    <!-- End Related Product Area -->
@endsection
@push('js')
    <script>
        "use strict";
        $('documnet').ready(function() {
            flatpickr("#datetime", {
                enableTime: true,
                dateFormat: "Y-m-d H:i:S",
                minDate: "today",
            });
        });
    </script>

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



    {{-- Related Car Wishlist  --}}
    @if (Auth::check())
        <script>
            "use strict";

            function RelatedupdateWishlist(button, listingId) {
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

            function RelatedupdateWishlist(listing_id) {
                warning("Please login first!");
            }
        </script>
    @endif


    <script>
        "use strict";

        function toggleDescription() {
            var shortDesc = document.getElementById("short-description");
            var fullDesc = document.getElementById("full-description");
            var readMoreBtn = document.getElementById("read-more-btn");

            if (shortDesc.classList.contains("d-block")) {
                shortDesc.classList.remove("d-block");
                shortDesc.classList.add("d-none");
                fullDesc.classList.remove("d-none");
                fullDesc.classList.add("d-block");
                readMoreBtn.querySelector("span").textContent = "Read Less";
            } else {
                shortDesc.classList.remove("d-none");
                shortDesc.classList.add("d-block");
                fullDesc.classList.remove("d-block");
                fullDesc.classList.add("d-none");
                readMoreBtn.querySelector("span").textContent = "Read More";
            }
        }
    </script>


    {{-- Message --}}
    @if (Auth::check())
        @if (isset(auth()->user()->id) && auth()->user()->id != $listing->user_id)
            <script>
                "use strict";

                function send_message(user_id) {
                    var message = $('#message').val();
                    if (message != "") {
                        $.ajax({
                            url: '{{ route('customerMessage') }}',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                agent_id: user_id,
                                message: message
                            },
                            success: function(response) {
                                console.log(response);
                                if (response.status == 'success') {
                                    success("Message sent successfully");
                                    $('#message').val('');
                                } else {
                                    error("Message send failed");
                                }
                            }
                        });
                    } else {
                        error("Please fill up the field first");
                    }
                }
            </script>
        @else
            <script>
                "use strict";

                function send_message(user_id) {
                    warning("You can't Message yourself");
                }
            </script>
        @endif
    @else
        <script>
            "use strict";

            function send_message(listing_id) {
                warning("Please login first!");
            }
        </script>
    @endif

    {{-- Message --}}

    <script>
        "use strict";
        $(document).ready(function() {
            $('#shareButton').on('click', function() {
                var currentPageUrl = window.location.href;
                $(this).toggleClass('active');
                navigator.clipboard.writeText(currentPageUrl).then(function() {
                    success('Successfully copied this link!');
                }).catch(function(error) {
                    error('Failed to copy the link!');
                });
            });
        });
    </script>

    {{-- Follow Unfollow --}}
    @if (Auth::check())
        @if (isset(auth()->user()->id) && auth()->user()->id != $listing->user_id)
            <script>
                "use strict";

                function followers(user_id) {
                    $.ajax({
                        url: "{{ route('followUnfollow') }}",
                        method: "POST",
                        data: {
                            agent_id: user_id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.status == 1) {
                                $("#followStatus").html('Unfollow').addClass('active');
                                success("Followed Successfully!");
                            } else {
                                $("#followStatus").html('Follow').removeClass('active');
                                success("Unfollowed Successfully!");
                            }
                        },
                        error: function() {
                            error("An error occurred. Please try again.");
                        }
                    });
                }
            </script>
        @else
            <script>
                "use strict";

                function followers(user_id) {
                    warning("You can't follow yourself");
                }
            </script>
        @endif
    @else
        <script>
            "use strict";

            function followers(listing_id) {
                warning("Please login first!");
            }
        </script>
    @endif
@endpush
