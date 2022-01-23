@extends('layouts.admin')
@section('content')

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
        <div class="header">
            <h2>{{$data->name}}</h2>
        </div>
        <div class="body table-responsive">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th>{{trans('app.location')}}</th>
                        <td>{{$data->location}}</td>
                    </tr>
                    <tr>
                        <th>{{trans('app.links')}}</th>
                        <td>    
                            <ul class="list-group">
                                @foreach($data->Links as $link)
                                    <li class="list-group-item">{{$link->name}}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-right">
                            <div class="btn-group">
                                <a href="{{route('cp.menu-link.edit', $data->id)}}" class="btn btn-success btn-lg">{{trans('app.edit')}}</a>
                                <a href="{{ URL::previous() }}" class="btn btn-primary btn-lg">{{trans('app.back')}}</a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@stop
