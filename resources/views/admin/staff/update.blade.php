@extends('layouts.adminlayout')
@section('content')
<div id="preloader">

</div>
<!-- start: page toolbar -->
<div class="page-toolbar px-xl-4 px-sm-2 px-0 py-3">
	<div class="container-fluid">
		<div class="row g-3 mb-3 align-items-center">
			<div class="col">
				<ol class="breadcrumb bg-transparent mb-0">
					<li class="breadcrumb-item"><a class="text-secondary" href="{{route('dashboard')}}">Dashboard</a></li>
					<li class="breadcrumb-item"><a class="text-secondary" href="{{url('staff')}}">Staff</a></li>
					<li class="breadcrumb-item active"  aria-current="page">Edit</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<!-- start: page body -->
<div class="page-body px-xl-4 px-sm-2 px-0 py-lg-2 py-1 mt-3">
	<div class="container-fluid">
		<div class="row g-4">
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="card">
					<div class="card-header"style="background-color:#3fbb7066;">
						<h6 class="card-title mb-0"style="color:white">Update Staff </h6>
						<div class="dropdown morphing scale-left">
							<a href="#" class="card-fullscreen" data-bs-toggle="tooltip" title="" data-bs-original-title="Card Full-Screen" aria-label="Card Full-Screen"><i class="icon-size-fullscreen"></i></a>
						</div>
					</div>
					<div class="card-body">
						<form id="staffUpdateForm" method="post"   enctype="multipart/form-data">
							@csrf
							<div class="row">
								<input type="hidden" name="id" value="{{ $data->id }}">
								<div class="form-group col-md-6 mb-3">
									<label>Name</label>
									<input type="text" class="form-control" name="name" id="name" value="{{ $data->name }}">
								</div>
								<div class="form-group col-md-6 mb-3">
									<label>Email</label>
									<input type="email" class="form-control" name="email" id="email" value="{{ $data->email  }}">
								</div>
								
								<div class="form-group col-md-6 mb-3">
									<label>Mobile</label>
									<input type="number" class="form-control" name="mobile" value="{{ $data->mobile }}">
								</div>

								<div class="form-group col-md-6 mb-3">
									<label>Alt Mobile</label>
									<input type="number" class="form-control" name="alt_mobile" value="{{ $data->alt_mobile }}">
								</div>
								<div class="form-group col-md-6 mb-3">
									<label>Photo </label>
									<input type="file" class="form-control" name="photo">
								</div>
								<div class="form-group col-md-6 mb-3">
									<label>New Password </label>
									<input type="password" class="form-control" name="new_password" id="new_password"placeholder="Enter New Password If You Wish To Change">
								</div>
								<div class="col-md-12 mb-3">
				                  <label class="form-label">Address</label>
				                  <textarea class="form-control" name="address">{{ $data->address }}</textarea>
				                </div>
								
							</div>
							<div class="col-md-12 mb-3" align="right">
									<div class="col-12">
									<button  type="submit" class="btn btn rounded-4 btn-primary create-banner">Submit</button>
									<a class="btn btn rounded-4 btn-secondary" href="{{ url('staff') }}">Back</a>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div> <!-- .row end -->
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
$('#preloader').fadeOut(100); 
$("#staffUpdateForm").on('submit',(function(e) {
$(".errors").html('');
e.preventDefault();
   $('#preloader').fadeIn(100); 
    $.ajax({
        url: "{{ route('staffUpdate') }}",
        type:"post",
        data:  new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success: function(data)
        {
           $('#preloader').fadeOut(100);
           $('#new_password').val('');
           Swal.fire(data);

        },
        error:function (response){
        
           $('#preloader').fadeOut(100); 
          jsonValue = jQuery.parseJSON(response.responseText);
          $.each(jsonValue.errors,function(field_name,error){
            $(document).find('[name='+field_name+']').after('<small class="form-control-feedback text-danger errors"> '+error+' </small>')
          });
        }
    });
}));
</script>
@stop
