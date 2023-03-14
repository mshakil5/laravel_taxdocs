<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Taxdocs</title>
    <link rel="icon" href="{{ asset('front/images/favicon.png')}}">
    <link rel="stylesheet" href="{{ asset('front/css/bootstrap-5.1.3min.css')}}">
    <link rel="stylesheet" href="{{ asset('front/css/app.css')}}">
    
</head>

<body>
    <!-- oncontextmenu="return false;" -->
    

@include('frontend.inc.header')

@yield('content')
    {{-- footer  --}}
@include('frontend.inc.footer')


    <script src="{{ asset('js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{ asset('front/js/bootstrap-5.bundle.min.js')}}"></script>
    <script src="{{ asset('front/js/iconify.min.js')}}"></script>
    <script src="{{ asset('front/js/app.js')}}"></script>
    
    <script>
        for (var i = 0; i < document.links.length; i++) {
            if (document.links[i].href === document.URL) {
                document.links[i].className = 'nav-link current';
            }
        }
    </script>

@yield('script')
</body>

</html>