@extends('layouts.admin')
@section('title',$data->name)
@section('content')

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">{{trans('app.edit menu')}} {{ $data->name }}</h3>
    </div>
    <!-- /.card-header -->
    {!! Form::open(['method'=>'PATCH', 'route'=>["cp.menu.update",$data->id]]) !!}
    
    <div class="card-body">
        <div class="row clearfix">
          <div class="col-sm-6 col-xs-12">
                <div class="col-lg-4 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: {{(app()->getLocale()=='ar')?'right':'left'}};">
                  {!! Form::label(trans('app.name')) !!}
                </div>
                <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                    <div class="form-group">
                        <div class="form-line">
                        {!! Form::text('name', $data->name, array('required', 'class'=>'form-control', 'placeholder'=>trans('app.name'))) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12">
                <div class="col-lg-4 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: {{(app()->getLocale()=='ar')?'right':'left'}};">
                    {!! Form::label(trans('app.location')) !!}
                </div>
                <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                    <div class="form-group">
                        <div class="form-line">
                        {!! Form::text('location', $data->location, array('required', 'class'=>'form-control', 'placeholder'=>trans('app.location'))) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->

    <div class="card-footer">
      {!! Form::submit(trans('app.save'), array('class'=>'btn btn-primary pull-right')) !!}
    </div>
    {!! Form::close() !!}
</div>

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">{{trans('app.links')}}</h3>
    </div>
    <!-- /.card-header -->   
    <div class="card-body">
        <div id="divLinks" class="col-xs-12"></div>
    </div>
    <!-- /.card-body -->
</div>

@section('js')
  <script>
    $(function(){
      $("#divLinks").load("{{route('cp.menu-link.index',['m'=>$data->id])}}");
    });
  </script>
@endsection
@stop
