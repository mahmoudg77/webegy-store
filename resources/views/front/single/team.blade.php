@extends('layouts.app')

@section('title'){{ $singlePost->meta_title }}@endsection
@section('description'){{ str_limit(strip_tags($singlePost->meta_description),150) }}@endsection

@section('content')

<section class="full-row pt-20 company-structure">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 pt-20 text-center">
                <h2 class="structure-header">{{$singlePost->title}}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 pt-30 pb-30">
                @if($cat=\App\Models\Category::find(102))
                    @php $n=1 @endphp
                    @if($posts=$cat->Posts()->where('is_published',1)->orderBy('id','asc')->get())
                    <div class="row" style="border-bottom: 1px solid #0c9;">
            		    @foreach($posts as $post)
            			<div class="col-lg-{{$n==1?'12':'6'}} col-md-6 {{$n==1?'text-center':''}}">
            				<div class="mb-{{$n==1?'20':'10'}}">
            					<div class="media" style="{{$n==1?'display: inline-flex;':''}}">
                                  <img class="m{{app()->getLocale()=='ar'?'r':'l'}}-3 {{app()->getLocale()=='ar'?'':'mr-3'}}" 
                                    src="{{$post->mainImage('70x70','crope')}}" alt="{{$post->title}}" style="border-radius: 50%;height: 70px;width: 70px;">
                                  <div class="media-body">
                                    <div class="h5 py-2" style="margin-bottom: 0;">{{$post->title}}</div>
                                    <p class="text-primary" style="font-size: 12px;">{{$post->description}}</p>
                                  </div>
                                </div>
            				</div>
            			</div>
            			@php $n++ @endphp
            			@endforeach
                	</div>
                    @endif
                @endif
            </div>
            
            <div class="col-lg-12">
                @if($cat=\App\Models\Category::find(103))
                @if($posts=$cat->Posts()->where('is_published',1)->orderBy('id','asc')->get())
            		<div class="row">
            		    @foreach($posts as $post)
            			<div class="col-lg-3 col-md-3">
            				<div class="mb-10">
            					<div class="media">
                                  <img class="m{{app()->getLocale()=='ar'?'r':'l'}}-3 {{app()->getLocale()=='ar'?'':'mr-3'}}" src="{{$post->mainImage('70x70','scale')}}" alt="{{$post->title}}" style="border-radius: 50%;height: 70px;width: 70px;">
                                  <div class="media-body">
                                    <div class="h5 py-2" style="margin-bottom: 0;">{{$post->title}}</div>
                                    <p class="text-primary" style="font-size: 12px;">{{$post->description}}</p>
                                  </div>
                                </div>
            				</div>
            			</div>
            			@endforeach
            		</div>
                @endif
            @endif
            </div>
        </div>
    </div>

</section>
@stop