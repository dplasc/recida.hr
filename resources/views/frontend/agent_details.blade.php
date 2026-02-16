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
                            @if(!empty($users->facebook))
                            <li><a href="{{$users->facebook}}" target="_Blank" style="display:flex; align-items:center; gap:10px; color:white;">
                                <span class="eSocialIcon" style="width:20px; display:inline-flex; justify-content:center;"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_8_202)">
                                    <path d="M20.001 10C20.001 4.47715 15.5238 0 10.001 0C4.47813 0 0.000976562 4.47715 0.000976562 10C0.000976562 14.9912 3.65781 19.1283 8.43848 19.8785V12.8906H5.89941V10H8.43848V7.79688C8.43848 5.29063 9.93145 3.90625 12.2156 3.90625C13.3094 3.90625 14.4541 4.10156 14.4541 4.10156V6.5625H13.1932C11.951 6.5625 11.5635 7.3334 11.5635 8.125V10H14.3369L13.8936 12.8906H11.5635V19.8785C16.3441 19.1283 20.001 14.9912 20.001 10Z" fill="white"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_8_202">
                                    <rect width="20" height="20" fill="white" transform="translate(0.000976562)"/>
                                    </clipPath>
                                    </defs>
                                </svg></span>         
                                {{get_phrase('Facebook.com')}}               
                            </a></li>
                            @endif
                            @if(!empty($users->twitter))
                            <li><a href="{{$users->twitter}}" target="_Blank" style="display:flex; align-items:center; gap:10px; color:white;">
                                <span class="eSocialIcon" style="width:20px; display:inline-flex; justify-content:center;"><svg width="20" height="20" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z" fill="currentColor"/></svg></span>
                                {{get_phrase('Instagram.com')}}                          
                            </a></li>
                            @endif
                            @if(!empty($users->linkedin))
                            <li><a href="{{$users->linkedin}}" class="mb-0" target="_Blank" style="display:flex; align-items:center; gap:10px; color:white;">
                                <span class="eSocialIcon" style="width:20px; display:inline-flex; justify-content:center;"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 448 512" fill="currentColor"><path d="M448 209.91a210.06 210.06 0 0 1-122.77-39.25V349.38A162.55 162.55 0 1 1 185 188.31V278.2a90.25 90.25 0 0 0 37.81 75.41V47.49h90.31a119.37 119.37 0 0 0 13.56-1.21V47.49h0A210.07 210.07 0 0 0 448 209.91Z"/></svg></span>
                                {{get_phrase('TikTok.com')}}                      
                            </a></li>
                            @endif
                            @if(!empty($users->youtube))
                            <li><a href="{{$users->youtube}}" target="_Blank" style="display:flex; align-items:center; gap:10px; color:white;">
                                <span class="eSocialIcon" style="width:20px; display:inline-flex; justify-content:center;"><svg width="20" height="20" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.007 2.007 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.007 2.007 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31.4 31.4 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.007 2.007 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A99.788 99.788 0 0 1 7.858 2h.193zM6.4 5.209v4.818l4.157-2.408L6.4 5.209z" fill="currentColor"/></svg></span>
                                {{get_phrase('YouTube.com')}}
                            </a></li>
                            @endif
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