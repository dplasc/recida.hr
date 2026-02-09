@extends('layouts.frontend')
@push('title', get_phrase('Verify  Email'))
@push('meta')@endpush
@section('frontend_layout')

<!-- Start Main Area -->
<section class="mb-60px mt-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-5 col-lg-6">
                <div>
                    <div class="mb-50px">
                        <h3 class="mb-3 in-title2-24px">{{ get_phrase('Email Verification') }}</h3>
                        <p class="in-subtitle3-16px lh-base">{{ get_phrase('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}</p>
    
                    </div>
                    <div class="mb-30px">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            @if (session('status') == 'verification-link-sent')
                                <p class="in-subtitle3-16px lh-base mb-3">{{ get_phrase('A new verification link has been sent to the email address.') }}</p>
                           @endif
                        
                           <button type="submit" class="btn ua-btn-dark w-100">{{ get_phrase('Click Verify Email') }}</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-7 col-lg-6">
                <div class="d-flex justify-content-center justify-content-lg-end">
                    <div class="ua-banner-slider-wrap">
                        @php
                          $homeBanner = json_decode(get_frontend_settings('mother_homepage_banner'), true);
                       @endphp
                        <!-- Swiper -->
                        <div class="swiper ua-slider">
                            <div class="swiper-wrapper">
                                @if(!empty($homeBanner) && is_array($homeBanner))
                                @foreach($homeBanner as $banner)
                                <div class="swiper-slide">
                                    <div class="ua-slider-banner">
                                        <img class="banner" src="{{ asset('uploads/mother_homepage_banner/' . $banner['image']) }}" alt="banner">
                                    </div>
                                    <div class="ua-slider-content">
                                        <img class="mb-3" src="{{ asset('assets/frontend/images/login/ua-star-shape.svg') }}" alt="shape">
                                        <h1 class="ua-title-36px text-white mb-3">{{ $banner['title'] }}</h1>
                                        <p class="in-subtitle-16px text-white ua-slider-subtitle-margin">{{ $banner['description'] }}</p>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="swiper-slide">
                                    <div class="ua-slider-banner">
                                        <img class="banner" src="{{ asset('assets/frontend/images/login/ua-login-banner1.webp') }}" alt="banner">
                                    </div>
                                    <div class="ua-slider-content">
                                        <img class="mb-3" src="{{ asset('assets/frontend/images/login/ua-star-shape.svg') }}" alt="shape">
                                        <h1 class="ua-title-36px text-white mb-3"></h1>
                                        <p class="in-subtitle-16px text-white ua-slider-subtitle-margin"></p>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Main Area -->

@endsection