
@extends('layouts.admin')
@section('title', trans('app.menus'))
@section('content')

<div class="card card-default">
  <div class="card-header">
    <h3 class="card-title">{{trans('app.menus')}}</h3>
    <div class="text-{{(app()->getLocale()=='ar')?'left':'right'}}">
        <a class="btn btn-primary" href="{{route('cp.menu.create',['curr_menu'=>$sel_menu])}}">{{trans('app.add new')}}</a>
    </div>
    
  </div>
  <!-- /.card-header -->
    <div class="card-body">
        <table class="table datatable" style="width: 100%;">
            <thead>
            <tr>
                <th>{{trans('app.name')}}</th>
                <th>{{trans('app.location')}}</th>
                <th></th>
            </tr>
            </thead>
            @foreach($data as $item)
            <tr>
                <td>{{$item->name}}</td>
                <td>{{$item->location}}</td>
                <td>
                    {!!Func::actionLinks('menu',$item->id,"tr",['view'=>['class'=>'view']])!!}
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    <!-- /.card-body -->

    <div class="card-footer">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
            
@endsection
