@extends('layouts.admin')

@section('title', __('Administrative Dashboard'))

@section('dash', __('active'))

@section('bread')
<h1>Dashboard</h1>
@endsection

@section('content')
<div class="row">
	<div class="col-lg-3 col-md-6 col-sm-12">
		<div class="card card-sales-widget card-bg-blue-gradient">
			<div class="card-icon shadow-primary bg-blue">
				<i class="fas fa-users"></i>
			</div>
			<div class="card-wrap pull-right">
				<div class="card-header">
					<h3>{{ number_format($users) }}</h3>
					<h4>Users</h4>
				</div>
			</div>
			<div class="card-chart">
				<div id="chart-1"></div>
			</div>
		</div>
	</div>
	<div class="col-lg-3 col-md-6 col-sm-12">
		<div class="card card-sales-widget card-bg-yellow-gradient">
			<div class="card-icon shadow-primary bg-warning">
				<i class="fas fa-dollar-sign"></i>
			</div>
			<div class="card-wrap pull-right">
				<div class="card-header">
					<h3>₦{{ number_format($active_investments,2) }}</h3>
					<h4>Active Investments</h4>
				</div>
			</div>
			<div class="card-chart">
				<div id="chart-2"></div>
			</div>
		</div>
	</div>
	<div class="col-lg-3 col-md-6 col-sm-12">
		<div class="card card-sales-widget card-bg-orange-gradient">
			<div class="card-icon shadow-primary bg-hibiscus">
				<i class="fas fa-shopping-cart"></i>
			</div>
			<div class="card-wrap pull-right">
				<div class="card-header">
					<h3>₦{{ number_format($investments,2) }}</h3>
					<h4>All Investments</h4>
				</div>
			</div>
			<div class="card-chart">
				<div id="chart-3"></div>
			</div>
		</div>
	</div>
	<div class="col-lg-3 col-md-6 col-sm-12">
		<div class="card card-sales-widget card-bg-green-gradient">
			<div class="card-icon shadow-primary bg-green">
				<i class="fas fa-dollar-sign"></i>
			</div>
			<div class="card-wrap pull-right">
				<div class="card-header">
					<h3>₦{{ number_format($payouts,2) }}</h3>
					<h4>Payouts</h4>
				</div>
			</div>
			<div class="card-chart">
				<div id="chart-4"></div>
			</div>
		</div>
	</div>
</div><!--
<div class="row">
	<div class="col-lg-4 col-md-12 col-12 col-sm-12">
		<div class="card">
			<div class="card-header">
				<h4>Sales by Social Sources</h4>
			</div>
			<div class="card-body mb-3">
				<div id="salesBySocialSourceChart"></div>
			</div>
		</div>
	</div>
	<div class="col-lg-8 col-md-12 col-12 col-sm-12">
		<div class="card">
			<div class="card-header">
				<h4>Invoice details</h4>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped">
						<tr>
							<th>Order ID</th>
							<th>Billing Name</th>
							<th>Total</th>
							<th>Payment Method</th>
							<th>Payment Status</th>
							<th>Action</th>
						</tr>
						<tr>
							<td>#TD1230</td>
							<td>David Brown</td>
							<td>150$</td>
							<td><img alt="image" class="mr-3" width="40" src="assets/img/cards/paypal.png"></td>
							<td>
								<div class="badge badge-success badge-shadow">Paid</div>
							</td>
							<td>
								<div class="media-cta-square">
									<a href="#" class="btn btn-outline-primary">Detail</a>
								</div>
							</td>
						</tr>
						<tr>
							<td>#TD1231</td>
							<td>Luna Moore</td>
							<td>250$</td>
							<td><img alt="image" class="mr-3" width="40" src="assets/img/cards/visa.png"></td>
							<td>
								<div class="badge badge-info badge-shadow">Refund</div>
							</td>
							<td>
								<div class="media-cta-square">
									<a href="#" class="btn btn-outline-primary">Detail</a>
								</div>
							</td>
						</tr>
						<tr>
							<td>#TD1232</td>
							<td>Emma Martin</td>
							<td>350$</td>
							<td><img alt="image" class="mr-3" width="40" src="assets/img/cards/americanexpress.png"></td>
							<td>
								<div class="badge badge-success badge-shadow">Paid</div>
							</td>
							<td>
								<div class="media-cta-square">
									<a href="#" class="btn btn-outline-primary">Detail</a>
								</div>
							</td>
						</tr>
						<tr>
							<td>#TD1233</td>
							<td>Noah Clark</td>
							<td>435$</td>
							<td><img alt="image" class="mr-3" width="40" src="assets/img/cards/mastercard.png"></td>
							<td>
								<div class="badge badge-danger badge-shadow">Chargeback</div>
							</td>
							<td>
								<div class="media-cta-square">
									<a href="#" class="btn btn-outline-primary">Detail</a>
								</div>
							</td>
						</tr>
						<tr>
							<td>#TD1234</td>
							<td>William Thomas</td>
							<td>220$</td>
							<td><img alt="image" class="mr-3" width="40" src="assets/img/cards/discover.png"></td>
							<td>
								<div class="badge badge-info badge-shadow">Refund</div>
							</td>
							<td>
								<div class="media-cta-square">
									<a href="#" class="btn btn-outline-primary">Detail</a>
								</div>
							</td>
						</tr>
						<tr>
							<td>#TD1230</td>
							<td>Olivia Lewis</td>
							<td>310$</td>
							<td><img alt="image" class="mr-3" width="40" src="assets/img/cards/jcb.png"></td>
							<td>
								<div class="badge badge-success badge-shadow">Paid</div>
							</td>
							<td>
								<div class="media-cta-square">
									<a href="#" class="btn btn-outline-primary">Detail</a>
								</div>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>-->
@endsection

@section('foot')
	<script src="{{ asset('assets_admin/bundles/echart/echarts.js') }}"></script>
	<script src="{{ asset('assets_admin/bundles/chartjs/chart.min.js') }}"></script>
	<script src="{{ asset('assets_admin/bundles/apexcharts/apexcharts.min.js') }}"></script>
	<script src="{{ asset('assets_admin/js/page/index.js') }}"></script>
	<script src="{{ asset('assets_admin/bundles/jquery.sparkline.min.js') }}"></script>
@endsection