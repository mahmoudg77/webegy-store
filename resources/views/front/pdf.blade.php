@extends('layouts.app')

@section('title'){{ $singlePost->meta_title }}@endsection
@section('description'){{ str_limit(strip_tags($singlePost->meta_description),150) }}@endsection

@section('content')


<!--============== Page title Start ==============-->
<div class="full-row pt-30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <nav aria-label="breadcrumb" class="mb-2">
                    <ol class="breadcrumb mb-0 bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('app.home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{route('categoryBySlug', $singlePost->Category->slug) }}">{{ $singlePost->Category->title}}</a></li>
                    <li class="breadcrumb-item active text-primary" aria-current="page">{{ $singlePost->title}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!--============== Page title End ==============-->

<div class="full-row pt-30 pb-30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12" >
                <iframe src="https://docs.google.com/viewer?embedded=true&url={{asset('uploads/files/'.$singlePost->mainFile())}}" width="100%" height="600px"></iframe>
            </div>
        </div>
    </div>
</div>
<!--============== Page title End 

@stop