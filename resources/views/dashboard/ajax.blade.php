<script type="text/javascript">

$.ajaxSetup({
	headers:{
		'X-CSRF-TOKEN':$('meat[name="_token"]').attr('content')
	}
})
//---------------------------
$('#add').on('click',function(){
	$('#save').val('save');
	$('#frmCustomer').trigger('reset');
	$('#customer').modal('show');
})
$("#frmCustomer").on('submit',function(e){
	e.preventDefault();
	var form=$('#frmCustomer');
	var formData=form.serialize();
	var url=form.attr('action');
	var state=$('#save').vale;
	var type= 'post';
	if (state=='update'){
		type='put';
	}
	$.ajax({
		type: type,
		url: url,
		data: formData,
		success:function(data){
			//console.log(data);
			//addRow(data);
			var sex="";
			if(data.sex==0){
				sex="Male";
			}else{sex="Female"}
			var row='tr id=""customer'+ data.id +'">'+
					'<td>'+ data.id +'</td>'+
					'<td>'+ data.first_name +'</td>'+
					'<td>'+ data.first_name +'</td>'+
					'<td><button class="btn btn-success btn-edit" data-id="'+data.id+'">Edit</button>'+
					'<td><button class="btn btn-danger btn-delete" data-id="'+data.id+'">Delete</button>'+
					'</tr>';
				if(state=='save'){
					$('tbody').append(row);
				}else{
					$('#customer'+data.id).replaceWith(row);
				}
				
			$('#frmCustomer').trigger('reset');
			$('#first_name').focus();
		}
	});
})
//---------addrow-----
function addRow(data){
	var sex="";
	if(data.sex==0){
		sex="Male";
	}else{sex="Female"}
	var row='tr id=""customer'+ data.id +'">'+
			'<td>'+ data.id +'</td>'+
			'<td>'+ data.first_name +'</td>'+
			'<td>'+ data.first_name +'</td>'+
			'<td><button class="btn btn-success btn-edit">Edit</button>'+
			'<td><button class="btn btn-danger btn-delete">Delete</button>'+
			'</tr>';
		$('tbody').append(row);
}
//----------------get update--------------
$('tbody').delegate('.btn-edit','click',function(){
	var value=$(this).data.('id');
	var url= '{{URL::to('getUpdate')}}';
	$.ajax({
		type: type,
		url: url,
		data: {'id':value},
		success:function(data){
			$('#id').val(data.id);
			$('#first_name').val(data.first_name);
			$('#last_name').val(data.last_name);
			$('#save').val('update');
			$('#customer').modal('show');
		}
	});
})
//-----------delete customer---------
$('tbody').delegate('.btn-edit','click',function(){
	var value=$(this).data.('id');
	var url= '{{URL::to('deleteCustomer')}}';
	if (confirm('Are you sure to delete')==true){
		$.ajax({
		type: 'post',
		url: url,
		data: {'id':value},
		success:function(data){
			alert(data.sms);
			$('#customer'+value).remove();
		}
	});
	}
});
</script>