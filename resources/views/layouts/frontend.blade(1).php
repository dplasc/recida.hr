<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.seo')
    @include('layouts.include_top')
    @stack('css')
    
</head>
<style>
    .languageforall .current{
        color: #fff;
    }
    .languageforall .search-select {
        min-width: 0;
    }
</style>
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
                        <ul class="header-social-list d-flex align-items-center flex-wrap">
                            <li><a href="{{get_settings('facebook')}}" target="_Blank">
                                <svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18.902 9.00006C18.902 4.02953 14.6706 0.00012207 9.45099 0.00012207C4.23135 0.00012207 0 4.02953 0 9.00006C0 13.4921 3.45607 17.2155 7.97427 17.8907V11.6016H5.57461V9.00006H7.97427V7.01726C7.97427 4.76165 9.38528 3.51572 11.5441 3.51572C12.5778 3.51572 13.6596 3.6915 13.6596 3.6915V5.90633H12.4679C11.2939 5.90633 10.9277 6.60014 10.9277 7.31257V9.00006H13.5489L13.1299 11.6016H10.9277V17.8907C15.4459 17.2155 18.902 13.4921 18.902 9.00006Z" fill="white"/>
                                </svg>                                    
                            </a></li>
                            <li><a href="{{get_settings('twitter')}}" target="_Blank">
                                <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_8_237)">
                                    <path d="M11.5246 7.63303L18.4561 0.0529327H16.8135L10.795 6.63463L5.98794 0.0529327H0.443604L7.71277 10.0056L0.443604 17.9545H2.08623L8.44201 11.004L13.5186 17.9545H19.0629L11.5242 7.63303H11.5246ZM9.27482 10.0933L8.5383 9.10225L2.67809 1.21624H5.20107L9.93033 7.5805L10.6668 8.57156L16.8143 16.8441H14.2913L9.27482 10.0937V10.0933Z" fill="white"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_8_237">
                                    <rect width="19.0285" height="17.9016" fill="white" transform="translate(0.239258 0.0529327)"/>
                                    </clipPath>
                                    </defs>
                                </svg>                                    
                            </a></li>
                            <li><a href="{{get_settings('linkedin')}}" target="_Blank">
                                <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_8_234)">
                                    <path d="M17.6483 0H1.54101C0.769421 0 0.145508 0.580074 0.145508 1.29726V16.6991C0.145508 17.4163 0.769421 17.9999 1.54101 17.9999H17.6483C18.4199 17.9999 19.0475 17.4163 19.0475 16.7026V1.29726C19.0475 0.580074 18.4199 0 17.6483 0ZM5.75334 15.3386H2.94758V6.74644H5.75334V15.3386ZM4.35046 5.57574C3.44966 5.57574 2.72238 4.88317 2.72238 4.02888C2.72238 3.17459 3.44966 2.48201 4.35046 2.48201C5.24757 2.48201 5.97485 3.17459 5.97485 4.02888C5.97485 4.87965 5.24757 5.57574 4.35046 5.57574ZM16.2528 15.3386H13.4507V11.162C13.4507 10.1671 13.4323 8.88392 11.9925 8.88392C10.5342 8.88392 10.3127 9.97025 10.3127 11.0917V15.3386H7.51433V6.74644H10.202V7.92065H10.2389C10.6117 7.24565 11.5273 6.53199 12.8896 6.53199C15.7286 6.53199 16.2528 8.31088 16.2528 10.6241V15.3386Z" fill="white"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_8_234">
                                    <rect width="18.902" height="17.9999" fill="white" transform="translate(0.145508)"/>
                                    </clipPath>
                                    </defs>
                                </svg>                                    
                            </a></li>
                            <li>
                                <!-- language Select -->
                                {{-- <div class="languageforall">
                                    @php
                                        $activated_language = strtolower(session('language') ?? get_settings('language'));
                                    @endphp

                                    <select class="search-select" name="type" id="type">
                                        @foreach (App\Models\Language::select('name')->distinct()->get() as $lng)
                                        <a href=""><option value="{{ $lng->id }}" @if ($activated_language != strtolower($lng->name)) selected @endif> {{ ucfirst($lng->name) }}</option></a>
                                        @endforeach
                                    </select>
                                </div> --}}
                                <div class="languageforall">
                                    @php
                                        $activated_language_id = auth()->user()->language ?? null;

                                        $languages = App\Models\Language::select('name')
                                        ->distinct()
                                        ->get();
                                    @endphp

                                    <form action="{{ route('user.language.update') }}" method="POST">
                                        @csrf
                                        <select class="search-select" name="language_name" id="language_name" onchange="this.form.submit()">
                                            @foreach ($languages as $lng)
                                                <option value="{{ strtolower($lng->name) }}" 
                                                    {{ strtolower(session('language')) == strtolower($lng->name) ? 'selected' : '' }}>
                                                    {{ ucfirst($lng->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                    {{-- <form action="{{ route('user.language.update') }}" method="POST">
                                        @csrf
                                        <select name="language_name" onchange="this.form.submit()">
                                            @foreach ($languages as $lng)
                                                <option value="{{ strtolower($lng->name) }}" 
                                                    {{ strtolower(session('language')) == strtolower($lng->name) ? 'selected' : '' }}>
                                                    {{ ucfirst($lng->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form> --}}


                                </div>

                                
                                {{-- <div class="dropdown at-user-dropdown">
                                    @php
                                            $activated_language = strtolower(session('language') ?? get_settings('language'));
                                        @endphp
                                        
                                        <button class="btn user-dropdown-toggle dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <svg width='20' height="20"  viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7.99967 15.1666C4.04634 15.1666 0.833008 11.9533 0.833008 7.99992C0.833008 4.04659 4.04634 0.833252 7.99967 0.833252C11.953 0.833252 15.1663 4.04659 15.1663 7.99992C15.1663 11.9533 11.953 15.1666 7.99967 15.1666ZM7.99967 1.83325C4.59967 1.83325 1.83301 4.59992 1.83301 7.99992C1.83301 11.3999 4.59967 14.1666 7.99967 14.1666C11.3997 14.1666 14.1663 11.3999 14.1663 7.99992C14.1663 4.59992 11.3997 1.83325 7.99967 1.83325Z" fill="#0A1017"/>
                                                <path d="M6.00016 14.5H5.33349C5.06016 14.5 4.83349 14.2733 4.83349 14C4.83349 13.7267 5.04682 13.5067 5.32016 13.5C4.27349 9.92667 4.27349 6.07333 5.32016 2.5C5.04682 2.49333 4.83349 2.27333 4.83349 2C4.83349 1.72667 5.06016 1.5 5.33349 1.5H6.00016C6.16016 1.5 6.31349 1.58 6.40682 1.70667C6.50016 1.84 6.52682 2.00667 6.47349 2.16C5.22016 5.92667 5.22016 10.0733 6.47349 13.8467C6.52682 14 6.50016 14.1667 6.40682 14.3C6.31349 14.42 6.16016 14.5 6.00016 14.5Z" fill="#0A1017"/>
                                                <path d="M9.99961 14.5C9.94628 14.5 9.89295 14.4934 9.83961 14.4734C9.57961 14.3867 9.43295 14.1 9.52628 13.84C10.7796 10.0734 10.7796 5.92671 9.52628 2.15337C9.43961 1.89337 9.57961 1.60671 9.83961 1.52004C10.1063 1.43337 10.3863 1.57337 10.4729 1.83337C11.7996 5.80671 11.7996 10.18 10.4729 14.1467C10.4063 14.3667 10.2063 14.5 9.99961 14.5Z" fill="#0A1017"/>
                                                <path d="M8 11.4667C6.14 11.4667 4.28667 11.2067 2.5 10.68C2.49333 10.9467 2.27333 11.1667 2 11.1667C1.72667 11.1667 1.5 10.94 1.5 10.6667V10C1.5 9.84003 1.58 9.68669 1.70667 9.59336C1.84 9.50003 2.00667 9.47336 2.16 9.52669C5.92667 10.78 10.08 10.78 13.8467 9.52669C14 9.47336 14.1667 9.50003 14.3 9.59336C14.4333 9.68669 14.5067 9.84003 14.5067 10V10.6667C14.5067 10.94 14.28 11.1667 14.0067 11.1667C13.7333 11.1667 13.5133 10.9534 13.5067 10.68C11.7133 11.2067 9.86 11.4667 8 11.4667Z" fill="#0A1017"/>
                                                <path d="M13.9995 6.50007C13.9462 6.50007 13.8929 6.4934 13.8395 6.4734C10.0729 5.22007 5.91953 5.22007 2.15286 6.4734C1.8862 6.56007 1.6062 6.42007 1.51953 6.16007C1.43953 5.8934 1.57953 5.6134 1.83953 5.52674C5.81286 4.20007 10.1862 4.20007 14.1529 5.52674C14.4129 5.6134 14.5595 5.90007 14.4662 6.16007C14.4062 6.36674 14.2062 6.50007 13.9995 6.50007Z" fill="#0A1017"/>
                                                </svg>
                                        </button>
                                        <div class="dropdown-menu user-dropdown-menu">
                                            <ul class="user-dropdown-group">
                                                @foreach (App\Models\Language::select('name')->distinct()->get() as $lng)
                                                <li><a  class="user-dropdown-item" href="{{ route('admin.select.language', ['language' => $lng->name]) }}" class="select-text text-capitalize">
                                                            <i class="fi fi-br-check text-10px me-1 @if ($activated_language != strtolower($lng->name)) visibility-hidden @endif"></i>
                                                            {{ $lng->name }}
                                                        </a></li>
                                                    @endforeach
                                            </ul>
                                            
                                        </div>
                                </div> --}}
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
