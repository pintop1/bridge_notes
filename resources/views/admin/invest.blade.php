@php
use App\Http\Controllers\Globals as Utils;
@endphp

@extends('layouts.app')

@section('title', __('Add new investment'))

@section('head')
<link rel="stylesheet" href="{{ asset('assets_admin/bundles/select2/dist/css/select2.min.css') }}">
@endsection

@section('bread')
<h1>Investments</h1>
<div class="section-header-breadcrumb">
	<div class="breadcrumb-item"><a href="/dashboard"><i class="fas fa-home"></i></a></div>
	<div class="breadcrumb-item"><a href="/dashboard/plans"><i class="far fa-chart-bar"></i></a></div>
	<div class="breadcrumb-item active"><a href="#">Invest Now</a></div>
</div>
@endsection

@section('content')
<div class="row">
	<div class="col-6">
		<form action="{{ route('admin.invest') }}" method="post" enctype="multipart/form-data">
			@csrf
			<div class="card">
				<div class="card-header">
					<h4 class="d-inline-block">Investments</h4>
				</div>
				<div class="card-body">
					<div class="form-group">
						<label>User</label>
						<select class="form-control select2" name="user">
							@foreach($users as $user)
							<option value="{{ $user->id }}">{{ $user->fullname() }} - {{ $user->email }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>Amount </label>
						<input type="number" name="amount" class="form-control" step="any" required="">
					</div>
					<div class="form-group">
						<label>Interest (%)</label>
						<input type="number" name="interest" class="form-control" step="any" required="">
					</div>
					<div class="form-group">
						<label>Witholding tax (%) </label>
						<input type="number" name="witholding_tax" class="form-control" step="any" required="">
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
						<label>Date approved </label>
						<input type="date" name="date_approved" class="form-control" step="any" required="">
					</div>
					<div class="form-group">
						<label>Payment Type</label>
						<select class="form-control select2" required name="payment_type">
	                        <option>Maturity</option>
	                        <option>Monthly</option>
	                        <option>Quarterly</option>
	                        <option>Semi Annually</option>
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
@endsection