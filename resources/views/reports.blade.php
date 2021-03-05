@php
use App\Http\Controllers\Globals as Utils;
use Illuminate\Support\Facades\DB;
$range = explode(' - ', urldecode($_GET['daterange']));
$date1 = explode('/', $range[0]);
$date2 = explode('/', $range[1]);
$ddate1 = $date1[2].'-'.$date1[0].'-'.$date1[1];
$ddate2 = $date2[2].'-'.$date2[0].'-'.$date2[1];
$data = array();
$invs = DB::table('investments')->whereBetween('created_at', [$ddate1, $ddate2])->orderBy('id', 'asc')->get();
$i =1;
foreach ($invs as $inv) {
    $user = DB::table('users')->where('email', $inv->user)->first();
    $plan = Utils::getPlan($inv->plan);
    $interest = Utils::getInterests($inv->tenor." ".$inv->tenor_type, $inv->amount, $plan->interests);
    $nestedData['sn'] = $i++;
    $nestedData['name'] =  strtoupper($user->firstname.' '.$user->lastname.' '.$user->othername);
    $nestedData['note_no'] = $inv->note_number;
    $nestedData['amount'] = number_format($inv->amount, 2);
    $nestedData['interest_rate'] = $plan->interests;
    $nestedData['tenor'] = $inv->tenor.' '.strtoupper($inv->tenor_type);
    $nestedData['interests'] = number_format($interest, 2);
    $nestedData['total_payment'] = number_format($inv->amount + $interest);
    $nestedData['maturity_date'] = $inv->maturity_date != null ? date('F d, Y :: h:i A', strtotime($inv->maturity_date)) : 'pending';
    $nestedData['payment_type'] = strtoupper($inv->payment_type);
    $nestedData['interest_payout'] = number_format($interest / Utils::addMonths($inv->payment_type),2);
    $nestedData['witholding_tax'] = number_format(Utils::getWitholdingTax($plan->witholding_tax, $interest), 2);
    $data[] = $nestedData;
}
@endphp
<table>
    <thead>
        <tr>
            <th><strong>S/N</strong></th>
            <th><strong>Name Of Customer</strong></th>
            <th><strong>Note Number</strong></th>
            <th><strong>Investment Amount (₦)</strong></th>
            <th><strong>Interest Rate %</strong></th>
            <th><strong>Tenor</strong></th>
            <th><strong>Interest Value (₦)</strong></th>
            <th><strong>Total Payment (₦)</strong></th>
            <th><strong>Maturity Date</strong></th>
            <th><strong>Payment Type</strong></th>
            <th><strong>Interest Payout Amount</strong></th>
            <th><strong>Witholding Tax (₦)</strong></th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $current)
        <tr>
            <td>{{ $current['sn'] }}</td>
            <td>{{ $current['name'] }}</td>
            <td>{{ $current['note_no'] }}</td>
            <td>{{ $current['amount'] }}</td>
            <td>{{ $current['interest_rate'] }}</td>
            <td>{{ $current['tenor'] }}</td>
            <td>{{ $current['interests'] }}</td>
            <td>{{ $current['total_payment'] }}</td>
            <td>{{ $current['maturity_date'] }}</td>
            <td>{{ $current['payment_type'] }}</td>
            <td>{{ $current['interest_payout'] }}</td>
            <td>{{ $current['witholding_tax'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>