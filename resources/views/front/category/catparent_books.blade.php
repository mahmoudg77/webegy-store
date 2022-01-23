@extends('layouts.app')

@section('title'){{ $title }}@endsection
@section('description'){{ str_limit(strip_tags($description),100) }}@endsection

@section('content')

<section class="full-row bg-dark books pt-20 pb-20">
<!--============== Page title Start ==============-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
            @include('partials/filter-form',['category'=>$category,'chields'=>$category->Parent->Chields,'type'=>17])
            </div>
        </div>
        <div class="pt-50">
            <div class="row">
                @foreach($data as $post)
                    @include('partials/book-item',$post)
                @endforeach
                <div class="col col-sm-12 mb-20">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination pagination-dotted-active justify-content-center">
                            {{ $data->appends(request()->except('page'))->links() }}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        

    </div>
<!--============== dddrj title End ==============-->
</section>

@endsection
@section('js')
<script>
    $(document).ready(function(){
        $("form.form-filter select").change(function(){
             $("form.form-filter").submit();
        });
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