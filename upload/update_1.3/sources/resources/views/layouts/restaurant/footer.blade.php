<!-- Start Footer Area -->
<footer class="main-footer-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Footer Top Area -->
                <div class="footer-top-area d-flex justify-content-between flex-wrap">
                    <div class="footer-top-details">
                        <h3 class="title">{{get_phrase('Sign up to our newsletter')}}</h3>
                        <p class="info">{{get_phrase('Stay up to date with the latest news, announcements, and articles.')}}</p>
                    </div>
                    <div class="footer-search">
                        <form action="{{ route('newsletter.subscribe') }}" method="post">
                            @csrf
                            <div class="footer-input-wrap">
                                <input class="form-control" name="email" type="search" placeholder="{{get_phrase('Enter your email Address')}}" required>
                                <button type="submit" class="">{{get_phrase('Subscribe')}}</button>
                            </div>
                        </form>

                    </div>
                </div>
                <!-- Footer Middle Area -->
                <div class="footer-middle-area mt-4">
                    <div class="row">
                        <div class="col-lg-4 mb-5">
                            <div class="footer-middle-logo">
                                <a href="{{route('home')}}">
                                 @if(get_frontend_settings('dark_logo'))
                                    <img src="{{ asset('uploads/logo/' . get_frontend_settings('dark_logo')) }}" alt="">
                                @else
                                    <img src="{{ asset('uploads/logo/footer_logo.svg') }}" alt="">
                                @endif
                                </a>
                                <p class="info">{{ get_settings('footer_copyright_text') }}</p>
                            </div>
                        </div>
                        <div class="col-lg-8 mb-3">
                            <div class="row">
                                <div class="col-lg-3 col-md-4 col-6 mb-3">
                                    <div class="footer-middle-nav">
                                        <h3 class="title">{{get_phrase('Quick links')}}</h3>
                                        <ul>
                                            <li><a href="{{route('about_us')}}">{{get_phrase('About Us')}}</a></li>
                                            <li><a href="{{route('privacy-policy')}}">{{get_phrase('Privacy Policy')}}</a></li>
                                            <li><a href="{{route('terms-and-condition')}}">{{get_phrase('Terms and Condition')}}</a></li>
                                            <li><a href="{{route('refund-policy')}}">{{get_phrase('Refund Policy')}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                               <div class="col-lg-3 col-md-4 col-6 mb-3">
                                    <div class="footer-middle-nav">
                                        <h3 class="title">{{get_phrase('Categories')}}</h3>
                                          @php
                                        $staticRoutes = ['restaurant', 'hotel', 'beauty', 'real-estate', 'car'];
                                        $menu_items = App\Models\CustomType::where('status', 1)->orderBy('sorting', 'asc')->get();
                                    @endphp

                                    <ul>
                                        @foreach ($menu_items as $item)
                                            @php
                                                $slug = strtolower($item->slug);
                                                $isStatic = in_array($slug, $staticRoutes);
                                                $routeName = $slug . '.home';
                                                $url = $isStatic ? route($routeName) : route('listing.view', ['type' => $slug, 'view' => 'grid']);
                                                $isActive = $isStatic
                                                    ? request()->routeIs($routeName)
                                                    : (request()->routeIs('listing.view') && request()->type == $slug);
                                            @endphp

                                            <li>
                                                <a class="{{ $isActive ? 'active' : '' }}" href="{{ $url }}">
                                                    {{ get_phrase($item->name) }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>

                                    </div>
                               </div>
                               <div class="col-lg-3 col-md-4 col-6 mb-3">
                                    <div class="footer-middle-nav">
                                        <h3 class="title">{{get_phrase('Another Links')}}</h3>
                                        <ul>
                                            <li><a href="{{route('blogs')}}">{{get_phrase('Blog')}}</a></li>
                                            <li><a href="{{route('pricing')}}">{{get_phrase('Pricing')}}</a></li>
                                            <li><a href="{{route('contact-us')}}">{{get_phrase('Contact Us')}}</a></li>
                                        </ul>
                                    </div>
                               </div>
                               <div class="col-lg-3 col-md-4 col-6 mb-3">
                                <div class="footer-middle-contact footer-middle-nav">
                                    <h3 class="title">{{get_phrase('Contact Us')}}</h3>
                                    <ul>
                                        <li><a href="tel:">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M15.3585 12.7602C14.7204 12.623 14.2156 12.9193 13.7686 13.178C13.3108 13.4446 12.4404 14.1507 11.9414 13.9701C9.38699 12.9183 6.98453 10.6825 5.94451 8.11777C5.76122 7.60819 6.46403 6.73223 6.72869 6.26907C6.98551 5.82072 7.27565 5.31114 7.14332 4.66824C7.02373 4.09052 5.47695 2.12232 4.93 1.58411C4.56928 1.22859 4.19974 1.03305 3.8204 1.00144C2.39418 0.940217 0.801338 2.84324 0.521981 3.2985C-0.177894 4.26927 -0.17397 5.561 0.533742 7.12725C2.23931 11.3343 8.69007 17.6832 12.9128 19.4529C13.6921 19.8173 14.4047 20 15.0448 20C15.6711 20 16.2289 19.8252 16.7083 19.4786C17.0699 19.2702 19.051 17.5983 18.999 16.1338C18.9676 15.7604 18.7726 15.3872 18.4217 15.0257C17.8874 14.4737 15.9319 12.8808 15.3585 12.7602Z" fill="white"/>
                                            </svg>
                                            <span>{{ get_settings('phone') }}</span>                                     
                                        </a></li>
                                        <li><a href="mailto:">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M14.1667 2.91663H5.83342C3.33341 2.91663 1.66675 4.16663 1.66675 7.08329V12.9166C1.66675 15.8333 3.33341 17.0833 5.83342 17.0833H14.1667C16.6667 17.0833 18.3334 15.8333 18.3334 12.9166V7.08329C18.3334 4.16663 16.6667 2.91663 14.1667 2.91663ZM14.5584 7.99163L11.9501 10.075C11.4001 10.5166 10.7001 10.7333 10.0001 10.7333C9.30008 10.7333 8.59175 10.5166 8.05008 10.075L5.44175 7.99163C5.17508 7.77496 5.13341 7.37496 5.34175 7.10829C5.55841 6.84163 5.95008 6.79163 6.21675 7.00829L8.82508 9.09163C9.45842 9.59996 10.5334 9.59996 11.1667 9.09163L13.7751 7.00829C14.0417 6.79163 14.4417 6.83329 14.6501 7.10829C14.8667 7.37496 14.8251 7.77496 14.5584 7.99163Z" fill="white"/>
                                            </svg>
                                            <span>{{ get_settings('system_email') }}</span>                                         
                                        </a></li>
                                    </ul>
                                </div>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="footer-bottom-wrap d-flex align-items-center justify-content-between flex-wrap">
                        <p class="info"> <span>{{ get_settings('footer_text') }}</span>     </p>
                        <div class="footer-bottom-social">
                            <ul class="d-flex align-items-center">
                                <li><a href="{{get_settings('facebook')}}" target="_Blank">
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
                                </a></li>
                                <li><a href="{{get_settings('twitter')}}" target="_Blank">
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
                                </a></li>
                                <li><a href="{{get_settings('linkedin')}}" target="_Blank">
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
                                </a></li>
                              
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- End Footer Area -->