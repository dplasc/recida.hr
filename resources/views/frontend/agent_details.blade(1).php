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
                    <img src="{{ $users->image ? asset('uploads/users/'.$users->image) : asset('image/placeholder.png') }}" alt="">
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
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_8_204)">
                                    <path d="M11.8626 8.46864L19.148 0H17.4216L11.0957 7.3532L6.04323 0H0.21582L7.85612 11.1193L0.21582 20H1.94231L8.6226 12.2348L13.9584 20H19.7858L11.8622 8.46864H11.8626ZM9.49793 11.2173L8.72381 10.1101L2.56439 1.29967H5.21619L10.1869 8.40994L10.961 9.51718L17.4224 18.7594H14.7706L9.49793 11.2177V11.2173Z" fill="white"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_8_204">
                                    <rect width="20" height="20" fill="white" transform="translate(0.000976562)"/>
                                    </clipPath>
                                    </defs>
                                </svg>     
                                {{get_phrase('Twitter.com')}}                          
                            </a></li>
                            <li><a href="{{$users->linkedin}}" class="mb-0" target="_Blank">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_8_210)">
                                    <path d="M18.5205 0H1.47754C0.661133 0 0.000976562 0.644531 0.000976562 1.44141V18.5547C0.000976562 19.3516 0.661133 20 1.47754 20H18.5205C19.3369 20 20.001 19.3516 20.001 18.5586V1.44141C20.001 0.644531 19.3369 0 18.5205 0ZM5.93457 17.043H2.96582V7.49609H5.93457V17.043ZM4.4502 6.19531C3.49707 6.19531 2.72754 5.42578 2.72754 4.47656C2.72754 3.52734 3.49707 2.75781 4.4502 2.75781C5.39941 2.75781 6.16894 3.52734 6.16894 4.47656C6.16894 5.42188 5.39941 6.19531 4.4502 6.19531ZM17.0439 17.043H14.0791V12.4023C14.0791 11.2969 14.0596 9.87109 12.5361 9.87109C10.9932 9.87109 10.7588 11.0781 10.7588 12.3242V17.043H7.79785V7.49609H10.6416V8.80078H10.6807C11.0752 8.05078 12.0439 7.25781 13.4854 7.25781C16.4893 7.25781 17.0439 9.23438 17.0439 11.8047V17.043Z" fill="white"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_8_210">
                                    <rect width="20" height="20" fill="white" transform="translate(0.000976562)"/>
                                    </clipPath>
                                    </defs>
                                </svg>    
                                {{get_phrase('linkedin.com')}}                     
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
                         <a href="mailto:" class="theme-btn1">{{get_phrase('Send Email')}}</a>
                        <a href="tel:" class="gray-btn1">{{get_phrase('Call')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Blog Post -->




@endsection