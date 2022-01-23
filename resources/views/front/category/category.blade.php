@extends('layouts.app')

@section('title'){{ $title }}@endsection
@section('description'){{ str_limit(strip_tags($description),100) }}@endsection

@section('content')

<!--============== Page title Start ==============-->
<div class="full-row pt-30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <nav aria-label="breadcrumb" class="mb-2" style="padding: 0 30px;">
                    <ol class="breadcrumb mb-0 bg-transparent p-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">{{trans('app.home')}}</a></li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">{{$title}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!--============== Page title End ==============-->

<section class="full-row bg-dark pt-50 pb-5 books">
<!--============== Page title Start ==============-->
<div class="container-fluid">
    <!--<div class="row mb-2">-->
    <!--    <div class="col-lg-12">-->
    <!--        <h3 class="books-header-cat">{{trans('app.categories')}} <i class="fa fa-circle"></i></h3>-->
    <!--    </div>-->
    <!--</div>-->
    <div class="row mb-2">
    @if(count($data)>0)
        @foreach($data as $post)
        <div class="col-lg-4 col-md-6 col-6 col-xs-6 mb-3">
            <a href="{{$post->link()}}">
                @if($post->mainImage())
                    <img  style="border-bottom:2px solid #0c9;width:100%" src="{{$post->mainImage('300x150','crope')}}" alt="{{$post->name}}" class="img-responsive" />
                @else
                    <img src="{{ asset('images/none.jpg')}}" alt="{{$post->name}}" style="border-bottom:2px solid #0c9;width:100%;height:230px">
                @endif
                <h4 class="pt-10 text-center">{{$post->title}}</h4>
            </a>
        </div>
        @endforeach
        <div class="col-xs-12 text-center my-pagination">{{ $data->links() }}</div>
    @else
        <div class="col col-xs-12 text-center pt80 pb100">
            <h4 class="alert alert-danger">{{ trans('app.No items found') }}</h4>
        </div>
    @endif
    </div>
</div>
<!--============== Page title End ==============-->
</section>



@stop