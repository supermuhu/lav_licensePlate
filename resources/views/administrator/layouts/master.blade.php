<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('title')
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/logo_infi.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/administrator/dashboard/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/administrator/dashboard/css/vendors.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/administrator/dashboard/css/theme.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/administrator/dashboard/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/administrator/dashboard/css/toastr.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-6.6.0/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/administrator/dashboard/css/sweetalert2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/administrator/dashboard/css/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/administrator/dashboard/css/main.css') }}">
    @yield('css')
</head>

<body>
    @include('administrator.components.sidebars')
    @include('administrator.components.header')
    <div class="nxl-container">
        <div class="nxl-content">
            @yield('content-header')
            <div class="main-content">
                @yield('content')
            </div>
        </div>
        @include('administrator.components.footer')
    </div>
    <script src="{{ asset('assets/administrator/dashboard/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/administrator/dashboard/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('assets/administrator/dashboard/js/vendors.min.js') }}"></script>
    <script src="{{ asset('assets/administrator/dashboard/js/common-init.min.js') }}"></script>
    <script src="{{ asset('assets/administrator/dashboard/js/theme-customizer-init.min.js') }}"></script>
    <script src="{{ asset('assets/administrator/dashboard/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/administrator/dashboard/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/fontawesome-6.6.0/js/all.min.js') }}"></script>
    <script src="{{ asset('assets/administrator/dashboard/js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/administrator/dashboard/js/main.js') }}"></script>
    <script src="{{ asset('assets/administrator/dashboard/js/moment.js') }}"></script>
    <script src="{{ asset('assets/administrator/dashboard/js/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    @yield('script')
</body>

</html>
