
@if($posts=\App\Models\Post::where('is_published',1)->where('category_id',25)->limit(5)->get())

<div id="carouselExampleFade" class="carousel slide carousel-fade " data-ride="carousel">
  <div class="carousel-inner">
      @php $n=1; @endphp
    @foreach($posts as $post)
    <div class="carousel-item {{$n ==1?'active':''}} overlay-dark">
      <img class="d-block w-100" src="{{$post->mainImage('1280x600','crope')}}" alt="{{$post->title}}">
      <div class="carousel-caption">
        <h1 style="color: #fff;">{{$post->title}}</h1>

        <div class="btn-slider">
            <a style="color: #fff; opacity: 1; transform: translate3d(0px, 0px, 0px); background: transparent none repeat scroll 0% 0%; transform-origin: 50% 50% 0px;border: 1px solid #fff;width: 170px;" 
                class="btn btn-link" href="#2" target="_self" aria-label="jump to slide 2">{{trans('app.news')}}
			</a>
			<a style="color: #fff; opacity: 1; transform: translate3d(0px, 0px, 0px); background: transparent none repeat scroll 0% 0%; transform-origin: 50% 50% 0px;border: 1px solid #fff;width: 170px;" 
                class="btn btn-link" href="#2" target="_self" aria-label="jump to slide 2">{{trans('app.tv network')}}
			</a>
        </div>
        <div class="btn-slider">
            <a href="#about" class=""><img src="{{ asset('front/img/scroll.png')}}" class=""/></a>
        </div>
      </div>
    </div>
    @php $n++ @endphp
   @endforeach
   
  </div>
  <!--<a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">-->
  <!--  <span class="carousel-control-prev-icon" aria-hidden="true"></span>-->
  <!--  <span class="sr-only">Previous</span>-->
  <!--</a>-->
  <!--<a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">-->
  <!--  <span class="carousel-control-next-icon" aria-hidden="true"></span>-->
  <!--  <span class="sr-only">Next</span>-->
  <!--</a>-->
</div>

@endif 




@section('js')
<script>
$(document).ready(function(){

  $('.carousel').carousel()

}); 
    
</script>
@endsection