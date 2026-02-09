<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> @yield('title') </title>
    <link rel="shortcut icon" href="{{ asset('assets/backend/images/favicon.svg') }}" type="image/x-icon">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/backend/vendors/bootstrap/bootstrap.min.css') }}">
    <!-- UI Icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/icons/uicons-solid-rounded/css/uicons-solid-rounded.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/icons/uicons-bold-rounded/css/uicons-bold-rounded.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/icons/uicons-bold-straight/css/uicons-bold-straight.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/icons/uicons-regular-rounded/css/uicons-regular-rounded.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/icons/uicons-thin-rounded/css/uicons-thin-rounded.css') }}" />

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/icon-picker/fontawesome-iconpicker.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/icon-picker/icons/fontawesome-all.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('plugin/tagify-master/dist/tagify.css') }}">
    
    <!-- select 2 -->
    <link rel="stylesheet" href="{{asset('assets/backend/css/select2.min.css')}}">
    <!-- datatable -->
    <link rel="stylesheet" href="{{asset('assets/backend/css/dataTables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/responsive.bootstrap5.css')}}">
    <!-- toastr css -->
    <link rel="stylesheet" href="{{asset('plugin/toastr/toastr.min.css')}}">
    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('assets/backend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/css/custom.css') }}">
    <script src="{{ asset('assets/backend/js/jquery-3.7.1.min.js') }}"></script>
    @stack('css')

</head>
<body>
    <!-- Admin Main Top Area Start -->
    <main>
        <!-- Sidebar -->
        <div class="ol-sidebar">
            @include('admin.navigation')
        </div>
        <div class="ol-sidebar-content">
            @include('admin.header')
            <!-- Content -->
            <div class="ol-body-content">
                <div class="container-fluid">
                    <div class="ol-body-content-inner">

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @yield('admin_layout')
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('layouts.modal')

   

    <!-- Admin Main Top Area End -->
    <script src="{{ asset('assets/backend/vendors/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/backend/vendors/chart-js/chart.js') }}"></script>
    <script src="{{ asset('assets/backend/icon-picker/fontawesome-iconpicker.min.js') }}"></script>
    <script src="{{asset('assets/backend/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/backend/js/select2.min.js')}}"></script>
    <script src="{{asset('assets/backend/js/dataTables.js')}}"></script>
    <script src="{{asset('assets/backend/js/dataTables.bootstrap5.js')}}"></script>
    <script src="{{asset('assets/backend/js/dataTables.responsive.js')}}"></script>
    
    <script>
        "use strict";


        $('#datatable').DataTable({
            responsive: true
        })
     
     </script>
    <!-- toastr js -->
    <script src="{{asset('plugin/toastr/toastr.min.js')}}"></script>
    <script src="{{asset('plugin/tagify-master/dist/tagify.min.js')}}"></script>
    {!! Toastr::message() !!}
    <script src="{{ asset('assets/backend/js/script.js') }}"></script>
    <!-- toster file -->
    @include('layouts.toaster')
    @include('admin.init')
    @stack('js')

</body>
</html>
