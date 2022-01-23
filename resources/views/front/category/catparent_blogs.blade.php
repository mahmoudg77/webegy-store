@extends('layouts.app')

@section('title'){{ $title }}@endsection
@section('description'){{ str_limit(strip_tags($description),100) }}@endsection

@section('content')

<!--============== Blog Area Start ==============-->
<div class="full-row mx-auto pt-30 blogs">
    <div class="container-fluid">
        <div class="row pb-50">
            <div class="col-lg-12">
                {{-- @include('partials/news-filter-form',['category'=>$category,'chields'=>$category->Parent->Chields,'type'=>7,'main_category'=>$category->Parent])
                --}}
                <form action="" method="get" class="form-filter">
                    <div class="form-row ">
                        <div class="col-lg-2 col-sm-4 col-4 col-xs-4 form-filter-select">
                            <select name="cat" placeholder="{{trans('app.category')}}" class="form-control selectpicker show-tick">
                                <option value="blogs">{{trans('app.Category')}}</option>
                                @foreach($category->Parent->Chields as $cat)
                                <option {{$category->id==$cat->id?'selected':''}} value="{{$cat->slug}}">{{$cat->title}}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-lg-2 col-sm-4 col-4 col-xs-4 form-filter-select">
                            <select name="cat" placeholder="{{trans('app.category')}}" class="form-control selectpicker show-tick">
                                <option value="{{$category->slug}}">{{trans('app.Sub Category')}}</option>
                                @if($category)
                                @foreach($category->Chields as $cat)
                                <option value="{{$cat->slug}}">{{$cat->title}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        
                        {{-- <div class="col-lg-2 col-sm-4 col-4 col-xs-4 form-filter-select">
                            <select name="cat" placeholder="{{trans('app.category')}}" class="form-control selectpicker show-tick">
                                <option value="{{$category->Parent?$category->Parent->slug:'blogs'}}">{{trans('app.Category')}}</option>
                                @foreach($chields as $cat)
                                <option {{$category->id==$cat->id?'selected':''}} value="{{$cat->slug}}">{{$cat->title}}</option>
                                @endforeach

                            </select>
                        </div>
                        --}}
                        {{-- <div class="col-lg-2 col-sm-4 col-4 col-xs-4 form-filter-select">
                            <select name="filter[created_at]" placeholder="{{trans('app.year')}}" class="form-control selectpicker show-tick">
                                <option value="">{{trans('app.Year')}}</option>
                                @for($n=2015;$n < 2022;$n++)
                                    <option {{request()->has('filter') && request()->get('filter')['created_at']==$n?'selected':''}} value="{{$n}}">{{$n}}</option>
                                    @endfor
                                </select>
                            </div>
                            --}}
                            <div class="col-lg-2 col-sm-4 col-4 col-xs-4 form-filter-select">
                                <input type="hidden" name="sort" value="pub_date">
                                <input type="hidden" name="type" value="7">
                                <select name="sort_dir" class="form-control selectpicker show-tick">
                                    <option {{request()->get('sort_dir')=='desc'?'selected':''}} value="desc">{{trans('app.Newest')}}</option>
                                    <option {{request()->get('sort_dir')=='asc'?'selected':''}} value="asc">{{trans('app.Oldest')}}</option>
                                </select>
                            </div>
                            <div class="col-lg-4 col-12 col-xs-12 form-filter-search">
                                <i class="fa fa-search"></i>
                                <input class="form-control" name="q" placeholder="{{trans('app.search')}}" value="{{request()->get('q')}}">
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 sm-mb-30">
                    <div class="row">
                        {{--@if($posts=\App\Models\Post::where('is_published',1)->where('post_type_id', 7)->paginate(6))
                        --}}
                        @if(count($data)>0)
                        @foreach($data as $post)
                      {{--  <div class="col-lg-4 col-md-6 mb-4">
                            <div class="thumb-blog-simple shadow-sm rounded">
                                <div class="post-image">
                                    @if($post->mainImage())
                                    <a href="{{route('getPostBySlug', $post->slug) }}" class="img-responsive">
                                        <img src="{{$post->mainImage('820x520','crope')}}" alt="{{$post->title}}"></a>
                                    @else
                                    <a href="{{route('getPostBySlug', $post->slug) }}" class="img-responsive">
                                        <img src="{{ asset('images/none.jpg')}}" alt="{{$post->name}}" style="width:100%;height:100%"></a>
                                    @endif
                                </div>
                                <div class="content p-1">
                                    <h6 class="mt-3 mb-2 post-cat">{{$post->Category?$post->Category->title:''}}</h6>
                                    <div class="date text-general pb-2">
                                        {{ Func::time_string($post->pub_date)}}
                                    </div>
                                    <h5 class="mb-3 post-title" style="font-size: 16px;"><a href="{{route('getPostBySlug', $post->slug) }}">{{ $post->title}}</a></h5>
                                </div>
                            </div>
                        </div>--}}
                        @include('partials.blog-item',compact('post'))
                        @endforeach
                        <div class="col col-sm-12 mb-20">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination pagination-dotted-active justify-content-center">
                                    {{ $data->links() }}
                                </ul>
                            </nav>
                        </div>
                        @else
                        <div class="col col-xs-12 text-center">
                            <h4 class="alert alert-danger">{{ trans('app.No items found') }}</h4>
                        </div>
                        @endif
                        {{--@endif--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--============== Blog Area End ==============-->
    @endsection
    @section('js')
    <script>
        $(document).ready(function() {
            $("form.form-filter select").change(function() {
                $("form.form-filter").submit();
            });
            $("form.form-filter select[name=cat]").change(function(e) {
                e.preventDefault();
                $("form.form-filter").attr("action", "/{{app()->getLocale()}}/cat/"+$(this).val());
                $("form.form-filter").submit();
            });
            $(".navbar-nav li a[href$='{{$category->slug}}']").closest('li').addClass('active');
            @if ($category->Parent) $(".navbar-nav li a[href$='{{$category->Parent->slug}}']").closest('li').addClass('active'); @endif
            @if ($category->Parent->Parent) $(".navbar-nav li a[href$='{{$category->Parent->Parent->slug}}']").closest('li').addClass('active'); @endif

        })
    </script>
    @stop