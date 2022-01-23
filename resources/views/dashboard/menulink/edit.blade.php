@extends('layouts.admin')
@section('title',$data->title)
@section('content')

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">{{trans('app.edit')}} :: {{ $data->title }}</h3>
    </div>
  
    {!! Form::open(['method'=>'PATCH', 'route'=>["cp.menu-link.update",$data->id]]) !!}
    <!-- /.card-header -->
    <div class="card-body">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                    @foreach(config('translatable.locales') as $key)
                        <li class="nav-item">
                            <a class="nav-link {{($key==app()->getLocale())?'active':''}}" id="custom-tabs-four-{{$key}}-tab" data-toggle="pill" 
                                href="#custom-tabs-four-{{$key}}" role="tab" aria-controls="custom-tabs-four-{{$key}}" 
                                aria-selected="true">{{config('languages')[$key]}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">
                    @foreach(config('translatable.locales') as $key)
                    <div class="tab-pane fade {{($key==app()->getLocale())?'active':''}} show" id="custom-tabs-four-{{$key}}" 
                        role="tabpanel" aria-labelledby="custom-tabs-four-{{$key}}-tab">
                    
                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                                <label for="email_address_2">{{trans('app.title')}}</label>
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                    {!! Form::text($key.'[title]', ($data->translate($key)!=null?$data->translate($key)->title:null), ['required', 'class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
    
                    </div>
                    @endforeach   
                </div>
                
                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-12 form-control-label" style="text-align: left;">
                        <label for=""></label>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                    <div class="form-group">
                         <input type="checkbox" value="1" id="display_title" name="display_title" {{($data->display_title?'checked':'')}} class="chk-col-teal">
                        <label for="display_title">Display Title</label>
                
                        <input type="checkbox"  value="1" id="display_icon"  name="display_icon" {{($data->display_icon?'checked':'')}} class="chk-col-teal">
                        <label for="display_icon">Display Icon</label>
                    </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                        <label for="email_address_2">{{trans('app.fa icon')}}</label>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                            <div class="form-line">
                            {{Form::text("icon",$data->icon,array( 'class'=>'form-control iconPicker', 'placeholder'=>trans('app.icon class name')))}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                        {!! Form::label(trans('app.type')) !!}
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                            <div class="form-line">
                            {!! Form::select('type', ['Custom Link','Category'],($data->category_id>0?1:0), array('required', 'class'=>'form-control')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row clearfix customlink">
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                    {!! Form::label(trans('app.link')) !!}
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                            <div class="form-line">
                            {!! Form::text('customlink', $data->customlink, array( 'class'=>'form-control')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row clearfix category_id">
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                    {!! Form::label(trans('app.category')) !!}           
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                            <div class="form-line">
                            {{Form::select("category_id",App\Models\Category::listsTranslations('title')->pluck('title','id'),$data->category_id,['class'=>'form-control', 'placeholder'=>trans('app.root')])}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row clearfix hasSubs">
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                        {!! Form::label(trans('app.include childes')) !!}
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                            <div class="form-line">
                            {!! Form::select('hasSubs', ['0'=>'No','1'=>'Yes'],$data->hasSubs, array('class'=>'form-control', 'placeholder'=>trans('app.root'))) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            {{Form::hidden('menu_id',$data->menu_id)}}
            <button type="submit" class="btn btn-success save" style="width: 100px;">
                {{trans('app.save')}}</button>
            <a href="{{ URL::previous() }}" class="btn btn-primary">{{trans('app.back')}}</a>
        </div>
    {!! Form::close() !!}
   </div> 
</div>

@section('js')
<script>
$(function(){
    $("select[name='type']").change(function(){
        console.log($(this));
        if($(this).val()==0){
            $("input[name='customlink']").closest(".customlink").show();
            $("select[name='category_id']").closest(".category_id").hide();
            $("select[name='hasSubs']").closest(".hasSubs").hide();
        }else{
            $("input[name='customlink']").closest(".customlink").hide();
            $("select[name='category_id']").closest(".category_id").show();
            $("select[name='hasSubs']").closest(".hasSubs").show();

        }
    }) ;
    $("select[name='type']").change();
});
</script>
@endsection
@stop
