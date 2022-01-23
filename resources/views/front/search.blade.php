@extends('layouts.app')

@section('title'){{ trans('search') }}@endsection

@section('content')

<!--============== Page title Start ==============-->
<div class="full-row">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <nav aria-label="breadcrumb" class="mb-2">
                    <ol class="breadcrumb mb-0 bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('app.home') }}</a></li>
                    <li class="breadcrumb-item active text-primary" aria-current="page">{{ trans('app.search') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!--============== Page title End ==============-->

<!--============== Property Grid View Start ==============-->
<div class="full-row pt-0">
    <div class="container">
    {{Form::model(null, ['route'=>["search"],"method"=>"POST","class"=>"quick-search form-icon-right"])}}
        <div class="full-row">
        <div class="container">
        <div class="row">
            <div class="col-lg-3 col-xs-12 mb-10">
                <div class="form-group mb-0">
                    <input type="text" class="form-control bg-gray" id="price" name="price_main_project" 
                        placeholder="{{trans('app.price_main_project')}}"/>
                </div>
                <div class="text-danger {{ $errors->has('price_main_project') ? 'has-error' : '' }}">{{ $errors->first('price_main_project') }}</div>
            </div>
            <div class="col-lg-3 col-xs-12 mb-10">
                <div class="form-group mb-0">
                    {!! Form::select('region_id',App\Models\Region::all()->pluck('title','id'),null,['class'=>'form-control select','placeholder'=>trans('app.root region')]) !!}
                </div>
            </div>
            <div class="col-lg-3 col-xs-12 mb-10">
                <div class="form-group mb-0">
                    {!! Form::select('area_id',App\Models\Area::all()->pluck('title','id'),null,['class'=>'form-control select','placeholder'=>trans('app.root area')]) !!}
                </div>
            </div>
            <div class="col-lg-3 col-xs-12 mb-10">
                <div class="form-group mb-0">
                    {!! Form::select('developer_id',
                        App\Models\Developer::all()->pluck('title','id'),null,['class'=>'form-control select','placeholder'=>trans('app.root client')]) !!}
                </div>
            </div>
            <div class="col-lg-3 col-xs-12 mb-10">
                <div class="form-group mb-0">
                    <input type="text" class="form-control bg-gray" id="year_receipt" name="year_receipt" 
                        placeholder="{{trans('app.year_receipt')}}"/>
                </div>
                <div class="text-danger {{ $errors->has('year_receipt') ? 'has-error' : '' }}">{{ $errors->first('year_receipt') }}</div>
            </div>
            <div class="col-lg-3 col-xs-12 mb-10">
                <div class="form-group mb-0">
                    <input type="text" class="form-control bg-gray" id="deposit" name="deposit" 
                        placeholder="{{trans('app.deposit')}}"/>
                </div>
                <div class="text-danger {{ $errors->has('deposit') ? 'has-error' : '' }}">{{ $errors->first('deposit') }}</div>
            </div>
            <div class="col-lg-3 col-xs-12 mb-10">
                <div class="form-group mb-0">
                    <input type="text" class="form-control bg-gray" id="keywords" name="keywords" 
                        placeholder="{{trans('app.keywords')}}"/>
                </div>
            </div>
    
            <div class="col-lg-3 col-xs-12">
                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary w-100">{{trans('app.search')}}</button>
                </div>
            </div>
        </div>
        </div>
        </div>
    {{Form::close()}}
    </div>
</div>

<div class="full-row pt-0">
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">
            @if(count($data)>0)
            @foreach($data as $post)
                <div class="col-lg-4 col-md-6 col-xs-12">
                    <div class="property-grid-1 bg-white property-block border transation-this hover-shadow mb-30">
                        <div class="overflow-hidden position-relative transation thumbnail-img bg-secondary hover-img-zoom m-2">
                            <div class="cata position-absolute">
                                @if($post->show_offers == 1)
                                <span class="sale bg-secondary text-white" style="background-color: red !important;">{{trans('app.offer')}}</span>
                                @endif

                                @if($post->Features)
                                    <span class="featured bg-primary text-white">{{trans('app.features')}}</span>
                                @endif
                            </div>
                            <a href="single_property.html">
                                <img src="{{$post->mainImage('820x550','crope')}}" alt="{{$post->title}}" style="width:100%">
                            </a>
                            <span class="price-on text-white font-medium font-700">{{$post->price_main_project}}/
                                <small>{{trans('app.EGP')}}</small></span>
                        </div>
                        <div class="property_text p-3">
                            <div class="post-meta font-mini text-uppercase list-color-primary">
                                @if(!is_null($post->Regions))
                                    @foreach($post->Regions as $reg )
                                    <a href="{{route('getRegionBySlug', $reg->slug) }}"><span>{{$reg->title}}</span></a>
                                    @endforeach
                                @endif
                            </div>
                            <h6 class="mt-2"><a class="font-600 text-secondary" href="{{route('getProjectBySlug', $post->slug) }}">{{$post->title}}</a></h6>
                            @if (!is_null($post->area_id))
                            <span class="my-3 d-block"><i class="fas fa-map-marker-alt text-primary"></i> {{ $post->Area->title }}</span>
                            @endif
                            <div class="quantity">
                                <ul class="d-flex">
                                    <li><span>{{trans('app.area')}}:</span> {{$post->from_space}} <span>:</span> {{$post->to_space}}</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center post-meta mt-2 p-3 border-top">
                            <div class="agent" style="min-height: 40px;height: 100%;max-height: 40px;">
                                @if (!is_null($post->developer_id))
                                <a href="{{route('getDeveloperBySlug', $post->Developer->slug)}}" class="d-flex text-general align-items-center">
                                    <img class="rounded-circle mr-2" src="{{$post->Developer->mainImage('80x80','crope')}}" 
                                    alt="{{$post->Developer->title}}"><span>{{$post->Developer->title}}</span></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
                <div class="col-lg-12 mt-5">
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
            </div>
        </div>
    </div>
</div>
</div>
<!--============== Property Grid View End ==============-->
@stop