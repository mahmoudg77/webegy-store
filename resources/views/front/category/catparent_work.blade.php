@extends('layouts.app')

@section('title'){{ $title }}@endsection
@section('description'){{ str_limit(strip_tags($description),100) }}@endsection

@section('content')


<!--============== Blog Area Start ==============-->
<div class="full-row pt-20 work">
    <div class="container-fluid">
        <div class="row pb-20">
            <div class="col-lg-6 col-6 col-xs-6">
                <h2 class="work-header">{{trans('app.last works')}}</h2>
            </div>
            <div class="col-lg-6 col-6 col-xs-6">
                <form action="" method="get" class="form-filter">
                <div class="form-row ">
                     <div class="col-sm-12 col-md-2">
                        <select name="cat" placeholder="{{trans('app.category')}}" class="form-control selectpicker show-tick">
                           <option value="{{$category->Parent?$category->Parent->slug:'work'}}">{{trans('app.Category')}}</option>
                            @foreach($category->Parent->Chields as $cat)
                            <option {{$category->id==$cat->id?'selected':''}} value="{{$cat->slug}}">{{$cat->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                </form>
            </div>
        </div>    
    
            <div class="col-lg-12 sm-mb-30">
                <div class="row">
                @if(count($data)>0)
                @foreach($data as $post)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="thumb-blog-simple shadow-sm rounded bg--white">
                            <div class="post-image">
                                @if($post->mainImage())
                                <a href="{{route('getPostBySlug', $post->slug) }}" ><img class="img-responsive" style="opacity:0.5" src="{{$post->mainImage('820x520','crope')}}" alt="{{$post->title}}"></a>
                                @else
                                    <a href="{{route('getPostBySlug', $post->slug) }}" ><img class="img-responsive" style="opacity:0.5" src="{{ asset('images/none.jpg')}}" alt="{{$post->name}}" style="width:100%;height:100%"></a>
                                @endif
                            </div>
                            <div class="content p-4">
                                {{--<div class="date text-general pb-2">{{ $post->created_at!=null?$post->created_at->toDateString('dd/MM/yyyy'):'' }}</div>
                      --}}          <h5 class="mb-3 post-title text-center"><a href="{{route('getPostBySlug', $post->slug) }}">{{ $post->title}}</a></h5>
                            </div>
                        </div>
                    </div>
                        @endforeach
                    <div class="blog-pagination text-center clearfix">
                        <ul class="pagination">
                            {{ $data->appends(request()->except('page'))->links() }}
                        </ul>
                    </div>
                @else
                    <div class="col col-xs-12 text-center">
                        <h4 class="alert alert-danger">{{ trans('app.No items found') }}</h4>
                    </div>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!--============== Blog Area End ==============-->
@endsection
@section('js')
<script>
    $(document).ready(function(){
        
        $("form.form-filter select[name=cat]").change(function(e){
             e.preventDefault();
             $("form.form-filter").attr("action","/{{app()->getLocale()}}/cat/"+$(this).val());
             $("form.form-filter").submit();
        });
         $(".navbar-nav li a[href$='{{$category->slug}}']").closest('li').addClass('active');
        @if($category->Parent) $(".navbar-nav li a[href$='{{$category->Parent->slug}}']").closest('li').addClass('active');@endif
        @if($category->Parent->Parent) $(".navbar-nav li a[href$='{{$category->Parent->Parent->slug}}']").closest('li').addClass('active');@endif
    
    })
</script>
@stop