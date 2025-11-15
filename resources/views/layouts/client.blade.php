<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', 'NongSanSach')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="shortcut icon" href="{{ asset('assets/user/img/favicon.png') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets/user/css/font-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/user/css/plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/user/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/user/css/responsive.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>
    <div class="wrapper">
        @include('user.partials.header')

        @hasSection('breadcrumb')
            @include('user.partials.breadcrumb')
        @endif

        <main>
            @yield('content')
        </main>

        @include('user.partials.feature')
        @include('user.partials.footer')
    </div>

    <div class="preloader d-none" id="preloader">
        <div class="preloader-inner">
            <div class="spinner">
                <div class="dot1"></div>
                <div class="dot2"></div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/user/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/user/js/main.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('assets/user/js/custom.js') }}"></script>

    <script>
        // 1. Setup CSRF Token cho mọi request AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // 2. Cấu hình Toastr mặc định
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000",
        }
    </script>

    @stack('scripts')
</body>

</html>
