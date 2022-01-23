@extends('layouts.app')

@section('title'){{ $singlePost->meta_title }}@endsection
@section('description'){{ str_limit(strip_tags($singlePost->meta_description),150) }}@endsection

@section('content')

<section class="single-work full-row pt-20">
    <div class="container-fluid">
       <!--============== Page title Start ==============-->
        <div class="full-row pt-0">
            <div class="row">
                <div class="col-lg-12">
                    <nav aria-label="breadcrumb" class="mb-2">
                        <ol class="breadcrumb mb-0 bg-transparent p-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">{{trans('app.home')}}</a></li>
                        <li class="breadcrumb-item"><a href="{{route('categoryBySlug', $singlePost->Category->slug) }}">{{$singlePost->Category->title}}</a></li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">{{$singlePost->title}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!--============== Page title End ==============-->
        
        <!--============== Property Details Start ==============-->
        <div class="full-row pt-10">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center pt-20 pb-20">{{ $singlePost->title }}</h2>
                    <div class="property-overview bor2der overflow-hidden rounded mb-30">
                        <div class="row">
                        {{--<div class="col-xs-12 col-lg-4 col-md-6">
                                <div class="overflow-hidden position-relative transation bg-secondary hover-img-zoom m-2 mr-0">
                                    <img src="{{$singlePost->mainImage('300x215','crope')}}" alt="{{$singlePost->title}}" style="width: 100%;">
                                </div>
                            </div>   
                            --}}
                            
                           {{-- @foreach(@$singlePost->images('600x600','scale','images') as $img)
                            <div class="col-xs-12 col-12 col-lg-4 col-md-6 gallery-container">
                               <div class="overflow-hidden position-relative transation bg-secondary hover-img-zoom m-2 mr-0">
                                   <a class="gallery-light-box xs-margin" data-gall="myGallery" href="{{$img}}">
                                    <!--<figure class="gallery-img">-->
                                        <img class="img-responsive" src="{{$img}}" alt="{{$singlePost->title}}" style="width: 100%;">
                                    <!--</figure>-->
                                    </a>
                                </div>
                            </div>
                            
                            
                    
                            @endforeach
                            --}}
                            @foreach(\App\Models\Post::related(21,'Work',$singlePost->id)->get() as $post)
                             <div class="col-xs-12 col-12 col-lg-4 col-md-6">
                               <div class="overflow-hidden position-relative transation bg-secondary hover-img-zoom m-2 mr-0">
                                   <a class="xs-margin" href="{{$post->link()}}?iframe=true&width=100%&height=100%" rel="prettyPhoto[iframes]" title="{{$post->title}}">
                                       <img class="img-responsive" src="{{$post->mainImage('300x215','crope')}}" alt="{{$post->title}}" style="width: 100%;">
                                   
                                    </a>

                                  
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                </div>
        </div>
        <!--============== Property Details End ==============--> 
    </div>
</section>

@endsection
@section('js')

<script>
    $(document).ready(function(){
     $("a[rel^='prettyPhoto']").prettyPhoto({theme:'dark_rounded'});

      $(".navbar-nav li a[href$='{{$singlePost->Category->slug}}']").closest('li').addClass('active');
        @if($singlePost->Category->Parent) $(".navbar-nav li a[href$='{{$singlePost->Category->Parent->slug}}']").closest('li').addClass('active');@endif
        @if($singlePost->Category->Parent->Parent) $(".navbar-nav li a[href$='{{$singlePost->Category->Parent->Parent->slug}}']").closest('li').addClass('active');@endif
    
    })
</script>


@stop