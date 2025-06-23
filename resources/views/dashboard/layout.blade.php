<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Piter SEO | Dashboard</title>

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/customize.css') }}" rel="stylesheet">
    <!-- Mainly scripts -->
    <script src="{{ asset('assets/js/jquery-3.7.0.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    
    <link href="{{ asset('assets/js/plugins/datatable/datatables.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/plugins/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/customize/common_functions.js') }}"></script>
    <link href="{{ asset('assets/js/plugins/select2/select2_4-1-0-rc-0.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/js/plugins/select2/select2_4-1-0-rc-0.min.js') }}"></script>

    <link href="{{ asset('assets/js/plugins/swiper/swiper11_swiper-bundle.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/js/plugins/swiper/swiper11_swiper-bundle.min.js') }}"></script>

    <script src="{{ asset('assets/js/plugins/moment/moment_2-26-0.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/moment/datetime-moment_1-10-25.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2-11.js') }}"></script>

</head>

<body>
    <script>
        $.fn.dataTable.moment('DD-MM-YYYY');
    </script>
    @if (isset($config['js']))
        @foreach ($config['js'] as $js => $val)
            {!! '<script src="' . $val . '"></script>' !!}
        @endforeach
    @endif
    <div id="wrapper">
        @include('dashboard.components.sidebar')
        <div id="page-wrapper" class="gray-bg">
            @include('dashboard.components.top-menu')
            @include($template)
            @include('dashboard.components.footer')
        </div>
    </div>
    @include('script.footer-scripts')
</body>

</html>
