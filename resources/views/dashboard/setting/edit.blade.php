@extends('layouts.admin')
@section('content')

<div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">{{trans('app.setting')}}</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    {{Form::model(null, ['route'=>["cp.setting.update"],"method"=>"PUT","enctype"=>"multipart/form-data"])}}
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
                
                    @foreach(App\Models\Setting::select('group')->distinct()->get() as $g)
                        <div class="table-responsive">
                            <table class='table borderless'>
                        @foreach($data as $setting)

                            <!-- Setting Item -->
                            @if($setting->group==$g->group)
                                @php $value=$setting->translate($key)?$setting->translate($key)->value:null; @endphp
                                <tr>
                                    <input type='hidden' name='id[]' value="<?=$setting->id?>"/>
                                    <td width="180px;"  class='xtr'> <?=$setting->name?></td>
                                    <td class='xtd'>
                                        @if($setting->type==1)
                                            <input class="form-control" type="text" name="setting[{{$setting->id}}][{{$key}}][value]" value="<?=$value?>"/>
                                        @elseif($setting->type==2)
                                            <input    type="text" class="date form-control" name="setting[{{$setting->id}}][{{$key}}][value]"  value="<?=$value?>" />
                                        @elseif($setting->type==3)
                                            <select  class="form-control"   name="setting[{{$setting->id}}][{{$key}}][value]"  >
                                                <option value="1" <?=(( $value=="1")?"selected":"")?>>Yes</option>
                                                <option value="0" <?=(( $value=="0")?"selected":"")?>>No</option>
                                            </select>
                                        @elseif($setting->type==4)
                                            @php $avs=null;
                                            if(strrpos($setting->availables,"{")===false){
                                                foreach(explode("|",$setting->availables) as $i){
                                                    $avs[]=array("key"=>$i,"value"=>$i);
                                                }
                                            }
                                            @endphp

                                        @elseif($setting->type==5)
                                            @if(strrpos($setting->availables,"{")===false)
                                                @foreach(explode("|",$setting->availables) as $i)
                                                    <?php $avs[]=array("key"=>$i,"value"=>$i);?>
                                                @endforeach
                                            @endif

                                        @elseif($setting->type==6)
                                            <input   readonly type="text" class="form-control" name="setting[{{$setting->id}}][{{$key}}][value]" value="{{date("Y-m-d H:i:s")}}" />
                                        @elseif($setting->type==7)
                                            <textarea class="form-control" name="setting[{{$setting->id}}][{{$key}}][value]" >{{$value}}</textarea>
                                        @elseif($setting->type==8)
                                            <textarea class="form-control editor" id="textarea_{{$setting->id}}" name="setting[{{$setting->id}}][{{$key}}][value]" >{{$value}}</textarea>
                                    @endif

                                </tr>
                                @endif
                                
                        @endforeach
                        </table>
                        </div>
                    @endforeach

                </div>
                
                @endforeach   
            </div>
            
        </div>
        <!-- /.card -->
    </div>
    <!-- /.card-body -->

    <div class="card-footer">
        <button type="submit" class="btn btn-success save" style="width: 100px;">{{trans('app.save')}}</button>
    </div>
    {{Form::close()}}
</div>

@stop
