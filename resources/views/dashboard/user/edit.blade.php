@extends('layouts.admin')
@section('title',$data->title)
@section('content')


<div class="card card-default">
  <div class="card-header">
    <h3 class="card-title">{{trans('app.edit')}} : <small>{{$data->name}}</small></h3>
  </div>
  <!-- /.card-header -->
    <div class="card-body">
        {{Form::model($data, ['route'=>["cp.user.update",$data->id],"method"=>"PUT"])}}    
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row clearfix">
                <div class="col-sm-6 col-xs-12">
                    <div class="col-lg-4 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                        <label for="email_address_2">{{trans('app.name')}}</label>
                    </div>
                    <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                            <div class="form-line">
                            {!! Form::text('name', null, ['required', 'class'=>'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xs-12">
                        <div class="col-lg-4 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                            <label for="email_address_2">{{trans('app.email')}}</label>
                        </div>
                        <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                {!! Form::text('email', null, ['required', 'class'=>'form-control','type'=>'email','disabled'=>'disabled']) !!}
                                </div>
                            </div>
                        </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-sm-6 col-xs-12">
                    <div class="col-lg-4 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                        <label for="email_address_2">{{trans('app.phone')}}</label>
                    </div>
                    <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                            <div class="form-line">
                            {!! Form::text('phone', null, ['class'=>'form-control', 'disabled'=>'disabled']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <div class="col-lg-4 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                        <label for="email_address_2">{{trans('app.account_level_id')}}</label>
                    </div>
                    <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                            <div class="form-line">
                            {!! Form::select('account_level_id', App\Models\AccountLevel::pluck('name','id'), null, array('class'=>'form-control', 'placeholder'=>'Select parent')) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <!-- /.card-body -->

    <div class="card-footer">
      {!! Form::submit(trans('app.edit'), array('class'=>'btn btn-success pull-right')) !!}
    <a href="{{ URL::previous() }}" class="btn btn-primary" style="margin: 0 10px;">{{trans('app.back')}}</a>
    </div>
    {!! Form::close() !!}
</div>


@stop
