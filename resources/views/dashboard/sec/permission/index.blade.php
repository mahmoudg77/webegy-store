
@extends('layouts.admin')
@section('content')
<div class="panel panel-default">
<div class="panel-body">
  <a class="btn btn-success pull-right" href="{{route('cp.secpermission.create',['curr_menu'=>$sel_menu])}}">Create New</a>
    <div class="clearfix"></div>
    <hr>
  <table class="table datatable">
    <thead>
      <tr>
        <th>Controller</th>
        <th>Action</th>
        <th>Role</th>
        
        <th></th>
      </tr>
    </thead>
    @foreach($data as $itemt)
      <tr>
          <td>{{explode('\\',$itemt->controller)[count(explode('\\',$itemt->controller))-1]}}</td>
          <td>{{$itemt->action}}</td>
          <td>{{$itemt->Group!=null?$itemt->Group->name:''}}</td>
          <td>
              {!!Func::actionLinks('secpermission',$itemt->id,"tr",["edit"=>['class'=>"edit"],"view"=>['class'=>"view"]])!!}
          </td>
      </tr>
    @endforeach

  </table>
</div>
</div>
@endsection

@section('js')

@endsection
