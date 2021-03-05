@php
use App\Http\Controllers\Globals as Utils;
@endphp

@extends('layouts.app')

@section('title', __('Active Plans'))

@section('plans', __('active'))

@section('head')
<link rel="stylesheet" href="{{ asset('assets_admin/bundles/datatables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets_admin/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
@endsection

@section('bread')
<h1>Plans</h1>
<div class="section-header-breadcrumb">
	<div class="breadcrumb-item active"><a href="/dashboard"><i class="fas fa-home"></i></a></div>
	<div class="breadcrumb-item"><a href="#">Plans</a></div>
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
								<th>Cover</th>
								<th>Name</th>
								<th>Description</th>
								<th>Interests</th>
								<th>Witholding Tax</th>
								<th>Min Investments</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($plans as $key => $plan)
							@php
							$i = $key+1;
							@endphp
							<tr>
								<td>{{ $i }}</td>
								<td><img class="profile-img-circle box-center" src="{{ asset($plan->cover) }}" style="width:120px;height:120px;object-fit:fit" alt="{{ $plan->name }}"></td>
								<td>{{ strtoupper($plan->name) }}</td>
								<td>{{ $plan->short_desc }}</td>
								<td>{{ $plan->interests }}%</td>
								<td>{{ $plan->witholding_tax }}%</td>
								<td>₦{{ number_format($plan->min_invest,2) }}</td>
								<td><a href='/dashboard/plans/invest/{{ $plan->id }}' class='btn btn-outline-info btn-sm mr-2'>Invest</a></td>
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