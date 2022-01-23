@extends('layouts.app')
@section('title')  {{$title}} @endsection
@section('content')

<div class="panel panel-default">
  <div class="panel-body">{!! $body !!}</div>
  
  <!--<div class="col-xs-12">-->
  <!--    <a href="{{ URL::previous() }}" class="btn btn-primary">{{trans('app.back')}}</a>-->
  <!--</div>-->
</div>

@stop

