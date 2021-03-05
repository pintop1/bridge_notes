@php
use App\Http\Controllers\Globals as Utils;
use App\Models\Investment;
$perInvest = round(($investment->amount / Investment::sum('amount'))*100);
$growth = round(Utils::getInvestmentGrowth($investment));
$interest = Utils::getInterests($investment->tenor." ".$investment->tenor_type, $investment->amount, $investment->interest);
$tax = $investment->witholding_tax;
$payouts = $investment->payouts()->latest()->get();
@endphp

@extends('layouts.app')

@section('title', __('View Investment < My Investments'))

@section('invests', __('active'))

@section('head')
<link rel="stylesheet" href="{{ asset('assets_admin/bundles/bootstrap-social/bootstrap-social.css') }}">
<link rel="stylesheet" href="{{ asset('assets_admin/bundles/summernote/summernote-bs4.css') }}">
@endsection

@section('bread')
<h1>Active Users</h1>
<div class="section-header-breadcrumb">
	<div class="breadcrumb-item"><a href="/dashboard"><i class="fas fa-home"></i></a></div>
	<div class="breadcrumb-item"><a href="/dashboard/investments"><i class="fas fa-shopping-bag"></i></a></div>
	<div class="breadcrumb-item active"><a href="#">View investment</a></div>
</div>
@endsection

@section('content')
<div class="row mt-sm-4">
	<div class="col-12 col-md-12 col-lg-4">
		<div class="card">
			<div class="card-header">
				<h4>Investment Stats</h4>
			</div>
			<div class="card-body">
				<ul class="list-unstyled user-progress list-unstyled-border list-unstyled-noborder">
					<li class="media">
						<div class="media-body">
							<div class="media-title">%in Investments</div>
						</div>
						<div class="media-progressbar p-t-5">
							<div class="progress" data-height="15">
								<div class="progress-bar {{ Utils::getBg($perInvest) }} progress-bar-striped progress-bar-animated" data-width="{{ $perInvest }}%">{{ $perInvest }}%</div>
							</div>
						</div>
					</li>
					<li class="media">
						<div class="media-body">
							<div class="media-title">Investment growth</div>
						</div>
						<div class="media-progressbar p-t-5">
							<div class="progress" data-height="15">
								<div class="progress-bar {{ Utils::getBg($growth) }} progress-bar-striped progress-bar-animated" data-width="{{ $growth }}%">{{ $growth }}%</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-12 col-lg-4">
		<div class="card">
			<div class="card-header">
				<h4>Investment Details</h4>
			</div>
			<div class="card-body">
				<div class="py-4">
					<p class="clearfix">
						<span class="float-left">
						Amount
						</span>
						<span class="float-right text-muted">
						₦{{ number_format($investment->amount,2) }}
						</span>
					</p>
					<p class="clearfix">
						<span class="float-left">
						Tenor
						</span>
						<span class="float-right text-muted">
						{{ $investment->tenor }} {{ strtoupper($investment->tenor_type) }}
						</span>
					</p>
					<p class="clearfix">
						<span class="float-left">
						Expected growth
						</span>
						<span class="float-right text-muted">
						₦{{ number_format(Utils::getExpectedGrowth($investment),2) }}
						</span>
					</p>
					<p class="clearfix">
						<span class="float-left">
						Total Witholding Tax
						</span>
						<span class="float-right text-muted">
						₦{{ number_format($tax,2) }}
						</span>
					</p>
					<p class="clearfix">
						<span class="float-left">
						Payment Type
						</span>
						<span class="float-right text-muted">
						{{ strtoupper($investment->payment_type) }}
						</span>
					</p>
					<p class="clearfix">
						<span class="float-left">
						Total Expected Payouts
						</span>
						<span class="float-right text-muted">
						₦{{ number_format($investment->amount + Utils::getExpectedGrowth($investment),2) }}
						</span>
					</p>
					<p class="clearfix">
						<span class="float-left">
						Status
						</span>
						<span class="float-right text-muted">
						{!! Utils::getBadge($investment->status) !!}
						</span>
					</p>
					<p class="clearfix">
						<span class="float-left">
						Payout
						</span>
						<span class="float-right text-muted">
							@if($investment->status == 'matured')
								@if($investment->payout == 'requested')
								<span class="badge badge-warning">Requested</span>
								@elseif($investment->payout == 'paid')
								<span class="badge badge-success">Paid</span>
								@else
								<a href="javascript:void(0)" data-target="{{ url('/dashboard/investments/'.$investment->id.'/payout') }}" class="btn btn-primary classed">Request Capital Payout</a>
								@endif
							@else
							Not Qualified
							@endif
						</span>
					</p>
					@if($investment->status != 'declined' && $investment->status != 'pending')
					<p class="clearfix">
						<span class="float-left">
						Certificate
						</span>
						<span class="float-right text-muted">
						<a href="/dashboard/investments/certificate/{{ $investment->id }}" target="_blank" class="btn btn-primary">Download</a>
						</span>
					</p>
					@endif
					@if(count($payouts) > 0)
					<h2>Matured Payments</h2>
					<div class="table-responsive">
						<table class="table table-striped table-hover" id="tableT">
							<thead>
								<tr>
									<th>Date Matured</th>
									<th>Amount</th>
									<th>Tax</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								@foreach($payouts as $pay)
								@php
								$tax = ($investment->witholding_tax/$investment->amount)*100;
								@endphp
								<tr>
									<td>{{ date('F d, Y h:i A', strtotime($pay->created_at)) }}</td>
									<td>₦{{ number_format($pay->amount,2) }}</td>
									<td>₦{{ number_format(($pay->amount * $tax) / 100 ,2) }}</td>
									<td>{{ $pay->status }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('foot')
<script src="{{ asset('assets_admin/bundles/summernote/summernote-bs4.min.js') }}"></script>
<script type="text/javascript">
	$(function(){
		$('.classed').on('click', function(){
        	swal({
			    title: 'Are you sure?',
			    text: 'Please note that this action cannot be reverted!',
			    icon: 'warning',
			    buttons: true,
			    dangerMode: true,
			}).then((willDelete) => {
			    if (willDelete) {
			    	var url = ($(this).attr('data-target'));
			        window.location = url;
			    } else {
			        swal('Your action has been cancelled');
			    }
			});
        });
	});
</script>
@endsection