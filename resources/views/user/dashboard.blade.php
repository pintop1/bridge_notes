@extends('layouts.app')

@section('title', __('Dashboard'))

@section('dash', __('active'))

@section('bread')
<h1>Dashboard</h1>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="card card-sales-widget card-bg-blue-gradient">
            <div class="card-icon shadow-primary bg-blue">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="card-wrap pull-right">
                <div class="card-header">
                    <h3>{{ number_format($activeInvests,2) }}</h3>
                    <h4>Active Investments</h4>
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
                    <h3>₦{{ number_format($totalInvests,2) }}</h3>
                    <h4>Total Investments</h4>
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
                    <h3>₦{{ number_format($totalPay,2) }}</h3>
                    <h4>Total Payouts</h4>
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
                    <h3>₦{{ number_format($pendingPay,2) }}</h3>
                    <h4>Pending Payouts</h4>
                </div>
            </div>
            <div class="card-chart">
                <div id="chart-4"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('foot')
    <script src="{{ asset('assets_admin/bundles/echart/echarts.js') }}"></script>
    <script src="{{ asset('assets_admin/bundles/chartjs/chart.min.js') }}"></script>
    <script src="{{ asset('assets_admin/bundles/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets_admin/js/page/index.js') }}"></script>
    <script src="{{ asset('assets_admin/bundles/jquery.sparkline.min.js') }}"></script>
@endsection