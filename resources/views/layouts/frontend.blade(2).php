<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.seo')
    @include('layouts.include_top')
    @stack('css')
    
</head>
@if(!empty($directory) && $directory == 'beauty')
  <body class="beauty-details-body">
@elseif((!empty($directory) && $directory == 'car'))
 <body class="car-details-body">
@elseif((!empty($directory) && $directory == 'hotel'))
 <body class="hotel-details-body">
@elseif((!empty($directory) && $directory == 'real-estate'))
 <body class="real-estate-details-body">
@elseif((!empty($directory) && $directory == 'restaurant'))
 <body class="restaurant-details-body">
@else
<body>

@endif

@if (get_frontend_settings('topheader') == 'enable' || get_frontend_settings('topheader') == Null)
    
    <!-- Start Header Top -->
    <section class="header-top-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="header-top-area d-flex align-items-center justify-content-between flex-wrap">
                        <div class="header-number-location d-flex align-items-center flex-wrap">
                            <svg class="d-none" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <mask id="mask0_99_4740" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="20" height="20">
                                <path d="M20 0H0V20H20V0Z" fill="white"/>
                                </mask>
                                <g mask="url(#mask0_99_4740)">
                                <path d="M17.67 16.1905L16.1137 17.7468C16.1137 17.7468 12.0715 19.4792 6.29557 13.7033C0.519687 7.9274 2.2521 3.88511 2.2521 3.88511L3.80832 2.32888C3.97381 2.16326 4.17296 2.03515 4.39229 1.95324C4.61162 1.87133 4.846 1.83752 5.07953 1.85412C5.31307 1.87072 5.54031 1.93733 5.74585 2.04944C5.95139 2.16155 6.13043 2.31653 6.27082 2.50389L7.75634 4.48438C7.9921 4.79901 8.10647 5.18813 8.07843 5.5803C8.0504 5.97247 7.88185 6.34136 7.60372 6.61925L6.29498 7.92799C6.29498 7.92799 6.29498 9.08293 8.60486 11.3928C10.9147 13.7027 12.0697 13.7027 12.0697 13.7027L13.3778 12.3945C13.6558 12.1164 14.0249 11.9478 14.4172 11.9199C14.8095 11.892 15.1987 12.0065 15.5133 12.2425L17.4932 13.7274C17.6808 13.8677 17.836 14.0467 17.9483 14.2522C18.0607 14.4577 18.1275 14.685 18.1442 14.9186C18.161 15.1522 18.1273 15.3867 18.0455 15.6062C17.9637 15.8256 17.8356 16.0249 17.67 16.1905Z" fill="#FF736A"/>
                                </g>
                                </svg>
                            <a href="tel:" class="location">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <mask id="mask0_99_4740" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="20" height="20">
                                    <path d="M20 0H0V20H20V0Z" fill="white"/>
                                    </mask>
                                    <g mask="url(#mask0_99_4740)">
                                    <path d="M17.67 16.1905L16.1137 17.7468C16.1137 17.7468 12.0715 19.4792 6.29557 13.7033C0.519687 7.9274 2.2521 3.88511 2.2521 3.88511L3.80832 2.32888C3.97381 2.16326 4.17296 2.03515 4.39229 1.95324C4.61162 1.87133 4.846 1.83752 5.07953 1.85412C5.31307 1.87072 5.54031 1.93733 5.74585 2.04944C5.95139 2.16155 6.13043 2.31653 6.27082 2.50389L7.75634 4.48438C7.9921 4.79901 8.10647 5.18813 8.07843 5.5803C8.0504 5.97247 7.88185 6.34136 7.60372 6.61925L6.29498 7.92799C6.29498 7.92799 6.29498 9.08293 8.60486 11.3928C10.9147 13.7027 12.0697 13.7027 12.0697 13.7027L13.3778 12.3945C13.6558 12.1164 14.0249 11.9478 14.4172 11.9199C14.8095 11.892 15.1987 12.0065 15.5133 12.2425L17.4932 13.7274C17.6808 13.8677 17.836 14.0467 17.9483 14.2522C18.0607 14.4577 18.1275 14.685 18.1442 14.9186C18.161 15.1522 18.1273 15.3867 18.0455 15.6062C17.9637 15.8256 17.8356 16.0249 17.67 16.1905Z" fill="#6C1CFF"/>
                                    </g>
                                    </svg>
                                                                       
                                <span>{{get_settings('phone')}}</span>
                                </a>
                            <p class="location">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17.1833 7.04166C16.3083 3.19166 12.95 1.45833 9.99996 1.45833C9.99996 1.45833 9.99996 1.45833 9.99162 1.45833C7.04996 1.45833 3.68329 3.18333 2.80829 7.03333C1.83329 11.3333 4.46662 14.975 6.84996 17.2667C7.73329 18.1167 8.86662 18.5417 9.99996 18.5417C11.1333 18.5417 12.2666 18.1167 13.1416 17.2667C15.525 14.975 18.1583 11.3417 17.1833 7.04166ZM9.99996 11.2167C8.54996 11.2167 7.37496 10.0417 7.37496 8.59166C7.37496 7.14166 8.54996 5.96666 9.99996 5.96666C11.45 5.96666 12.625 7.14166 12.625 8.59166C12.625 10.0417 11.45 11.2167 9.99996 11.2167Z" fill="#6C1CFF"/>
                                    </svg>
                                <span>{{get_settings('address')}}</span>
                            </p>
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

                            {{-- INSTAGRAM (Mapped to Twitter field) --}}
                            @if(get_settings('twitter'))
                            <li>
                                <a href="{{ get_settings('twitter') }}" target="_blank" title="Instagram">
                                    <i class="fab fa-instagram" style="color: #B7A1D7; font-size: 16px;"></i>
                                </a>
                            </li>
                            @endif

                            {{-- TIKTOK (Mapped to LinkedIn field) --}}
                            @if(get_settings('linkedin'))
                            <li style="display: flex; align-items: center;">
                                <a href="{{ get_settings('linkedin') }}" target="_blank" title="TikTok" style="display: flex;">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512" style="fill: #B7A1D7;">
                                        <path d="M448 209.91a210.06 210.06 0 0 1-122.77-39.25V349.38A162.55 162.55 0 1 1 185 188.31V278.2a90.25 90.25 0 0 0 37.81 75.41V47.49h90.31a119.37 119.37 0 0 0 13.56-1.21V47.49h0A210.07 210.07 0 0 0 448 209.91Z"/>
                                    </svg>
                                </a>
                            </li>
                            @endif

                            {{-- YOUTUBE --}}
                            <li>
                                <a href="https://www.youtube.com/@ReciDaHr" target="_blank" title="YouTube">
                                    <i class="fab fa-youtube" style="color: #B7A1D7; font-size: 16px;"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Header Top -->
    
@endif


    
    @if(!empty($directory))
        @include('layouts.'.$directory.'.header')
    @else
        @include('layouts.header')
    @endif
 
    @yield('frontend_layout')

    @if(!empty($directory))
        @include('layouts.'. $directory . '.footer')
    @else
        @include('layouts.footer')
    @endif

    @include('layouts.include_bottom')
    <!-- toster file -->
    @include('layouts.toaster')
    @stack('js')
    
    @if (addon_status('live_chat') == 1)
    {!!get_settings('tawk_live_chat_code')!!}
    @endif

</body>
</html>
