@extends('layouts.app')

@section('title'){{ $title }}@endsection
@section('description'){{ str_limit(strip_tags($description),100) }}@endsection

@section('content')

<!--============== Features Start ==============-->
@foreach($category->Chields as $cat)
@if($cat->Posts()->count()>0)
<div class="full-row pt-20 cat-tv">
    <div class="container-fliud">
        <div class="row">
			<div class="col-lg-12 col-md-12">
				<h3 class="mb-4">{{$cat->title}}</h3>
			</div>
		</div>
			
        <div class="row">
            <div class="col-12">
               <div class="owl-carousel owl-theme pt-20">
                    @foreach(App\Models\Post::where('category_id',$cat->id )->get() as $post)
                
                    <div class="item ">
                        <div class="thumb-blog-overlay bg-dark hover-text-PushUpBottom mb-4">
        					<div class="post-image position-relative overlay-secondary">
        						<img src="{{$post->mainImage('300x150','crope')}}" alt="{{$post->title}}">
        						<div class="position-absolute xy-center">
        							<div class="overflow-hidden text-center">
        								<a class="text-primary transation font-large" href="{{$post->link()}}"><i class="fa fa-play"></i></a>
        							</div>
        						</div>
        					</div>
        					<div class="post-content p-10">
        						<h6 class="d-block mb-3 text-center">
        						    <a href="{{$post->link()}}" class="transation text-white hover-text-primary">{{$post->title}}</a>
        					    </h6>
        					</div>
        				</div>
        			</div>
                    @endforeach
                </div> 
            </div>
        </div>
        
    </div>
</div>
@endif
@endforeach


<!--============== Testimonials End ==============-->
@endsection
@section('js')
<script>
    $(document).ready(function() {
        $('.owl-carousel').owlCarousel({
            loop: false,
            margin: 20,
            responsiveClass: true,
            nav:false,
            dots:false,
            autoWidth:true,
            rtl:{{app()->getLocale()=="ar"?"true":"false"}},
            responsive: 
            {
            0:{
            items:1,
            
            },
            600:{
            items:3,
            
            },
            1000:{
            items:3,

            }}
        });
        $(".navbar-nav li a[href$='{{$category->slug}}']").closest('li').addClass('active');
        @if($category->Parent) $(".navbar-nav li a[href$='{{$category->Parent->slug}}']").closest('li').addClass('active');@endif
        @if($category->Parent->Parent) $(".navbar-nav li a[href$='{{$category->Parent->Parent->slug}}']").closest('li').addClass('active');@endif
    
    })
</script>
@endsection