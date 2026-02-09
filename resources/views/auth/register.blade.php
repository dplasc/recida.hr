@extends('layouts.frontend')
@push('title', get_phrase('Sign Up'))
@push('meta')@endpush
@section('frontend_layout')
<style>
.ua-slider-banner > img {
	height: 600px;
}
.mt-50px{
    margin-top: 50px;
}
</style>
<!-- Start Main Area -->
<section class="mb-60px mt-3">
    <div class="container">
        <div class="row">
            <div class="col-xl-5 col-lg-6">
                <div>
                    <div class="mb-50px mt-50px">
                        <h3 class="mb-3 in-title2-24px">{{ get_phrase('Get Started Now') }}</h3>
                        <p class="in-subtitle3-16px lh-base">{{ get_phrase('Enter your credentials to access your account') }}</p>
                    </div>
                    <div class="mb-30px">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="mb-4">
                                <label for="name" class="form-label ua-form-label mb-3">{{ get_phrase('Name') }}<span>*</span></label>
                                <input type="text" class="form-control ua-form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Your Name" aria-label="Your Name" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="email" class="form-label ua-form-label mb-3">{{ get_phrase('Email') }}<span>*</span></label>
                                <input type="email" class="form-control ua-form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Your Email" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-20px">
                                <div class="d-flex align-items-center justify-content-between column-gap-2 row-gap-1 flex-wrap mb-3">
                                    <label for="password" class="fform-label ua-form-label">{{ get_phrase('New Password') }}<span>*</span></label>
                                </div>
                                <div class="at-password-group">
                                    <div class="toggle-icons">
                                        <img src="{{ asset('assets/frontend/images/icons/eye-slash-20.svg') }}" class="password-icon" toggle=".password-field1" alt="">
                                        <img src="{{ asset('assets/frontend/images/icons/eye-show-20.svg') }}" class="password-icon d-none" toggle=".password-field1" alt="">
                                    </div>
                                    <input type="password" class="form-control ua-form-control password-field1 @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" aria-label="Password" required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-20px">
                                <div class="d-flex align-items-center justify-content-between column-gap-2 row-gap-1 flex-wrap mb-3">
                                    <label for="password" class="fform-label ua-form-label">{{ get_phrase('Confirm Password') }}<span>*</span></label>
                                </div>
                                <div class="at-password-group">
                                    <div class="toggle-icons">
                                        <img src="{{ asset('assets/frontend/images/icons/eye-slash-20.svg') }}" class="password-icon" toggle=".password-field2" alt="">
                                        <img src="{{ asset('assets/frontend/images/icons/eye-show-20.svg') }}" class="password-icon d-none" toggle=".password-field2" alt="">
                                    </div>
                                    <input type="password" class="form-control ua-form-control password-field2 @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="Confirmed Password" aria-label="password_confirmation" required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-30px">
                                <div class="form-check ua-form-check">
                                    <input class="form-check-input ua-form-check-input" type="checkbox" value="1" id="flexCheckDefault">
                                    <label class="form-check-label ua-form-check-label" for="flexCheckDefault">
                                        {{ get_phrase('I agree to the') }} <a href="{{route('terms-and-condition')}}" class="at-text-underline ua-link">{{ get_phrase('Terms & Policy') }}</a>
                                    </label>
                                </div>                                      
                            </div>
                            <button type="submit" class="btn ua-btn-dark w-100 mb-3">{{ get_phrase('Register') }}</button>
                            <p class="ua-subtitle-16px text-center">{{ get_phrase('Back to login') }}? <a href="{{ route('login') }}" class="fw-semibold ua-link">{{ get_phrase('Login') }}</a></p>
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
