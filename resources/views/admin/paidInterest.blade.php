@php
use App\Http\Controllers\Globals as Utils;
use App\Models\User;
@endphp

@extends('layouts.admin')

@section('title', __('Paid interests'))

@section('trans', __('active'))
@section('trans-paid-int', __('active'))

@section('head')
<link rel="stylesheet" href="{{ asset('assets_admin/bundles/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets_admin/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('bread')
<h1>Plans</h1>
<div class="section-header-breadcrumb">
	<div class="breadcrumb-item"><a href="/admin/dashboard"><i class="fas fa-home"></i></a></div>
	<div class="breadcrumb-item"><a href="/admin/transactions"><i class="fas fa-wallet"></i></a></div>
	<div class="breadcrumb-item active"><a href="#">Pending Payouts</a></div>
</div>
@endsection

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-hover" id="tableT">
						<thead>
							<tr>
								<th>SN</th>
								<th>User</th>
								<th>Amount</th>
								<th>Status</th>
								<th>Date Matured</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@php
							$i = 1;
							@endphp
							@foreach($payouts as $post)
								@php
								$duser = $post->investment->user;
								@endphp
								<tr>
									<td>{{ $i++ }}</td>
									<td>{!! "<img class='profile-img-circle box-center' style='width:120px;height:120px;object-fit:cover;' src='".asset($duser->profile_photo_path)."' alt='".$duser->firstname."'>" !!}</td>
									<td>{{ '₦'.number_format($post->amount,2) }}</td>
									<td>{{ $post->status }}</td>
									<td>{{ date('F d, Y h:i a', strtotime($post->created_at)) }}</td>
									<td>{!! "<a href='/admin/investments/view/".$post->investment."' class='btn btn-outline-info btn-sm mr-2' target='_blank'>View Investment</a>" !!}
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
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
			$('a.performing').on('click', function(){
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