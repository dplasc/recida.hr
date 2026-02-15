@extends('layouts.frontend')
@push('title', get_phrase('Agent Details'))
@push('meta')@endpush
@section('frontend_layout')
 
<!-- Start Blog Post -->
<section>
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <!-- Top Link Path -->
                <div class="top-link-path mb-4 mt-2 d-flex align-items-center flex-wrap row-gap-1">
                    <a href="{{route('home')}}">{{get_phrase('Home')}}</a>
                    <img src="{{asset('assets/frontend/images/icons/angle-right2-gray-20.svg')}}" alt="">
                    <a href="javascript:;">{{get_phrase('Agent')}}</a>
                    <img src="{{asset('assets/frontend/images/icons/angle-right2-gray-20.svg')}}" alt="">
                    <a href="javascript:;" class="active">{{get_phrase('Agent details')}}</a>
                </div>
            </div>
        </div>
        <div class="row row-28 mb-90 mt-3">
            <div class=" col-lg-4">
                <div class="gCard">
                    <img src="{{ $users->image ? asset('uploads/users/'.$users->image) : asset('image/placeholder.png') }}" alt="" loading="lazy" decoding="async" width="200" height="200">
                    <div class="footer-bottom-social">
                        <ul class="eSocials">
                            <li><a href="{{$users->facebook}}" target="_Blank">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_8_202)">
                                    <path d="M20.001 10C20.001 4.47715 15.5238 0 10.001 0C4.47813 0 0.000976562 4.47715 0.000976562 10C0.000976562 14.9912 3.65781 19.1283 8.43848 19.8785V12.8906H5.89941V10H8.43848V7.79688C8.43848 5.29063 9.93145 3.90625 12.2156 3.90625C13.3094 3.90625 14.4541 4.10156 14.4541 4.10156V6.5625H13.1932C11.951 6.5625 11.5635 7.3334 11.5635 8.125V10H14.3369L13.8936 12.8906H11.5635V19.8785C16.3441 19.1283 20.001 14.9912 20.001 10Z" fill="white"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_8_202">
                                    <rect width="20" height="20" fill="white" transform="translate(0.000976562)"/>
                                    </clipPath>
                                    </defs>
                                </svg>         
                                {{get_phrase('Facebook.com')}}               
                            </a></li>
                   <li><a href="{{$users->twitter}}" target="_Blank">
                                <i class="fab fa-instagram" style="font-size: 20px; color: white;"></i>
                                {{get_phrase('Instagram.com')}}                          
                            </a></li>

                            <li><a href="{{$users->linkedin}}" class="mb-0" target="_Blank">
                                <i class="fab fa-tiktok" style="font-size: 20px; color: white;"></i>
                                {{get_phrase('TikTok.com')}}                      
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="aGdescription">
                    <h4 class="in-title-4 fw-medium mb-20">{{$users->name}}</h4>
                    <p class="bio">{{$users->bio}}</p>
                    <ul>
                        @php 
                           $Beauty = App\Models\BeautyListing::where('user_id', $users->id)->where('visibility', 'visible')->count();
                           $Hotel = App\Models\HotelListing::where('user_id', $users->id)->where('visibility', 'visible') ->count();
                           $Restaurant = App\Models\RestaurantListing::where('user_id', $users->id)->where('visibility', 'visible')->count();
                           $Realestate = App\Models\RealEstateListing::where('user_id', $users->id)->where('visibility', 'visible')->count();
                           $Car = App\Models\CarListing::where('user_id', $users->id)->count();
                           $dynamic = App\Models\CustomListings::where('user_id', $users->id)->where('visibility', 'visible')->count();
                           $totalListing = $Beauty +  $Hotel + $Restaurant + $Realestate +  $Car + $dynamic;
                        @endphp 
                        <li>
                            <span>{{$totalListing}}</span>
                            <p>{{get_phrase('Listings')}}</p>
                        </li>
                    </ul>
                    <div class="restdetails-agent-btns d-flex align-items-center flex-wrap mt-4">
                         <a href="mailto:{{$users->email}}" class="theme-btn1">{{get_phrase('Send Email')}}</a>
                        <a href="tel:{{$users->phone}}" class="gray-btn1">{{get_phrase('Call')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Blog Post -->




@endsection