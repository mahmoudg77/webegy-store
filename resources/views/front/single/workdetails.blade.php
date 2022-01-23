@if(!request()->ajax())
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" {{(app()->getLocale()=='ar')?"dir=rtl":''}}>
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
    <link media="all" rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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

</head>

<body {{(app()->getLocale()=='ar')?"dir=rtl":''}}>

<div class="preloader">
	<div class="loader clock xy-center"></div>
</div>

<div id="page_wrapper" class="bg-light">

@endif
  
<!--============== Blog Area Start ==============-->
<div class="full-row pt-0 single-blog">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 sm-mb-30">
                <div class="single-post bo2rder summary rounded bg-black p-0 mb-30">
                    <div class="post-image mb-3">
                        @if($singlePost->slider_option==1)
                        <img src="{{ $singlePost->mainImage('820x550','scale') }}" alt="{{$singlePost->title}}" style="width: 100%;">
                        @endif
                        @if($singlePost->slider_option==2)
                        <div id="carouselExample_Indicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                @php $n=1 @endphp
                                @foreach(@$singlePost->images('820x550','crope','images') as $img)
                                <li data-target="#carouselExampleIndicators" data-slide-to="{{$n}}" class="{{$n == 1?'active':''}}"></li>
                                @php $n++ @endphp
                                @endforeach
                            </ol>
                            <div class="carousel-inner">
                                @php $n=1 @endphp
                                @foreach(@$singlePost->images('820x550','crope','images') as $img)
                                <div class="carousel-item {{$n == 1?'active':''}}">
                                    <img class="d-block w-100" src="{{ $img }}" style="" alt="{{$singlePost->title}}">
                                </div>
                                @php $n++ @endphp
                                @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                        @endif
                        @if($singlePost->slider_option==3)
                        @if(strpos($singlePost->external_url,'youtu.b')>0)
                        <div class="row">
                            <div class="col-12">
                                <iframe id="player" width="100%" height="400" src="https://www.youtube.com/embed/{{explode('/',$singlePost->external_url)[count(explode('/',$singlePost->external_url))-1]}}?autoplay=1&rel=0&enablejsapi=1"
                                    title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                           
                            </div>
                           
                        </div>
                        @endif
                        @endif
                        @if($singlePost->slider_option==4)
                        <div class="row">
                            <div class="col-12">
                                <video width="100%" height="400" controls>
                                    <source src="{{url('/uploads/files/'.$singlePost->mainFile())}}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                           
                        </div>
                        @endif
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>


  @if(!request()->ajax())
  
</div>

    
    
    
    <!-- Javascript Files -->
    {{--<script src="{{ asset('front/js/jquery.min.js')}}"></script>
    --}} <script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script async src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js" type="text/javascript"></script>

    <script async src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script defer src="{{ asset('front/js/chosen.jquery.min.js') }}"></script>
    <script defer src="{{ asset('front/js/greensock.js')}}"></script>
    <script defer src="{{ asset('front/js/layerslider.transitions.js')}}"></script>
    <script defer src="{{ asset('front/js/layerslider.kreaturamedia.jquery.js')}}"></script>
    <script defer src="{{ asset('front/js/popper.min.js')}}"></script>

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
    


    
  
</body>
</html>
@endif


