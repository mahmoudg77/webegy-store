@extends('layouts.admin')
@section('content')
{{Form::model($data, ['route'=>["cp.secpermission.update",$data->id],"method"=>"PUT"])}}
<div class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-md-2">Group</label>
                <div class="col-md-10">
                  {{Form::select('sec_group_id',App\Models\SecGroup::pluck('name','id'),$data->sec_group_id,['class'=>'form-control'])}}
                </div>
            </div>
              <div class="form-group">
                <label class="control-label col-md-2">Controller</label>
                <div class="col-md-10">
                  <select id="controller" class="form-control" name="controller">
                    @foreach (Func::controllers() as $key=>$value)
                      <option value="{{$key}}" {{($key==$data->controller)?"selected":""}}>{{$value}}</option>
                    @endforeach
                  </select>
                </div>
            </div>

        <div class="form-group">
            <label class="control-label col-md-2">Action</label>
            <div class="col-md-10">
              <select id="action" class="form-control" name="action">

              </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Force Filter</label>
            <div class="col-md-10">
              {{Form::text('force_filter')}}
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <button type="submit" class="btn btn-success create"><i class="fa fa-save"></i> Create</button>
            </div>
        </div>
    </div>
{{Form::close()}}

<script type="text/javascript">
  $(function(){
    $("#controller").change(function(){
      var $this=$(this);
      $("#action").html("<option>Loading....</option>");
      $.ajax({
        type:"post",
        headers:{'X-CSRF-TOKEN':'{{csrf_token()}}'},
        url:"{{route('cp.secpermission-getactions')}}",
        dataType:'json',
        data:{'ctrl':$this.val()},
        success:function(d){
          $("#action").html("");
          console.log(d);
          if(d.success){
            d.data.forEach(function(item){
              $("#action").append('<option value="'+ item.key +'" ' + (item.key=='{{$data->action}}'?'selected':'') + '>' + item.value + '</option>');
            });
          }else{
            Error(d.message);
          }

        },
        error: function (data, status, xhr) {
            Error( data.status + " " + xhr);
        }
      });
    });

      $("#action").change(function(){
          var $this=$(this);
          $("#action").html("<option>Loading....</option>");
          $.ajax({
              type:"post",
              headers:{'X-CSRF-TOKEN':'{{csrf_token()}}'},
              url:"{{route('cp.secpermission-getfilter')}}",
              dataType:'json',
              data:{'ctrl':$this.val()},
              success:function(d){
                  $("#action").html("");
                  console.log(d);
                  if(d.success){
                      d.data.forEach(function(item){
                          $("#action").append('<option value="'+ item.key +'" ' + (item.key=='{{$data->action}}'?'selected':'') + '>' + item.value + '</option>');
                      });
                  }else{
                      Error(d.message);
                  }

              },
              error: function (data, status, xhr) {
                  Error( data.status + " " + xhr);
              }
          });
      });
    $("#controller").change();
    $("#action").change();
  });
</script>
@stop
