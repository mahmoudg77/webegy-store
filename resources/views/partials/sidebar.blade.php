<div class="blog-sidebar widget-box-model">
    
    <!-- Category Field -->
    <!--<div class="widget widget_categories" style="background-color: #1a1a1a;">-->
    <!--    <h5 class="widget-title mb-3">{{trans('app.categories')}}</h5>-->
    <!--    <ul>-->
    <!--        @foreach(Func::menu('main') as $link)-->
    <!--            {!!Func::drowMenuLink($link,['li'=>'','a'=>''])!!}-->
    <!--        @endforeach -->
    <!--    </ul>-->
    <!--</div>-->
    
    <!-- Recent Post -->
    <div class="widget widget_recent_entries" style="background-color: #1a1a1a;border: 0;">
        <h5 class="widget-title mb-3">{{trans('app.recent blog')}}</h5>
        <ul>
        @foreach(\App\Models\Post::where('is_published',1)->where('post_type_id',7)->orderBy('id','desc')->limit(3)->get() as $post)
            <li>
                <a href="{{route('getPostBySlug', $post->slug) }}">{{ $post->title}}</a>
                <span class="post-date">{{ $post->created_at!=null?$post->created_at->toDateString('dd/MM/yyyy'):'' }}</span>
            </li>
        @endforeach
        </ul>
    </div>
    
    <!--============== Recent Property Widget Start ==============-->
    <div class="widget widget_recent_property" style="background-color: #1a1a1a;border: 0;">
        <h5 class="widget-title mb-3">{{trans('app.recently episodes')}}</h5>
        <ul>
        @if($tvs=\App\Models\Post::where('is_published',1)->where('post_type_id',10)->orderBy('id','desc')->limit(5)->get())
        @foreach($tvs as $post)
            <li> 
                <img src="{{$post->mainImage('300x300','crope')}}" alt="{{$post->title}}">
                <div class="thumb-body">
                    <h6 class="text-secondary hover-text-primary mb-0"><a href="{{route('getProjectBySlug', $post->slug) }}">{{$post->title}}</a></h6>
                    <span class="text-primary d-table py-1">{{$post->Category->Parent->title}}</span> 
                </div>
            </li>
        @endforeach
        @endif
        </ul>
    </div>
</div>