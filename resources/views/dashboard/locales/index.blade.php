@extends('layouts.admin')
@section('content')
<section class="user-dashboard">
    
<div class="card card-default">
  <div class="card-header">
    <h2 class="pull-left">{{trans('cp.Translations')}} </h2>
    
  </div>
  <!-- /.card-header -->
    <div class="card-body">
        <form action="" id="frmFilter" method="get">
            <table class="table">
                <tr>
                    <td>{{trans('app.language')}}</td>
                    <td>
                        <select name="l" class="form-control locales-select">
                            @foreach(config('translatable.locales') as $l)
                                <option value="{{$l}}" {{$l==$lang?"selected":""}}>{{config("languages")[$l]}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>{{trans('app.group')}}</td>
                    <td>
                        <select name="g" class="form-control locales-select">
                             @foreach($files as $file)
                                <option value="{{$file}}" {{$file==$g?"selected":""}}>{{$file}}</option>
                             @endforeach
                        </select>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <!-- /.card-body -->
    
    <div class="card-body">
    <form method="POST" action="" >
        {{csrf_field()}}
        <table class="table datatable-ajax" style="width: 100%;">
            <tbody>
                @if($data)
                @foreach($data as $key=>$value)
                <tr>
                    <td>{{$key}}</td>
                    <td> 
                        @if(is_array($value))
                            <table>
                                @foreach($value as $k=>$v)
                                <tr>
                                    <td>{!!$k!!}</td>
                                    <td>
                                        @if(is_array($v))
                                            <table>
                                                @foreach($v as $k1=>$v1)
                                                    <tr>
                                                        <td>{!!$k1!!}</td>
                                                        <td><textarea class="form-control" name="vals[{{$key}}][{{$k}}][{{$k1}}]">{!!$v1!!}</textarea></td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        @else
                                            <textarea class="form-control" name="vals[{{$key}}][{{$k}}]">{!!$v!!}</textarea>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        @else
                        <textarea class="form-control" name="vals[{{$key}}]">{!!$value!!}</textarea>
                        @endif
                    </td>
                    <td></td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
        <div class="col-12 col-xs-12">
            <button type="submit" class="btn btn-primary">{{trans('app.save')}}</button>
        </div>
    </form>
    </div>
    <!--<div class="card-footer">-->
    <!--  <button type="submit" class="btn btn-primary">{{trans('app.save')}}</button>-->
    <!--</div>-->

</div>


</section>

@endsection

@section('js')
<script>
$(function(){
    $("#frmFilter select").change(function(){
        $("#frmFilter").submit();
    });
});
</script>
@endsection
