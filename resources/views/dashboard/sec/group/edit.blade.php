@extends('layouts.admin')
@section('content')
{{Form::model($data, ['route'=>["cp.secgroup.update",$data->id],"method"=>"PUT"])}}
<?php //`title`, `body`, `pub_date`,`post_type_id`, `category_id`, `is_published`, `created_by`, `updated_by`, `created_at`, `updated_at` ?>
<div class="form-horizontal">

        <div class="form-group">
            <label class="control-label col-md-2">Name</label>
            <div class="col-md-10">
              {{Form::text('name',$data->name,['class'=>'form-control'])}}
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-2">Key</label>
            <div class="col-md-10">
              {{Form::text('groupkey',$data->groupkey,['class'=>'form-control'])}}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <button type="submit" class="btn btn-success save"><i class="fa fa-save"></i> Save</button>
            </div>
        </div>
    </div>
{{Form::close()}}
@stop
