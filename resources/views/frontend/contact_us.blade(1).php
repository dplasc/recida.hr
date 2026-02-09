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
                        <ul class="d-flex align-items-center flex-wrap gap-10px contact">
                            <li>
                                <a href="{{get_settings('facebook')}}" target="_Blank" class="secondary-light-iconlink">
                                    <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_11_337)">
                                        <path d="M20 10.5C20 4.97715 15.5229 0.5 10 0.5C4.47715 0.5 0 4.97715 0 10.5C0 15.4912 3.65684 19.6283 8.4375 20.3785V13.3906H5.89844V10.5H8.4375V8.29688C8.4375 5.79063 9.93047 4.40625 12.2146 4.40625C13.3084 4.40625 14.4531 4.60156 14.4531 4.60156V7.0625H13.1922C11.95 7.0625 11.5625 7.8334 11.5625 8.625V10.5H14.3359L13.8926 13.3906H11.5625V20.3785C16.3432 19.6283 20 15.4912 20 10.5Z" fill="#242D3D"/>
                                        </g>
                                        <defs>
                                        <clipPath id="clip0_11_337">
                                        <rect width="20" height="20" fill="white" transform="translate(0 0.5)"/>
                                        </clipPath>
                                        </defs>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="{{get_settings('twitter')}}"  target="_Blank" class="secondary-light-iconlink">
                                    <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_11_339)">
                                        <path d="M11.8616 8.96864L19.147 0.5H17.4206L11.0947 7.8532L6.04225 0.5H0.214844L7.85515 11.6193L0.214844 20.5H1.94134L8.62162 12.7348L13.9574 20.5H19.7848L11.8612 8.96864H11.8616ZM9.49695 11.7173L8.72283 10.6101L2.56342 1.79967H5.21521L10.1859 8.90994L10.9601 10.0172L17.4214 19.2594H14.7696L9.49695 11.7177V11.7173Z" fill="#242D3D"/>
                                        </g>
                                        <defs>
                                        <clipPath id="clip0_11_339">
                                        <rect width="20" height="20" fill="white" transform="translate(0 0.5)"/>
                                        </clipPath>
                                        </defs>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="{{get_settings('linkedin')}}" target="_Blank" class="secondary-light-iconlink">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_8_210)">
                                        <path d="M18.5205 0H1.47754C0.661133 0 0.000976562 0.644531 0.000976562 1.44141V18.5547C0.000976562 19.3516 0.661133 20 1.47754 20H18.5205C19.3369 20 20.001 19.3516 20.001 18.5586V1.44141C20.001 0.644531 19.3369 0 18.5205 0ZM5.93457 17.043H2.96582V7.49609H5.93457V17.043ZM4.4502 6.19531C3.49707 6.19531 2.72754 5.42578 2.72754 4.47656C2.72754 3.52734 3.49707 2.75781 4.4502 2.75781C5.39941 2.75781 6.16894 3.52734 6.16894 4.47656C6.16894 5.42188 5.39941 6.19531 4.4502 6.19531ZM17.0439 17.043H14.0791V12.4023C14.0791 11.2969 14.0596 9.87109 12.5361 9.87109C10.9932 9.87109 10.7588 11.0781 10.7588 12.3242V17.043H7.79785V7.49609H10.6416V8.80078H10.6807C11.0752 8.05078 12.0439 7.25781 13.4854 7.25781C16.4893 7.25781 17.0439 9.23438 17.0439 11.8047V17.043Z" fill="white"/>
                                        </g>
                                        <defs>
                                        <clipPath id="clip0_8_210">
                                        <rect width="20" height="21" fill="white" transform="translate(0.000976562)"/>
                                        </clipPath>
                                        </defs>
                                    </svg>         
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