@if(!request()->ajax())
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" {{(app()->
getLocale()=='ar')?"dir=rtl":''}}>
<head>
    <!-- ========== Meta Tags ========== -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#1a1a1a" />

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('description',Setting::getIfExists('site_desc'))">
    <meta name="keywords" content="@yield('keywords',Setting::getIfExists('site_key'))" />
    <meta name="author" content="@yield('author', 'webegy')" />

    <!-- Twitter Card data -->
    <meta name="twitter:card" value="summary">
    <!-- Open Graph data -->
    <meta property="og:title" content="@yield('title', Setting::getIfExists('site_name'))" />
    <meta property="og:type" content="@yield('type', 'Real Estate Marketing')" />
    <meta property="og:url" content="@yield('url', request()->url())" />
    <meta property="og:image" content="@yield('image', asset('front/img/favicon.png'))" />
    <meta property="og:description" content="@yield('description',Setting::getIfExists('site_desc'))" />
    <!-- ========== Title ========== -->
    <title> @yield('title')</title>


    <!-- Google Font -->
    <link media="all" href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,400;0,600;0,700;1,400&amp;display=swap" rel="stylesheet">
    <link media="all" href="https://fonts.googleapis.com/css2?family=Arvo:ital,wght@0,400;0,700;1,400&amp;display=swap" rel="stylesheet">

    <link media="all" rel='stylesheet' href='https://use.fontawesome.com/releases/v5.0.1/css/all.css?ver=4.9.1' />
    <link media="all" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Required style of the theme -->

    <link media="screen" rel="stylesheet" href="{{ asset('front/css/bootstrap-select.min.css')}}">
    <!-- <link rel="stylesheet" href="{{ asset('front/css/fontawesome.min.css')}}"> -->
    @if(app()->getLocale()=='ar')
    <link media="all" rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css">
    @else
    <link media="all" rel="stylesheet" href="{{ asset('front/css/bootstrap.min.css')}}">
    @endif
    <link media="all" rel="stylesheet" href="{{ asset('front/css/animate.min.css')}}">
    <link media="screen" rel="stylesheet" href="{{ asset('front/fonts/flaticon/flaticon.css')}}">
    <link media="all" rel="stylesheet" href="{{ asset('front/css/owl.css')}}">
    <link media="all" rel="stylesheet" href="{{ asset('front/css/jquery.fancybox.min.css')}}">
    <link media="all" rel="stylesheet" href="{{ asset('front/css/layerslider.css')}}">
    <link media="all" rel="stylesheet" href="{{ asset('front/css/chosen.min.css') }}">
    <link media="screen" rel="stylesheet" href="{{ asset('front/css/template.css')}}">
    <link media="all" rel="stylesheet" href="{{ asset('front/css/style.css')}}">
    <link media="all" rel="stylesheet" href="{{ asset('front/css/colors/color-2.css')}}">
    <link media="all" rel="stylesheet" href="{{ asset('front/css/clock.css')}}">
    <link media="all" rel="stylesheet" href="{{ asset('front/css/venobox.css')}}">
    <link media="all" rel="stylesheet" href="{{ asset('front/css/prettyPhoto.css')}}">

    <!-- Favicon -->
    <link media="all" rel="icon" type="image/png" href="{{ asset('front/img/favicon.png')}}">
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prettyPhoto/3.1.6/css/prettyPhoto.min.css" />
    --}}
    @if(app()->getLocale()=='ar')
    <link media="all" href="{{ asset('front/css/style-rtl.css')}}" rel="stylesheet">
    @endif

    @yield('css')
</head>

<body {{(app()->
    getLocale()=='ar')?"dir=rtl":''}}>

    <div class="preloader">
        <div class="loader clock xy-center"></div>
    </div>


    <div id="page_wrapper" class="bg-light">

        @endif
        @include('partials.nav')
        @yield('content')

        @if(!request()->ajax())
        @include('partials.footer')
        @include('partials.modal')

    </div>

    <!-- Javascript Files -->
    {{--<script src="{{ asset('front/js/jquery.min.js')}}"></script>
    --}} <script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script async src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js" type="text/javascript"></script>

   {{-- <script defer src="{{ asset('front/js/chosen.jquery.min.js') }}"></script>
    <script defer src="{{ asset('front/js/greensock.js')}}"></script>
   --}} <script defer src="{{ asset('front/js/layerslider.transitions.js')}}"></script>
    <script defer src="{{ asset('front/js/layerslider.kreaturamedia.jquery.js')}}"></script>
   <script defer src="{{ asset('front/js/popper.min.js')}}"></script>
--
    <!--<script src="{{ asset('front/js/bootstrap.min.js')}}"></script>-->
    <script defer src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script defer src="{{ asset('front/js/jquery.prettyPhoto.js')}}"></script>
    <script defer src="{{ asset('front/js/bootstrap-select.min.js')}}"></script>
    <script defer src="{{ asset('front/js/jquery.fancybox.min.js')}}"></script>
    <script defer src="{{ asset('front/js/owl.js')}}"></script>
    <script defer src="{{ asset('front/js/wow.js')}}"></script>
    <script defer src="{{ asset('front/js/mixitup.min.js')}}"></script>
    <script defer src="{{ asset('front/js/paraxify.js')}}"></script>
    <script defer src="{{ asset('front/js/venobox.min.js')}}"></script>
    <script defer src="{{ asset('front/js/custom.js')}}"></script>



    <script defer>
        // $('#slider').layerSlider({
        //     sliderVersion: '6.0.0',
        //     type: 'fullwidth',
        //     responsiveUnder: 0,
        //     maxRatio: 1,
        //     slideBGSize: 'auto',
        //     hideUnder: 0,
        //     hideOver: 100000,
        //     skin: 'numbers',
        //     fitScreenWidth: true,
        //     fullSizeMode: 'fitheight',
        //     thumbnailNavigation: 'disabled',
        //     height: 860,
        //     skinsPath: 'assets/skins/'
        // });

        if ($('.gallery-light-box').length) {
            $('.gallery-light-box').venobox();
        }
    </script>

    @yield("js")
</body>
</html>
@endif