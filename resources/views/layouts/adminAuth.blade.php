@php
use App\Http\Controllers\Globals as Utils;
Utils::matureInvestment();
@endphp
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
		<title>Bridge Credit Limited - @yield('title')</title>
		<link rel="stylesheet" href="{{ asset('assets_admin/css/app.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets_admin/bundles/bootstrap-social/bootstrap-social.css') }}">
		<link rel="stylesheet" href="{{ asset('assets_admin/css/style.css') }}">
		<link rel="stylesheet" href="{{ asset('assets_admin/css/components.css') }}">
		<link rel="shortcut icon" href="https://bridgecredit.com.ng/wp-content/uploads/2017/04/favyi-1.png" type="image/x-icon">
	    <link rel="icon" href="https://bridgecredit.com.ng/wp-content/uploads/2017/04/favyi-1.png" type="image/x-icon">
	    <link rel="stylesheet" href="{{ asset('assets_admin/bundles/select2/dist/css/select2.min.css') }}">
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	    <meta name="csrf-token" content="{{ csrf_token() }}">
	</head>
	<body class="background-image-body">
		<div class="loader"></div>
		<div id="app">
			<section class="section">
				<div class="container mt-5">
					<div class="row">
						<div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
							<div class="login-brand login-brand-color">
								<img alt="image" src="{{ asset('logo.png') }}" />
							</div>
							@yield('content')
						</div>
					</div>
				</div>
			</section>
		</div>
		<script src="{{ asset('assets_admin/js/app.min.js') }}"></script>
		<script src="{{ asset('assets_admin/js/scripts.js') }}"></script>
		<script src="{{ asset('assets_admin/bundles/select2/dist/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('assets_admin/bundles/jquery.sparkline.min.js') }}"></script>
		<script src="{{ asset('assets_admin/js/page/forms-advanced-forms.js') }}"></script>
	</body>
</html>