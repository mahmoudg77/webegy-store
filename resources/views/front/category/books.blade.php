@extends('layouts.app')

@section('title'){{ $title }}@endsection
@section('description'){{ str_limit(strip_tags($description),100) }}@endsection

@section('content')

<section class="full-row pt-20 bg-dark books">
<!--============== Page title Start ==============-->
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-lg-12">
                <h3 class="books-header">{{trans('app.Top rate books')}} <i class="fa fa-circle"></i></h3>
            </div>
        </div>
        <div class="row">
            @foreach(cache()->remember('books_top-rates',Carbon\Carbon::now()->addMinutes(10),function(){
         return App\Models\Post::where('post_type_id',17)->orderBy(DB::raw("(select sum(rate)/count(rate) from post_rates where post_id=posts.id )"),"desc")->limit(4)->get();}) as $post)
                @include('partials/book-item',$post)   
            @endforeach
        </div>

    </div>
<!--============== dddrj title End ==============-->
</section>


<section class="full-row bg-dark pt-50 pb-5 books">
<!--============== Page title Start ==============-->
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-lg-12">
            <h3 class="books-header-cat">{{trans('app.book_categories')}} <i class="fa fa-circle"></i></h3>
        </div>
    </div>
    <div class="row mb-2">
        @foreach(cache()->remember('books_child_categories',Carbon\Carbon::now()->addMinutes(120),function()use($category){
         return $category->Chields;}) as $cat)
        <div class="col-lg-4 col-md-6 col-6 col-xs-6 mb-3">
            <a href="{{$cat->link()}}">
                @if($cat->mainImage('300x150','crope'))
                    <img  style="border-bottom:2px solid #0c9;width:100%" src="{{$cat->mainImage('300x150','crope')}}" class="img-responsive" />
                @else
                    <img src="{{ asset('images/none.jpg')}}" alt="{{$post->name}}" style="border-bottom:2px solid #0c9;width:100%;height:230px">
                @endif
                <h4 class="pt-10 text-center">{{$cat->title}}</h4>
            </a>
        </div>
        @endforeach
    </div>
</div>
<!--============== Page title End ==============-->
</section>

@stop