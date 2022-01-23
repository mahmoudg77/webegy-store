 <div class="col-lg-4 col-md-6 mb-4">
                            <div class="thumb-blog-simple shadow-sm rounded">
                                <div class="post-image">
                                    @if($img=$post->mainImage('820x520','crope'))
                                    <a href="{{$post->link()}}" class="img-responsive">
                                        <img src="{{$img}}" alt="{{$post->title}}"></a>
                                    @else
                                    <a href="{{$post->link()}}" class="img-responsive">
                                        <img src="{{ asset('images/none.jpg')}}" alt="{{$post->name}}" style="width:100%;height:100%"></a>
                                    @endif
                                </div>
                                <div class="content p-1">
                                    <h6 class="mt-3 mb-2 post-cat">{{$post->Category?$post->Category->title:''}}</h6>
                                    <div class="date text-general pb-2 pt-2">
                                        {{ Func::time_string($post->pub_date)}}{{--$post->created_at!=null?$post->created_at->toDateString('Y-m-d H:i:s'):'' --}}
                                    </div>
                                    <h5 class="mb-3 post-title" style="font-size: 16px;"><a href="{{route('getPostBySlug', $post->slug) }}">{{ $post->title}}</a></h5>
                                </div>
                            </div>
                        </div>