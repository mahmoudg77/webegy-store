@extends('layouts.app')

@section('title'){{ $title }}@endsection
@section('description'){{ str_limit(strip_tags($description),100) }}@endsection

@section('content')


<!--============== Blog Area Start ==============-->
<div class="full-row pt-20 work">
<div class="container-fluid">
    <div class="row pb-20">
        <div class="col-lg-6 col-8 col-xs-8">
            <h2 class="work-header">{{trans('app.last works')}} <i class="fa fa-circle"></i></h2>
        </div>
        <div class="col-lg-6 col-4 col-xs-4">
            @if(count($category->Chields))
            <form action="" method="get" class="form-filter">
            <div class="form-row ">
                 <div class="col-sm-12 col-md-2">
                    <select name="cat" placeholder="{{trans('app.category')}}" class="form-control selectpicker show-tick">
                       <option value="{{$category->Parent?$category->Parent->slug:'work'}}">{{trans('app.Category')}}</option>
                        @foreach($category->Chields as $cat)
                            <option {{$category->id==$cat->id?'selected':''}} value="{{$cat->slug}}">{{$cat->title}}</option>
                        @endforeach
                    
                    </select>
                </div>
            </div>
            </form>
            @endif
        </div>
    </div>    
    
    <div class="row">
        <div class="col-lg-12 sm-mb-30">
            <div class="row">
            @if(count($data)>0)
            @foreach($data as $post)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="thumb-blog-simple shadow-sm rounded bg--white">
                        <div class="post-image text-center">
                            @if($post->mainImage())
                            <a href="{{route('getPostBySlug', $post->slug) }}" ><img class="img-responsive" style="opacity:0.5" src="{{$post->mainImage('340x340','crope')}}" alt="{{$post->title}}"></a>
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
                <!-- <div class="col-lg-12 mt-5">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination pagination-dotted-active justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous Page</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next Page</a>
                            </li>
                        </ul>
                    </nav>
                </div> -->
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
        })
    })
</script>
@stop