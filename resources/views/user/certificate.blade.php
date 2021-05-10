@php
use App\Http\Controllers\Globals as Utils;
use App\Models\User;
$user = $investment->user;
$interest = Utils::getInterests($investment->tenor." ".$investment->tenor_type, $investment->amount, $investment->interests);
$tax = $investment->tax;
$data = $user->user_data();
@endphp
<!DOCTYPE html>
<html>
	<head>
		<style>
			body {
				border: 2px solid #000;
				padding: 25px;
				margin: 25px;
				font-family: calibri;
				font-size: 0.6em;
			}
			.inline {
				display: inline-block;
				vertical-align: top;
			}
			.logo {
				margin-bottom: 4em;

			}
			.address {
				float:right;
				font-weight: bolder;
				font-size: 0.8em;
			}
			.email {
				color: #1D9DDC;
			}
			.title {
				text-align: center;
			}
			table.form {
				border-collapse: collapse;
				margin: 25px 0;
				width: 90%;
			}
			table tr th {
				text-align: left;
				font-weight: lighter;
				margin-bottom: 20px;
			}
			.input {
				border: 1px solid #000;
				padding: 5px 7px;
				margin-right: 20px;
				font-size: 0.8em;
			}
			.width {
				width: 263px;
			}
			.line {
				height: 2px;
				width: 200px;
				min-width: 90px;
				border-bottom: 1px solid #222; position: 20px;
				
			}
			.dlt {
				float: right; position: 20px;
			}
		
		</style>
	</head>
	<body>
		<div style="width: 100%;font-family: sans-serif;">
			<div class="head">
				<div class="logo inline"><img src="{{ env('APP_URL').'/logo.png' }}"></div>
				<div class="address inline">4<sup>th</sup> , NIS Building,<br>ASSBIFI Road, Central Business District,<br>Alausa, Ikeja<br>Lagos, Nigeria.<br>Tel: 0700-9090-9090; 08115838889;<br>08092971111; 07087007052; 09030001071<br>E-mail: <span class="email">info@bridgecredit.com.ng</span><br>Website: <span class="email">www.bridgecredit.com.ng</span></div>
			</div>
			<h1 class="title">BRIDGE CREDIT PRIVATE NOTE</h1>
			<table class="form">
				<tr>
					<th>Date:</th>
					<th><div class="input">{{ date('d-m-Y', strtotime($investment->created_at)) }}</div></th>
				</tr>
				<tr>
					<td>Name of Subscriber:</td>
					<td><div class="input">{{ strtoupper($user->firstname.' '.$user->othername.' '.$user->lastname) }}</div></td>
				</tr>
				<tr>
					<td>Address:</td>
					<td><div class="input">{{ strtoupper($data->address) }}</div></td>
				</tr>
				<tr>
					<td></td>
					<td><div class="input">{{ strtoupper($data->city) }}</div></td>
				</tr>
				<tr>
					<td></td>
					<td><div class="input">{{ strtoupper($data->state.', '.$data->country) }}</div></td>
				</tr>
				<tr>
					<td>Note Number:</td>
					<td><div class="input">{{ $investment->note_number }}</div></td>
				</tr>
			</table>
			<div class="salutation">
				Dear Sir / Madam,<br><br>
				Please find below details of your subscription to Bridge Credit Private Note:
			</div>
			<table class="form">
				<tr>
					<td>Amount Subscribed:</td>
					<td><div class="input inline">NGN</div><div class="input inline width">{{ number_format($investment->amount) }}</div></td>
				</tr>
				<tr>
					<td>Start Date:</td>
					<td><div class="input">{{ date('d-m-Y', strtotime($investment->date_approved)) }}</div></td>
				</tr>
				<tr>
					<td>Maturity Date:</td>
					<td><div class="input">{{ date('d-m-Y', strtotime($investment->maturity_date)) }}</div></td>
				</tr>
				<tr>
					<td>Note Payback Date:</td>
					@php
					$date = new DateTime($investment->maturity_date);
		    		$date->modify('+1 day');
					@endphp
					<td><div class="input">{{ $date->format('d-m-Y') }}</div></td>
				</tr>
				<tr>
					<td>Period:</td>
					@php
					$start = strtotime($investment->date_approved);
		            $end = strtotime($investment->maturity_date);
		            $days_between = ceil(abs($end - $start) / 86400);
					@endphp
					<td><div class="input">{{ $days_between }} DAYS</div></td>
				</tr>
				<tr>
					<td>Interest Rate:</td>
					<td><div class="input">{{ $investment->interest }}% p.a</div></td>
				</tr>
				<tr>
					<td>Interest Payment:</td>
					<td><div class="input">{{ ucwords($investment->payment_type) }}</div></td>
				</tr>
				<tr>
					<td>Witholding Tax:</td>
					<td><div class="input inline">NGN</div><div class="input inline width">{{ number_format($tax,2) }}</div></td>
				</tr>
				<tr>
					<td>Interest Value:</td>
					<td><div class="input inline">NGN</div><div class="input inline width">{{ number_format(Utils::getExpectedGrowth($investment),2) }}</div></td>
				</tr>
				<tr>
					<td>Payback Value:</td>
					<td><div class="input inline">NGN</div><div class="input inline width">{{ number_format(Utils::getExpectedGrowth($investment) + $investment->amount,2) }}</div></td>
				</tr>
			</table>
			<div class="salutation">
				This Note cannot be paid before the due date.<br><br><br>
				Extension of period (if necessary) would be agreed by both parties.<br><br>Thank you for your confidence in us<br>
				<br>Yours faithfully<br>
				<div class="sign inline">
					For: BRIDGE CREDIT LIMITED<br><br><br>
					<div class="line">
						<span style="visibility: hidden;">my name is babatunde ayokunmi dawodu</span>
					</div>
					<br>
					<div class="auto">Authorized Signatory</div>
				</div>
				<div class="sign inline dlt">
					<br><br>
					<div class="line">
						<span style="visibility: hidden;">my name is babatunde ayokunmi dawodu</span>
					</div>
					<br>
					<div class="auto">Authorized Signatory</div>
				</div>
			</div>
		</div>
	</body>
</html>