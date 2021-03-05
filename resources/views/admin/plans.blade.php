@php
use App\Http\Controllers\Globals as Utils;
@endphp

@extends('layouts.admin')

@section('title', __('Active Plans'))

@section('plans', __('active'))

@section('head')
<link rel="stylesheet" href="{{ asset('assets_admin/bundles/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets_admin/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('bread')
<h1>Plans</h1>
<div class="section-header-breadcrumb">
	<div class="breadcrumb-item active"><a href="/admin/dashboard"><i class="fas fa-home"></i></a></div>
	<div class="breadcrumb-item"><a href="#">Plans</a></div>
</div>
@endsection

@section('content')
<div class="row">
	<div class="col-12">
		<form action="{{ route('admin.plan.multiple.delete') }}" method="post" id="dform">
			@csrf
			<div class="card">
				<div class="card-header">
					<h4 class="d-inline-block">Active Package</h4>
					<a href="/admin/plans/add" class="d-inline-block btn btn-info float-right">Add Plan</a>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-striped table-hover" id="tableT">
							<thead>
								<tr>
									<th class="text-center pt-3">
										<div class="custom-checkbox custom-checkbox-table custom-control">
											<input type="checkbox" name="selection[]" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
											<label for="checkbox-all" class="custom-control-label">&nbsp;</label>
										</div>
									</th>
									<th>Cover</th>
									<th>Name</th>
									<th>Description</th>
									<th>Interests</th>
									<th>Witholding Tax</th>
									<th>Min Investments</th>
									<th>Active Investors</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach($plans as $key => $plan)
								@php
								$i = $key+1;
								@endphp
								<tr>
									<td>
										<div class='custom-checkbox custom-control'><input type='checkbox' data-checkboxes='mygroup' class='custom-control-input' name='selection[]' id='checkbox-{{ $i }}' value='{{ $plan->id }}'><label for='checkbox-{{ $i }}' class='custom-control-label'>&nbsp;</label></div>
									</td>
									<td><img class="profile-img-circle box-center" src="{{ asset($plan->cover) }}" style="width:120px;height:120px;object-fit:fit" alt="{{ $plan->name }}"></td>
									<td>{{ strtoupper($plan->name) }}</td>
									<td>{{ $plan->short_desc }}</td>
									<td>{{ $plan->interests }}%</td>
									<td>{{ $plan->witholding_tax }}%</td>
									<td>₦{{ number_format($plan->min_invest,2) }}</td>
									<td>{{ count(Utils::getInvestors($plan->id)) }}</td>
									<td><a href='/admin/plans/edit/{{ $plan->id }}' class='btn btn-outline-warning btn-sm mr-2' target='_blank'>Edit</a><a data-target='{{ url("/admin/plans/delete/".$plan->id) }}' class='btn btn-outline-danger btn-sm performing'>Delete</a>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<a href="javascript:void(0)" class="btn btn-danger mt-4 classed" type="submit">Deleted Selected</a>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection

@section('foot')
	<script src="{{ asset('assets_admin/bundles/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets_admin/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets_admin/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets_admin/js/page/datatables.js') }}"></script>
    <script type="text/javascript">
    	$(function(){
    		$("#tableT").dataTable({
				"columnDefs": [
			    	{ "sortable": false, "targets": [0,2] }
			  	],
			  	order: [[ 1, "asc" ]]
			});
	        $('.classed').on('click', function(){
	        	swal({
				    title: 'Are you sure?',
				    text: 'Please note that this action cannot be reverted!',
				    icon: 'warning',
				    buttons: true,
				    dangerMode: true,
				}).then((willDelete) => {
				    if (willDelete) {
				        $("#dform").submit();
				    } else {
				        swal('Your action has been cancelled');
				    }
				});
	        });
	        $('.performing').on('click', function(){
	        	var url = ($(this).attr('data-target'));
	        	swal({
				    title: 'Are you sure?',
				    text: 'Please note that this action cannot be reverted!',
				    icon: 'warning',
				    buttons: true,
				    dangerMode: true,
				}).then((willDelete) => {
				    if (willDelete) {
				        window.location = url;
				    } else {
				        swal('Your action has been cancelled');
				    }
				});
	        });
    	});
    </script>
@endsection