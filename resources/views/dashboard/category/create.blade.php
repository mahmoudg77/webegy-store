@extends('layouts.admin')
@section('title', trans('app.category'))
@section('content')

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">{{trans('app.create new')}}</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    {!! Form::open(['method'=>'POST', 'route'=>["cp.category.store"],"enctype"=>"multipart/form-data","class"=>"ajax--form"]) !!}
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
                            @if(app()->getLocale()!=$key)
                                <a href="#" class="btn btn-primary trans" data-locale="{{$key}}" data-attr="title"><i class="fa fa-globe"></i></a>
                            @endif
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    {!! Form::text($key.'[title]', null, ['required', 'class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                            <label for="email_address_2">{{trans('app.description')}}</label>
                            @if(app()->getLocale()!=$key)
                                <a href="#" class="btn btn-primary trans" data-locale="{{$key}}" data-attr="description"><i class="fa fa-globe"></i></a>
                            @endif
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    {!! Form::textarea($key.'[description]', null, [ 'class'=>'form-control','rows'=>3]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                            <label for="email_address_2">{{trans('app.content')}}</label>
                            @if(app()->getLocale()!=$key)
                                <a href="#" class="btn btn-primary trans" data-locale="{{$key}}" data-attr="body"><i class="fa fa-globe"></i></a>
                            @endif
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                {!! Form::textarea($key.'[body]', null, ['required', 'class'=>'form-control editor','id'=>$key.'_editor']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach   
            </div>
            
            <!--<div class="row clearfix">-->
            <!--    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">-->
            <!--        <label for="email_address_2">{{trans('app.url')}}</label>-->
            <!--    </div>-->
            <!--    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">-->
            <!--        <div class="form-group">-->
            <!--            <div class="form-line">-->
            <!--            {{Form::text("slug","",['required','class'=>'form-control'])}}-->
            <!--            </div>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
            
            <div class="row clearfix">
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                    <label for="email_address_2">{{trans('app.category')}}</label>
                </div>
                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                    <div class="form-group">
                        <div class="form-line" style="height:600px;overflow:auto">
                      {{--  {!! Form::select('parent_id',
                        App\Models\Category::where('parent_id',0)->orWhereNull('parent_id')->listsTranslations('title')->pluck('title','id')
                        //Func::getCategoriesList
                        ,null,['class'=>'form-control','placeholder'=>trans('app.root')]) !!}                              
                        --}}
                        
                <ul class="list-group">
                    <li class="list-group-item">
                        
                    
                     <input type="radio" name="parent_id" value="0" checked> {{trans('cp.main category')}}
                    
                </li>
                
                    @foreach(App\Models\Category::whereNull('parent_id')->get() as $item)
{{--@if(is_array($item))--}}
                    <li class="list-group-item">
                        
                    
                     <input type="radio" name="parent_id" value="{{$item->id}}"> {{$item->title}}
                      <ul class="list-group">
                      @foreach($item->Chields as $i)
                         {{--@if(is_array($i))--}}
                         <li class="list-group-item">
                             
                         
                         <input type="radio" name="parent_id" value="{{$i->id}}"> {{$i->title}}
                            <ul class="list-group">
                            @foreach($i->Chields as $c)
                             {{--@if(is_array($c))--}}
                             <li class="list-group-item">
                             <input type="radio" name="parent_id" value="{{$c->id}}"> {{$c->title}}
                              <ul class="list-group">
                               @foreach($c->Chields as $m)
                            <li class="list-group-item"><input type="radio" name="parent_id" value="{{$m->id}}"> {{$m->title}}
                               </li>
                               @endforeach
                               </ul>
                           </li>
                            @endforeach
                            </ul>
                         </li>
                      @endforeach
                      </ul>
                      </li>
                    @endforeach
                    </ul>
                </div>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                    <label for="email_address_2">{{trans('app.image')}}</label>
                </div>
                <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                    <div class="form-group">
                        <div class="form-line">
                        {{Form::file("image",['accept'=>'.jpg,.png,.gif'])}}
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.card -->
    </div>
    <!-- /.card-body -->

    <div class="card-footer">
        <button type="submit" class="btn btn-success save" style="width: 100px;">{{trans('app.save')}}</button>
        <a href="{{ URL::previous() }}" class="btn btn-primary">{{trans('app.back')}}</a>
    </div>
    {{Form::close()}}
</div>

@endsection

@section('js')
    <script>
        $(function(){
            $('.trans').click(function(e){
                e.preventDefault();
                var btn=$(this);
                var is_editor=$("*[name='{{app()->getLocale()}}["+$(this).data("attr")+"]']").hasClass('editor');
                var t=$("*[name='{{app()->getLocale()}}["+$(this).data("attr")+"]']").val();
                if(is_editor)
                    t=CKEDITOR.instances["{{app()->getLocale()}}_"+$(this).data("attr")+"_editor"].getData();
                $.ajax({
                    type:'POST',
                    headers:{'X-CSRF-TOKEN':'{{csrf_token()}}'},
                    url:'/{{app()->getLocale()}}/translate?target='+
btn.data("locale")
                    ,
                    data:{t:t},
                    dataType:'json',
                    success:function(res){
                        console.log(btn.data("locale"));
$("*[name='"+btn.data("locale")+"["+btn.data("attr")+"]']").val(res.text);
if(is_editor)CKEDITOR.instances[btn.data("locale")+"_"+btn.data("attr")+"_editor"].setData(res.text);
                        //alert(res.text);
                    },
                    error:function(a,b,c){
                        console.log(JSON.stringify(a))
                    }
                });
                
            })
        });
    </script>
@endsection