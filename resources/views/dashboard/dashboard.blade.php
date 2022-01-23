@extends('layouts.admin')
@section('content')

@php($arr=['info','success','warning','danger'])
<!-- Small boxes (Stat box) -->
<div class="row">
   
    @foreach(\App\Models\PostType::where('show_state',1)->get() as $type)
    <div class="col-lg-3 col-6" groups="{{implode(',',$type->Roles()->pluck('groupkey')->toArray())}}">
        <!-- small box -->
        <div class="small-box bg-{{$type->color}}">
            <div class="inner">
                <h3>{{App\Models\Post::where('post_type_id',$type->id)->where('is_published',1)->count()}}</h3>
                <p>
                    {{trans('cp.'.$type->name)}}
                </p>
            </div>
            <div class="icon">
                <i class="fa {{$type->icon}}"></i>
            </div>
            <a href="/{{app()->getLocale()}}/dashboard/posts?post_type_id={{$type->id}}" class="small-box-footer">{{trans('app.more')}} <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
     @endforeach
</div>
<!-- /.row -->

<!-- Main row -->
<div class="row">
    <div class="col-12">
        <!-- solid sales graph -->
        <div class="card card-default bg-gradient--info">
            <div class="card-header border-0">
                <h3 class="card-title">
                    <i class="fas fa-th mr-1"></i>
                    {{trans('app.latest rates')}}
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <!--<button type="button" class="btn bg-info btn-sm" data-card-widget="remove">-->
                    <!--  <i class="fas fa-times"></i>-->
                    <!--</button>-->
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Post title</th>
                            <th>Category</th>
                            <th>Rate</th>
                            <th>Date</th>
                            <th>Location</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(App\Models\PostRate::orderBy('id','desc')->limit(5)->get() as $rate)
                        @if($rate->Post)
                        <tr>
                            <td><a href="{{$rate->Post->link()}}" target="_blank">{{str_limit($rate->Post->title,20)}}</a></td>
                            <td>{{trans('cp.'.$rate->Post->PostType->name)}}</td>
                            <td>@if($rate->Post->PostType->can_rate)
                                @for($x=1;$x <= 5;$x++)
                                    <i style="color:orange" class="fa fa-star{{$x>$rate->rate?'-o':''}}" aria-hidden="true"></i>
                                    @endfor
                                    @else
                                    <i style="color:{{$rate->rate<3?'red':'green'}}" class="fa fa-thumbs{{$rate->rate<3?'-down':'-up'}}" aria-hidden="true"></i>
                                    @endif
                                </td>
                                <td>{{$rate->created_at}}</td>
                                <td><a target="_blank" href="https://www.google.com/maps/search/?api=1&query={{$rate->latitude}},{{$rate->longitude}}"><img src="{{asset('front/flags/'.strtolower($rate->country_code).'.png')}}">
                                    {{$rate->country}}, {{$rate->city}}
                                </a>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                    </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
    <!-- /.row last rats -->
    <!-- Main row -->
    <!--<div class="row">-->
        <!-- Left col -->
    <!--    <section class="col-lg-7 connectedSortable">-->
    <!--        <div class="card">-->
    <!--            <div class="card-header">-->
    <!--                <h3 class="card-title">-->
    <!--                    <i class="fas fa-chart-pie mr-1"></i>-->
    <!--                    Visits-->
    <!--                </h3>-->
    <!--            </div>-->
    <!--            <div class="card-body">-->
    <!--                <div class="p-0">-->
    <!--                    <div class="chart " id="sales-chart" style="position: relative; height: 300px;">-->
    <!--                    <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </section>-->
    <!--</div>-->
    
    @endsection
    @section('js')
    <script src="{{asset('cp/plugins/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('cp/js/pages/dashboard.js')}}"></script>
    
    @stop