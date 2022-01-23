@extends('layouts.app')

@section('title'){{ $singlePost->meta_title }}@endsection
@section('description'){{ str_limit(strip_tags($singlePost->meta_description),150) }}@endsection

@section('content')

<!--============== Page title Start ==============-->
<div class="full-row">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <nav aria-label="breadcrumb" class="mb-2">
                    <ol class="breadcrumb mb-0 bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">{{trans('app.home')}}</a></li>
                    <li class="breadcrumb-item active text-primary" aria-current="page">{{$singlePost->title}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!--============== Page title End ==============-->

<!--============== Property Details Start ==============-->
<div class="full-row pt-0">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @if($singlePost->mainImage())
                <div class="property-overview border overflow-hidden rounded bg-white mb-30">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="overflow-hidden position-relative transation bg-secondary hover-img-zoom m-2 mr-0">
                                <img src="{{$singlePost->mainImage('630x600','crope')}}" alt="{{$singlePost->title}}">
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="property-overview border summary rounded bg-white p-30 mb-30">
                    <div class="row mb-4">
                        <div class="col-auto">
                            <h4><a class="font-600 text-secondary" href="single_property.html">{{ $singlePost->title }}</a></h4>
                            <span class="mb-2 d-block"><i class="fas fa-map-marker-alt text-primary"></i> {{ $singlePost->description }} </span>
                        </div>

                    </div>
                    <div class="row row-cols-1">
                        <div class="col">
                            <h5 class="mb-3">{{trans('app.content')}}</h5>
                            {!! $singlePost->body !!}
                        </div>
                    </div>
                </div>

            </div>
            
            <div class="col-lg-4">
            @include('partials.sidebar')
            </div>
        </div>
    </div>
</div>
<!--============== Property Details End ==============-->
@stop
