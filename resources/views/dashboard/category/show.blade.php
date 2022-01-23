@extends('layouts.admin')
@section('content')

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">{{trans('app.show')}} : <small>{{$data->title}}</small></h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table class="table table-sm" style="width:100%">
            <tbody>
                <tr>
                    <th>{{trans('app.title')}}</th>
                    <td>{{$data->title}}</td>
                </tr>
                @if(!is_null($data->Parent))
                <tr>
                    <th>{{trans('app.parent')}}</th>
                    <td>{{$data->Parent->title}}</td>
                </tr>
                @endif
                @if(!is_null($data->Chields))
                <tr>
                    <th>{{trans('app.chields')}}</th>
                    <td>
                        <ul>
                            @foreach($data->Chields as $cat)
                                <li>{{$cat->title}}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>


@stop
