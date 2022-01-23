@extends('layouts.admin')
@section('content')
{{Form::model(null, ['route'=>["cp.secpermission.store"],"method"=>"POST",'class'=>'ajax--form'])}}
<div class="panel panel-default">
    <div class="panel-body">
        <div class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-md-2">Group</label>
                <div class="col-md-10">
                  {{Form::select('groupid',App\Models\SecGroup::pluck('name','id'),null,['class'=>'form-control'])}}
                </div>
            </div>
              <div class="form-group">
                <label class="control-label col-md-2">Controller</label>
                <div class="col-md-10">
                  <select id="ctrl"  class="form-control" name="ctrl">
                    @foreach (Func::controllers() as $key=>$value)
                      <option value="{{$key}}">{{$value}}</option>
                    @endforeach
                  </select>
                </div>
            </div>

        <div class="form-group">
            <label class="control-label col-md-2"></label>
            <div class="col-md-10">
             <table class="table" id="actions">
                 <thead>
                    <tr>
                      <th>Allow</th>
                      <th>Action</th>
                      <th>Force Filter</th>
                    </tr>
                 </thead>
                 <tbody></tbody>
             </table>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <button type="submit" class="btn btn-success create"><i class="fa fa-save"></i> Create</button>
            </div>
        </div>
    </div>
    </div>
</div>

<!-- <input type="checkbox" id="md_checkbox_36" class="filled-in chk-col-deep-orange" checked />
  <label for="md_checkbox_36">DEEP ORANGE</label> -->

{{Form::close()}}
@endsection
@section("js")
<script type="text/javascript">
  $(function(){
    $("#ctrl,select[name='groupid']").change(function(){
        $("#actions tbody").html("Loading ...");
      $.ajax({
        type:"post",
        headers:{'X-CSRF-TOKEN':'{{csrf_token()}}'},
        url:"{{route('cp.secpermission-getactions')}}",
        dataType:'json',
        data:{'ctrl':$("#ctrl").val(),'group':$("select[name='groupid']").val()},
        success:function(d){
          $("#action").html("");
          console.log(d);
          if(d.success){
              $("#actions tbody").html("");
              var n=0;
            d.data.forEach(function(item){
                var tr=$("<tr><input type='hidden' name='"+n+"[controller]' value='" + item.controller + "'/><input type='hidden' name='"+n+"[sec_group_id]' value='" + item.sec_group_id + "'/></tr>");
                tr.append("<td><input style='opacity:1;left:40px;' class='filled-in chk-col-deep-orange' type='checkbox' name='"+n+"[action]' value='" + item.action + "' " + (item.id>0?"checked":"") + " /></td>");
                tr.append("<td>"+item.action+"</td>");
                tr.append("<td><input type='text' value='" + item.force_filter + "' class='form-control' placeholder='e.g. [[\"column\",\"=\",\"value\"],...]' name='"+n+"[force_filter]'/></td>");

                $("#actions tbody").append(tr);
                n++;
            });
          }else{
              $("#actions tbody").html("");
            Error(d.message);
          }

        },
        error: function (data, status, xhr) {
            $("#actions tbody").html("");
            Error( data.status + " " + xhr);
        }
      });
    });


      $("#ctrl").change();

  });
</script>
@stop
