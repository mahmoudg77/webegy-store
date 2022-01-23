@extends('layouts.app')

@section('title'){{ $singlePost->meta_title }}@endsection
@section('description'){{ str_limit(strip_tags($singlePost->meta_description),150) }}@endsection

@section('css')
<style>
    .hytPlayerWrap {
        display: inline-block;
        position: relative
    }

    .hytPlayerWrap.ended::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        cursor: pointer;
        background-color: black;
        background-repeat: no-repeat;
        background-position: center;
        background-size: 64px 64px;
        background-image: url(data:image/svg+xml;utf8;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMjgiIGhlaWdodD0iMTI4IiB2aWV3Qm94PSIwIDAgNTEwIDUxMCI+PHBhdGggZD0iTTI1NSAxMDJWMEwxMjcuNSAxMjcuNSAyNTUgMjU1VjE1M2M4NC4xNSAwIDE1MyA2OC44NSAxNTMgMTUzcy02OC44NSAxNTMtMTUzIDE1My0xNTMtNjguODUtMTUzLTE1M0g1MWMwIDExMi4yIDkxLjggMjA0IDIwNCAyMDRzMjA0LTkxLjggMjA0LTIwNC05MS44LTIwNC0yMDQtMjA0eiIgZmlsbD0iI0ZGRiIvPjwvc3ZnPg==)
    }

    .hytPlayerWrap.paused::after {
        content: "";
        position: absolute;
        top: 0px;
        left: 0;
        bottom: 0px;
        right: 0;
        cursor: pointer;
        background-color: black;
        background-repeat: no-repeat;
        background-position: center;
        background-size: 40px 40px;
        background-image: url(data:image/svg+xml;utf8;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZlcnNpb249IjEiIHdpZHRoPSIxNzA2LjY2NyIgaGVpZ2h0PSIxNzA2LjY2NyIgdmlld0JveD0iMCAwIDEyODAgMTI4MCI+PHBhdGggZD0iTTE1Ny42MzUgMi45ODRMMTI2MC45NzkgNjQwIDE1Ny42MzUgMTI3Ny4wMTZ6IiBmaWxsPSIjZmZmIi8+PC9zdmc+)
    }
</style>
<style>


    /*.sticky + .property-overview {*/
    /*  padding-top: 102px;*/
    /*}*/
</style>
@endsection
@section('content')

<!--============== Property Details Start ==============-->
<div class="full-row pt-20 bg-dark single-tv">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="property-overview bo2rder overflow-hidden rounded mb-30 header pb-30" id="myHeader">
                    <div class="row pt-30">
                        <div class="col-lg-6">
                            <div class="hytPlayerWrapOute w-100r">
                                <div class="hytPlayerWrap w-100">
                                    <iframe id="player" width="100%" height="400" src="https://www.youtube.com/embed/{{explode('/',$singlePost->external_url)[count(explode('/',$singlePost->external_url))-1]}}?autoplay=1&rel=0&enablejsapi=1"
                                        title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6">
                            <div class="thumb-modern-border p-3 h-100">
            					<h3 class="my-3 services-body-header">{{$singlePost->Category->Parent->title}}</h3>
            					<div class="rate mb-3">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-o"></i>
                                    <span>4/5</span>
                                </div>
                                
            					<div class="services-body" style="text-align: justify;">{!! strip_tags($singlePost->Category->Parent->body) !!}</div>
            				</div>
                        </div>
                    </div>
                </div>

                <div class="property-overview bo2rder summary rounded bg p-0 mb-30">
                    <div class="row mb-4">
                        <div class="col-12 text-center tv-dropdown">
                            <div class="" style="display: inline-flex;">
                                <select class="form-control" id="select-cat">
                                    @foreach($singlePost->Category->Parent->Chields as $cat)
                                    @if($cat->Posts()->where('is_published',1)->count() >0)
                                    <option {{$cat->id==$singlePost->category_id?'select':''}} value="{{$cat->id}}">{{$cat->title}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                <select class="form-control" id="select-sort">
                                    <option selected value="1">{{trans('app.Newest')}}</option>
                                    <option value="2">{{trans('app.Oldest')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4" id="videos-section">

                    </div>
                    <div class="text-center more loadmore" data-page="2" data-target="index" data-q="" data-count="100">
                        <a class="btn btn-link " style="text-decoration:none;margin-top: 15px;">{{trans('app.more')}} <i style="display:none;" class="fa fa-spinner fa-spin"></i></a>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>
<!--============== Property Details End ==============-->

@section('js')
<script>
    var catid = {{
        $singlePost->category_id
    }};
    var sort = 1;
    var data;
    function loadVideos(succ = null, error = null) {
        $("#videos-section").html();
        //alert(catid);
        var p = data?data.current_page+1: 1;
        $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            url: '/{{app()->getLocale()}}/tv-fn/cat?page='+p,
            data: {
                id: catid, sort: sort
            },
            dataType: 'json',
            success: function(res) {
                data = res;
                //$("#videos-section").html("");
                data.data.forEach(function(item) {
                    //console.log(item);
                    $("#videos-section").append("<div class='col-lg-4 col-sm-6 col-xs-6 col-6 text-center mb-20 tv-body-img'><a href='#'><img title='"+item.title+"' data-id='"+item.id+"' data-url='"+item.videoId+"' src='"+item.image.sm+"' data-slug='"+item.slug+"' data-title='"+item.title+"'/><div class='text-primary transation font-large'><i class='fa fa-play'></i></div></a></div>");

                });
                if (succ)succ(data);
                //alert(res.text);
            },
            error: function(a, b, c) {
                console.log(JSON.stringify(a))

            }
        });
    }
    $(document).ready(function() {
        loadVideos();
        $("#select-cat").change(function(e) {
            // e.preventDefault();
            //alert("ggggggg");
            catid = $(this).val(); //.data("id");
            $("#videos-section").html("");
            data = null;
            loadVideos();
        });
        $("#select-sort").change(function(e) {
            //e.preventDefault();
            //alert("ggggggg");
            sort = $(this).val(); //.data("id");
            $("#videos-section").html("");
            data = null;
            loadVideos();
        });
        $("body").on("click", "#videos-section .tv-body-img a", function() {
            var img=$(this).find('img');
            window.history.pushState("object or string", img.data("title"), "/{{app()->getLocale()}}/"+img.data("slug"));
            $("#post-title").html(img.data("title"));

            $("#player").attr("src", "https://www.youtube.com/embed/"+img.data("url")+"?autoplay=1").attr('title', img.attr('title'));
        
            
        });


        $(window).scroll(function() {
            $(".loadmore").each(function() {
                if (isScrolledIntoView($(this)) && !$(this).hasClass("wait")) {
                    $(this).click();

                }
            });
        });
        $(".loadmore").click(function() {
            var btn = $(this);
            if (btn.hasClass("wait")) return;
            btn.addClass("wait");
            btn.find("i").show();
            loadVideos(function() {
                btn.removeClass("wait");
                btn.find("i").hide();

            });

        });
        $(".navbar-nav li a[href$='{{$singlePost->Category->slug}}']").closest('li').addClass('active');
        @if ($singlePost->Category->Parent) $(".navbar-nav li a[href$='{{$singlePost->Category->Parent->slug}}']").closest('li').addClass('active'); @endif
        @if ($singlePost->Category->Parent->Parent) $(".navbar-nav li a[href$='{{$singlePost->Category->Parent->Parent->slug}}']").closest('li').addClass('active'); @endif


    });
    function isScrolledIntoView(elem) {
        var $elem = $(elem);
        var $window = $(window);

        var docViewTop = $window.scrollTop();
        var docViewBottom = docViewTop + $window.height();

        var elemTop = $elem.offset().top;
        var elemBottom = elemTop + $elem.height();

        return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
    }
</script>

<script>
    window.onscroll = function() {
        myFunction()};

    var header = document.getElementById("myHeader");
    var sticky = header.offsetTop;

    function myFunction() {
        if (window.pageYOffset > sticky) {
            header.classList.add("sticky");
        } else {
            header.classList.remove("sticky");
        }
    }
</script>
<script>
    "use strict"; document.addEventListener('DOMContentLoaded', function() {
        if (window.hideYTActivated)return; if (typeof YT === 'undefined') {
            let tag = document.createElement('script'); tag.src = "https://www.youtube.com/iframe_api"; let firstScriptTag = document.getElementsByTagName('script')[0]; firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
        } let onYouTubeIframeAPIReadyCallbacks = []; for (let playerWrap of document.querySelectorAll(".hytPlayerWrap")) {
            let playerFrame = playerWrap.querySelector("iframe"); let onPlayerStateChange = function(event) {
                if (event.data == YT.PlayerState.ENDED) {
                    playerWrap.classList.add("ended");
                } else if (event.data == YT.PlayerState.PAUSED) {
                    playerWrap.classList.add("paused");
                } else if (event.data == YT.PlayerState.PLAYING) {
                    playerWrap.classList.remove("ended"); playerWrap.classList.remove("paused");
                }}; let player; onYouTubeIframeAPIReadyCallbacks.push(function() {
                    player = new YT.Player(playerFrame, {
                        events: {
                            'onStateChange': onPlayerStateChange
                        }});
                }); playerWrap.addEventListener("click", function() {
                    let playerState = player.getPlayerState(); if (playerState == YT.PlayerState.ENDED) {
                        player.seekTo(0);
                    } else if (playerState == YT.PlayerState.PAUSED) {
                        player.playVideo();
                    }});
        } window.onYouTubeIframeAPIReady = function() {
            for (let callback of onYouTubeIframeAPIReadyCallbacks) {
                callback();
            }}; window.hideYTActivated = true;
    });
</script>
@endsection


@stop