@extends('layouts.admin')
@section('title', 'Create User')
@section('content')


<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="header">
            <h2>{{trans('app.new user')}}</h2>
        </div>
        <div class="body" style="display: flow-root;">    
        {!! Form::open(['method'=>'POST', 'route'=>["cp.user.store"]]) !!}  
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
                          {!! Form::text('email', null, ['required', 'class'=>'form-control','type'=>'email']) !!}
                          </div>
                      </div>
                  </div>
            </div>
          </div>
         
          <div class="row clearfix">
              <div class="col-sm-6 col-xs-12">
                  <div class="col-lg-4 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                      <label for="email_address_2">{{trans('app.country')}}</label>
                  </div>
                  <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                      <div class="form-group">
                          <div class="form-line">
                          {!! Form::text('country', null, ['class'=>'form-control']) !!}
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-sm-6 col-xs-12">
                    <div class="col-lg-4 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                        <label for="email_address_2">{{trans('app.city')}}</label>
                    </div>
                    <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                            <div class="form-line">
                            {!! Form::text('city', null, ['class'=>'form-control']) !!}
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
                          {!! Form::text('phone', null, ['class'=>'form-control', 'placeholder'=>'']) !!}
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
 <div class="row clearfix">
              <div class="col-sm-6 col-xs-12">
                  <div class="col-lg-4 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                      <label for="email_address_2">{{trans('app.password')}}</label>
                  </div>
                  <div class="col-lg-8 col-md-10 col-sm-8 col-xs-7">
                      <div class="form-group">
                          <div class="form-line">
                          {!! Form::password('password', ['class'=>'form-control', 'type'=>'password','placeholder'=>'']) !!}
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
                         {!! Form::password('confirm-password', ['class'=>'form-control','type'=>'password', 'placeholder'=>'']) !!}
                           </div>
                      </div>
                  </div>
              </div>
          </div>
          <hr>
          <div class="form-group">
              <div class="col-md-offset-2 col-md-10 text-right">
              {!! Form::submit(trans('app.add'), array('class'=>'btn btn-success btn-lg pull-right')) !!}
              <a href="{{ URL::previous() }}" class="btn btn-primary btn-lg" style="margin: 0 10px;">{{trans('app.back')}}</a>
              </div>
          </div>
        {!! Form::close() !!}
        </div>
    </div>
</div>
</div>


  <!-- <div class="panel panel-default" style="width:700px;max-width: 100%;">
    <div class="panel-heading main-color-bg">
      <h3 class="panel-title">Add New User</h3>
    </div>
`name`, `email`, `password`, `country`, `city`, `phone`,
        `active`, `created_by`, `updated_by`, `verified`,
        `email_token`, `remember_token`, `created_at`, `updated_at`, `account_level_id`*/ ?>
    <div class="modal-body">
      <div class="row">
      {!! Form::open(['method'=>'POST', 'route'=>["cp.user.store"]]) !!}

      <div class="form-group col-sm-6">
            {!! Form::label('Name') !!}
            {!! Form::text('name', null, ['required', 'class'=>'form-control', 'placeholder'=>'']) !!}
          </div>

          <div class="form-group col-sm-12">
            {!! Form::label('Email') !!}
            {!! Form::text('email', null, ['required', 'class'=>'form-control','type'=>'email', 'placeholder'=>'']) !!}
          </div>
          <div class="form-group col-sm-12">
            {!! Form::label('Country') !!}
            {!! Form::text('country', null, ['class'=>'form-control', 'placeholder'=>'']) !!}
          </div>
          <div class="form-group col-sm-12">
            {!! Form::label('City') !!}
            {!! Form::text('city', null, ['class'=>'form-control', 'placeholder'=>'']) !!}
          </div>
          <div class="form-group col-sm-12">
            {!! Form::label('Phone') !!}
            {!! Form::text('phone', null, ['class'=>'form-control', 'placeholder'=>'']) !!}
          </div>

        <div class="form-group col-sm-6">
          {!! Form::label('Account Type?') !!}
          {!! Form::select('account_level_id', App\Models\AccountLevel::pluck('name','id'), null, array('class'=>'form-control', 'placeholder'=>'Select parent')) !!}
        </div>


        <hr/>
        <div class="model-footer form-group col-sm-12">
            {!! Form::submit('Add New', array('class'=>'btn btn-primary pull-right')) !!}
        </div>
      {!! Form::close() !!}
      </div>
    </div>

  </div> -->

@stop
