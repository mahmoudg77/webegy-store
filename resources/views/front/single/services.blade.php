@extends('layouts.app')

@section('title'){{ $singlePost->meta_title }}@endsection
@section('description'){{ str_limit(strip_tags($singlePost->meta_description),150) }}@endsection

@section('content')

<!-- Start Education Area -->
@if($post=\App\Models\Post::where('is_published',1)->where('slug', 'about-us')->first())
<section class="full-row bg-dark pt-20 pb-50 about ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="about-content pb-30">
                    <h2 class="about-header">{{$post->title}} <i class="fa fa-circle"></i></h2>
                    <div class="about-body">{!! $post->body !!}</div>
                    <div class="about-btn">
                        <a href="javascript:;" class="btn btn-services">{{trans('app.services')}}</a>
                        <a href="{{route('categoryBySlug','work') }}" class="btn">{{trans('app.work')}}</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="about-img">
                    <img src="{{$post->mainImage('820x850','scale')}}" alt="{{$post->title}}"/>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- End Education Area -->
<section class="full-row pt-0">
<div class="container-fluid">
    <div class="col-12 text-center">
        <div class="service-chevron-down">
            <i class="fa fa-chevron-down fa-2x" style="color:#fff"></i>
        </div>
    </div>
</div>  
</section>

            
@if($cat=\App\Models\Category::find(64))
@if($posts=$cat->Posts()->where('is_published',1)->orderBy('pub_date','desc')->limit(8)->get())
<!--============== Our Service Start ==============-->
<div class="full-row bg-dark services">
	<div class="container-fluid">
		<!--<div class="row">-->
		<!--	<div class="col-lg-12 mb-5">-->
		<!--		<h2 class="mb-4 text-center w-50 w-sm-100 mx-auto services-header" style="color: #fff;">{{$cat->title}}</h2>-->
		<!--	</div>-->
		<!--</div>-->
		<div class="row">
		    @foreach($posts as $post)
			<div class="col-lg-3 col-md-6 mb-4 mb-1">
				<div class="thumb-modern-border p-4 h-100">
					<i class="{{$post->icon}} fa-5x bg-dark d-table" style="color:#00cc99"></i>
					<h5 class="my-3 services-body-header">{{$post->title}}</h5>
					<div class="services-body" style="">{!! strip_tags($post->body) !!}</div>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</div>
<!--============== Our Service End ==============-->
@endif
@endif

@stop