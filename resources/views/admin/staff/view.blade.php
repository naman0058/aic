<div class="modal-content">
	<div class="modal-header">
	<h5 class="modal-title h4" id="exampleModalLgLabel">Staff Info</h5>
</div>
<div class="modal-body">
	<div class="row">
		<div class="col-md-8">
			<ul class="resume-box">
				<li>
					<div class="icon text-center">
						<i class="fa fa-user"></i>
						
					</div>
					<div class="fw-bold mb-0"> Name</div>
					<span>{{ucfirst($data->name)}}</span>
				</li>
				<li>
					<div class="icon text-center">
						<i class="fa fa-mobile"></i>
					</div>
					<div class="fw-bold mb-0">Contact Number</div>
					<span>{{$data->mobile}}</span>
					@if($data->alt_mobile !='')<br>
					<span>{{$data->alt_mobile}}</span>
					@endif
				</li>
				@if($data->email!='')
				<li>
					<div class="icon text-center">
						<i class="fa fa-envelope"></i>
					</div>
					<div class="fw-bold mb-0">Email Address</div>
					<span>{{$data->email}}</span>
				</li>
				@endif
				@if($data->address !='')
				<li>
					<div class="icon text-center">
						<i class="fa fa-map-marker"></i>
					</div>
					<div class="fw-bold mb-0">Address</div>
					<span>{{ucfirst($data->address)}}</span>
				</li>
				@endif
				
			
			</ul>
		</div>
		<div class="col-md-4">
			<div class="fw-bold mb-0"></div>
			@if($data->photo!='')
			<img src="{{ asset('public/images/staff') }}/{{ $data->photo }}" style="width:100px;height:100px;">
			@endif
		</div>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-secondary modalClose" data-dismiss="modal">Close</button>
</div>
</div>