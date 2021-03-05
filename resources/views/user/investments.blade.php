@extends('layouts.app')

@section('title', __('My Investments'))

@section('invests', __('active'))

@section('head')
<link rel="stylesheet" href="{{ asset('assets_admin/bundles/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets_admin/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
@endsection

@php
use App\Http\Controllers\Globals as Utils;
@endphp

@section('bread')
<h1>Investments</h1>
<div class="section-header-breadcrumb">
	<div class="breadcrumb-item"><a href="/dashboard"><i class="fas fa-home"></i></a></div>
	<div class="breadcrumb-item active"><a href="#">Investments</a></div>
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
								<th>Amount</th>
								<th>Tenor</th>
								<th>Status</th>
								<th>Date Created</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($entities as $entity)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ '₦'.number_format($entity->amount,2) }}</td>
								<td>{{ $entity->tenor.' '.strtoupper($entity->tenor_type) }}</td>
								<td>{!! Utils::getBadge($entity->status) !!}</td>
								<td>{{ $entity->created_at->format('F d, Y h:i a') }}</td>
								<td><a href='/dashboard/investments/view/{{ $entity->id }}' class='btn btn-outline-info btn-sm mr-2' target='_blank'>View</a></td>
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
    	});
    </script>
@endsection