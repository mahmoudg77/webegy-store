
@extends('layouts.admin')
@section('content')

<div class="card card-default">
  <div class="card-header">
    <h3 class="card-title">{{trans('app.menus')}}</h3>
    <div class="text-{{(app()->getLocale()=='ar')?'left':'right'}}">
        <a class="btn btn-primary" href="{{route('cp.menu-link.create',['m'=>$m,'curr_menu'=>$sel_menu])}}">{{trans('app.add new')}}</a>
    </div>
    
  </div>
  <!-- /.card-header -->
    <div class="card-body">
        <div class="list-group" >
            @foreach($data as $item)
              @if(count($item->Links)>0)
                <a href="#{{$item->id}}" class="list-group-item" data-toggle="collapse">
                  <i class="glyphicon glyphicon-chevron-right"></i>
                  {!!  $item->title!!} ({!! ($item->category_id>0)?"<span style='color:red'>Category</span>":"<span style='color:blue'>Custom</span>"!!})
                </a>
              @else
                <div class="list-group-item">
                  {!! $item->title!!} ({!! ($item->category_id>0)?"<span style='color:red'>Category</span>":"<span style='color:blue'>Custom</span>"!!})
                  <div class="col col-sm-6 float-right">
                    {!!Func::actionLinks('menu-link',$item->id,".list-group-item",["edit"=>['class'=>"edit"],"delete"=>['class'=>""],"view"=>['class'=>"view"]])!!}
                  </div>
                    <div class="clearfix"></div>
                </div>
              @endif
              @if(count($item->Links)>0)
                <div class="list-group collapse" id="{{$item->id}}">
                  @foreach($item->Links as $link)
                  <div  class="list-group-item">{!! $link->title!!} ({!! ($link->category_id>0)?"<span style='color:red'>Category</span>":"<span style='color:blue'>Custom</span>"!!})
                      <div class="col col-sm-6 float-right">
                        {!!Func::actionLinks('menu-link',$link->id,".list-group-item",["edit"=>['class'=>"edit"],"delete"=>['class'=>""],"view"=>['class'=>"view"]])!!}
                    </div>
                      <div class="clearfix"></div>
                  </div>
                  @endforeach
                </div>
              @endif
            @endforeach
        </div>
    </div>
    <!-- /.card-body -->
</div>


@endsection

