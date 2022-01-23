@extends('layouts.app')

@section('title'){{ $singlePost->meta_title }}@endsection
@section('description'){{ str_limit(strip_tags($singlePost->meta_description),150) }}@endsection

@section('content')

<section class="full-row bg-dark books pt-20 pb-20">
<!--============== Page title Start ==============-->
    <div class="container-fluid">
        <div class="pt-50">
            <div class="row">
                <div class="col-12">
                    <h2 class="text-center pb-20">{{ $singlePost->title }}</h2>
                </div>
            </div>
            <div class="row">
                @if($data=\App\Models\Post::related(17,'Author',$singlePost->id)->where('is_published',1)->orderBy('id','asc')->get())
                    @foreach($data as $post)
                        @include('partials/book-item',$post)
                    @endforeach
                @endif
            </div>
        </div>
    </div>
<!--============== dddrj title End ==============-->
</section>

@endsection