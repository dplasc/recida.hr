@extends('layouts.frontend')
@push('title', get_phrase('Contact Us'))
@push('meta')@endpush
@section('frontend_layout')    
    
    <!-- Start Contact Area -->
    <section>
        <div class="container">
            <div class="row g-4 align-items-center mt-60px mb-80px">
                <div class="col-lg-6 col-xl-5">
                    <div>
                        <div class="mb-40px">
                            <h2 class="in-title-3 fw-semibold mb-20px">{{get_phrase('Get In Touch')}}</h2>
                            <p class="in-subtitle-2">{{get_phrase('Promote your business and get discovered with ease — List your services on Listing Atlas, the smart directory solution.')}}</p>
                        </div>
                        <div class="mb-40px">
                            <div class="d-flex align-items-center gap-3 mb-28px">
                                <div class="secondary-light-iconbox">
                                    <img src="{{asset('assets/frontend/images/icons/call-purple-26.svg')}}" alt="...">
                                </div>
                                <div>
                                    <h5 class="in-title-5 lh-1 fw-semibold mb-2">{{get_phrase('Phone')}}</h5>
                                    <p class="in-subtitle-2 lh-1">{{ get_settings('phone') }}</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3 mb-28px">
                                <div class="secondary-light-iconbox">
                                    <img src="{{asset('assets/frontend/images/icons/sms-purple-26.svg')}}" alt="icon">
                                </div>
                                <div>
                                    <h5 class="in-title-5 lh-1 fw-semibold mb-2">{{get_phrase('Email')}}</h5>
                                    <p class="in-subtitle-2 lh-1 text-break">{{ get_settings('system_email') }}</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="secondary-light-iconbox">
                                    <img src="{{asset('assets/frontend/images/icons/location-purple-26.svg')}}" alt="icon">
                                </div>
                                <div>
                                    <h5 class="in-title-5 lh-1 fw-semibold mb-2">{{get_phrase('Location')}}</h5>
                                    <p class="in-subtitle-2">{{get_settings('address')}}</p>
                                </div>
                            </div>
                        </div>
                        <ul class="d-flex align-items-center" style="list-style: none; padding: 0; margin: 0; gap: 15px;">
                            {{-- FACEBOOK --}}
                            @if(get_settings('facebook'))
                            <li>
                                <a href="{{ get_settings('facebook') }}" target="_blank" title="Facebook">
                                    <i class="fab fa-facebook-f" style="color: #B7A1D7; font-size: 16px;"></i>
                                </a>
                            </li>
                            @endif

                            {{-- INSTAGRAM (mapped to Twitter field) --}}
                            @if(get_settings('twitter'))
                            <li>
                                <a href="{{ get_settings('twitter') }}" target="_blank" title="Instagram">
                                    <i class="fab fa-instagram" style="color: #B7A1D7; font-size: 16px;"></i>
                                </a>
                            </li>
                            @endif

                            {{-- TIKTOK (mapped to LinkedIn field) --}}
                            @if(get_settings('linkedin'))
                            <li style="display: flex; align-items: center;">
                                <a href="{{ get_settings('linkedin') }}" target="_blank" title="TikTok" style="display: flex;">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512" style="fill: #B7A1D7;">
                                        <path d="M448 209.91a210.06 210.06 0 0 1-122.77-39.25V349.38A162.55 162.55 0 1 1 185 188.31V278.2a90.25 90.25 0 0 0 37.81 75.41V47.49h90.31a119.37 119.37 0 0 0 13.56-1.21V47.49h0A210.07 210.07 0 0 0 448 209.91Z"/>
                                    </svg>
                                </a>
                            </li>
                            @endif

                            {{-- YOUTUBE (fixed link) --}}
                            <li>
                                <a href="https://www.youtube.com/@ReciDaHr" target="_blank" title="YouTube">
                                    <i class="fab fa-youtube" style="color: #B7A1D7; font-size: 16px;"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-7">
                    <div class="at-shadow-card px-20px py-4">
                        <form action="{{ route('contact.store') }}" method="post">
                            @csrf
                            <div class="row mb-20px g-3">
                                <div class="col-md-6">
                                    <div>
                                        <label for="name" class="form-label at2-form-label">{{get_phrase('Name')}}</label>
                                        <input type="text" name="name" class="form-control at2-form-control" id="name" placeholder="Your name" required>
                                    </div>                                      
                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <label for="email" class="form-label at2-form-label">{{get_phrase('Email')}}</label>
                                        <input type="email" name="email" class="form-control at2-form-control" id="email" placeholder="Your email" required>
                                    </div>                                      
                                </div>
                            </div>
                            <div class="row mb-20px g-3">
                                <div class="col-md-6">
                                    <div>
                                        <label for="phone" class="form-label at2-form-label">{{get_phrase('Phone')}}</label>
                                        <input type="number" name="number" class="form-control at2-form-control" id="phone" placeholder="Your number" required>
                                    </div>                                      
                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <label for="address" class="form-label at2-form-label">{{get_phrase('Address')}}</label>
                                        <input type="text" name="address" class="form-control at2-form-control" id="address" placeholder="Your address" required>
                                    </div>                                      
                                </div>
                            </div>
                            <div class="mb-12px">
                                <label for="message" class="form-label at2-form-label">{{get_phrase('Message')}}</label>
                                <textarea class="form-control at2-form-control" name="message" id="message" placeholder="Write here..." required></textarea>
                            </div>
                            <button type="submit" class="theme-btn1">{{get_phrase('Send Message')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Contact Area -->
    
    
    @endsection