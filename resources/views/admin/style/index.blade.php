@extends('layouts.adminlayout')
@section('content')
<!-- start: page toolbar -->
<div class="page-toolbar px-xl-4 px-sm-2 px-0 py-3">
	<div class="container-fluid">
		<div class="row g-3 mb-3 align-items-center">
			<div class="col">
				<ol class="breadcrumb bg-transparent mb-0">
					<li class="breadcrumb-item"><a class="text-secondary" href="{{route('dashboard')}}">Dashboard</a></li>
					<li class="breadcrumb-item active" aria-current="page">Styles</li>
				</ol>
			</div>
			 
		</div>
		<div class="row g-3 clearfix row-deck mt-3">
			<div class="col-lg-12 col-md-12">
				<div class="card">
					<div class="card-body">
						<form class="row g-3" id="filter_form" enctype="multipart/formdata">
							<div class="row">
								<div class="col-md-3">
									<label class="form-label">Inspenction Date</label>
									<input type="date" class="form-control" id="date">
								</div>
								<div class="col-md-3">
									<label class="form-label">Inspenction No</label>
									<input type="text" class="form-control" id="number">
									
								</div>
								<div class="col-md-3">
									<label class="form-label">Is Completed</label>
									<select class="form-control" id="is_completed">
										<option value="all">All</option>
										<option value="ongoing">Ongoing</option>
										<option value="completed">Completed</option>
									</select>
									
								</div>
								
								<div class="col-md-3" style="padding-top:2rem;">
									<label>&nbsp;</label>
									<button  type="button" class="btn bg-primary btn-xs text-white rounded-circle" id="filterBtn"><i class="fa fa-search"></i></button>
									
									<button  type="button" class="btn bg-danger btn-xs text-white rounded-circle" id="resetfilterBtn">X</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>
<!-- start: page body -->
<div class="page-body px-xl-4 px-sm-2 px-0 py-lg-2 py-1 mt-0 mt-lg-1">
  <div class="container-fluid">
	<div class="row g-2 clearfix">
		
		<div class="col-md-12 mt-4">
			<div class="card">
				<div class="card-body">
					<table id="staff-table" class="table display dataTable table-hover" style="width:100%" >
						<thead>
							<tr>
								<th>#</th>
								<th>Inspection Date</th>
								<th>Inspection No</th>
								<th>Time In</th>
								<th>Time Out</th>
								<th>Is Completed</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
  </div>
</div>
<div class="modal fade bd-example-modal-lg viewModal" id="exampleModalLive" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div id="staffShow"></div>
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
var tableX = $('#staff-table').DataTable({
processing:true,
serverSide:true,
ajax: {
url: "{{url('filter_inspection') }}",
data: function (d) {
	d.date =  $("#date").val();
	d.number =  $("#number").val();
	d.is_completed =  $("#is_completed").val();
}
},
"columns" : [
// { data : "checkbox", name : "checkbox" },
{ "data": 'DT_RowIndex',
orderable: false,
searchable: false },
{ data : "InspectionDate", name : "InspectionDate" },
{ data : "InspectionNo", name : "InspectionNo" },
{ data : "TimeIn", name : "TimeIn" },
{ data : "TimeOut", name : "TimeOut" },
{ data : "is_completed",name:"is_completed"},
{ data : "action", name : "action"}
],
responsive: true,
"searching": true,
"bStateSave": true,
"bAutoWidth":false,
"ordering": true,
});
$('#filterBtn').on('click',function(){
tableX.draw();
});
$('#resetfilterBtn').on('click',function(){
$('#date').val('');
$('#number').val('');
$('#is_completed').val('all').change();
tableX.draw();

});

$(document).on('click','.deleteBTn',function(){
Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes,  continue!',
    }).then((data) => {
    if (data.isConfirmed) {
		$.ajax({
			url:"{{url('inspection')}}/"+$(this).attr('data-id'),
			type:'post',
			data:{'_token':"{{csrf_token()}}",'id':$(this).attr('data-id'),'_method':'DELETE'},
			success:function(data){
				if(data == '1')
				{
					//toast
					Swal.fire({
						title: 'Deleted!',
						text: "Inspection has been deleted.",
						icon: 'success',
					});
					tableX.draw();
					 
				}
			}
		});
	}
	})
}); 
 

$(document).on('click','.downloadBtn',function(){
	 let id = $(this).attr('data-id');
	 window.open( "{{url('download-inspection')}}/"+id,'_blank');
});
</script>
@endsection()