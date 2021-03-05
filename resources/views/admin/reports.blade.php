@php
use App\Http\Controllers\Globals as Utils;
@endphp

@extends('layouts.admin')

@section('title')Generate Report@endsection

@section('head')
<script src="{{ asset('assets_admin/bundles/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('assets_admin/bundles/tinymce/jquery.tinymce.min.js') }}"></script>
<link href="{{ asset('assets/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('foot')
<script src="{{ asset('assets/moment/moment.js') }}" language="javascript" type="text/javascript"></script>
<script src="{{ asset('assets/daterangepicker/daterangepicker.js') }}" language="javascript" type="text/javascript"></script>
<script type="text/javascript">
	$(function(){
		$('#daterange').daterangepicker(
          {
            ranges: {
              'Today': [moment(), moment()],
              'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
              'Last 7 Days': [moment().subtract(6, 'days'), moment()],
              'Last 30 Days': [moment().subtract(29, 'days'), moment()],
              'This Month': [moment().startOf('month'), moment().endOf('month')],
              'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            startDate: moment().subtract(29, 'days'),
            endDate: moment()
          },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
      }
      );
	});
</script>
@endsection

@section('bread')
<h1>Reporting</h1>
<div class="section-header-breadcrumb">
	<div class="breadcrumb-item"><a href="/admin/dashboard"><i class="fas fa-home"></i></a></div>
	<div class="breadcrumb-item active"><a href="#"> Reports </a></div>
</div>
@endsection

@section('content')
<div class="row">
	<div class="col-6">
		<form action="{{ route('admin.reports') }}" method="get" enctype="multipart/form-data">
			<div class="card">
				<div class="card-header">
					<h4 class="d-inline-block">Get reports</h4>
				</div>
				<div class="card-body">
					<div class="form-group">
						<label>Range</label> 
                        <input type="text" class="form-control" name="daterange" id="daterange" value="03/01/2020 - {{ date('m/d/Y') }}" />
					</div>
					<button class="btn btn-primary btn-block">Generate</button>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection

@section('foot')
    <script src="{{ asset('assets_admin/bundles/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets_admin/js/page/ckeditor.js') }}"></script>
@endsection