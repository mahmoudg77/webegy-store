@extends('layouts.app')

@section('title'){{ $singlePost->meta_title }}@endsection
@section('description'){{ str_limit(strip_tags($singlePost->meta_description),150) }}@endsection

@section('content')

<!--============== Blog Area Start ==============-->
<div class="full-row pt-20 single-book">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-12 col-xs-12 sm-mb-30 text-center">
                <img src="{{ $singlePost->mainImage('350x525','scale') }}" alt="{{$singlePost->title}}" class="img-resposive">
            </div>

            <div class="col-lg-4 col-md-4 col-sm-4 col-12 col-xs-12">
                @include('partials/book-info',['book'=>$singlePost])
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-12 col-xs-12">
                @include('partials.ad-unit',['slug'=>'ad-book-1'])
                @include('partials.ad-unit',['slug'=>'ad-book-2'])
                @include('partials.ad-unit',['slug'=>'ad-book-3'])
            </div>
        </div>
        
        <div class="row mb-20" style="border-bottom: 1px solid #0c9;">
            <div class="col mt-50">
                <h3 class="about-book-header">{{trans('app.book description')}} <i class="fa fa-circle"></i></h3>
                <div class="post-content pt-4 mb-5">
                    {!! $singlePost->body !!}
                </div>
            </div>
        </div>
        @if($singlePost->PostType->can_comment)
            <div class="row pb-30">
                <div class="col-12"><h3>{{trans('app.comments')}}</h3></div>
                <div class="col-lg-6 col-md-6 col-12 col-xs-12" style="">
                     <div class="fb-comments" style="background:#efefef !important" data-href="{{$singlePost->link()}}" data-width="100%" data-colorscheme="dark" data-numposts="5"></div>
                </div>
                <div class="col-lg-6 col-md-6 col-12 col-xs-12">
                    @include('partials.ad-unit',['slug'=>'ad-book-4'])
                    @include('partials.ad-unit',['slug'=>'ad-book-5'])
                </div>
            </div>
        @endif
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
<script>
    $(document).ready(function(){
        $(".rate i").click(function(){
            var n=$(this).index();
            $(".rate i").removeClass("fa-star").addClass("fa-star-o");
            for(var x=0;x<=n;x++){
               var item= $(".rate i:eq("+x+")");
                item.removeClass("fa-star-o").addClass("fa-star");
            }
        $.ajax({
        type:'POST',
        headers:{'X-CSRF-TOKEN':'{{csrf_token()}}'},
        url:'{{route("ajax-post-rate")}}',
        data:{post_id:{{$singlePost->id}},rate:n+1},
        dataType:'json',
        success:function(res){
            //alert(res.message);
            //alert(res.text);
            },
            error:function(a,b,c){
               // $(".post-content").html(a.responseText)
            }
        });
            
        });
        $(".rate i").hover(function(){
            var n=$(this).index();
            $(".rate i").removeClass("fa-star").addClass("fa-star-o");
            for(var x=0;x<=n;x++){
               var item= $(".rate i:eq("+x+")");
                item.removeClass("fa-star-o").addClass("fa-star");
            }
        });
          $(".navbar-nav li a[href$='{{$singlePost->Category->slug}}']").closest('li').addClass('active');
        @if($singlePost->Category->Parent) $(".navbar-nav li a[href$='{{$singlePost->Category->Parent->slug}}']").closest('li').addClass('active');@endif
        @if($singlePost->Category->Parent->Parent) $(".navbar-nav li a[href$='{{$singlePost->Category->Parent->Parent->slug}}']").closest('li').addClass('active');@endif
    
    })
</script>

@stop