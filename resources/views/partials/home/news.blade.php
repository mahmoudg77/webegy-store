{{--@if($cats=\App\Models\Category::where('parent_id',60)->get())
--}}
<!--============== Recent Property Start ==============-->
<div class="full-row pt-20 pb-50 news">
    <div class="container-fluid">
        <div class="row pb-30">
            <div class="col-lg-12">
                <h2 class="mb-4 text-center w-50 w-sm-100 mx-auto news-header">{{trans('app.news')}} <i class="fa fa-circle"></i></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="owl-carousel owl-theme">
                    {{--@foreach($cats as $cat)
                    --}}

                    @if($posts=cache()->remember('home_section_blogs',Carbon\Carbon::now()->addMinutes(30),function(){
                    return \App\Models\Post::CategoryIs(60)->orderBy('pub_date','desc')->limit(12)->get();}
                    ))

                    {{--@php(dd($posts))--}}

                    @foreach($posts as $post)
                    <a href="{{$post->link()}}">
                        <div class="item">
                            <!-- Property Grid -->
                            <div class="property-grid-0 property-block transation-this hover-shadow bg-white">
                                <div class="overflow-hidden position-relative transation thumbnail-img bg-secondary hover-img-zoom">
                                    {{--<a href="{{route('getPostBySlug', $post->slug) }}">
                                        --}}
                                        <img src="{{$post->mainImage('350x200','crope')}}" alt="{{$post->title}}">
                                        {{--</a>--}}
                                </div>
                                <div class="property_text p-3">
                                    <h6 class="mt-2 news-title font-600 text-dark">
                                        {{--  <a class=" " href="{{route('getPostBySlug', $post->slug) }}">
                                            --}} {{str_limit(strip_tags($post->title),100)}}
                                            {{--  </a>--}}
                                    </h6>
                                </div>
                                {{--	<div class="col-12 col-xs-12 news-btn">
                                    <div class="text-center post-meta mt-2 p-3 border-top">
                                        <a class="font-600 text-dark" href="{{route('getPostBySlug',$post->slug)}}">{{trans('app.read more')}}</a>
                                    </div>
                                </div>
                                --}}

                            </div>
                        </div>
                    </a>
                    @endforeach
                    @endif
                    {{--@endforeach	--}}
                </div>
            </div>
        </div>
    </div>
</div>

<!--============== Recent Property End ==============-->

{{--@endif--}}

@section('js')
<script>
    $(document).ready(function() {
        $('.owl-carousel').owlCarousel({
            loop: true,
            autoplay: 5000,
            margin: 20,
            responsiveClass: true,
            nav: true,
            dots: false,
            autoWidth: true,
            rtl: {{
                app()->getLocale() == "ar"?"true": "false"
            }},
            responsive:
            {
                0: {
                    items: 1,

                },
                600: {
                    items: 4,

                },
                1000: {
                    items: 4,

                }}
        });
    })
</script>
@endsection