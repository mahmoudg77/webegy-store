@extends('layouts.admin')
<?php $postType = \App\Models\PostType::find(\request()->get('post_type_id'));
if (!$postType) return;
?>

@section('content')

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">{{trans("cp.{$postType->name}")}} > {{trans('app.create new')}}</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    {{Form::model(null, ['route'=>["cp.posts.store",'post_type_id'=>\request()->get('post_type_id'),'curr_menu'=>$sel_menu],"method"=>"POST","enctype"=>"multipart/form-data","class"=>"ajax--form"])}}
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
                                <label for="email_address_2">{{trans('app.title')}} <span class="required">*</span></label>
                                @if(app()->getLocale()!=$key)
                                <a href="#" class="btn btn-primary trans" data-locale="{{$key}}" data-attr="title"><i class="fa fa-globe"></i></a>
                                @endif
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                <div class="form-group ">
                                    <div class="form-line">
                                        {{Form::text($key."[title]","",['','class'=>'form-control'])}}
                                    </div>
                                    <div class="text-danger {{ $errors->has($key.'.title') ? 'has-error' : '' }}">
                                        {{ $errors->first($key.'.title') }}
                                    </div>
                                </div>
                            </div>

                        </div>
                        @if($postType->has_description>0)

                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                                <label for="email_address_2">{{trans('app.description')}} <span class="required">*</span></label>
                                @if(app()->getLocale()!=$key)
                                <a href="#" class="btn btn-primary trans" data-locale="{{$key}}" data-attr="description"><i class="fa fa-globe"></i></a>
                                @endif
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                <div class="form-group ">
                                    <div class="form-line">
                                        {{Form::textarea($key."[description]","",['','class'=>'form-control','rows' => 3, 'cols' => 40])}}
                                    </div>
                                    <div class="text-danger {{ $errors->has($key.'.description') ? 'has-error' : '' }}">
                                        {{ $errors->first($key.'.description') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($postType->has_meta_tags>0)

                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                                <label for="email_address_2">{{trans('app.meta title')}} <span class="required">*</span></label>
                                @if(app()->getLocale()!=$key)
                                <a href="#" class="btn btn-primary trans" data-locale="{{$key}}" data-attr="meta_title"><i class="fa fa-globe"></i></a>
                                @endif
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        {{Form::text($key."[meta_title]","",['','class'=>'form-control'])}}
                                    </div>
                                    <div class="text-danger {{ $errors->has($key.'.meta_title') ? 'has-error' : '' }}">
                                        {{ $errors->first($key.'.meta_title') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                                <label for="email_address_2">{{trans('app.meta description')}} <span class="required">*</span></label>
                                @if(app()->getLocale()!=$key)
                                <a href="#" class="btn btn-primary trans" data-locale="{{$key}}" data-attr="meta_description"><i class="fa fa-globe"></i></a>
                                @endif
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        {{Form::textarea($key."[meta_description]","",['','class'=>'form-control','rows' => 3, 'cols' => 40])}}
                                    </div>
                                    <div class="text-danger {{ $errors->has($key.'.meta_description') ? 'has-error' : '' }}">
                                        {{ $errors->first($key.'.meta_description') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($postType->has_body>0)

                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                                <label for="email_address_2">{{trans('app.content')}} <span class="required">*</span></label>
                                @if(app()->getLocale()!=$key)
                                <a href="#" class="btn btn-primary trans" data-locale="{{$key}}" data-attr="body"><i class="fa fa-globe"></i></a>
                                @endif
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <center>
                                            <a class="chkeditor-toogle" href="#" data-locale="{{$key}}" data-attr="body">{{trans('cp.Hide / Show Editor')}}</a>
                                        </center>
                                        {{Form::textarea($key."[body]","",['','class'=>'form-control '. ($postType->has_editor?'editor':''),'id'=>$key.'_body_editor'])}}
                                    </div>
                                    <div class="text-danger {{ $errors->has($key.'.body') ? 'has-error' : '' }}">
                                        {{ $errors->first($key.'.body') }}
                                    </div>
                                </div>
                            </div>

                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
                @if($postType->has_slug>0)

                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                        <label for="email_address_2">{{trans('app.url')}} <span class="required">*</span></label>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                            <div class="form-line">
                                {{Form::text("slug","",['','class'=>'form-control'])}}
                            </div>
                            <div class="text-danger {{ $errors->has('slug') ? 'has-error' : '' }}">
                                {{ $errors->first('slug') }}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if($postType->has_category>0)
                @if($catlist=App\Models\Category::where('parent_id',$postType->has_category)->get())
                @if(count(reset($catlist))>0)
                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                        <label for="email_address_2">{{trans('app.category')}}</label>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                            <div class="form-line" style="max-height:300px;overflow:auto;height:100%">

                                {{--{{Form::select("category_id",Func::getCategoriesList($postType->has_category),null,["",'class'=>'form-control show-tick'])}}
                                --}}
                                <ul class="list-group">


                                    @foreach($catlist as $item)
                                    <li class="list-group-item">


                                        @if($item->Chields->count()==0)
                                        <input type="radio" name="category_id" value="{{$item->id}}">
                                        @endif
                                        {{$item->title}}
                                        <ul class="list-group">
                                            @foreach($item->Chields as $i)
                                            <li class="list-group-item">


                                                <input type="radio" name="category_id" value="{{$i->id}}"> {{$i->title}}
                                                <ul class="list-group">
                                                    @foreach($i->Chields as $c)
                                                    <li class="list-group-item">
                                                        <input type="radio" name="category_id" value="{{$c->id}}"> {{$c->title}}
                                                        <ul class="list-group">
                                                            @foreach($c->Chields as $m)
                                                            <li class="list-group-item"><input type="radio" name="category_id" value="{{$m->id}}"> {{$m->title}}
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
                            <div class="text-danger {{ $errors->has('category_id') ? 'has-error' : '' }}">
                                {{ $errors->first('category_id') }}
                            </div>
                        </div>
                    </div>
                </div>
                @else
                {{Form::hidden('category_id',$postType->has_category)}}
                @endif
                @else
                {{Form::hidden('category_id',$postType->has_category)}}
                @endif
                @else
                {{Form::hidden('category_id',0)}}
                @endif
                {{Form::hidden('post_type_id',\request()->get('type'))}}

                @if($postType->has_slider_option==1)
                <div class="">
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                            <label for="email_address_2">{{trans('cp.slider option')}}</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7 input_fields_wrap">
                            <div class="form-group">
                                <select class="form-control" name="slider_option">
                                    @if($postType->has_main_image)<option value="1">{{trans('cp.one image')}}</option>@endif
                                    @if($postType->has_images)<option value="2">{{trans('cp.images slider')}}</option>@endif
                                    @if($postType->has_external_url)<option value="3">{{trans('cp.youtube video')}}</option>@endif
                                    @if($postType->has_main_file)<option value="4">{{trans('cp.upload video')}}</option>@endif
                                 </select>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if($postType->has_main_image==1)
                <div class="" id=main_image>
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                            <label for="email_address_2">{{trans('app.image')}}</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7 input_fields_wrap">
                            <div class="form-line">
                                {{Form::file("image",['accept'=>'.jpg,.png,.gif'])}}
                            </div>
                            <div class="image-size">"{{trans('app.image size')}}"</div>
                            <div class="text-danger {{ $errors->has('image') ? 'has-error' : '' }}">
                                {{ $errors->first('image') }}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if($postType->has_external_url>0)
                <div class="" id="external_url">
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                            <label for="email_add">{{trans('cp.external url')}}</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7 input_fields_wrap">
                            <div class="form-group">
                                {{Form::text("external_url",null,['class'=>'form-control','placeholder'=>'https://google.com/'])}}
                            </div>
                        </div>
                    </div>
                </div>

                @endif
                @if($postType->has_images>0)
                <div class="" id="images">
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                            <label for="email_add">{{trans('cp.images')}}</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7 input_fields_wrap">
                            <div class="form-group">
                                {{Form::file("images[]",['multiple'=>'multiple','accept'=>'.jpg,.png,.gif'])}}
                            </div>
                        </div>
                    </div>
                </div>

                @endif
                @if($postType->has_main_file==1)
                <div class="row clearfix" id="file">
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                        <label for="email_address_2">{{trans('app.attach')}}</label>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                            <div class="form-line">
                                {{Form::file("attach",['accept'=>'.pdf,.doc,.docx,.xls,.xlsx,.rar,.mp4'])}}
                            </div>
                            <div class="attach-size">"{{trans('app.attach size')}}"</div>
                            <div class="text-danger {{ $errors->has('attach') ? 'has-error' : '' }}">
                                {{ $errors->first('attach') }}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if($postType->has_tags==1)
                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                        <label for="email_address_2">{{trans('app.tags')}}</label>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                            <div class="form-line">
                                {{Form::text("tags","",['class'=>'tag-editor form-control'])}}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if($postType->can_schedule==1)
                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                        <label for="email_address_2">{{trans('cp.publish date')}}</label>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                            <div class="form-line">
                                {{Form::text("pub_date",null,array( 'class'=>'form-control date-time', 'placeholder'=>'yyyy-mm-dd H:i'))}}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if($postType->has_icon==1)
                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                        <label for="email_address_2">{{trans('app.fa icon')}}</label>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                            <div class="form-line">
                                {{Form::text("icon",null,array( 'class'=>'form-control iconPicker', 'placeholder'=>trans('app.icon class name')))}}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <hr>
                @if(count(App\Models\PostTypeProperty::getProperties($postType->id))>0)
                @foreach(App\Models\PostTypeProperty::getProperties($postType->id) as $prop)
                <div class="row clearfix">
                    @if($prop->is_single)
                    @php($v=Request::has('related') && array_key_exists($prop->name,Request::get('related'))?Request::get('related')[$prop->name]:null)
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">

                        <label class="">{{$prop->name}} :</label>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                            <div class="form-line">
                                @if($prop->related_post_type_id==null)
                                @if($prop->datasource)
                                @php(eval("\$arr=".$prop->datasource.";"))
                                {{Form::select("props[".$prop->id."]",$arr,$v,['class'=>'form-control','placeholder'=>'Select '.$prop->name.' ..'])}}
                                @else
                                {!!Form::text("props[".$prop->id."]",$v,['class'=>'form-control','placeholder'=>' '.$prop->name.' ..'])!!}
                                @endif
                                @else
                                {{Form::select("props[".$prop->id."]",$prop->relatedDatasource()->listsTranslations('title')->pluck('title','id'),$v,['class'=>'form-control','placeholder'=>'Select '.$prop->name.' ..'])}}
                                @endif
                            </div>
                        </div>
                    </div>
                    @else

                    @endif
                </div>
                @endforeach
                @endif

            </div>
            <!-- /.card -->
        </div>
    </div>
    <!-- /.card-body -->

    <div class="card-footer">
        <input name="next_action" checked="checked" value="create" type="checkbox"> {{trans('cp.Create a new post after save',['type'=>trans('cp.'.$postType->name)])}}
        <br /><br />
        <button type="submit" class="btn btn-success save" style="width: 100px;">{{trans('app.save')}}  <i></i></button>
        <a href="{{ URL::previous() }}" class="btn btn-primary">{{trans('app.back')}}</a>
    </div>
    {{Form::close()}}
</div>

@endsection
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css" integrity="sha512-bYPO5jmStZ9WI2602V2zaivdAnbAhtfzmxnEGh9RwtlI00I9s8ulGe4oBa5XxiC6tCITJH/QG70jswBhbLkxPw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
<script>
    $(function() {
        $('.date').datepicker({
            dateFormat: 'yy-mm-dd'
        });
        $('.date-time').datetimepicker({
            format: 'Y-m-d H:i',
            formatTime:'h:i A',
            formatDate:'Y-m-d'
        });

        $('.trans').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var is_editor = $("*[name='{{app()->getLocale()}}["+$(this).data("attr")+"]']").hasClass('editor');
            var t = $("*[name='{{app()->getLocale()}}["+$(this).data("attr")+"]']").val();
            if (is_editor)
                t = CKEDITOR.instances["{{app()->getLocale()}}_"+$(this).data("attr")+"_editor"].getData();
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                url: '/{{app()->getLocale()}}/translate?target='+
                btn.data("locale"),
                data: {
                    t: t
                },
                dataType: 'json',
                success: function(res) {
                    console.log(btn.data("locale"));
                    $("*[name='"+btn.data("locale")+"["+btn.data("attr")+"]']").val(res.text);
                    if (is_editor)CKEDITOR.instances[btn.data("locale")+"_"+btn.data("attr")+"_editor"].setData(res.text);
                    //alert(res.text);
                },
                error: function(a, b, c) {
                    console.log(JSON.stringify(a))
                }
            });

        })
    });
</script>
@if($postType->has_slug>0)

<script>
    $(function() {
        $("input[name='{{app()->getLocale()}}[title]']").change(function() {
            /*   if($("input[name='slug']").val()){
                    return;
                }*/
            $.ajax({
                type: "post",
                url: "{{route('cp.post-slug')}}",
                data: {
                    title: $(this).val()},
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                success: function(d) {
                    if (d.type == "success") {
                        $("input[name='slug']").val(d.data.slug);
                    }
                },
                error: function (data, status, xhr) {
                    Error(data.status + " " + xhr);
                }
            })

        });
    })
</script>
@endif
@if($postType->has_slider_option>0)

<script>
    $(function() {

        $("#images,#external_url,#file").hide();
        $("select[name='slider_option']").change(function() {
            $("#images,#external_url,#file").hide();

            if ($(this).val() == 1)$("#main_image").show();
            if ($(this).val() == 2)$("#images").show();
            if ($(this).val() == 3)$("#external_url").show();
            if ($(this).val() == 4)$("#file").show();

        });
    })
</script>
@endif
<script>
    $(document).ready(function() {
        $('.chkeditor-toogle').click(function(e) {
            e.preventDefault();
            if (CKEDITOR.instances[$(this).data("locale")+"_"+$(this).data("attr")+"_editor"])
                CKEDITOR.instances[$(this).data("locale")+"_"+$(this).data("attr")+"_editor"].destroy();
            else {
                var editor = CKEDITOR.replace($(this).data("locale")+"_"+$(this).data("attr")+"_editor");
                // Just call CKFinder.setupCKEditor and pass the CKEditor instance as the first argument.
                // The second parameter (optional), is the path for the CKFinder installation (default = "/ckfinder/").
                CKFinder.setupCKEditor(editor, '/cp/js/ckfinder/');
                //CKFinder.setupCKEditor( editor, '../' ) ;

                // It is also possible to pass an object with selected CKFinder properties as a second argument.
                CKFinder.setupCKEditor(editor, {
                    basePath: '/cp/js/ckfinder/', skin: 'v1'
                });


            }


        });
        $("button[type='submit']").click(function(e) {
            //e.preventDefault();
            $(this).addAttribute('disabled');
            $(this).find('i').addClass('fa fa-spinner fa-spin');
        });
    });
</script>
@endsection