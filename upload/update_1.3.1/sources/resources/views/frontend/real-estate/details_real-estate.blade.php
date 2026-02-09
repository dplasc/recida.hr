
@extends('layouts.frontend')
@section('title', get_phrase('Real Estate Listing Details'))
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/plyr.css') }}">
    <script src="{{ asset('assets/frontend/js/plyr.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/venobox.min.css') }}">
    <script src="{{ asset('assets/frontend/js/venobox.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/flatpickr.min.css') }}">
    <script src="{{ asset('assets/frontend/js/flatpickr.min.js') }}"></script>
@endpush
@section('frontend_layout')
    <!-- Start Bread Crumb  -->
    <section class="mt-20px mb-20px">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb atn-breadcrumb">
                          <li class="breadcrumb-item atn-breadcrumb-item"><a href="{{route('real-estate.home')}}">{{get_phrase('Home')}}</a></li>
                          <li class="breadcrumb-item atn-breadcrumb-item"><a href="{{route('listing.view', ['type' => 'real-estate', 'view' => 'grid'])}}">{{get_phrase('Real-Estate')}}</a></li>
                          <li class="breadcrumb-item atn-breadcrumb-item active" aria-current="page">{{get_phrase('Details')}}</li>
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
            <div class="row">
                <div class="col-md-12">
                    <div class="details-title-back1 d-flex align-items-start justify-content-between flex-wrap">
                        <div class="detailstop-title-location1">
                            <div class="detailstop-title1 d-flex align-items-center flex-wrap">
                                @php 
                                    $claimStatus = App\Models\ClaimedListing::where('listing_id', $listing->id)->where('listing_type', 'real-estate')->first();  
                                @endphp
                                <h1 class="title">
                                    @if(isset($claimStatus) && $claimStatus->status == 1) 
                                    <span data-bs-toggle="tooltip" 
                                    data-bs-title=" {{ get_phrase('This listing is verified') }}">
                                    <svg fill="none" height="34" viewBox="0 0 24 24" width="34" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><linearGradient id="paint0_linear_16_1334" gradientUnits="userSpaceOnUse" x1="12" x2="12" y1="-1.2" y2="25.2"><stop offset="0" stop-color="#ce9ffc"/><stop offset=".979167" stop-color="#7367f0"/></linearGradient><path d="m3.783 2.826 8.217-1.826 8.217 1.826c.2221.04936.4207.17297.563.3504.1424.17744.22.39812.22.6256v9.987c-.0001.9877-.244 1.9602-.7101 2.831s-1.14 1.6131-1.9619 2.161l-6.328 4.219-6.328-4.219c-.82173-.5478-1.49554-1.2899-1.96165-2.1605-.46611-.8707-.71011-1.8429-.71035-2.8305v-9.988c.00004-.22748.07764-.44816.21999-.6256.14235-.17743.34095-.30104.56301-.3504zm8.217 10.674 2.939 1.545-.561-3.272 2.377-2.318-3.286-.478-1.469-2.977-1.47 2.977-3.285.478 2.377 2.318-.56 3.272z" fill="url(#paint0_linear_16_1334)"/></svg>
                                    </span>
                                    @endif
                                    {{$listing->title}}</h1>
                            </div>
                            <div class="location d-flex align-items-center">
                                <img src="{{asset('assets/frontend/images/icons/location-sky-blue2-20.svg')}}" alt="">
                                @php
                                $city_name = App\Models\City::where('id',$listing->city)->first()->name;
                                $country_name = App\Models\Country::where('id',$listing->country)->first()->name;
                            @endphp
                               <p class="name fw-medium"> {{$city_name.', '.$country_name}} </p>
                            </div>
                        </div>
                        <div class="detailstop-share-back d-flex align-items-center flex-wrap">
                            @php
                         $is_in_wishlist = check_wishlist_status($listing->id, $listing->type);
                       @endphp
                         <a href="javascript:;" data-bs-toggle="tooltip" 
                         data-bs-title="{{ $is_in_wishlist ? get_phrase('Remove from Wishlist') : get_phrase('Add to Wishlist') }}" class="save-share {{ $is_in_wishlist ? 'active' : '' }}" onclick="updateWishlist(this, '{{ $listing->id }}')">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 21.6501C11.69 21.6501 11.39 21.6101 11.14 21.5201C7.32 20.2101 1.25 15.5601 1.25 8.6901C1.25 5.1901 4.08 2.3501 7.56 2.3501C9.25 2.3501 10.83 3.0101 12 4.1901C13.17 3.0101 14.75 2.3501 16.44 2.3501C19.92 2.3501 22.75 5.2001 22.75 8.6901C22.75 15.5701 16.68 20.2101 12.86 21.5201C12.61 21.6101 12.31 21.6501 12 21.6501ZM7.56 3.8501C4.91 3.8501 2.75 6.0201 2.75 8.6901C2.75 15.5201 9.32 19.3201 11.63 20.1101C11.81 20.1701 12.2 20.1701 12.38 20.1101C14.68 19.3201 21.26 15.5301 21.26 8.6901C21.26 6.0201 19.1 3.8501 16.45 3.8501C14.93 3.8501 13.52 4.5601 12.61 5.7901C12.33 6.1701 11.69 6.1701 11.41 5.7901C10.48 4.5501 9.08 3.8501 7.56 3.8501Z" fill="#7E7E89"/>
                                </svg>
                            </a>
                            <a href="javascript:;" data-bs-toggle="tooltip" data-bs-title="{{get_phrase('Copy link to share')}}" id="shareButton" class="save-share">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18.7259 14.4443C18.0336 14.4448 17.3519 14.614 16.7395 14.9373C16.1271 15.2605 15.6025 15.728 15.2109 16.2995L9.25111 13.6056C9.67441 12.5823 9.67606 11.4329 9.25569 10.4084L15.2072 7.70071C15.7876 8.54103 16.6496 9.14527 17.6369 9.40383C18.6241 9.66239 19.6713 9.55815 20.5884 9.11001C21.5055 8.66187 22.2317 7.89952 22.6354 6.96124C23.0392 6.02296 23.0936 4.9709 22.7888 3.9959C22.4841 3.02089 21.8403 2.18752 20.9744 1.64695C20.1085 1.10638 19.0777 0.894424 18.069 1.04952C17.0603 1.20461 16.1406 1.71649 15.4766 2.4923C14.8126 3.26811 14.4484 4.25647 14.45 5.27809C14.4539 5.51989 14.4784 5.76092 14.5232 5.99855L8.19632 8.87673C7.58867 8.3068 6.82794 7.92697 6.00761 7.78391C5.18728 7.64084 4.34307 7.74078 3.5787 8.07144C2.81432 8.40211 2.16308 8.94909 1.70497 9.64519C1.24686 10.3413 1.00184 11.1562 1.00001 11.9898C0.998181 12.8234 1.23962 13.6394 1.69467 14.3375C2.14972 15.0356 2.79856 15.5854 3.56147 15.9195C4.32439 16.2535 5.16815 16.3571 5.9891 16.2177C6.81005 16.0782 7.57243 15.7017 8.18259 15.1345L14.526 18.0017C14.4819 18.2391 14.4577 18.4798 14.4536 18.7212C14.4535 19.5674 14.7039 20.3946 15.1734 21.0982C15.6429 21.8018 16.3103 22.3503 17.0911 22.6742C17.872 22.9981 18.7313 23.0829 19.5603 22.9178C20.3893 22.7528 21.1507 22.3454 21.7484 21.747C22.3461 21.1487 22.7531 20.3864 22.9179 19.5565C23.0828 18.7266 22.9981 17.8664 22.6745 17.0846C22.351 16.3029 21.8032 15.6348 21.1003 15.1648C20.3974 14.6949 19.5711 14.4441 18.7259 14.4443ZM18.7259 2.83346C19.2089 2.83328 19.6811 2.9765 20.0828 3.24501C20.4845 3.51352 20.7977 3.89526 20.9826 4.34194C21.1676 4.78862 21.2161 5.28018 21.122 5.75445C21.0278 6.22872 20.7953 6.66439 20.4539 7.00637C20.1124 7.34835 19.6773 7.58127 19.2036 7.67567C18.7298 7.77007 18.2388 7.72171 17.7925 7.53671C17.3463 7.35171 16.9648 7.03838 16.6965 6.63634C16.4281 6.23431 16.2849 5.76163 16.2849 5.27809C16.2854 4.63004 16.5427 4.00866 17.0003 3.55034C17.458 3.09201 18.0786 2.83419 18.7259 2.83346ZM5.29748 14.4443C4.81447 14.4445 4.34226 14.3012 3.94056 14.0327C3.53886 13.7642 3.22573 13.3825 3.04077 12.9358C2.8558 12.4891 2.80731 11.9976 2.90143 11.5233C2.99555 11.049 3.22805 10.6133 3.56953 10.2714C3.911 9.92939 4.34611 9.69647 4.81983 9.60207C5.29355 9.50767 5.78459 9.55603 6.23085 9.74103C6.67711 9.92603 7.05854 10.2394 7.32691 10.6414C7.59527 11.0434 7.73851 11.5161 7.73851 11.9997C7.73779 12.6476 7.4804 13.2689 7.02281 13.7271C6.56521 14.1854 5.94475 14.4433 5.29748 14.4443ZM18.7259 21.1658C18.2429 21.1658 17.7708 21.0225 17.3692 20.7539C16.9677 20.4852 16.6547 20.1034 16.4698 19.6567C16.285 19.21 16.2367 18.7185 16.3309 18.2443C16.4251 17.7701 16.6577 17.3345 16.9992 16.9926C17.3407 16.6507 17.7758 16.4179 18.2495 16.3236C18.7232 16.2292 19.2142 16.2777 19.6604 16.4627C20.1066 16.6477 20.488 16.961 20.7563 17.3631C21.0246 17.7651 21.1679 18.2377 21.1679 18.7212C21.1674 19.3694 20.9099 19.9909 20.4521 20.4493C19.9942 20.9076 19.3734 21.1654 18.7259 21.1658Z" fill="#7E7E89"/>
                                </svg>
                            </a>
                            <a href="{{route('listing.view',['type'=>'real-estate','view'=>'grid'])}}" class="back-btn1">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.9752 15.6834C7.81686 15.6834 7.65853 15.6251 7.53353 15.5001L2.4752 10.4418C2.23353 10.2001 2.23353 9.8001 2.4752 9.55843L7.53353 4.5001C7.7752 4.25843 8.1752 4.25843 8.41686 4.5001C8.65853 4.74176 8.65853 5.14176 8.41686 5.38343L3.8002 10.0001L8.41686 14.6168C8.65853 14.8584 8.65853 15.2584 8.41686 15.5001C8.3002 15.6251 8.13353 15.6834 7.9752 15.6834Z" fill="#7E7E89"/>
                                    <path d="M17.0831 10.625H3.05811C2.71644 10.625 2.43311 10.3417 2.43311 10C2.43311 9.65833 2.71644 9.375 3.05811 9.375H17.0831C17.4248 9.375 17.7081 9.65833 17.7081 10C17.7081 10.3417 17.4248 10.625 17.0831 10.625Z" fill="#7E7E89"/>
                                </svg>
                                <span>{{get_phrase('Back to listing')}}</span>    
                            </a>
                        </div>
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
                    <div class="realstate-details-banners mb-30px">
                        <div class="banner-top">
                            @foreach (json_decode($listing->image) as $key => $image)
                            @php if ($key >= 1) { break; } @endphp
                             <img class="big-image-view" src="{{get_all_image('listing-images/'.$image)}}" alt="">
                            @endforeach
                        </div>
                        <ul class="realestate-banner-list">
                            @php
                            $images = json_decode($listing->image) ?? [];
                            $imageCount = count($images);
                        @endphp
                        
                        @foreach ($images as $key => $image)
                            @php 
                                if ($key == 0) { continue; } 
                                elseif($key > 3) { break; } 
                            @endphp
                            @if ($key > 0 && $key <= 3)    
                                <li>
                                    <img class="small-image-view" src="{{get_all_image('listing-images/'.$image)}}" alt="">
                                </li>
                            @endif
                        @endforeach
                        @if ($imageCount > 4)
                            <li class="last-child small-image-view">
                                <img src="{{get_all_image('listing-images/'.$images[4])}}" alt="">
                                <a href="javascript:;" class="see-more" data-bs-toggle="modal" data-bs-target="#imageViewModal"> {{get_phrase('View More')}}</a>
                            </li>
                        @endif
                        
                        </ul>
                    </div>
                    <!-- Price  -->
                    <div class="realestate-pricing-area mb-50px">
                        <div class="pricing d-flex align-items-baseline">
                            <p class="info capitalize">{{get_phrase('Price')}}</p>
                            
                            <div class="d-flex">
                                @if(!empty($listing->discount))
                                <h4 class="price">{{currency($listing->discount)}}</h4>
                                <del class="mt-1 ms-2">{{currency($listing->price)}}</del>
                                @elseif(!empty($listing->price))
                                <h4 class="price">{{currency($listing->price)}}</h4>
                                @endif
                            </div>
                        </div>
                        <div class="row row-28">
                            <div class="col-xl-5 col-lg-12 col-md-5">
                                <div class="realestate-property-title">
                                    <h5 class="title">{{get_phrase('Property')}}</h5>
                                    <p class="info">{{get_phrase('ID :')}} {{$listing->property_id}}</p>
                                </div>
                            </div>
                            <div class="col-xl-7 col-lg-12 col-md-7">
                                <ul class="realestate-property-list d-flex align-items-center">
                                    <li>
                                        <img src="{{asset('assets/frontend/images/icons/bed-gray-30.svg')}}" alt="">
                                        <span>{{$listing->bed}} {{get_phrase('Bed')}}</span>
                                    </li>
                                    <li>
                                        <img src=" {{asset('assets/frontend/images/icons/bath-gray-30.svg')}}" alt="">
                                        <span>{{$listing->bath}} {{get_phrase('Bath')}}</span>
                                    </li>
                                    <li>
                                        <img src="{{asset('assets/frontend/images/icons/resize-arrow-gray-30.svg')}}" alt="">
                                        <span>{{$listing->size}} {{get_phrase('sqft')}}</span>
                                    </li>
                                    <li>
                                        <img src="{{asset('assets/frontend/images/icons/car-gray-30.svg')}}" alt="">
                                        <span>{{$listing->garage}} {{get_phrase('Garage')}}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Description -->
                    <div class="at-details-description mb-50px">
                        <h4 class="title mb-16">{{get_phrase('Description')}}</h4>
                        <p class="info mb-16">
                            <span id="short-description" class="d-block">{{ Str::limit($listing->description, 400) }}</span>
                            <span id="full-description" class="d-none"> {!! removeScripts($listing->description) !!}</span>
                        </p>
                        @if(strlen($listing->description) > 400)
                        <a href="javascript:void(0);" id="read-more-btn" class="icontext-link-btn" onclick="toggleDescription()">
                            <span>{{get_phrase('Read More')}}</span>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.33217 8.33306H13.0562L9.52751 4.8044C9.46383 4.7429 9.41304 4.66933 9.37811 4.588C9.34317 4.50666 9.32478 4.41918 9.32401 4.33066C9.32324 4.24214 9.34011 4.15436 9.37363 4.07243C9.40715 3.9905 9.45665 3.91606 9.51924 3.85347C9.58184 3.79087 9.65627 3.74137 9.7382 3.70785C9.82014 3.67433 9.90792 3.65746 9.99644 3.65823C10.085 3.659 10.1724 3.67739 10.2538 3.71233C10.3351 3.74727 10.4087 3.79806 10.4702 3.86173L15.1368 8.5284C15.2618 8.65341 15.332 8.82295 15.332 8.99973C15.332 9.17651 15.2618 9.34604 15.1368 9.47106L10.4702 14.1377C10.3444 14.2592 10.176 14.3264 10.0012 14.3248C9.82644 14.3233 9.65923 14.2532 9.53563 14.1296C9.41202 14.006 9.34191 13.8388 9.34039 13.664C9.33887 13.4892 9.40607 13.3208 9.52751 13.1951L13.0562 9.6664H1.33217C1.15536 9.6664 0.985792 9.59616 0.860768 9.47113C0.735744 9.34611 0.665506 9.17654 0.665506 8.99973C0.665506 8.82292 0.735744 8.65335 0.860768 8.52832C0.985792 8.4033 1.15536 8.33306 1.33217 8.33306Z" fill="#242D3D"></path>
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
                    <!-- Details Address -->
                    <div class="row row-28 mb-50px">
                        <div class="col-lg-6">
                            <div class="realestate-details-details">
                                <h4 class="title">{{get_phrase('Details')}}</h4>
                                <ul class="realdetails-detailslist">
                                    <li>
                                        <span class="info">{{get_phrase('Property ID')}}</span>
                                        <span class="value">{{$listing->property_id}}</span>
                                    </li>
                                    <li>
                                        <span class="info capitalize">{{get_phrase('Price')}}</span>
                                        <span class="value">
                                            <div class="d-flex">
                                                @if(!empty($listing->discount))
                                                <p class="price">{{currency($listing->discount)}}</p>
                                                @elseif(!empty($listing->price))
                                                <p class="price">{{currency($listing->price)}}</p>
                                                @endif
                                            </div>
                                        </span>
                                    </li>
                                    <li>
                                        <span class="info">{{get_phrase('Property Size')}}</span>
                                        <span class="value">{{$listing->size}} {{get_phrase('Sqft')}}</span>
                                    </li>
                                    <li>
                                        <span class="info">{{get_phrase('Bedrooms')}}</span>
                                        <span class="value">{{$listing->bed}}</span>
                                    </li>
                                    <li>
                                        <span class="info">{{get_phrase('Bathrooms')}}</span>
                                        <span class="value">{{$listing->bath}}</span>
                                    </li>
                                    <li>
                                        <span class="info">{{get_phrase('Garage')}}</span>
                                        <span class="value">{{$listing->garage}}</span>
                                    </li>
                                    <li>
                                        <span class="info">{{get_phrase('Year Build')}}</span>
                                        <span class="value">{{$listing->year}}</span>
                                    </li>
                                    <li>
                                        <span class="info">{{get_phrase('Property Agent')}}</span>
                                        @php 
                                          $agentName = App\Models\User::where('id', $listing->user_id)->first();
                                        @endphp
                                        <span class="value">{{$agentName->name}}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="realestate-details-address">
                                <div class="title-btn d-flex align-items-center justify-content-between flex-wrap">
                                    <h4 class="title">{{get_phrase('Address')}}</h4>
                                    <a href="javascript:;" class="get-direction-btn" id="dynamicLocation">{{ get_phrase('Get Direction') }}</a>
                                </div>
                                <ul class="realdetails-detailslist">
                                    <li>
                                        <span class="info">{{get_phrase('Address')}}</span>
                                        <span class="value">{{$listing->address}}</span>
                                    </li>
                                    <li>
                                        <span class="info">{{get_phrase('City')}}</span>
                                        <span class="value">{{$city_name}}</span>
                                    </li>
                                    <li>
                                        <span class="info">{{get_phrase('Country')}}</span>
                                        <span class="value">{{$country_name}}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="realestate-details-features mb-50px">
                        <h2 class="in-title3-24px mb-20">{{ get_phrase('Features') }}</h2>
                        <ul class="realdetails-features-list">
                            @php
                                $features = json_decode($listing->feature, true) ?? [];
                                $featuresToShow = array_slice($features, 0, 3); 
                                $remainingFeatures = array_slice($features, 3); 
                                $remainingFeaturesCount = count($remainingFeatures);
                            @endphp
                            
                            @foreach ($featuresToShow as $key => $feature)
                                @php
                                    $amenities = App\Models\Amenities::where('id', $feature)->first();
                                @endphp
                                <li class="realdetails-feature">
                                    <div class="icon">
                                        <img src="{{ asset($amenities?->image ? '/' . $amenities?->image : 'image/placeholder.png') }}" alt="">
                                    </div>
                                    <p class="name">{{ $amenities?->name }}</p>
                                </li>
                            @endforeach
                            
                            @if($remainingFeaturesCount > 0)
                                <li class="realdetails-feature-more">
                                    <button class="more-btn" data-bs-toggle="modal" data-bs-target="#featureModal">
                                        <span class="more">+{{ $remainingFeaturesCount }} {{ get_phrase('More') }}</span>
                                        <span class="feature">{{ get_phrase('Features') }}</span>
                                    </button>
                                </li>
                            @endif
                        </ul>    
                    </div>
                    
                    {{-- Feature Modal --}}
                    <div class="modal fade" id="featureModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title in-title3-24px" id="exampleModalLabel">{{ get_phrase('Features') }}</h1>
                                    <button type="button" class="btn-close FeatureCLose" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        @foreach ($remainingFeatures as $feature)
                                            @php
                                                $amenities = App\Models\Amenities::where('id', $feature)->first();
                                            @endphp
                                            @if($amenities)
                                                <div class="col-lg-3 col-md-6 mb-2">
                                                    <div class="realdetails-feature">
                                                        <div class="icon">
                                                            <img src="{{ asset($amenities?->image ? '/' . $amenities?->image : 'image/placeholder.png') }}" alt="">
                                                        </div>
                                                        <p class="name">{{ $amenities?->name }}</p>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Feature Modal --}}
                    <!-- Floor Plans -->
                    <div class="floor-plans-area mb-50px">
                        <h2 class="in-title3-24px mb-20">{{get_phrase('Floor Plans')}}</h2>
                        <div class="floor-plans-slider-wrap">
                            <div class="swiper floor-plans-slider">
                                <div class="swiper-wrapper">
                                    @foreach ((array) json_decode($listing->floor_plan) as $key => $floor)
                                        <div class="swiper-slide">
                                            <div class="floor-plan-img">
                                                <a class="veno-gallery-img" href="{{ get_all_image('floor-plan/' . $floor) }}"><img src="{{ get_all_image('floor-plan/' . $floor) }}" alt="photo"></a>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Video -->
                    <div class="realdetails-video-area mb-50px">
                        <h2 class="in-title3-24px mb-20">{{get_phrase('Video')}}</h2>
                        <div class="realdetails-video">
                            <div class="plyr__video-embed" id="player">
                                <iframe src="{{$listing->video}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                    <!-- Nearby -->
                    @include('frontend.real-estate.nearby')
                    <!-- 3D Model -->
                    <div class="real-3dmodel-area mb-50px">
                        <h2 class="in-title3-24px mb-20">{{get_phrase('3D Model')}}</h2>
                        <div class="realdetails-3d-wrap">
                            <!-- If you don't want to use thumbnails, simply remove poster. -->
                            <script  type="module" src="{{asset('assets/backend/js/model-viewer.min.js')}}"></script>
                            <model-viewer
                              poster="{{get_all_image('3d/'.$listing->model)}}" src="{{get_all_image('3d/'.$listing->model)}}"
                              ar  ar-modes="webxr scene-viewer quick-look"  camera-controls
                              orientation="0 0 -90"
                              shadow-intensity="2"
                              class="model-viewer">
                            </model-viewer>
                           
                        </div>
                    </div>

                     <!-- Agent Contact Details -->
                <div class="restdetails-agent-details mb-50px">
                    <div class="restdetails-agent-header mb-16 d-flex align-items-center justify-content-between flex-wrap">
                        <h3 class="title">{{get_phrase('Agent Contact Details')}}</h3>
                        <div class="restdetails-agent-btns d-flex align-items-center flex-wrap">
                            @php
                            $isFollowing = in_array($listing->user_id, json_decode(auth()->user()->following_agent ?? '[]'));
                            $text = $isFollowing ? 'Unfollow' : 'Follow'; 
                            @endphp
                             <a href="javascript:;" class="theme-btn1" onclick="followers('{{ $listing->user_id }}')" id="followStatus"> {{ $text }}</a>
                            <a href="{{route('agent.details',['id'=>$listing->user_id, 'slug'=>slugify($listing->title)])}}" class="gray-btn1">{{get_phrase('View Details')}}</a>
                        </div>
                    </div>
                    <div class="restdetails-agent-area d-flex align-items-center">
                        @php 
                           $agentInfo = App\Models\User::where('id', $listing->user_id)->first(); 
                         @endphp
                        <div class="profile">
                            <img src="{{get_all_image('users/'.$agentInfo->image)}}" alt="">
                        </div>
                        <div class="details">
                            <div class="restagent-details-listreview">
                                <p class="name mb-14px">{{get_phrase('Listing by')}} <span>{{$agentInfo->name}}</span></p>
                            </div>
                            <div class="restagent-details-contacts">
                                <p class="contact">{{get_phrase('Phone:')}} <span>{{$agentInfo->phone}}</span></p>
                                    <p class="contact">{{get_phrase('Email:')}} <span>{{$agentInfo->email}}</span></p>
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
                 <!-- Reviews -->
                <div class="real-details-reviews  mb-50px">
                    <div class="review-title-button d-flex align-items-center justify-content-between flex-wrap">
                        
                           @php 
                            $totalReview = App\Models\Review::where('listing_id', $listing->id)->where('type', 'real-estate')->where('reply_id', NULL)->get(); 
                           @endphp
                           <h2 class="title">{{count($totalReview)}} {{get_phrase('Reviews')}}</h2>
                       
                        @if(auth()->check()) 
                            @php 
                               $user_review_count = App\Models\Review::where('listing_id', $listing->id)->where('type', 'real-estate')->where('user_id', auth()->user()->id)->whereNull('reply_id')->first(); 
                               @endphp
                           @if(auth()->user()->id !== $listing->user_id) 
                                @if(!$user_review_count) 
                                    <a href="#add_review" id="" class="white-btn1">{{get_phrase('Add Reviews')}}</a>
                                @else
                                    <a href="#update_review" id="" class="white-btn1">{{get_phrase('Update Reviews')}}</a>
                                @endif
                            @endif
                        @endif
                    </div>
                    <!-- Single comment wrapper -->
                  
                        @php 
                           $reviews = App\Models\Review::where('listing_id', $listing->id)->where('reply_id', NULL)->where('type', 'real-estate')->get();
                        @endphp
                       @foreach($reviews as $review)
                       @php 
                        $users = App\Models\User::where('id', $review->user_id)->first();
                        $replies = App\Models\Review::where('reply_id', $review->id)->get();
                        $userReplyExists = auth()->check() ? App\Models\Review::where('reply_id', $review->id)->where('user_id', auth()->user()->id)->exists(): false;
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
                                            <h3 class="name">{{$users->name}}</h3>
                                            <p class="date">{{ \Carbon\Carbon::parse($review->created_at)->format('F j, Y . g:i a') }}</p>
                                        </div>
                                       
                                    </div>
                                    <div class="comment-content">
                                        <ul class="d-flex eClass gap-1 mb-2">
                                            @for($i = 1; $i <= 5; $i++ )
                                                   @if($i <= $review->rating)
                                                        <img src="{{ asset('assets/frontend/images/icons/star-yellow-17.svg') }}" alt="">
                                                        @else
                                                        <img src="{{ asset('assets/frontend/images/icons/star-gray-17.svg') }}" alt="">
                                                     @endif
                                               @endfor   
                                        </ul>
                                        <p class="info">{{$review->review}}</p>
                                    </div>
                                    @if(auth()->user() && auth()->user()->id == $listing->user_id && !$userReplyExists)
                                        <button class="comment-reply-btn" data-bs-toggle="modal" data-bs-target="#exampleModal{{$review->id}}">{{get_phrase('Reply')}}</button>
                                    @endif
                                </div>
                            </div>
                            {{-- Reply Modal --}}
                            <form action="{{route('listing.review.reply', ['id' => $review->id])}}" method="POST" class="modal fade" id="exampleModal{{$review->id}}" tabindex="-1" aria-labelledby="exampleModalLabel{{$review->id}}" aria-hidden="true">
                                @csrf
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel{{$review->id}}">{{get_phrase('Reply Review')}}</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-20">
                                                <label  class="form-label smform-label2 mb-16">{{ get_phrase('Review*') }}</label>
                                                <textarea class="form-control mform-control review-textarea" name="review"  required></textarea>
                                                <input type="hidden" name="reply_id" value="{{$review->id}}">
                                                <input type="hidden" name="agent_id" value="{{$review->agent_id}}">
                                                <input type="hidden" name="listing_id" value="{{$review->listing_id}}">
                                                <input type="hidden" name="listing_types" value="{{$review->type}}">
                                            </div>    
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{get_phrase('Close')}}</button>
                                        <button type="submit" class="btn btn-primary">{{get_phrase('Save changes')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- All Reply -->

                              <!-- Display Replies -->
                            
                                @if($replies->count() > 0)
                                <ul class="comment-replies">
                                    @foreach($replies as $reply)
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
                                                            <h3 class="name">{{$reply_user->name}}</h3>
                                                            <p class="date">{{ \Carbon\Carbon::parse($reply->created_at)->format('F j, Y . g:i a') }}</p>
                                                        </div>
                                                        @if(auth()->user() && auth()->user()->id == $listing->user_id)
                                                        <div class="dropdown">
                                                            <button type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <img src="{{asset('assets/frontend/images/icons/menu-dots-vertical.svg')}}" alt="">
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li><a class="dropdown-item" href="javascript:;" onclick="edit_modal('modal-md','{{route('listing.review.edit',['id'=>$reply->id])}}','{{get_phrase('Update Review')}}')">{{get_phrase('Edit')}}</a></li>
                                                                <li><a class="dropdown-item" href="javascript:;" onclick="delete_modal('{{route('listing.review.delete',['id'=>$reply->id])}}')" href="javascript:void(0);">{{get_phrase("Delete")}}</a></li>
                                                            </ul>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div class="comment-content">
                                                        <p class="info">{{$reply->review}}</p>
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
                    $ownReview = App\Models\Review::where('listing_id', $listing->id)->where('type', 'real-estate')
                        ->where('user_id', auth()->user()->id)->whereNull('reply_id')
                        ->first();
                }
            @endphp
            @if(auth()->check() && auth()->user()->id !== $listing->user_id) 
                @if(!$user_review_count) 
                    <!-- Add Review -->
                    <div class="atndetails-edit-reviews" id="add_review">
                        <h2 class="title mb-20">{{ get_phrase('Add Your Review') }}</h2>
                        <form action="{{ route('listing.review', ['id' => $listing->id]) }}" method="post">
                            @csrf
                            <div class="realdetails-review-form">
                                <div class="mb-16">
                                    <input type="hidden" name="agent_id" value="{{ $listing->user_id }}">
                                    <input type="hidden" name="listing_type" value="{{ $listing->type }}">
                                    <label class="form-label smform-label2 mb-16">{{ get_phrase('Rating') }}</label>
                                    <select class="mNiceSelect review-select mform-control" name="rating" required>
                                        <option selected>{{ get_phrase('Select Rating') }}</option>
                                        <option value="1">{{get_phrase('1')}}</option>
                                        <option value="2">{{get_phrase('2')}}</option>
                                        <option value="3">{{get_phrase('3')}}</option>
                                        <option value="4">{{get_phrase('4')}}</option>
                                        <option value="5">{{get_phrase('5')}}</option>
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
                    <!-- Edit Review -->
                    <div class="atndetails-edit-reviews" id="update_review">
                        <h2 class="title mb-20">{{ get_phrase('Update Your Review') }}</h2>
                        <form action="{{ route('listing.review.update', ['id' => $listing->id]) }}" method="post">
                            @csrf
                            <div class="realdetails-review-form">
                                <div class="mb-16">
                                    <input type="hidden" name="agent_id" value="{{ $listing->user_id }}">
                                    <input type="hidden" name="listing_type" value="{{ $listing->type }}">
                                    <label class="form-label smform-label2 mb-16">{{ get_phrase('Rating') }}</label>
                                    <select class="mNiceSelect review-select mform-control" name="rating" required>
                                        <option value="1" {{ isset($user_review_count) && $user_review_count->rating == 1 ? 'selected' : '' }}>{{get_phrase('1')}}</option>
                                        <option value="2" {{ isset($user_review_count) && $user_review_count->rating == 2 ? 'selected' : '' }}>{{get_phrase('2')}}</option>
                                        <option value="3" {{ isset($user_review_count) && $user_review_count->rating == 3 ? 'selected' : '' }}>{{get_phrase('3')}}</option>
                                        <option value="4" {{ isset($user_review_count) && $user_review_count->rating == 4 ? 'selected' : '' }}>{{get_phrase('4')}}</option>
                                        <option value="5" {{ isset($user_review_count) && $user_review_count->rating == 5 ? 'selected' : '' }}>{{get_phrase('5')}}</option>
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
            @endif

                     {{-- Custom Field --}}
                     
                            @include('frontend.custom_field')
                     
                     {{-- Custom Field --}} 

                </div>
                <div class="col-xl-4 col-lg-5">
                    <div class="realdetails-sidebar">
                        <h1 class="title mb-20">{{get_phrase('Book a Meeting')}}</h1>
                        
                        @if (addon_status('form_builder') == 1 && get_settings('form_builder') == 1)
                           @include('frontend.form_builder.form')  
                        @else
                        <form action="{{ route('customerBookAppointment') }}" method="post">
                            @csrf
                            <input type="hidden" name="listing_type" value="real-estate">
                            <input type="hidden" name="listing_id" value="{{ $listing->id }}">
                            <input type="hidden" name="agent_id" value="{{ $listing->user_id }}">
                            <div class="realdetails-meeting-form">
                                <div class="mb-20">
                                    <label for="datetime" class="form-label mform-label mb-14">{{get_phrase('Select Date and Time')}}</label>
                                    <input type="text" name="date"  placeholder="{{get_phrase('Select date')}}" class="form-control mform-control flat-input-picker3 input-calendar-icon" id="datetime" required />
                                </div>
                                <div class="meeting-input-wrap mb-14">
                                    <label class="form-label mform-label mb-14">{{get_phrase('Tour Type')}}</label>
                                    <div class="btn-group tour-type-group" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="btn-check" name="type" value="person" id="btnradio1" autocomplete="off" checked>
                                        <label class="btn btn-outline-primary" for="btnradio1">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9.99935 18.9596C5.05768 18.9596 1.04102 14.943 1.04102 10.0013C1.04102 5.05964 5.05768 1.04297 9.99935 1.04297C14.941 1.04297 18.9577 5.05964 18.9577 10.0013C18.9577 14.943 14.941 18.9596 9.99935 18.9596ZM9.99935 2.29297C5.74935 2.29297 2.29102 5.7513 2.29102 10.0013C2.29102 14.2513 5.74935 17.7096 9.99935 17.7096C14.2493 17.7096 17.7077 14.2513 17.7077 10.0013C17.7077 5.7513 14.2493 2.29297 9.99935 2.29297Z" fill="#242429"/>
                                                <path d="M8.81719 12.9846C8.65052 12.9846 8.49219 12.918 8.37552 12.8013L6.01719 10.443C5.77552 10.2013 5.77552 9.8013 6.01719 9.55964C6.25885 9.31797 6.65885 9.31797 6.90052 9.55964L8.81719 11.4763L13.1005 7.19297C13.3422 6.9513 13.7422 6.9513 13.9839 7.19297C14.2255 7.43464 14.2255 7.83463 13.9839 8.0763L9.25885 12.8013C9.14219 12.918 8.98385 12.9846 8.81719 12.9846Z" fill="#242429"/>
                                            </svg>
                                            <span>{{get_phrase('In Person')}}</span>
                                        </label>
                                      
                                        <input type="radio" class="btn-check" name="type" value="video" id="btnradio2" autocomplete="off">
                                        <label class="btn btn-outline-primary" for="btnradio2">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10.7327 17.3839H5.67435C2.71602 17.3839 1.66602 15.3089 1.66602 13.3755V6.62552C1.66602 3.74219 2.79102 2.61719 5.67435 2.61719H10.7327C13.616 2.61719 14.741 3.74219 14.741 6.62552V13.3755C14.741 16.2589 13.616 17.3839 10.7327 17.3839ZM5.67435 3.88385C3.49935 3.88385 2.93268 4.45052 2.93268 6.62552V13.3755C2.93268 14.4005 3.29102 16.1172 5.67435 16.1172H10.7327C12.9077 16.1172 13.4743 15.5505 13.4743 13.3755V6.62552C13.4743 4.45052 12.9077 3.88385 10.7327 3.88385H5.67435Z" fill="#242429"/>
                                                <path d="M17.3158 15.0911C16.9574 15.0911 16.4991 14.9744 15.9741 14.6078L13.7491 13.0494C13.5824 12.9328 13.4824 12.7411 13.4824 12.5328V7.46609C13.4824 7.25776 13.5824 7.06609 13.7491 6.94943L15.9741 5.39109C16.9658 4.69943 17.6908 4.89943 18.0324 5.07443C18.3741 5.25776 18.9574 5.73276 18.9574 6.94109V13.0494C18.9574 14.2578 18.3741 14.7411 18.0324 14.9161C17.8741 15.0078 17.6241 15.0911 17.3158 15.0911ZM14.7408 12.1994L16.6991 13.5661C17.0741 13.8244 17.3408 13.8494 17.4491 13.7911C17.5658 13.7328 17.6908 13.4994 17.6908 13.0494V6.94943C17.6908 6.49109 17.5574 6.26609 17.4491 6.20776C17.3408 6.14943 17.0741 6.17443 16.6991 6.43276L14.7408 7.79943V12.1994Z" fill="#242429"/>
                                            </svg>
                                            <span>{{get_phrase('Video Chat')}}</span>
                                        </label>
                                    </div>
                                </div>
                               
                                <input type="text" class="form-control mform-control mb-14" name="name" placeholder="Name" required>
                                <input type="number" class="form-control mform-control mb-14" name="phone" placeholder="Phone" required>
                                <input type="email" class="form-control mform-control mb-14" name="email" placeholder="Email" required>
                                <textarea class="form-control mform-control review-textarea mb-14" name="message" placeholder="Message" required></textarea>
                                <button type="submit" class="submit-fluid-btn">{{get_phrase('Submit Now')}}</button>
                            </div>
                        </form>
                        @endif
                        @if (Auth::check())
                            @if (isset(auth()->user()->id) && auth()->user()->id == $listing->user_id)
                                @php
                                    $existingClaim = \App\Models\ClaimedListing::where('listing_id', $listing->id)->where('listing_type', $listing->type)->where('user_id', auth()->user()->id)->exists();
                                @endphp
                                @if (!$existingClaim)
                                    <a href="javascript:;" onclick="edit_modal('modal-md','{{ route('claimListingForm',['type'=>$listing->type ,'id'=>$listing->id]) }}','{{ get_phrase('Claim Listing') }}')" class="submit-fluid-btn2 mt-2">
                                        {{ get_phrase('Claim Listing') }}
                                    </a>
                                @else
                                    <button type="button" class="submit-fluid-btn mt-2" disabled>
                                        {{ get_phrase('Already Claimed') }}
                                    </button>
                                @endif
                            @endif
                       @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Main Content Area -->

    <!-- Start Related Product Area -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="in-title3-24px mb-20">{{get_phrase('Related Property')}}</h1>
                </div>
            </div>
            <div class="row row-28 mb-80">
                @php 
                $RealEstateListings = App\Models\RealEstateListing::where('status', $listing->status)->where('visibility', 'visible')->where('id', '!=', $listing->id)->take(4)->get();
                @endphp
                <!-- Single Card -->
                @foreach($RealEstateListings->sortByDesc('created_at') as $listings)
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                    <div class="single-grid-card">
                        <!-- Banner Slider -->
                        <div class="grid-slider-area">
                            @php
                                $images = json_decode($listings->image);
                                $image = isset($images[0]) ? $images[0] : null;
                                $claimStatus = App\Models\ClaimedListing::where('listing_id', $listings->id)->where('listing_type', 'real-estate')->first(); 
                            @endphp
                            <a class="w-100 h-100" href="{{route('listing.details',['type'=>$type, 'id'=>$listings->id, 'slug'=>slugify($listings->title)])}}">
                                <img class="card-item-image" src="{{ get_all_image('listing-images/' . $image) }}">
                            </a>
                            <p class="card-light-text re-dark-light capitalize">{{$listings->status}}</p>
                            @php
                              $is_in_wishlist = check_wishlist_status($listings->id, $listings->type);
                            @endphp
                            <a href="javascript:void(0);" data-bs-toggle="tooltip" 
                            data-bs-title="{{ $is_in_wishlist ? get_phrase('Remove from Wishlist') : get_phrase('Add to Wishlist') }}" onclick="PopuralupdateWishlist(this, '{{ $listings->id }}')"  class="grid-list-bookmark white-bookmark {{ $is_in_wishlist ? 'active' : '' }}">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.4361 3C12.7326 3.01162 12.0445 3.22023 11.4411 3.60475C10.8378 3.98927 10.3407 4.53609 10 5.18999C9.65929 4.53609 9.16217 3.98927 8.55886 3.60475C7.95554 3.22023 7.26738 3.01162 6.56389 3C5.44243 3.05176 4.38583 3.57288 3.62494 4.44953C2.86404 5.32617 2.4607 6.48707 2.50302 7.67861C2.50302 10.6961 5.49307 13.9917 8.00081 16.2262C8.56072 16.726 9.26864 17 10 17C10.7314 17 11.4393 16.726 11.9992 16.2262C14.5069 13.9917 17.497 10.6961 17.497 7.67861C17.5393 6.48707 17.136 5.32617 16.3751 4.44953C15.6142 3.57288 14.5576 3.05176 13.4361 3Z" fill="#44A1ED"/>
                                </svg>                                                  
                            </a>
                        </div>
                        <div class="reals-grid-details position-relative">
                            <div class="location d-flex">
                                @php
                                $city_name = App\Models\City::where('id',$listings->city)->first()->name;
                                $country_name = App\Models\Country::where('id',$listings->country)->first()->name;
                              @endphp
                                <img src="{{asset('assets/frontend/images/icons/location-gray3-16.svg')}}" alt="">
                                <p class="info fw-medium">{{$city_name.', '.$country_name}} </p>
                            </div>
                            <div class="reals-grid-title mb-16">
                                <a href="{{route('listing.details',['type'=>$type, 'id'=>$listings->id, 'slug'=>slugify($listings->title)])}}" class="title">
                                    @if(isset($claimStatus) && $claimStatus->status == 1) 
                                    <span data-bs-toggle="tooltip" 
                                    data-bs-title=" {{ get_phrase('This listing is verified') }}">
                                    <svg fill="none" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><linearGradient id="paint0_linear_16_1334" gradientUnits="userSpaceOnUse" x1="12" x2="12" y1="-1.2" y2="25.2"><stop offset="0" stop-color="#ce9ffc"/><stop offset=".979167" stop-color="#7367f0"/></linearGradient><path d="m3.783 2.826 8.217-1.826 8.217 1.826c.2221.04936.4207.17297.563.3504.1424.17744.22.39812.22.6256v9.987c-.0001.9877-.244 1.9602-.7101 2.831s-1.14 1.6131-1.9619 2.161l-6.328 4.219-6.328-4.219c-.82173-.5478-1.49554-1.2899-1.96165-2.1605-.46611-.8707-.71011-1.8429-.71035-2.8305v-9.988c.00004-.22748.07764-.44816.21999-.6256.14235-.17743.34095-.30104.56301-.3504zm8.217 10.674 2.939 1.545-.561-3.272 2.377-2.318-3.286-.478-1.469-2.977-1.47 2.977-3.285.478 2.377 2.318-.56 3.272z" fill="url(#paint0_linear_16_1334)"/></svg>
                                    </span>
                                    @endif
                                    {{$listings->title}} </a>
                                <p class="info">{{substr_replace($listings->description, "...", 50)}}</p>
                            </div>
                            <div class="reals-bed-bath-sqft d-flex align-items-center flex-wrap">
                                <div class="item d-flex align-items-center">
                                    <img src="{{asset('assets/frontend/images/icons/bed-gray-16.svg')}}" alt="">
                                    <p class="total">{{$listings->bed.' '.get_phrase('Bed')}}</p>
                                </div>
                                <div class="item d-flex align-items-center">
                                    <img src="{{asset('assets/frontend/images/icons/bath-gray-16.svg')}}" alt="">
                                    <p class="total">{{$listings->bath.' '.get_phrase('Bath')}}</p>
                                </div>
                                <div class="item d-flex align-items-center">
                                    <img src="{{asset('assets/frontend/images/icons/resize-arrows-gray-16.svg')}}" alt="">
                                    <p class="total">{{$listings->size.' '.get_phrase('sqft')}}</p>
                                </div>
                            </div>
                            <div class="reals-grid-price-see d-flex align-items-center justify-content-between">
                                <div class="prices d-flex">
                                    <p class="new-price">{{currency($listings->price)}}</p>
                                     @if(!empty($listings->discount))
                                       <p class="old-price">{{ currency($listings->discount) }}</p>
                                    @endif
                                </div>
                                <a href="{{route('listing.details',['type'=>$type, 'id'=>$listings->id, 'slug'=>slugify($listings->title)])}}" class="reals-grid-view realsn-grid-view stretched-link">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.6499 9.33752H6.8999C6.5924 9.33752 6.3374 9.08252 6.3374 8.77502C6.3374 8.46752 6.5924 8.21252 6.8999 8.21252H10.6499C10.9574 8.21252 11.2124 8.46752 11.2124 8.77502C11.2124 9.08252 10.9574 9.33752 10.6499 9.33752Z" fill="#555558"/>
                                        <path d="M8.7749 11.2125C8.4674 11.2125 8.2124 10.9575 8.2124 10.65V6.90002C8.2124 6.59252 8.4674 6.33752 8.7749 6.33752C9.0824 6.33752 9.3374 6.59252 9.3374 6.90002V10.65C9.3374 10.9575 9.0824 11.2125 8.7749 11.2125Z" fill="#555558"/>
                                        <path d="M8.625 16.3125C4.3875 16.3125 0.9375 12.8625 0.9375 8.625C0.9375 4.3875 4.3875 0.9375 8.625 0.9375C12.8625 0.9375 16.3125 4.3875 16.3125 8.625C16.3125 12.8625 12.8625 16.3125 8.625 16.3125ZM8.625 2.0625C5.0025 2.0625 2.0625 5.01 2.0625 8.625C2.0625 12.24 5.0025 15.1875 8.625 15.1875C12.2475 15.1875 15.1875 12.24 15.1875 8.625C15.1875 5.01 12.2475 2.0625 8.625 2.0625Z" fill="#555558"/>
                                        <path d="M16.5001 17.0625C16.3576 17.0625 16.2151 17.01 16.1026 16.8975L13.5003 14.2955C13.2828 14.078 13.2828 13.718 13.5003 13.5005C13.7178 13.283 14.0778 13.283 14.2953 13.5005L16.8976 16.1025C17.1151 16.32 17.1151 16.68 16.8976 16.8975C16.7851 17.01 16.6426 17.0625 16.5001 17.0625Z" fill="#555558"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <!-- Single Card -->
                
            </div>
        </div>
    </section>
    <!-- End Related Product Area -->


    <!-- Start Modal Area -->
    <div class="modal modal-main-xl fade" id="imageViewModal" tabindex="-1" aria-labelledby="imageViewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="alm-header-wrap d-flex align-items-center">
                    <div class="alm-header-title-wrap d-flex align-items-center justify-content-between">
                        <h3 class="xl-modal-title">{{$listing->title}}</h3>
                        <div class="alm-rating-review d-flex align-items-center gap-1">
                            <img src="{{asset('assets/frontend/images/icons/star-yellow-16.svg')}}" alt="">
                            <p>({{count($totalReview) ?? 0}} {{get_phrase('REVIEWS')}})</p>
                        </div>
                    </div>
                    <ul class="alm-hlist-group align-items-center d-flex">
                        <li class="alm-hlist-item">
                            <svg viewBox="0 0 31 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_164_10032)">
                                <path d="M26.9927 13.9327V5.86933C26.9927 4.2297 25.6128 2.89575 23.9166 2.89575H6.89186C5.19568 2.89575 3.81586 4.2297 3.81586 5.86933V13.9327C1.86141 14.3872 0.404297 16.0902 0.404297 18.117V24.1312C0.404297 24.6084 0.804434 24.9952 1.29803 24.9952H3.8158V27.0847C3.8158 27.5618 4.21594 27.9486 4.70953 27.9486C5.20312 27.9486 5.60326 27.5618 5.60326 27.0847V24.9952H25.2052V27.0847C25.2052 27.5618 25.6054 27.9486 26.0989 27.9486C26.5925 27.9486 26.9927 27.5618 26.9927 27.0847V24.9952H29.5104C30.004 24.9952 30.4042 24.6084 30.4042 24.1312V18.117C30.4043 16.0902 28.9472 14.3872 26.9927 13.9327ZM5.60332 5.86933C5.60332 5.1825 6.18141 4.62369 6.89186 4.62369H23.9167C24.6272 4.62369 25.2053 5.1825 25.2053 5.86933V13.8127H22.2519V12.4497C22.2519 10.1915 20.3512 8.35427 18.0152 8.35427H12.7935C10.4574 8.35427 8.55686 10.1915 8.55686 12.4497V13.8127H5.60332V5.86933ZM20.4644 12.4497V13.8127H10.3442V12.4497C10.3442 11.1442 11.4429 10.0821 12.7934 10.0821H18.0151C19.3656 10.0821 20.4644 11.1443 20.4644 12.4497ZM2.19176 23.2673V18.117C2.19176 16.6964 3.38736 15.5406 4.85695 15.5406H25.9515C27.4211 15.5406 28.6167 16.6964 28.6167 18.117V23.2673H2.19176Z" fill="#9098A4"></path>
                                </g>
                                <defs>
                                <clipPath id="clip0_164_10032">
                                <rect width="30" height="29" fill="white" transform="translate(0.404297 0.922119)"></rect>
                                </clipPath>
                                </defs>
                            </svg>
                            <p class="alm-hlist-totalitem">{{$listing->bed}}</p>
                            <h4 class="alm-hlist-title">{{get_phrase('Bedrooms')}}</h4>
                        </li>
                        <li class="alm-hlist-item">
                            <svg viewBox="0 0 31 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_164_10027)">
                                <path d="M27.3978 14.7191H13.8325C10.7296 14.7191 7.70958 14.1262 4.83884 12.956V4.0022C4.83884 3.16756 5.49596 2.48853 6.30368 2.48853H7.47555C8.28327 2.48853 8.9404 3.16756 8.9404 4.0022V4.43184C7.5894 4.82824 6.59665 6.11365 6.59665 7.63501V8.84595C6.59665 9.34752 6.99016 9.75415 7.47555 9.75415H12.1631C12.6484 9.75415 13.042 9.34752 13.042 8.84595V7.63501C13.042 6.11365 12.0492 4.8283 10.6982 4.43184V4.0022C10.6982 2.16599 9.25253 0.672119 7.47555 0.672119H6.30368C4.52671 0.672119 3.08102 2.16599 3.08102 4.0022V12.3147C1.96956 12.1879 0.856395 12.8055 0.37909 13.9149C0.0930352 14.5798 0.074754 15.3201 0.327469 15.9994C0.580184 16.6789 1.07378 17.2158 1.71731 17.5114C1.78124 17.5408 1.84546 17.5693 1.9095 17.5982V21.0764C1.9095 23.8836 3.28616 26.3645 5.37831 27.8368L3.81491 30.26C3.54561 30.6774 3.65477 31.2413 4.05866 31.5195C4.20854 31.6227 4.37782 31.6721 4.5454 31.6721C4.8294 31.6721 5.10813 31.5301 5.27747 31.2675L6.94059 28.6896C7.83327 29.0513 8.80434 29.2502 9.8196 29.2502H20.3665C21.3817 29.2502 22.3528 29.0513 23.2455 28.6896L24.9087 31.2675C25.0781 31.5301 25.3567 31.6721 25.6407 31.6721C25.8082 31.6721 25.9776 31.6227 26.1275 31.5195C26.5314 31.2413 26.6405 30.6774 26.3712 30.26L24.8078 27.8368C26.9 26.3645 28.2767 23.8836 28.2767 21.0765V20.0121C29.2997 19.6372 30.0345 18.6277 30.0345 17.4437C30.0345 15.9413 28.8517 14.7191 27.3978 14.7191ZM9.8193 6.12134C10.627 6.12134 11.2841 6.80037 11.2841 7.63501V7.93774H8.35446V7.63501C8.35446 6.80037 9.01159 6.12134 9.8193 6.12134ZM26.5189 21.0764C26.5189 24.5819 23.7589 27.4338 20.3665 27.4338H9.81966C6.42725 27.4338 3.66731 24.5819 3.66731 21.0764V18.3241C6.92559 19.5484 10.3356 20.1683 13.8325 20.1683H26.5189V21.0764ZM27.3978 18.3519H13.8325C9.87884 18.3519 6.04294 17.5106 2.43128 15.8516C1.98848 15.6483 1.78845 15.1104 1.98538 14.6528C2.13063 14.315 2.45307 14.1141 2.79028 14.1141C2.90923 14.1141 3.03005 14.1391 3.14548 14.192C6.53108 15.747 10.1267 16.5355 13.8325 16.5355H27.3978C27.8824 16.5355 28.2767 16.9429 28.2767 17.4437C28.2767 17.9444 27.8824 18.3519 27.3978 18.3519Z" fill="#9098A4"></path>
                                </g>
                                <defs>
                                <clipPath id="clip0_164_10027">
                                <rect width="30" height="31" fill="white" transform="translate(0.0917969 0.672119)"></rect>
                                </clipPath>
                                </defs>
                            </svg>
                            <p class="alm-hlist-totalitem">{{$listing->bath}}</p>
                            <h4 class="alm-hlist-title">{{get_phrase('Bathrooms')}}</h4>
                        </li>
                        <li class="alm-hlist-item">
                            <svg height="20" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.940828 11.0985C0.873827 11.0036 0.826492 10.8965 0.801568 10.7833C0.776645 10.6701 0.774629 10.5532 0.795639 10.4392C0.816649 10.3253 0.860266 10.2166 0.92396 10.1195C0.987653 10.0224 1.07015 9.93876 1.16668 9.87352L12.8703 1.86902C13.7306 1.29416 14.7443 0.987061 15.7816 0.987061C16.819 0.987061 17.8327 1.29416 18.693 1.86902L30.3966 9.87352C30.5894 10.0053 30.7215 10.2077 30.7639 10.4361C30.8062 10.6645 30.7554 10.9003 30.6224 11.0915C30.4895 11.2827 30.2855 11.4138 30.0552 11.4558C29.8249 11.4978 29.5872 11.4473 29.3944 11.3155L17.6943 3.31627C17.1297 2.9389 16.4643 2.7373 15.7834 2.7373C15.1025 2.7373 14.4371 2.9389 13.8725 3.31627L2.16889 11.3225C2.07345 11.3879 1.96596 11.4339 1.85257 11.458C1.73917 11.4822 1.62209 11.4839 1.50803 11.4631C1.39397 11.4423 1.28516 11.3994 1.18784 11.3368C1.09051 11.2742 1.00657 11.1933 0.940828 11.0985ZM30.7812 29.8515C30.7812 30.0836 30.6883 30.3061 30.5229 30.4702C30.3574 30.6343 30.133 30.7265 29.899 30.7265H1.66778C1.4338 30.7265 1.2094 30.6343 1.04395 30.4702C0.878505 30.3061 0.785556 30.0836 0.785556 29.8515C0.785556 29.6195 0.878505 29.3969 1.04395 29.2328C1.2094 29.0687 1.4338 28.9765 1.66778 28.9765H5.19669V27.0655C4.68243 26.8852 4.23691 26.5517 3.92107 26.1106C3.60523 25.6696 3.4345 25.1425 3.43224 24.6015V21.826C3.43134 21.4814 3.49934 21.14 3.6323 20.8216C3.76525 20.5032 3.96053 20.2141 4.20683 19.971L4.83145 19.3515L3.68985 18.221C3.60782 18.1397 3.54275 18.0431 3.49836 17.9368C3.45397 17.8305 3.43112 17.7166 3.43112 17.6015C3.43112 17.4865 3.45397 17.3725 3.49836 17.2663C3.54275 17.16 3.60782 17.0634 3.68985 16.982C3.8555 16.8177 4.08018 16.7254 4.31446 16.7254C4.43046 16.7254 4.54533 16.7481 4.6525 16.7921C4.75967 16.8361 4.85705 16.9007 4.93908 16.982L5.83718 17.8745L8.33036 12.9273C8.54912 12.4903 8.88687 12.1228 9.30536 11.8664C9.72385 11.61 10.2064 11.475 10.6983 11.4765H20.8686C21.3604 11.475 21.843 11.61 22.2614 11.8664C22.6799 12.1228 23.0177 12.4903 23.2365 12.9273L25.7296 17.8745L26.6277 16.982C26.7934 16.8177 27.0181 16.7254 27.2523 16.7254C27.4866 16.7254 27.7113 16.8177 27.877 16.982C28.0426 17.1463 28.1357 17.3692 28.1357 17.6015C28.1357 17.8339 28.0426 18.0567 27.877 18.221L26.7354 19.3515L27.36 19.971C27.6063 20.2141 27.8016 20.5032 27.9345 20.8216C28.0675 21.14 28.1355 21.4814 28.1346 21.826V24.6015C28.1323 25.1425 27.9616 25.6696 27.6457 26.1106C27.3299 26.5517 26.8844 26.8852 26.3701 27.0655V28.9765H29.899C30.133 28.9765 30.3574 29.0687 30.5229 29.2328C30.6883 29.3969 30.7812 29.6195 30.7812 29.8515ZM26.3701 21.826C26.3701 21.5944 26.2774 21.3723 26.1125 21.2083L25.1226 20.2265H6.44416L5.4543 21.2083C5.28938 21.3723 5.19674 21.5944 5.19669 21.826V24.6015C5.19669 24.8336 5.28964 25.0561 5.45509 25.2202C5.62054 25.3843 5.84493 25.4765 6.07891 25.4765H25.4879C25.7219 25.4765 25.9463 25.3843 26.1117 25.2202C26.2772 25.0561 26.3701 24.8336 26.3701 24.6015V21.826ZM7.50636 18.4765H24.0604L21.6573 13.7095C21.5839 13.5644 21.4713 13.4423 21.332 13.357C21.1927 13.2717 21.0323 13.2265 20.8686 13.2265H10.6983C10.5345 13.2265 10.3741 13.2717 10.2348 13.357C10.0955 13.4423 9.98288 13.5644 9.90954 13.7095L7.50636 18.4765ZM10.49 28.9765V27.2265H6.96114V28.9765H10.49ZM19.3123 28.9765V27.2265H12.2545V28.9765H19.3123ZM24.6057 28.9765V27.2265H21.0768V28.9765H24.6057ZM9.60782 21.9765H7.84337C7.60939 21.9765 7.38499 22.0687 7.21954 22.2328C7.05409 22.3969 6.96114 22.6195 6.96114 22.8515C6.96114 23.0836 7.05409 23.3061 7.21954 23.4702C7.38499 23.6343 7.60939 23.7265 7.84337 23.7265H9.60782C9.8418 23.7265 10.0662 23.6343 10.2316 23.4702C10.3971 23.3061 10.49 23.0836 10.49 22.8515C10.49 22.6195 10.3971 22.3969 10.2316 22.2328C10.0662 22.0687 9.8418 21.9765 9.60782 21.9765ZM23.7234 21.9765H21.959C21.725 21.9765 21.5006 22.0687 21.3352 22.2328C21.1697 22.3969 21.0768 22.6195 21.0768 22.8515C21.0768 23.0836 21.1697 23.3061 21.3352 23.4702C21.5006 23.6343 21.725 23.7265 21.959 23.7265H23.7234C23.9574 23.7265 24.1818 23.6343 24.3473 23.4702C24.5127 23.3061 24.6057 23.0836 24.6057 22.8515C24.6057 22.6195 24.5127 22.3969 24.3473 22.2328C24.1818 22.0687 23.9574 21.9765 23.7234 21.9765Z" fill="#9098A4"></path>
                            </svg>
                            <p class="alm-hlist-totalitem">{{$listing->garage}}</p>
                            <h4 class="alm-hlist-title">{{get_phrase('Garage')}}</h4>
                        </li>
                        <li class="alm-hlist-item">
                            <svg viewBox="0 0 35 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g filter="url(#filter0_d_164_10038)">
                                <path d="M25.1495 0.0107422H9.28409C7.98799 0.0130022 6.74563 0.528876 5.82915 1.44536C4.91267 2.36184 4.39679 3.6042 4.39453 4.9003V20.7657C4.39679 22.0618 4.91267 23.3042 5.82915 24.2207C6.74563 25.1371 7.98799 25.653 9.28409 25.6553H25.1495C26.4456 25.653 27.688 25.1371 28.6044 24.2207C29.5209 23.3042 30.0368 22.0618 30.0391 20.7657V4.9003C30.0368 3.6042 29.5209 2.36184 28.6044 1.44536C27.688 0.528876 26.4456 0.0130022 25.1495 0.0107422ZM28.3294 20.7657C28.3272 21.6084 27.9914 22.4159 27.3956 23.0118C26.7997 23.6076 25.9922 23.9434 25.1495 23.9456H9.28409C8.44141 23.9434 7.6339 23.6076 7.03804 23.0118C6.44217 22.4159 6.10642 21.6084 6.10417 20.7657V4.9003C6.10642 4.05763 6.44217 3.25011 7.03804 2.65425C7.6339 2.05838 8.44141 1.72263 9.28409 1.72038H25.1495C25.9922 1.72263 26.7997 2.05838 27.3956 2.65425C27.9914 3.25011 28.3272 4.05763 28.3294 4.9003V20.7657Z" fill="#9098A4"></path>
                                <path d="M24.9095 14.406C24.6828 14.406 24.4654 14.496 24.3051 14.6563C24.1447 14.8166 24.0547 15.0341 24.0547 15.2608V18.4663L11.5829 5.99455H14.7885C15.0152 5.99455 15.2326 5.90449 15.3929 5.74418C15.5532 5.58387 15.6433 5.36644 15.6433 5.13973C15.6433 4.91302 15.5532 4.69559 15.3929 4.53528C15.2326 4.37497 15.0152 4.28491 14.7885 4.28491H9.25779C9.10136 4.28491 8.95134 4.34705 8.84072 4.45767C8.73011 4.56828 8.66797 4.71831 8.66797 4.87474V10.4054C8.66797 10.6321 8.75803 10.8495 8.91834 11.0099C9.07865 11.1702 9.29607 11.2602 9.52279 11.2602C9.7495 11.2602 9.96692 11.1702 10.1272 11.0099C10.2875 10.8495 10.3776 10.6321 10.3776 10.4054V7.19984L22.8494 19.6716H19.6438C19.4171 19.6716 19.1997 19.7617 19.0394 19.922C18.8791 20.0823 18.789 20.2997 18.789 20.5264C18.789 20.7532 18.8791 20.9706 19.0394 21.1309C19.1997 21.2912 19.4171 21.3813 19.6438 21.3813H25.1745C25.3309 21.3813 25.481 21.3191 25.5916 21.2085C25.7022 21.0979 25.7643 20.9479 25.7643 20.7914V15.2608C25.7643 15.0341 25.6743 14.8166 25.514 14.6563C25.3536 14.496 25.1362 14.406 24.9095 14.406Z" fill="#9098A4"></path>
                                </g>
                                <defs>
                                <filter id="filter0_d_164_10038" x="0.394531" y="0.0107422" width="33.6445" height="33.6445" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
                                <feOffset dy="4"></feOffset>
                                <feGaussianBlur stdDeviation="2"></feGaussianBlur>
                                <feComposite in2="hardAlpha" operator="out"></feComposite>
                                <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"></feColorMatrix>
                                <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_164_10038"></feBlend>
                                <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_164_10038" result="shape"></feBlend>
                                </filter>
                                </defs>
                            </svg>
                            <p class="alm-hlist-totalitem">{{$listing->size}}</p>
                            <h4 class="alm-hlist-title">{{get_phrase('sqft')}}</h4>
                        </li>
                        <li class="alm-hlist-item">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_164_1319)">
                                 <path d="M15.5299 1.87337H14.7383V1.08171C14.7383 0.871743 14.6549 0.670379 14.5064 0.521913C14.3579 0.373447 14.1566 0.290039 13.9466 0.290039C13.7367 0.290039 13.5353 0.373447 13.3868 0.521913C13.2384 0.670379 13.1549 0.871743 13.1549 1.08171V1.87337H6.82161V1.08171C6.82161 0.871743 6.73821 0.670379 6.58974 0.521913C6.44127 0.373447 6.23991 0.290039 6.02995 0.290039C5.81998 0.290039 5.61862 0.373447 5.47016 0.521913C5.32169 0.670379 5.23828 0.871743 5.23828 1.08171V1.87337H4.44661C3.39719 1.87463 2.3911 2.29207 1.64904 3.03413C0.906979 3.77619 0.489538 4.78228 0.488281 5.83171L0.488281 15.3317C0.489538 16.3811 0.906979 17.3872 1.64904 18.1293C2.3911 18.8713 3.39719 19.2888 4.44661 19.29H15.5299C16.5794 19.2888 17.5855 18.8713 18.3275 18.1293C19.0696 17.3872 19.487 16.3811 19.4883 15.3317V5.83171C19.487 4.78228 19.0696 3.77619 18.3275 3.03413C17.5855 2.29207 16.5794 1.87463 15.5299 1.87337ZM2.07161 5.83171C2.07161 5.20182 2.32184 4.59773 2.76724 4.15233C3.21264 3.70693 3.81673 3.45671 4.44661 3.45671H15.5299C16.1598 3.45671 16.7639 3.70693 17.2093 4.15233C17.6547 4.59773 17.9049 5.20182 17.9049 5.83171V6.62337H2.07161V5.83171ZM15.5299 17.7067H4.44661C3.81673 17.7067 3.21264 17.4565 2.76724 17.0111C2.32184 16.5657 2.07161 15.9616 2.07161 15.3317V8.20671H17.9049V15.3317C17.9049 15.9616 17.6547 16.5657 17.2093 17.0111C16.7639 17.4565 16.1598 17.7067 15.5299 17.7067Z" fill="#9098A4"></path>
                               <path d="M9.98828 13.3525C10.6441 13.3525 11.1758 12.8209 11.1758 12.165C11.1758 11.5092 10.6441 10.9775 9.98828 10.9775C9.33244 10.9775 8.80078 11.5092 8.80078 12.165C8.80078 12.8209 9.33244 13.3525 9.98828 13.3525Z" fill="#9098A4"></path>
                               <path d="M6.03027 13.3525C6.68611 13.3525 7.21777 12.8209 7.21777 12.165C7.21777 11.5092 6.68611 10.9775 6.03027 10.9775C5.37444 10.9775 4.84277 11.5092 4.84277 12.165C4.84277 12.8209 5.37444 13.3525 6.03027 13.3525Z" fill="#9098A4"></path>
                               <path d="M13.9463 13.3525C14.6021 13.3525 15.1338 12.8209 15.1338 12.165C15.1338 11.5092 14.6021 10.9775 13.9463 10.9775C13.2905 10.9775 12.7588 11.5092 12.7588 12.165C12.7588 12.8209 13.2905 13.3525 13.9463 13.3525Z" fill="#9098A4"></path>
                               </g>
                               <defs>
                               <clipPath id="clip0_164_1319">
                               <rect width="19" height="19" fill="white" transform="translate(0.488281 0.290039)"></rect>
                               </clipPath>
                               </defs>
                            </svg>
                            <p class="alm-hlist-totalitem">{{$listing->year}}</p>
                            <h4 class="alm-hlist-title">{{get_phrase('Year Build')}}</h4>
                        </li>
                    </ul>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <div class="row mt-2 gx-3 row-gap-3">

                     @foreach (json_decode($listing->image) as $key => $image)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="sing-gallery">
                                <div class="gallery-head">
                                    <a class="veno-gallery-img" href="{{get_all_image('listing-images/'.$image)}}"><img src="{{get_all_image('listing-images/'.$image)}}" alt=""></a>
                                </div>
                              
                            </div>
                        </div>
                     @endforeach
                    
                </div>
            </div>
        </div>
        </div>
    </div>
    <!-- End Modal Area -->

  


@endsection
@push('js')

<script>
    "use strict";
    $('documnet').ready(function(){
     flatpickr("#datetime", {
         enableTime: true,
         dateFormat: "Y-m-d H:i:S", 
         minDate: "today",
     });
    });

 </script>

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
        url: '{{ route("wishlist.update") }}', 
        method: 'POST', 
        data: {
            listing_id: listingId,
            type: 'real-estate', 
            user_id: {{ auth()->check() ? auth()->id() : 'null' }}, 
            _token: '{{ csrf_token() }}',
        },
        success: function (response) {
            if (response.status === 'success') {
                success(response.message);
            } 
            else if (response.status === 'error') {
                bookmarkButton.toggleClass('active');
                const revertTooltipText = isActive ? 'Remove from Wishlist' : 'Add to Wishlist';
                bookmarkButton.attr('data-bs-title', revertTooltipText);
                const revertTooltipInstance = bootstrap.Tooltip.getInstance(button);
                if (revertTooltipInstance) revertTooltipInstance.dispose();
                new bootstrap.Tooltip(button);
            }
        },
        error: function (xhr) {
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

<script>
    "use strict";
    document.addEventListener('DOMContentLoaded', function () {
        var latitude = "{{ $listing->Latitude }}";
        var longitude = "{{ $listing->Longitude }}";
        var googleMapsUrl = 'https://www.google.com/maps?q=' + latitude + ',' + longitude;
        var linkElement = document.getElementById('dynamicLocation');
        linkElement.href = googleMapsUrl;
        linkElement.target = '_blank'; 
    });
</script>


@if (Auth::check())
<script>
 "use strict";
 function PopuralupdateWishlist(button, listingId) {
    const bookmarkButton = $(button);
    const isActive = bookmarkButton.hasClass('active');
    bookmarkButton.toggleClass('active'); 
    const newTooltipText = isActive ? 'Add to Wishlist' : 'Remove from Wishlist';
    bookmarkButton.attr('data-bs-title', newTooltipText);

    const tooltipInstance = bootstrap.Tooltip.getInstance(button);
    if (tooltipInstance) tooltipInstance.dispose(); 
    new bootstrap.Tooltip(button); 

    $.ajax({
        url: '{{ route("wishlist.update") }}', 
        method: 'POST', 
        data: {
            listing_id: listingId,
            type: 'real-estate', 
            user_id: {{ auth()->check() ? auth()->id() : 'null' }}, 
            _token: '{{ csrf_token() }}',
        },
        success: function (response) {
            if (response.status === 'success') {
                success(response.message);
            } 
            else if (response.status === 'error') {
                bookmarkButton.toggleClass('active');
                const revertTooltipText = isActive ? 'Remove from Wishlist' : 'Add to Wishlist';
                bookmarkButton.attr('data-bs-title', revertTooltipText);
                const revertTooltipInstance = bootstrap.Tooltip.getInstance(button);
                if (revertTooltipInstance) revertTooltipInstance.dispose();
                new bootstrap.Tooltip(button);
            }
        },
        error: function (xhr) {
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
            function PopuralupdateWishlist(listing_id) {
                warning("Please login first!");
            }
        </script>
@endif


@if (Auth::check())  
@if(isset(auth()->user()->id) && (auth()->user()->id != $listing->user_id)) 
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
            success: function (response) {
                if (response.status == 1) {
                    $("#followStatus").html('Unfollow');
                    success("Follow Successfully!");
                } else {
                    $("#followStatus").html('Follow');
                    success("Unfollow Successfully!");
                }
            },
            error: function () {
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


@if (Auth::check())  
@if(isset(auth()->user()->id) && (auth()->user()->id != $listing->user_id)) 
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
        warning("Please fill up the field first");
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

@endpush