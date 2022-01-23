
@if($cat=cache()->remember('category_64',Carbon\Carbon::now()->addMinutes(30),function(){
         return \App\Models\Category::find(64);}
         ))
@if($posts=cache()->remember('home_section_services',Carbon\Carbon::now()->addMinutes(120),function(){
         return \App\Models\Post::CategoryIs(64)->orderBy('pub_date','desc')->limit(8)->get();}
         ))

<!--============== Our Service Start ==============-->
<div class="full-row bg-dark pt-20 services-home">
	<div class="container-fluid">
		<div class="row pb-30">
			<div class="col-lg-12 mb-5">
				<h2 class="mb-4 text-center w-50 w-sm-100 mx-auto services-header" style="color: #fff;">{{$cat->title}} <i class="fa fa-circle"></i></h2>
			</div>
		</div>
		<div class="row">
		    @foreach($posts as $post)
			<div class="col-lg-3 col-md-6 col-12 col-xs-12 mb-4 mb-5">
				<div class="thumb-modern-border p-4 h-100">
					<i class="{{$post->icon}} fa-5x bg-dark d-table"></i>
					<h5 class="my-3 services-body-header">{{$post->title}}</h5>
					<div class="services-body">{!! strip_tags($post->body) !!}</div>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</div>
<!--============== Our Service End ==============-->
	
@endif
@endif