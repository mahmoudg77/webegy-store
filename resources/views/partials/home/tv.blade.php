
@if($posts=cache()->remember('home_section_tv',Carbon\Carbon::now()->addMinutes(120),function(){
         return \App\Models\Post::CategoryIs(54)->orderBy('pub_date','desc')->limit(6)->get();}
         ))
<!--============== Blog Section Start ==============-->
<div class="full-row bg-ligh pt-20 tv-section">
	<div class="container-fluid">
		<div class="row pb-30">
			<div class="col-lg-12 ">
				<h2 class="mb-4 text-center w-50 w-sm-100 mx-auto tv-section-header">{{trans('app.recently episodes')}} <i class="fa fa-circle"></i></h2>
			</div>
		</div>
		<div class="row">
		    @foreach($posts as $post)
			    <div class="col-lg-4 col-md-6 col-6 col-xs-6">
				<div class="thumb-blog-overlay bg-dark hover-text-PushUpBottom mb-2">
				    <a class="text-primary transation font-large" href="{{$post->link()}}">
    					<div class="post-image position-relative overlay-secondary">
    						<img src="{{$post->mainImage('450x250','scale')}}" class="w-100" alt="Image not found!">
    						<div class="position-absolute xy-center">
    							<div class="overflow-hidden text-center"><i class="fa fa-play"></i></div>
    						</div>
    					</div>
					</a>
					<div class="post-content p-10 text-center">
						<h6 class="d-block mb-3 tv-body-title">
						    <a href="{{$post->link()}}" class="transation text-white hover-text-primary">{{$post->Category->Parent->title}} 
						    <i class="fa fa-angle-double-{{(app()->getLocale()=='ar')?"left":'right'}} text-primary"></i> {{$post->title}}</a>
					    </h6>
					</div>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</div>
<!--============== Blog Section End ==============-->
@endif


