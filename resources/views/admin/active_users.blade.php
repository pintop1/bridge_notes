@extends('layouts.admin')

@section('title', __('Active Users'))

@section('users', __('active'))
@section('user-active', __('active'))

@section('head')
<link rel="stylesheet" href="{{ asset('assets_admin/bundles/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets_admin/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('bread')
<h1>Active Users</h1>
<div class="section-header-breadcrumb">
	<div class="breadcrumb-item active"><a href="/admin/dashboard"><i class="fas fa-home"></i></a></div>
	<div class="breadcrumb-item"><a href="/admin/users">Users</a></div>
	<div class="breadcrumb-item"><a href="#">Active Users</a></div>
</div>
@endsection

@section('content')
<div class="row">
	<div class="col-12">
		<form action="{{ route('admin.user.multiple.delete') }}" method="post" id="dform">
			@csrf
			<div class="card">
				<div class="card-header">
					<h4>Active Accounts</h4>
				</div>
				<div class="card-body">
					<a href="/admin/users/create" class="btn btn-primary mb-2">Add new user</a>
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
									<th>Passport</th>
									<th>Firstname</th>
									<th>Lastname</th>
									<th>Othername</th>
									<th>Email</th>
									<th>Phone</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach($users as $user)
								<tr>
									<td  class="text-center pt-3"><div class='custom-checkbox custom-control'><input type='checkbox' data-checkboxes='mygroup' class='custom-control-input' name='selection[]' id='checkbox-{{ $loop->iteration}}' value='{{ $user->id }}'><label for='checkbox-{{ $loop->iteration}}' class='custom-control-label'>&nbsp;</label></div></td>
									<td>
										<img class='profile-img-circle box-center' style='width:120px;height:120px;object-fit:cover;' src='{{ asset($user->profile_photo_path) }}' alt=''>
									</td>
									<td>{{ ucwords($user->firstname) }}</td>
									<td>{{ ucwords($user->lastname) }}</td>
									<td>{{ ucwords($user->othername) }}</td>
									<td>{{ strtolower($user->email) }}</td>
									<td>{{ $user->mobile }}</td>
									<td>
										<a href='/admin/users/view/{{ $user->id }}' class='btn btn-outline-info btn-sm mr-2' target='_blank'>View</a><a data-target='/admin/users/tdelete/{{ $user->id }}' class='btn btn-outline-danger btn-sm performing'>Delete</a>
									</td>
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
			$('#tableT').on('click', 'a.performing', function () {
	          //var row = table.row($(this)).data();
	          //console.log(row);   //full row of array data
	          //console.log(row[1]);   //EmployeeId*/
	          var url = ($(this).attr('data-target'));
	          $(".loading").show();
	          $.get(url, function(data){
	            $(".loading").hide();
	            $(".return").html(data);
	          });
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
    	});
    </script>
@endsection