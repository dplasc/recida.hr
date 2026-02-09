<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Creativeitem Software Installation" />
    <meta name="author" content="Creativeitem" />
    <title>{{ __('Installation') . ' | ' . __('Atlas Directory Listing') }}</title>
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <!-- End meta -->

    <link rel="shortcut icon" href="{{ asset('uploads/logo/favicon.svg') }}" type="image/x-icon">
   <!-- toastr css -->
   <link rel="stylesheet" href="{{asset('plugin/toastr/toastr.min.css')}}">

    <link rel="stylesheet" href="{{ asset('assets/install/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/install/css/style.css') }}">
    <script src="{{ asset('assets/frontend/js/jquery-3.7.1.min.js') }}"></script>
</head>

<body class="install-body">

    <div class="row align-items-center justify-content-center h-100">
        <div class="col-sm-6">
            @yield('content')
        </div>
    </div>
   
    <script src="{{ asset('assets/install/js/bootstrap.bundle.min.js') }}"></script>
    <!-- jQuery -->
    <!-- toastr js -->
     <script src="{{asset('plugin/toastr/toastr.min.js')}}"></script>
     @include('install.toaster')
     
     <script src="{{asset('plugin/tagify-master/dist/tagify.min.js')}}"></script>
     {!! Toastr::message() !!}
     
</body>

</html>
