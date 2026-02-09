@extends('layouts.frontend')
@push('title', get_phrase('Real Estate Grid'))
@push('meta')@endpush
@section('frontend_layout')

 <!-- Start Content Area -->
 <section>
    <div class="container">
        <div class="row row-28 mb-80 mt-3">
            <!-- Sidebar -->
            <div class="col-xl-3 col-lg-4">
                @include('frontend.real-estate.sidebar_real-estate')
            </div>
            <!-- Right Content Area -->
            <div class="col-xl-9 col-lg-8">
                <!-- Top Filter Area -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="showing-result-header d-flex align-items-center justify-content-between flex-wrap">
                            <div class="listing-info info"> 
                             
                                    {{get_phrase('Showing').'  to '.count($listings).' '.get_phrase('of').' '.count($listings).' '.get_phrase('results')}} 
                              
                            </div>
                            <div class="filter-tab-switch d-flex align-items-center flex-wrap">
                                <a href="{{route('listing.view',['type'=>'real-estate','view'=>'grid'])}}" class="{{request()->is('listing/real-estate/grid')?'active':''}} grid-list">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M21.5 10.9V4.1C21.5 2.6 20.86 2 19.27 2H15.23C13.64 2 13 2.6 13 4.1V10.9C13 12.4 13.64 13 15.23 13H19.27C20.86 13 21.5 12.4 21.5 10.9Z" fill="#555558"/>
                                        <path d="M11 13.1V19.9C11 21.4 10.36 22 8.77 22H4.73C3.14 22 2.5 21.4 2.5 19.9V13.1C2.5 11.6 3.14 11 4.73 11H8.77C10.36 11 11 11.6 11 13.1Z" fill="#555558"/>
                                        <path d="M21.5 19.9V17.1C21.5 15.6 20.86 15 19.27 15H15.23C13.64 15 13 15.6 13 17.1V19.9C13 21.4 13.64 22 15.23 22H19.27C20.86 22 21.5 21.4 21.5 19.9Z" fill="#555558"/>
                                        <path d="M11 6.9V4.1C11 2.6 10.36 2 8.77 2H4.73C3.14 2 2.5 2.6 2.5 4.1V6.9C2.5 8.4 3.14 9 4.73 9H8.77C10.36 9 11 8.4 11 6.9Z" fill="#555558"/>
                                    </svg>                                            
                                </a>
                                <a href="{{route('listing.view',['type'=>'real-estate','view'=>'list'])}}" class="{{request()->is('listing/real-estate/list')?'active':''}} grid-list">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M22 5.21429C22 5.88619 21.4417 6.42857 20.75 6.42857H3.25C2.55833 6.42857 2 5.88619 2 5.21429C2 4.54238 2.55833 4 3.25 4H20.75C21.4417 4 22 4.54238 22 5.21429ZM7.41667 18.5714H3.25C2.55833 18.5714 2 19.1138 2 19.7857C2 20.4576 2.55833 21 3.25 21H7.41667C8.10833 21 8.66667 20.4576 8.66667 19.7857C8.66667 19.1138 8.10833 18.5714 7.41667 18.5714ZM14.0833 11.2857H3.25C2.55833 11.2857 2 11.8281 2 12.5C2 13.1719 2.55833 13.7143 3.25 13.7143H14.0833C14.775 13.7143 15.3333 13.1719 15.3333 12.5C15.3333 11.8281 14.775 11.2857 14.0833 11.2857Z" fill="#555558"/>
                                    </svg>                                            
                                </a>
                                <div class="switch-wrap">
                                    <div class="switch-button">
                                        <input type="checkbox" class="switch-checkbox" checked>
                                        <div class="knobs">
                                          <span></span>
                                        </div>
                                        <div class="layer"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Google Map -->
                @if (get_frontend_settings('map_position') == 'top')
                    <!-- Map Area -->
                    @include('frontend.map')
                @endif
                <div class="row">
                    <!-- Card Area -->
                    <div class="{{get_frontend_settings('map_position') == 'right'?'col-xl-8':'col-xl-12'}} col-lg-12 order-2 order-xl-1" id="right-map">
                        @if(count($listings) > 0)
                        <div class="row row-28">
                            @foreach ($listings->sortByDesc('created_at') as $listing)
                            <!-- Single Card -->
                            <div class="col-sm-6 {{get_frontend_settings('map_position') == 'right'?'col-sm-6':'col-xl-4'}} map-card">
                                <div class="single-grid-card">
                                    <!-- Banner Slider -->
                                    <div class="grid-slider-area">
                                        @php
                                            $images = json_decode($listing->image);
                                            $image = isset($images[0]) ? $images[0] : null;

                                            $claimStatus = App\Models\ClaimedListing::where('listing_id', $listing->id)->where('listing_type', 'real-estate')->first(); 
                                        @endphp
                                        <a class="w-100 h-100" href="{{route('listing.details',['type'=>$type, 'id'=>$listing->id, 'slug'=>slugify($listing->title)])}}">
                                            <img class="card-item-image" src="{{ get_all_image('listing-images/' . $image) }}">
                                        </a>
                                        <p class="card-light-text black-light capitalize">{{$listing->status}}</p>
                                        @php
                                           $is_in_wishlist = check_wishlist_status($listing->id, $listing->type);
                                       @endphp
                                      <a href="javascript:void(0);" data-bs-toggle="tooltip" 
                                      data-bs-title="{{ $is_in_wishlist ? get_phrase('Remove from Wishlist') : get_phrase('Add to Wishlist') }}" onclick="updateWishlist(this, '{{ $listing->id }}')"  class="grid-list-bookmark white-bookmark {{ $is_in_wishlist ? 'active' : '' }}">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M13.4361 3C12.7326 3.01162 12.0445 3.22023 11.4411 3.60475C10.8378 3.98927 10.3407 4.53609 10 5.18999C9.65929 4.53609 9.16217 3.98927 8.55886 3.60475C7.95554 3.22023 7.26738 3.01162 6.56389 3C5.44243 3.05176 4.38583 3.57288 3.62494 4.44953C2.86404 5.32617 2.4607 6.48707 2.50302 7.67861C2.50302 10.6961 5.49307 13.9917 8.00081 16.2262C8.56072 16.726 9.26864 17 10 17C10.7314 17 11.4393 16.726 11.9992 16.2262C14.5069 13.9917 17.497 10.6961 17.497 7.67861C17.5393 6.48707 17.136 5.32617 16.3751 4.44953C15.6142 3.57288 14.5576 3.05176 13.4361 3Z" fill="#6C1CFF"/>
                                            </svg>                                                 
                                        </a>
                                    </div>
                                    <div class="reals-grid-details position-relative">
                                        <div class="location d-flex">
                                            <img src="{{asset('assets/frontend/images/icons/location-sky-blue2-20.svg')}}" alt="">
                                            @php
                                                $city_name = App\Models\City::where('id',$listing->city)->first()->name;
                                                $country_name = App\Models\Country::where('id',$listing->country)->first()->name;
                                            @endphp
                                            <p class="info"> {{$city_name.', '.$country_name}} </p>
                                        </div>
                                        <div class="reals-grid-title mb-16">
                                            <a href="{{route('listing.details',['type'=>$type, 'id'=>$listing->id, 'slug'=>slugify($listing->title)])}}" class="title"> 
                                                @if(isset($claimStatus) && $claimStatus->status == 1) 
                                                <span data-bs-toggle="tooltip" 
                                                data-bs-title=" {{ get_phrase('This listing is verified') }}">
                                                <svg fill="none" height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><linearGradient id="paint0_linear_16_1334" gradientUnits="userSpaceOnUse" x1="12" x2="12" y1="-1.2" y2="25.2"><stop offset="0" stop-color="#ce9ffc"/><stop offset=".979167" stop-color="#7367f0"/></linearGradient><path d="m3.783 2.826 8.217-1.826 8.217 1.826c.2221.04936.4207.17297.563.3504.1424.17744.22.39812.22.6256v9.987c-.0001.9877-.244 1.9602-.7101 2.831s-1.14 1.6131-1.9619 2.161l-6.328 4.219-6.328-4.219c-.82173-.5478-1.49554-1.2899-1.96165-2.1605-.46611-.8707-.71011-1.8429-.71035-2.8305v-9.988c.00004-.22748.07764-.44816.21999-.6256.14235-.17743.34095-.30104.56301-.3504zm8.217 10.674 2.939 1.545-.561-3.272 2.377-2.318-3.286-.478-1.469-2.977-1.47 2.977-3.285.478 2.377 2.318-.56 3.272z" fill="url(#paint0_linear_16_1334)"/></svg>
                                                </span>
                                                @endif
                                                {{$listing->title}} </a>
                                            <p class="info"> {{substr_replace($listing->description, "...", 50)}}</p>
                                        </div>
                                        <div class="reals-bed-bath-sqft d-flex align-items-center flex-wrap">
                                            <div class="item d-flex align-items-center">
                                                <img src="{{asset('assets/frontend/images/icons/bed-gray-16.svg')}}" alt="">
                                                <p class="total">{{$listing->bed.' '.get_phrase('Bed')}}</p>
                                            </div>
                                            <div class="item d-flex align-items-center">
                                                <img src="{{asset('assets/frontend/images/icons/bath-gray-16.svg')}}" alt="">
                                                <p class="total">{{$listing->bath.' '.get_phrase('Bath')}}</p>
                                            </div>
                                            <div class="item d-flex align-items-center">
                                                <img src="{{asset('assets/frontend/images/icons/resize-arrows-gray-16.svg')}}" alt="">
                                                <p class="total">{{$listing->size.' '.get_phrase('sqft')}}</p>
                                            </div>
                                        </div>
                                        <div class="reals-grid-price-see d-flex align-items-center justify-content-between">
                                            <div class="prices d-flex">
                                                @if(!empty($listing->discount))
                                                <p class="new-price">{{ currency($listing->discount) }}</p>
                                                <p class="old-price">{{ currency($listing->price) }}</p>
                                                @elseif(!empty($listing->price))
                                                    <p class="new-price">{{ currency($listing->price) }}</p>
                                                @endif
                                            </div>
                                            <a href="{{route('listing.details',['type'=>$type, 'id'=>$listing->id, 'slug'=>slugify($listing->title)])}}" class="reals-grid-view stretched-link">
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
                            <div class="listing-pegination paginationColor">
                                {{ $listings->links() }}
                            </div>
                        </div>
                        @else 
                           @include('frontend.no_data')
                       @endif
                    </div>
                    @if (get_frontend_settings('map_position') == 'right')    
                        <!-- Map Area -->
                        <div class="col-xl-4 col-lg-12 order-1 order-xl-2">
                            @include('frontend.map')
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Content Area -->

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


    @endpush