<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    {{-- <title>NongSanSach - Cửa hàng bán rau củ</title> --}}
    <title>@yield('title')</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <!-- Place favicon.png in the root directory -->
    <link rel="shortcut icon" href="{{ asset('assets/user/img/favicon.png') }}" type="image/x-icon" />
    <!-- Font Icons css -->
    <link rel="stylesheet" href="{{ asset('assets/user/css/font-icons.css') }}">
    <!-- plugins css -->
    <link rel="stylesheet" href="{{ asset('assets/user/css/plugins.css') }}">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/user/css/style.css') }}">
    <!-- Responsive css -->
    <link rel="stylesheet" href="{{ asset('assets/user/css/responsive.css') }}">

    <!-- jQuery-toast-CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>

    <div class="body-wrapper">
        @include('user.partials.header_home') <!-- Đường dẫn của header_home -->

            <main>
                @yield('content')
            </main>

         @include('user.partials.feature') <!-- Đường dẫn của feature -->

         <div style="margin-top: 100px;"></div> <!-- Tạo khoảng trống -->


         @include('user.partials.footer_home') <!-- Đường dẫn của footer_home -->


    </div>




    <!-- preloader area start -->
    <div class="preloader d-none" id="preloader">
        <div class="preloader-inner">
            <div class="spinner">
                <div class="dot1"></div>
                <div class="dot2"></div>
            </div>
        </div>
    </div>
    <!-- preloader area end -->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    <!-- All JS Plugins -->
    <script src="{{ asset('assets/user/js/plugins.js') }}"></script>
    <!-- Main JS -->
    <script src="{{ asset('assets/user/js/main.js') }}"></script>


    <!-- jQuery-toast -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Custom JS -->
    <script src="{{ asset('assets/user/js/custom.js') }}"></script>

</body>

</html>
