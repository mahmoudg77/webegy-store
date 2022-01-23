@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{trans('app.category')}}</h3>
        <div class="text-{{(app()->getLocale()=='ar')?'left':'right'}}">
            <a href="{{route('cp.category.create',['curr_menu'=>$sel_menu])}}">{{trans('app.add new')}}</a>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <!-- we are adding the accordion ID so Bootstrap's collapse plugin detects it -->
        <div id="accordion">
            @foreach($data as $item)
            @if(count($item->Chields)>0)
            <div class="card card-primary">
                <div class="card-header">
                    <h4 class="card-title w-100">
                        <table style="width:100%">
                            <tbody>
                                <tr>
                                    <td style="padding: 0 10px;"><a class="d-block w-100" data-toggle="collapse"
                                        href="#collapse{{$item->id}}">{{$item->title}}</a></td>
                                    <td class="text-{{(app()->getLocale()=='ar')?'left':'right'}}">
                                        <div class="btn-group">
                                            <a href="{{route('cp.category.edit', $item->id)}}" class="btn btn-link btn-sm">{{trans('app.edit')}}</a>
                                            {!! Form::open(['route'=>["cp.category.destroy",$item->id],"method"=>"DELETE"]) !!}
                                            {!! Form::submit(trans('app.delete'),["class"=>"btn btn-link btn-sm",'style'=>'color:#fff']) !!}
                                            {!! Form::close() !!}
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </h4>
                </div>
                <div id="collapse{{$item->id}}" class="collapse " data-parent="#accordion">
                    <div class="card-body">
                        <table style="width:100%">
                            <tbody>
                                @foreach($item->Chields as $subitem)
                                <tr style="border: solid 1px #eee;">
                                    <td style="padding: 0 10px;">{{$subitem->title}} </td>
                                    <td style="padding: 5px;text-align: {{(app()->getLocale()=='ar')?'left':'right'}};">
                                        {!!Func::actionLinks('category',$subitem->id,".list-group-item",['edit'=>['class'=>''],'view'=>['class'=>'view']])!!}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-{{app()->getLocale()=='ar'?'right':'left'}}:10px">
                                        <table style="width:100%">
                                            @foreach($subitem->Chields as $i)
                                            <tr style="border: solid 1px #eee;">
                                                <td style="padding: 0 10px;">{{$i->title}} </td>
                                                <td style="padding: 5px;text-align: {{(app()->getLocale()=='ar')?'left':'right'}};">
                                                    {!!Func::actionLinks('category',$i->id,".list-group-item",['edit'=>['class'=>''],'view'=>['class'=>'view']])!!}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @else
            <div class="card">
                <div class="card-body">
                    <table style="width:100%">
                        <tbody>
                            <tr style="border: solid 1px #eee;">
                                <td style="padding: 0 10px;">{{$item->title}} </td>
                                <td style="padding: 5px;text-align: {{(app()->getLocale()=='ar')?'left':'right'}};">
                                    <div class="btn-group">
                                        <a href="{{route('cp.category.edit', $item->id)}}" class="btn btn-success btn-sm" style="margin:0 5px">{{trans('app.edit')}}</a>
                                        {!! Form::open(['route'=>["cp.category.destroy",$item->id],"method"=>"DELETE"]) !!}
                                        {!! Form::submit(trans('app.delete'),["class"=>"btn btn-danger btn-sm btn-dele2te"]) !!}
                                        {!! Form::close() !!}
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            @endif
            @endforeach
        </div>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->

@endsection