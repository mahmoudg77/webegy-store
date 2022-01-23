@extends('layouts.admin')
@section('content')
<div class="form-horizontal">
        <div class="form-group">
            <label class="control-label col-md-2">Controller</label>
            <div class="col-md-10">
              {{$data->controller}}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Action</label>
            <div class="col-md-10">
              {{$data->action}}
            </div>
        </div>

    </div>


@stop
