@php
use App\Http\Controllers\Globals as Utils;
@endphp

@extends('layouts.app')

@section('title', __('Invest on'.strtoupper($plan->name)))

@section('head')
<link rel="stylesheet" href="{{ asset('assets_admin/bundles/select2/dist/css/select2.min.css') }}">
@endsection

@section('bread')
<h1>Plans</h1>
<div class="section-header-breadcrumb">
	<div class="breadcrumb-item"><a href="/dashboard"><i class="fas fa-home"></i></a></div>
	<div class="breadcrumb-item"><a href="/dashboard/plans"><i class="far fa-chart-bar"></i></a></div>
	<div class="breadcrumb-item active"><a href="#">Invest Now</a></div>
</div>
@endsection

@section('content')
<div class="row">
	<div class="col-6">
		<form action="{{ route('plans.invest') }}" method="post" enctype="multipart/form-data">
			@csrf
			<div class="card">
				<div class="card-header">
					<h4 class="d-inline-block">Investments</h4>
				</div>
				<div class="card-body">
					<div class="form-group">
						<h5 class="text-primary">PACKAGE DESCRIPTION: </h5>
						<div class="text-primary"><strong>Name:</strong> {{ strtoupper($plan->name) }}</div>
						<div class="text-primary"><strong>Annual Interest:</strong> {{ $plan->interests }}%</div>
						<div class="text-primary"><strong>Witholding Tax:</strong> {{ $plan->witholding_tax }}%</div>
						<div class="text-primary"><strong>Minimum Investment:</strong> ₦{{ number_format($plan->min_invest,2) }}</div>
					</div>
					<div class="form-group">
						<label>Amount </label>
						<input type="number" name="amount" class="form-control" step="any" required="">
						<input type="hidden" name="plan" class="form-control" value="{{ $plan->id }}">
					</div>
					<div class="form-group">
						<label>Tenure</label>
						<select class="form-control select2" required name="tenor">
	                        <option value="">Select a tenure</option>
	                        <option>30 days</option>
	                        <option>60 days</option>
	                        <option>120 days</option>
	                        <option>180 days</option>
	                        <option>365 days</option>
	                        <option>2 years</option>
	                        <option>3 years</option>
	                    </select>
					</div>
					<div class="form-group">
						<label>Payment Type</label>
						<select class="form-control select2" required name="pay_type">
	                        <option value="">Select a payment type</option>
	                    </select>
					</div>
					<button class="btn btn-primary btn-block">Add Investment</button>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection

@section('foot')
<script src="{{ asset('assets_admin/bundles/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets_admin/js/page/forms-advanced-forms.js') }}"></script>
<script type="text/javascript">
	$(function(){
		$('select[name="tenor"]').on('change', function(){
			var tenor = $('select[name="tenor"]').val();
			if(tenor == "30 days" || tenor == "60 days" || tenor == "120 days" || tenor == "180 days"){
				$('select[name="pay_type"]').html('<option value="">Select a payment type</option><option>Monthly</option>');
			}else{
				$('select[name="pay_type"]').html('<option value="">Select a payment type</option><option>Monthly</option><option>Quarterly</option><option>Semi Annually</option><option>Maturity</option>');
			}
		});
	});
</script>
@endsection