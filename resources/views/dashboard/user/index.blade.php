
@extends('layouts.admin')
@section('content')
<section class="user-dashboard">
 
<div class="card card-default">
   <div class="card-header">
        <a class="btn btn-primary btn-sm"
            href="{{route('cp.user.create')}}">{{trans('app.create New')}}</a>

    <h3 class="card-title">{{trans('app.users')}}</h3>
  </div>
  <!-- /.card-header -->
    <div class="card-body">
        <div class="table-responsive">
            <table class="table datatable-ajax" style="width: 100%;">
                <thead>
                <tr>
                    <th>{{trans('app.name')}}</th>
                    <th>{{trans('app.type_user')}}</th>
                    <th>{{trans('app.email')}}</th>
                    <th>{{trans('app.register date')}}</th>
                    <th>{{trans('app.verifed')}}</th>
                    <th></th>
                    <!--<th></th>-->
                </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- /.card-body -->
</div>

</section>

@endsection

@section('js')
<script>
$(function(){
    $('body').on("click",".resendVerify",function(e){
        e.preventDefault();
        var $this=$(this);
        $this.html("<i class='fa fa-spinner fa-spin'></i>");
        var $id=$this.data("rowid");
          $.ajax({
            headers:{'X-CSRF-TOKEN':'{{csrf_token()}}'},
            url:'{{ route('cp.resendVerify')}}',
            data:{id:$id},
            dataType:"json",
            type:"POST",
            
            success:function(resp){
                if(resp.type=="success"){
                    Success(resp.message);
                     $this.html("Sent Success");
                     $this.removeClass("resendVerify");
                }else{
                    Error(resp.message);
                    $this.html("Error !");

                }
            },
            error:function(a){
                    Error(a.responseText);
                    $this.html("Error");

            }
        });
    })
    $(".datatable-ajax").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            headers:{'X-CSRF-TOKEN':'{{csrf_token()}}'},
            url:'{{ route('cp.user.datatable',['curr_menu'=>$sel_menu]) }}',type:"POST"},

        columns: [
            { data: 'name', name: 'name' },
            { data: 'account_level', name: 'account_level' },
            { data: 'email', name: 'email' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action2', name: 'action2',orderable: false, searchable: false },
            //{ data: 'action', name: 'action',orderable: false, searchable: false },
            // { name: 'verify',orderable: false, searchable: false,
            //     render:function(data, type, row, meta ){
            //         return '<a href="#" class="btn btn-success resendVerify" data-rowid="'+row.id+'">{{trans('app.resend-verify')}}</a>';

            //     } 
        
            // },
        ],
        //buttons: ['csv', 'excel', 'pdf', 'reset', 'reload'],

    });
})
</script>
@endsection
