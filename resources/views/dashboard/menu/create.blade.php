@extends('layouts.admin')
@section('title', trans('app.new menu'))
@section('content')

<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="card">
            <div class="header">
                <h2>{{trans('app.new menu')}}</h2>
            </div>
        {!! Form::open(['method'=>'POST', 'route'=>["cp.menu.store"]]) !!}
            <div class="body" style="display: flow-root;">  
                <div class="row clearfix">
                    <div class="col-sm-6 col-xs-12">
                      <div class="col-lg-4 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                        {!! Form::label(trans('app.name')) !!}
                      </div>
                      <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                          <div class="form-group">
                              <div class="form-line">
                              {!! Form::text('name', null, array('required', 'class'=>'form-control', 'placeholder'=>trans('app.name'))) !!}
                              </div>
                          </div>
                      </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="col-lg-4 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                            {!! Form::label(trans('app.location')) !!}
                        </div>
                        <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                {!! Form::text('location', null, array('required', 'class'=>'form-control', 'placeholder'=>trans('app.location'))) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-xs-12">
                        {!! Form::submit(trans('app.save'), array('class'=>'btn btn-primary btn-lg pull-right')) !!}
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
      </div>
  </div>
</div>

@stop
