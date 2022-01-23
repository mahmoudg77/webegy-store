@extends('layouts.admin')
@section('content')
<?php $postType = $data->PostType;
if (!$postType) return;
//dd($data);
?>
<div class="card card-default">
    <div class="card-header">
        {{trans('app.edit')}} {{trans("cp.".App\Models\PostType::find($data->post_type_id)->name)}}: <small>{{$data->title}}</small>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    {{Form::model($data, ['route'=>["cp.posts.update",$data->id,'curr_menu'=>$sel_menu],"method"=>"PUT","enctype"=>"multipart/form-data"])}}
    <div class="card-body">
        <div class="col-12">
            @foreach(\App\Models\PostTypeProperty::where('related_post_type_id',$data->post_type_id)->get() as $prop)
            @php($count=App\Models\PostProperty::where('related_post_id',$data->id)->where('property_id',$prop->id)->count())
            <a class="btn btn-default" style="width:unset !important;" href="{{route('cp.posts.index',['post_type_id'=>$prop->post_type_id,'related'=>[$prop->name=>$data->id]])}}" target="_blank">{{trans("cp.{$prop->PostType->name}")}} <span class="badge badge-success"> {{$count}}</span></a>
            @endforeach
        </div>
        <hr />
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
                                <div class="form-group">
                                    <div class="form-line">
                                        {{Form::text($key."[title]",($data->translate($key)!=null?$data->translate($key)->title:null),['required','class'=>'form-control'])}}
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
                                <div class="form-group">
                                    <div class="form-line">
                                        {{Form::textarea($key."[description]",($data->translate($key)!=null?$data->translate($key)->description:null),['required','class'=>'form-control','rows' => 3, 'cols' => 40])}}
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
                                        {{Form::text($key."[meta_title]",($data->translate($key)!=null?$data->translate($key)->meta_title:null),['required','class'=>'form-control'])}}
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
                                        {{Form::textarea($key."[meta_description]",($data->translate($key)!=null?$data->translate($key)->meta_description:null),['required','class'=>'form-control','rows' => 3, 'cols' => 40])}}
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
                                <a href="#" class="btn btn-primary trans" data-locale="{{$key}}" data-attr="title"><i class="fa fa-globe"></i></a>
                                @endif
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                <div class="form-group">
                                    <div class="form-line">
                                        <center>
                                            <a class="chkeditor-toogle" href="#" data-locale="{{$key}}" data-attr="body">{{trans('cp.Hide / Show Editor')}}</a>
                                        </center>
                                        {{Form::textarea($key."[body]",($data->translate($key)!=null?$data->translate($key)->body:null),['required','class'=>'form-control '.($postType->has_editor?'editor':''),'id'=>$key.'_body_editor'])}}
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
                                {{Form::text("slug",$data->slug,['required','class'=>'form-control',])}}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if($postType->has_category>0)
                @if($catlist=App\Models\Category::where('parent_id',$postType->has_category)->get())
                @if(count(reset($catlist))>1)
                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                        <label for="email_address_2">{{trans('app.category')}}</label>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group" style="max-height:300px;overflow:auto;height:100%">
                            <div class="form-line">
                                {{--
                                {{Form::select("category_id",Func::getCategoriesList($postType->has_category),$data->category_id,["required",'class'=>'form-control show-tick'])}}
                                --}}

                                <ul class="list-group">

                                    @foreach($catlist as $item)
                                    <li class="list-group-item">


                                        <input type="radio" name="category_id" value="{{$item->id}}" {{$item->id==$data->category_id?'checked':''}}> {{$item->title}}
                                        <ul class="list-group">
                                            @foreach($item->Chields as $i)
                                            <li class="list-group-item">


                                                <input type="radio" name="category_id" value="{{$i->id}}" {{$i->id==$data->category_id?'checked':''}}> {{$i->title}}
                                                <ul class="list-group">
                                                    @foreach($i->Chields as $c)
                                                    <li class="list-group-item">
                                                        <input type="radio" name="category_id" value="{{$c->id}}" {{$c->id==$data->category_id?'checked':''}}> {{$c->title}}
                                                        <ul class="list-group">
                                                            @foreach($c->Chields as $m)
                                                            <li class="list-group-item"><input type="radio" name="category_id" value="{{$m->id}}" {{$m->id==$data->category_id?'checked':''}}> {{$m->title}}
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
                @else
                {{Form::hidden('category_id',$data->category_id)}}
                @endif
                @else
                {{Form::hidden('category_id',$data->category_id)}}
                @endif
                @else
                {{Form::hidden('category_id',$data->category_id)}}
                @endif

                {{Form::hidden('post_type_id',$data->post_type_id)}}
                @if($postType->has_slider_option==1)
                <div class="">
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                            <label for="email_address_2">{{trans('cp.slider option')}}</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7 input_fields_wrap">
                            <div class="form-group">
                                <select class="form-control" name="slider_option">
                                    @if($postType->has_main_image)<option value="1" {{($data->slider_option==1?'selected':'')}}>{{trans('cp.one image')}}</option>@endif
                                    @if($postType->has_images)<option value="2" {{($data->slider_option==2?'selected':'')}}>{{trans('cp.images slider')}}</option>@endif
                                    @if($postType->has_external_url)<option value="3" {{($data->slider_option==3?'selected':'')}}>{{trans('cp.youtube video')}}</option>@endif
                                    @if($postType->has_main_file)<option value="4" {{($data->slider_option==4?'selected':'')}}>{{trans('cp.upload video')}}</option>@endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                @endif


                @if($postType->has_main_image==1)
                <div class="row clearfix" id="main_image">
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                        <label for="email_address_2">{{trans('app.image')}}</label>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                            <div class="form-line">
                                {{Form::file("image",['accept'=>'.jpg,.png,.gif'])}}
                            </div>
                            <div class="image-size">"{{trans('app.image size')}}"</div>
                            <div class="text-danger {{ $errors->has('image') ? 'has-error' : '' }}">
                                {{ $errors->first('image') }}
                            </div>
                        </div>
                        <div class="form-group">
                            <img src="{{$data->mainImage('200x115','crope')}}" class="img-responsive" />
                        </div>
                    </div>
                </div>
                @endif @if($postType->has_external_url>0)
                <div class="" id="external_url">
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                            <label for="email_add">{{trans('app.external url')}}</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7 input_fields_wrap">
                            <div class="form-group">
                                {{Form::text("external_url",$data->external_url,['class'=>'form-control','placeholder'=>'https://google.com/'])}}
                            </div>
                        </div>
                    </div>
                </div>

                @endif
                @if($postType->has_images>0)
                <div class="row clearfix" id="images">
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                        <label for="email_address_2">{{trans('cp.images')}}</label>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                            <div class="form-line">
                                {{Form::file("images[]",['multiple'=>'multiple','accept'=>'.jpg,.png,.gif'])}}
                            </div>
                        </div>
                        <div class="row form-group">
                            @if($images=$data->images('200x115','crope','images'))
                            @foreach($images as $img)
                            <div class="col-3 img-item text-center">
                                <a style="position:absolute;margin-right:5px;margin-left:5px;margin-top:5px"
                                    data-tag="images" data-img="{{explode('/',$img)[count(explode('/',$img))-1]}}" data-id="{{$data->id}}" class="btn btn-default text-danger delete" href="#"><i class="fa fa-trash"></i></a>
                                <img src="{{$img}}" class="img-responsive" />
                            </div>
                            @endforeach
                            @endif
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
                                {{Form::file("attach",['accept'=>'.pdf,.doc,.docx,.xls,.xlsx,.mp4'])}}
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
                                {{Form::text("tags",$data->strTags(),['class'=>'tag-editor form-control'])}}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if($postType->can_schedule==1)
                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                        <label for="email_address_2">{{trans('cp.publish date')}} </label>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                            <div class="form-line">
                                {{Form::text("pub_date",date('Y-m-d H:i',strtotime($data->pub_date)),array('class'=>'form-control date-time', 'placeholder'=>trans('app.publish date'),'id'=>'datepicker'))}}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if($postType->has_icon==1)
                <div class="row clearfix">
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">
                        <label for="email_address_2">{{trans('app.fa icon')}}
                            <!--(<a href="#" data-target="#flatIconModal" data-toggle="modal">Flat Icons</a> )-->
                        </label>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                            <div class="form-line">
                                {{Form::text("icon",null,array( 'class'=>'form-control iconPicker', 'placeholder'=>'Icon class name ....'))}}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <hr>
                @if($data->Properties)
                @foreach($data->properties as $prop)
                <div class="row clearfix">

                    @if($prop->is_single)
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label" style="text-align: left;">

                        <label class="">{{$prop->name}}</label>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                        <div class="form-group">
                            <div class="form-line">
                                @if($prop->related_post_type_id==null)
                                @if($prop->datasource)
                                @php(eval("\$arr=".$prop->datasource.";"))
                                {{Form::select("props[".$prop->id."]",$arr,$data->RelatedPost($prop->name),['class'=>'form-control','placeholder'=>'Select '.$prop->name.' ..'])}}

                                @else
                                {{Form::text("props[".$prop->id."]",$data->RelatedPost($prop->name),['class'=>'form-control'])}}
                                @endif
                                @else
                                {{Form::select("props[".$prop->id."]",$prop->relatedDatasource()->listsTranslations('title')->pluck('title','id'),($prop->data($data->id))?$prop->data($data->id)->related_post_id:null,['class'=>'form-control'])}}
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
        <button type="submit" class="btn btn-success save" style="width:unset !important;">{{trans('app.save')}} <i></i></button>
        <a href="{{ URL::previous() }}" class="btn btn-primary" style="width:unset !important;">{{trans('app.back')}}</a>
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

        });
        $(".img-item a.delete").click(function(e) {
            e.preventDefault();
            var btn = $(this);
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                url: '/{{app()->getLocale()}}/dashboard/post-image-delete',
                data: {
                    img: $(this).data('img'),
                    model_id: {{
                        $data->id
                    }},
                    tag: 'images',
                    model: 'App\\Models\\Post'
                },
                dataType: 'json',
                success: function(res) {

                    btn.closest('.img-item').hide();
                },
                error: function(a, b, c) {}
            });
        })
    });
</script>
@if($data->PostType->has_slider_option>0)

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
        $("select[name='slider_option']").change();

    })
</script>
@endif
<script>
    //     $(function(){
    //         $("input[name='{{app()->getLocale()}}[title]']").change(function(){
    //             if($("input[name='slug']").val()){
    //                 return;
    //             }
    //           $.ajax({
    //               type:"post",
    //               url:"{{route('cp.post-slug')}}",
    //               data:{title:$(this).val()},
    //               dataType:"json",
    //               headers:{'X-CSRF-TOKEN':'{{csrf_token()}}'},
    //               success:function(d){
    //                   if(d.type=="success"){
    //                       $("input[name='slug']").val(d.data.slug);
    //                   }
    //               },
    //               error: function (data, status, xhr) {
    //                   Error( data.status + " " + xhr);
    //               }
    //           })

    //         });
    //     });
</script>
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
            $(this).find('i').addClass('fa fa-spinner fa-spin');

            /// return true;
            //var validator = $("form").validate()
            //console.log(validator.errorList)
            //$(this).closest('form').submit();
        });
    });
</script>
@stop()