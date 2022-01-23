
@extends('layouts.admin')
@section('title', trans('app.languages'))
@section('content')

<div class="card card-default">
  <div class="card-header">
    <h3 class="card-title">{{trans('app.languages')}}</h3>
    
  </div>
  <!-- /.card-header -->
    <div class="card-body">
        <table class="table data-table" style="width: 100%;">
            <thead>
            <tr>
                <th>{{trans('app.code')}}</th>
                <th>{{trans('app.name')}}</th>
                <th></th>
            </tr>
            </thead>
            @foreach($data as $item)
            <tr>
                <td>{{$item->code}}</td>
                <td>{{$item->name}}</td>
                <td>
                    @if(app()->getLocale()==$item->code)
                    <i class="fa fa-toggle-on text-success"></i>
                    @elseif($item->installed)
                    <a href="#"><i data-code='{{$item->code}}' class="fa fa-toggle-on text-success"></i></a>
                    @else
                    <a href="#"><i data-code='{{$item->code}}' class="fa fa-toggle-off text-dark"></i></a>
                     @endif
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    <!-- /.card-body -->

   
</div>
            
@endsection
@section('js')
<script>
    $(function(){
        $('.data-table').dataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.10.22/i18n/Arabic.json"
            },
            order:[[2,'desc']]
        });
        $('.fa-toggle-on,.fa-toggle-off').click(function(){
            var $this=$(this);
            var $method='install';
            if($this.hasClass('fa-toggle-off')) $method='install';
            if($this.hasClass('fa-toggle-on')) $method='uninstall';
           $.ajax({
                headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    },
               type:'POST',
               url:'languages/' + $method,
               dataType:'json',
               data:{code:$this.data('code')},
               success:function(resp){
                    $this.toggleClass("text-dark");
                    $this.toggleClass("text-success");
                    $this.toggleClass("fa-toggle-off");
                    $this.toggleClass("fa-toggle-on");

               },
               error:function(a,b,c){
                   error(a.statusText);
               }
           })
            
        })
    })
</script>

@endsection
