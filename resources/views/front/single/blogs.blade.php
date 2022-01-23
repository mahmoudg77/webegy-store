@extends('layouts.app')

@section('title'){{ $singlePost->meta_title }}@endsection
@section('description'){{ str_limit(strip_tags($singlePost->meta_description),150) }}@endsection

@section('content')

<!--============== Page title Start ==============-->
<div class="full-row pt-30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <nav aria-label="breadcrumb" class="mb-2" style="padding: 0 30px;">
                    <ol class="breadcrumb mb-0 bg-transparent p-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">{{trans('app.home')}}</a></li>
                        <li class="breadcrumb-item"><a href="{{route('categoryBySlug', $singlePost->Category->Parent->slug) }}">{{$singlePost->Category->Parent->title}}</a></li>
                        <li class="breadcrumb-item "><a href="{{route('categoryBySlug', $singlePost->Category->slug) }}" class="active text-primary">{{$singlePost->Category->title}}</a></li>
                        <!--<li class="breadcrumb-item active text-primary" aria-current="page">{{$singlePost->title}}</li>-->
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!--============== Page title End ==============-->

<!--============== Blog Area Start ==============-->
<div class="full-row pt-0 single-blog">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 sm-mb-30">
                <div class="single-post bo2rder summary rounded bg-black p-0 mb-30">
                    <div class="post-image mb-3">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 col-xs-12">
                                @if($singlePost->slider_option==1)
                                <img src="{{ $singlePost->mainImage('1920x1920','scale') }}" alt="{{$singlePost->title}}" style="width: 100%;">
                                @endif
                                @if($singlePost->slider_option==2)
                                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                        <ol class="carousel-indicators">
                                            @php $n=1 @endphp
                                            @foreach(@$singlePost->images('1920x1920','crope','images') as $img)
                                            <li data-target="#carouselExampleIndicators" data-slide-to="{{$n}}" class="{{$n == 1?'active':''}}"></li>
                                            @php $n++ @endphp
                                            @endforeach
                                        </ol>
                                        <div class="carousel-inner">
                                            @php $n=1 @endphp
                                            @foreach(@$singlePost->images('1920x1920','crope','images') as $img)
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
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xs-12">
                                        <iframe id="player" width="100%" height="400" src="https://www.youtube.com/embed/{{explode('/',$singlePost->external_url)[count(explode('/',$singlePost->external_url))-1]}}?autoplay=1&rel=0&enablejsapi=1"
                                            title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                   
                                    </div>
                                </div>
                                @endif
                                @endif
                                @if($singlePost->slider_option==4)
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xs-12">
                                        <video width="100%" height="400" controls>
                                            <source src="{{url('/uploads/files/'.$singlePost->mainFile())}}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 col-xs-12">
                                @include('partials.ad-unit',['slug'=>'ad-news-1'])
                                @include('partials.ad-unit',['slug'=>'ad-news-2'])
                            </div>
                        </div>
                        
                    </div>

                    <div class="single-post-title" style="border-bottom: 1px solid #04ab81;">
                        <div class="post-me2ta list-color-general mb-2">
                            <!--<i class="flaticon-calendar flat-mini"></i>-->
                            <!--<span class="text-primary">{{ $singlePost->created_at!=null?$singlePost->created_at->toDateString():'' }}</span>-->
                            <span class="text-primary">{{ Func::time_string($singlePost->pub_date)}}</span>
                        </div>
                        <h3 class="mb-4">{{$singlePost->title}}</h3>
                        <div class="row pb-10">
                            <div class="col-lg-6 col-12 col-xs-12">
                                <div class="post-me2ta list-color-general mb-2">
                                    <a href="javascript:;"><span>{{$singlePost->Creator!=null?$singlePost->Creator->name:''}}</span></a>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12 col-xs-12">
                                <div class="row">
                                    <div class="col-lg-6 col-4 col-xs-4 text-{{(app()->getLocale()=='ar')?'right':'left'}}" style="height: 100%;margin: auto;">
                                        @if($singlePost->PostType->can_like)
                                        <div class="rate text-primary">
                                            {{$singlePost->calcDisLikes()}}
                                            <i class="fa fa-thumbs-o-down"></i>
                                            <i class="fa fa-thumbs-o-up"></i>
                                            {{$singlePost->calcLikes()}}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-lg-6 col-8 col-xs-8 text-{{(app()->getLocale()=='ar')?'right':'left'}}">
                                        @if($singlePost->PostType->can_share)
                                        <div style="display:inline" class="addthis_inline_share_toolbox_biwn"></div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="post-content pt-4 mb-5">
                        {!! $singlePost->body !!}
                    </div>
                    @if($singlePost->PostType->can_comment)
                    <div class="row pb-30">
                        <div class="col-12">
                            <h3>{{trans('app.comments')}}</h3>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12 col-xs-12" style="">
                            <div class="fb-comments" style="background:#efefef !important" data-href="{{$singlePost->link()}}" data-width="100%" data-colorscheme="dark" data-numposts="5"></div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12 col-xs-12">
                            @include('partials.ad-unit',['slug'=>'ad-news-3'])
                            @include('partials.ad-unit',['slug'=>'ad-news-4'])
                        </div>
                    </div>
                    @endif
                </div>

            </div>

        </div>
    </div>
</div>
<!--============== Blog Area End ==============-->
@endsection

@section('js')
    @if($singlePost->PostType->can_comment)
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/ar_AR/sdk.js#xfbml=1&version=v11.0" nonce="30KIWzWD"></script>
    @endif
    @if($singlePost->PostType->can_share)
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-51bef7323f54f9c6"></script>
    @endif

    @if($singlePost->PostType->can_like)
    <script>
        $(document).ready(function() {
            $(".rate i").click(function() {
                var n = $(this).index() == 0?0: 4;
                $(".rate i.fa-thumbs-down").removeClass("fa-thumbs-down").addClass("fa-thumbs-o-down");
                $(".rate i.fa-thumbs-up").removeClass("fa-thumbs-up").addClass("fa-thumbs-o-up");
    
    
                if ($(this).hasClass('fa-thumbs-o-down')) $(this).removeClass("fa-thumbs-o-down").addClass("fa-thumbs-down");
                if ($(this).hasClass('fa-thumbs-o-up')) $(this).removeClass("fa-thumbs-o-up").addClass("fa-thumbs-up");
    
                $.ajax({
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
                    url: '{{route("ajax-post-rate")}}',
                    data: {
                        post_id: {{
                            $singlePost->id
                        }}, rate: n+1
                    },
                    dataType: 'json',
                    success: function(res) {
                        //alert(res.message);
                        //alert(res.text);
                    },
                    error: function(a, b, c) {
                        //$(".post-content").html(a.responseText)
                    }
                });
    
            });
            /*$(".rate i").hover(function(){
                var n=$(this).index();
                $(".rate i").removeClass("fa-star").addClass("fa-star-o");
                for(var x=0;x<=n;x++){
                   var item= $(".rate i:eq("+x+")");
                    item.removeClass("fa-star-o").addClass("fa-star");
                }
            });*/
            $(".navbar-nav li a[href$='{{$singlePost->Category->slug}}']").closest('li').addClass('active');
            @if ($singlePost->Category->Parent) $(".navbar-nav li a[href$='{{$singlePost->Category->Parent->slug}}']").closest('li').addClass('active'); @endif
            @if ($singlePost->Category->Parent->Parent) $(".navbar-nav li a[href$='{{$singlePost->Category->Parent->Parent->slug}}']").closest('li').addClass('active'); @endif
    
        })
    </script>
    @endif

     <script>
    //     (function(){
    //         $('.carousel').owlCarousel({
    //             loop: true,
    //             margin: 20,
    //             responsiveClass: true,
    //             nav:true,
    //             dots:true,
    //             autoWidth:true,
    //             rtl:{{app()->getLocale()=="ar"?"true":"false"}},
    //             responsive:
    //             {
    //             0:{
    //                 items:1,
    //             },
    //             600:{
    //                 items:1,
    //             },
    //             1000:{
    //                 items:1,
    //             }}
    //         });
    //     })
     </script>
@stop