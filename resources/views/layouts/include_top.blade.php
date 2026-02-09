    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> @yield('title') </title>
    
    @if(get_frontend_settings('favicon_logo'))
    <link rel="shortcut icon" href="{{ asset('uploads/logo/' . get_frontend_settings('favicon_logo')) }}" type="image/x-icon">
    @else
        <link rel="shortcut icon" href="{{ asset('uploads/logo/favicon.svg') }}" type="image/x-icon">
    @endif 
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/vendors/bootstrap/bootstrap.min.css') }}">
    <!-- Nice Select -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/vendors/nice-select/nice-select.css') }}">
    
    <!-- listing slider -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/icon-picker/icons/fontawesome-all.min.css') }}" />
    <!-- toastr css -->
    <link rel="stylesheet" href="{{asset('plugin/toastr/toastr.min.css')}}">

    

    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/custom.css') }}">
    <script src="{{ asset('assets/frontend/js/jquery-3.7.1.min.js') }}"></script>
