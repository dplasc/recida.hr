@extends('layouts.frontend')
@push('title', get_phrase('Login'))
@push('meta')@endpush
@section('frontend_layout')
    <style>
        .ua-slider-banner>img {
            height: 600px;
        }
    </style>
    <!-- Start Main Area -->
    <section class="mb-60px mt-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-5 col-lg-6">
                    <div>
                        <div class="mb-50px">
                            <h3 class="mb-3 in-title2-24px">{{ get_phrase('Get Started Now') }}</h3>
                            <p class="in-subtitle3-16px lh-base">{{ get_phrase('Enter your credentials to access your account') }}</p>
                        </div>
                        <div class="mb-30px">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mb-4">
                                    <label for="user-email" class="form-label ua-form-label mb-3">{{ get_phrase('Email') }}</label>
                                    <input type="email" class="form-control ua-form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="username@gmail.com" autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-20px">
                                    <div class="d-flex align-items-center justify-content-between column-gap-2 row-gap-1 flex-wrap mb-3">
                                        <label for="password" class="form-label ua-form-label">{{ get_phrase('Password') }}<span>*</span></label>
                                        <a href="{{ route('password.request') }}" class="ua-subtitle-14px ua-link">{{ get_phrase('Forget your password') }} ?</a>
                                    </div>
                                    <div class="at-password-group">
                                        <div class="toggle-icons">
                                            <img src="{{ asset('assets/frontend/images/icons/eye-slash-20.svg') }}" class="password-icon" toggle=".password-field1" alt="">
                                            <img src="{{ asset('assets/frontend/images/icons/eye-show-20.svg') }}" class="password-icon d-none" toggle=".password-field1" alt="">
                                        </div>
                                        <input type="password" class="form-control ua-form-control password-field1 @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="current-password" placeholder="Enter password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn ua-btn-dark w-100 mb-3">{{ get_phrase('Login') }}</button>
                                <p class="ua-subtitle-16px text-center">{{ get_phrase('Don\'t an account') }}? <a href="{{ route('register') }}" class="fw-semibold ua-link">{{ get_phrase('Sign up') }}</a></p>
                                
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
                                    @if (!empty($homeBanner) && is_array($homeBanner))
                                        @foreach ($homeBanner as $banner)
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
