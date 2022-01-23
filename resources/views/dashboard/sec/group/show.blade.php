@extends('layouts.admin')
@section('content')
<div class="form-horizontal">
        <div class="form-group">
            <label class="control-label col-md-2">Name</label>
            <div class="col-md-10">
              {{$data->name}}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Key</label>
            <div class="col-md-10">
              {{$data->groupkey}}
            </div>
        </div>

    </div>


@stop
