@extends('layouts.admin')
@section('title', 'Profile')
@section('content')

<div class="row clearfix">
    <div class="col-xs-12 col-sm-3">
        <div class="card profile-card">
            <div class="profile-header">&nbsp;</div>
            <div class="profile-body">
                <div class="image-area">
                    <img src="{{$data->mainImage()}}" width="140" height="130" alt="{{$data->name}}" />
                </div>
                <div class="content-area">
                    <h3>{{$data->name}}</h3>
                    <p>{{$data->email}}</p>
                    <p>{{($data->AccountLevel)?$data->AccountLevel->role:'None'}}</p>
                </div>
            </div>
            <div class="profile-footer">
                
            </div>
        </div>
        
    </div>
    <div class="col-xs-12 col-sm-9">
        <div class="card">
            <div class="body">
                <div>
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#edit_profile" aria-controls="home" 
                            role="tab" data-toggle="tab">{{trans('app.profile')}}</a></li>
                        <!-- <li role="presentation"><a href="#change_password_settings" aria-controls="settings" 
                            role="tab" data-toggle="tab">{{trans('app.change password')}}</a></li> -->
                    </ul>

                    <div class="tab-content">
                          <div role="tabpanel" class="tab-pane fade in active" id="edit_profile">
                              <div class="body">
                              <div class="body table-responsive">
                              <table class="table">
                                  <tbody>
                                      <tr>
                                          <th>{{trans('app.name')}}</th>
                                          <td>{{$data->name}}</td>
                                          <th>{{trans('app.email')}}</th>
                                          <td>{{$data->email}}</td>
                                      </tr>
                                      <tr>
                                          <th>{{trans('app.country')}}</th>
                                          <td>{{$data->country}}</td>
                                          <th>{{trans('app.city')}}</th>
                                          <td>{{$data->city}}</td>
                                      </tr>
                                      <tr>
                                          <th>{{trans('app.phone')}}</th>
                                          <td>{{$data->phone}}</td>
                                          <th>{{trans('app.active')}}</th>
                                          <td>
                                          @if($data->active == 1)
                                            <h4><span class="label label-success">{{trans('app.active')}}</span></h4>
                                          @elseif($data->active == 0)
                                            <h4><span class="label label-danger">{{trans('app.rejected')}}</span></h4>
                                          @endif
                                          </td>
                                      </tr>
                                      <tr>
                                          <th>{{trans('app.address')}}</th>
                                          <td colspan="3">{{$data->address}}</td>
                                      </tr>
                                  </tbody>
                              </table>
                          </div>
                            </div>
                        </div>
                        
                        <!-- <div role="tabpanel" class="tab-pane fade in" id="change_password_settings">
                            <div class="body">

                            </div>
                        </div> -->
                    </div>
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
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
