<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminNotification;
use App\Models\Notification;
use App\Models\Investment;
use App\Mail\UserMail;
use App\Models\User;
use App\Models\Payout;
use Mail;
use Auth;
use App\Models\Kin;
use App\Models\Plan;

class Globals extends Controller
{
    public static function getUser(){
        return Auth::user();
    }

    public static function getAdmin(){
        return Auth::guard('admin')->user();
    }

    public static function getNotifications($limit = 5){
        $user = self::getUser();
        return Notification::where(['user'=>$user, 'status'=>'unread'])->orderBy('id', 'asc')->limit($limit)->get();
    }

    public static function getAdminNotifications($limit = 5){
        return AdminNotification::where('status', 'unread')->orderBy('id', 'asc')->limit($limit)->get();
    }

    public static function convertTime($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    public static function getActivities($user){
        return Activity::where('staff', $user->email)->orderBy('id', 'desc')->get();
    }

    public static function getTasks($user){
        $tasks = Task::orderBy('id', 'desc')->get();
        $return = array();
        foreach($tasks as $task){
            foreach(json_decode($task->users) as $using){
                if($using == $user->email){
                    $return[] = $task->id;
                }
            }
        }
        return $return;
    }

    public static function userPartTask($user, $task){
        $task = Task::where('id', $task)->first();
        $return = false;
        foreach(json_decode($task->users) as $using){
            if($using == $user->email){
                $return = true;
            }
        }
        return $return;
    }

    public static function getTask($id){
        return Task::where('id', $id)->first();
    }

    public static function getCreatedTasks($user){
        return Task::where('staff', $user->email)->get();
    }

    public static function getBadge($status){
        $return = '';
        if($status == 'pending'){
            $return .= '<span class="badge badge-warning">Pending</span>';
        }else if($status == 'active'){
            $return .= '<span class="badge badge-primary">Active</span>';
        }else if($status == 'declined'){
            $return .= '<span class="badge badge-danger">Declined</span>';
        }else if($status == 'matured'){
            $return .= '<span class="badge badge-success">Matured</span>';
        }

        return $return;
    }

    public static function getBg($status){
        $return = '';
        if($status < 10){
            $return .= 'bg-danger';
        }else if($status > 9 && $status < 30){
            $return .= 'bg-warning';
        }else if($status > 29 && $status < 50){
            $return .= 'bg-secondary';
        }else if($status > 49 && $status < 75){
            $return .= 'bg-info';
        }else if($status > 74 && $status < 99){
            $return .= 'bg-primary';
        }else if($status > 99){
            $return .= 'bg-success';
        }

        return $return;
    }

    public static function removeSpaces($name){
        return str_replace(' ', '-', $name);
    }

    public static function previewer($file){
        $dfile = explode('.', $file);
        $key = count($dfile)-1;
        $ext = $dfile[$key];
        $return = '';
        if($ext == 'txt'){
            $return .= asset($file);
        }else if($ext == 'doc'){
            $return .= "https://view.officeapps.live.com/op/view.aspx?src=".env('APP_URL').'/'.$file;
        }else if($ext == 'docx'){
            $return .= "https://view.officeapps.live.com/op/view.aspx?src=".env('APP_URL').'/'.$file;
        }else if($ext == 'xls'){
            $return .= "https://view.officeapps.live.com/op/view.aspx?src=".env('APP_URL').'/'.$file;
        }else if($ext == 'xlsx'){
            $return .= "https://view.officeapps.live.com/op/view.aspx?src=".env('APP_URL').'/'.$file;
        }else if($ext == 'pdf'){
            $return .= env('APP_URL').'/'.$file;
        }else{
            $return .= 'nil';
        }
        return $return;
    }

    public static function removeSpacesNTabs($string){
        return preg_replace( "/\r|\n/", "", preg_replace( "/\t/", "",$string));
    }

    public static function getPlan($plan){
        return Plan::where('id', $plan)->first();
    }

    public static function matureInvestment(){
        $investments = Investment::where('status', 'active')->latest()->get();
        foreach($investments as $investment){
            $user = $investment->user;
            if($investment->payment_type == "Maturity"){
                $start = $investment->date_approved;
                $end = $investment->maturity_date;
                if(now()->gt($end)){
                    $investment->update(['status'=>'matured']);
                    $total = $investment->amount * ($investment->interest/100);
                    $investment->payouts()->save(new Payout(['amount'=>$total, 'status'=>'pending']));
                    $my_msg = [
                        'name'=>ucwords($user->firstname ?? ''),
                        'subject'=>'INVESTMENT MATURED',
                        'message_1'=>'Your investment of <strong>₦'.number_format($investment->amount,2).'</strong> and tenor of <strong>'.$investment->tenor.' '.strtoupper($investment->tenor_type).'</strong>is now matured and due for cashing out.',
                        'message_2'=>'Please click on the button above or copy the link below into a browser to view.<br/><br/><br/>'.url('/dashboard/investments/view/'.$investment->id),
                        'action'=>true,
                        'action_link'=>url('/dashboard/investments/view/'.$investment->id),
                        'action_title'=>'View Investment',
                    ];
                    Mail::to($user->email)->send(new UserMail($my_msg));
                }
            }else {
                $payouts = $investment->payouts()->count();
                $remaining = self::getRemainInterestPay(self::getTenor($investment->tenor." ".$investment->tenor_type), $investment->payment_type);
                $paydiff = $remaining - $payouts;
                if($paydiff == 1){
                    $start = strtotime($investment->date_approved);
                    $end = strtotime($investment->maturity_date);
                    $days_between = ceil(abs($end - $start) / 86400);
                    $current = time();
                    $days_now = ceil(abs($current - $start) / 86400);
                    $diff = $days_between - $days_now;
                    if($diff < 1){
                        Investment::where('id', $investment->id)->update(['status'=>'matured']);
                        Payout::create(['investment_id'=>$investment->id, 'amount'=>self::getInterestPayout($investment), 'status'=>'pending']);
                        $my_msg = [
                            'name'=>ucwords($user->firstname ?? ''),
                            'subject'=>'INVESTMENT MATURED',
                            'message_1'=>'Your investment of <strong>₦'.number_format($investment->amount,2).'</strong> and tenor of <strong>'.$investment->tenor.' '.strtoupper($investment->tenor_type).' with '.strtoupper($investment->payment_type).' payment type </strong>is now fully matured and due for cashing out.',
                            'message_2'=>'Please click on the button above or copy the link below into a browser to view.<br/><br/><br/>'.url('/dashboard/investments/view/'.$investment->id),
                            'action'=>true,
                            'action_link'=>url('/dashboard/investments/view/'.$investment->id),
                            'action_title'=>'View Investment',
                        ];
                        Mail::to($user->email)->send(new UserMail($my_msg));
                    }
                }else {
                    if($investment->payment_type == "Monthly"){
                        $start = strtotime($investment->date_approved);
                        $added = $payouts+1;
                        $end = strtotime("+".$added." months", strtotime($investment->date_approved));
                        $days_between = ceil(abs($end - $start) / 86400);
                        $current = time();
                        $days_now = ceil(abs($current - $start) / 86400);
                        $diff = $days_between - $days_now;
                        if($diff < 1){
                            Payout::create(['investment_id'=>$investment->id, 'amount'=>self::getInterestPayout($investment), 'status'=>'pending']);
                            $my_msg = [
                                'name'=>ucwords($user->firstname ?? ''),
                                'subject'=>'INVESTMENT MATURED',
                                'message_1'=>'Your investment of <strong>₦'.number_format($investment->amount,2).'</strong> and tenor of <strong>'.$investment->tenor.' '.strtoupper($investment->tenor_type).' </strong>is matured for interest payout <strong>No'.$added.'</strong> based on your payment setting of <strong>'.strtoupper($investment->payment_type).' payment</strong>',
                                'message_2'=>'Please click on the button above or copy the link below into a browser to view.<br/><br/><br/>'.url('/dashboard/investments/view/'.$investment->id),
                                'action'=>true,
                                'action_link'=>url('/dashboard/investments/view/'.$investment->id),
                                'action_title'=>'View Investment',
                            ];
                            Mail::to($user->email)->send(new UserMail($my_msg));
                        }
                    }else if($investment->payment_type == "Quarterly"){
                        $start = strtotime($investment->date_approved);
                        $added = ($payouts*3)+3;
                        $end = strtotime("+".$added." months", strtotime($investment->date_approved));
                        $days_between = ceil(abs($end - $start) / 86400);
                        $current = time();
                        $days_now = ceil(abs($current - $start) / 86400);
                        $diff = $days_between - $days_now;
                        $plus = $payouts + 1;
                        if($diff < 1){
                            Payout::create(['investment_id'=>$investment->id, 'amount'=>self::getInterestPayout($investment), 'status'=>'pending']);
                            $my_msg = [
                                'name'=>ucwords($user->firstname ?? ''),
                                'subject'=>'INVESTMENT MATURED',
                                'message_1'=>'Your investment of <strong>₦'.number_format($investment->amount,2).'</strong> and tenor of <strong>'.$investment->tenor.' '.strtoupper($investment->tenor_type).' </strong>is matured for interest payout <strong>No'.$plus.'</strong> based on your payment setting of <strong>'.strtoupper($investment->payment_type).' payment</strong>',
                                'message_2'=>'Please click on the button above or copy the link below into a browser to view.<br/><br/><br/>'.url('/dashboard/investments/view/'.$investment->id),
                                'action'=>true,
                                'action_link'=>url('/dashboard/investments/view/'.$investment->id),
                                'action_title'=>'View Investment',
                            ];
                            Mail::to($user->email)->send(new UserMail($my_msg));
                        }
                    }else if($investment->payment_type == "Semi Annually"){
                        $start = strtotime($investment->date_approved);
                        $added = ($payouts*6)+6;
                        $end = strtotime("+".$added." months", strtotime($investment->date_approved));
                        $days_between = ceil(abs($end - $start) / 86400);
                        $current = time();
                        $days_now = ceil(abs($current - $start) / 86400);
                        $diff = $days_between - $days_now;
                        $plus = $payouts + 1;
                        if($diff < 1){
                            Payout::create(['investment_id'=>$investment->id, 'amount'=>self::getInterestPayout($investment), 'status'=>'pending']);
                            $my_msg = [
                                'name'=>ucwords($user->firstname ?? ''),
                                'subject'=>'INVESTMENT MATURED',
                                'message_1'=>'Your investment of <strong>₦'.number_format($investment->amount,2).'</strong> and tenor of <strong>'.$investment->tenor.' '.strtoupper($investment->tenor_type).' </strong>is matured for interest payout <strong>No'.$plus.'</strong> based on your payment setting of <strong>'.strtoupper($investment->payment_type).' payment</strong>',
                                'message_2'=>'Please click on the button above or copy the link below into a browser to view.<br/><br/><br/>'.url('/dashboard/investments/view/'.$investment->id),
                                'action'=>true,
                                'action_link'=>url('/dashboard/investments/view/'.$investment->id),
                                'action_title'=>'View Investment',
                            ];
                            Mail::to($user->email)->send(new UserMail($my_msg));
                        }
                    }
                }
            }
        }
    }
    
    public static function getDraw($draw){
        $value = ($draw - 1)*10;
        return $value;
    }

    public static function getInvestmentGrowth($investment){
        $val = 0;
        if($investment->status == 'matured'){
            $val += 100;
        }else if($investment->status == 'active'){
            $start = strtotime($investment->date_approved);
            $end = strtotime($investment->maturity_date);
            $days_between = ceil(abs($end - $start) / 86400);
            $current = time();
            $days_now = ceil(abs($current - $start) / 86400);
            $val += ($days_now / $days_between) * 100;
        }
        return $val;
    }

    public static function getExpectedGrowth($investment){
        $user = self::getUser();
        $daily = $investment->interest / 365;
        $my_int = self::getTenor($investment->tenor." ".$investment->tenor_type) * ($daily / 100);
        $val = $my_int * $investment->amount;
        return $val;
    }

    public static function getInvestors($plan, $order = 'asc'){
        $investments = Investment::where('plan', $plan)->orderBy('id', $order)->get();
        return $investments;
    }

    public static function getInterests($tenor, $amount, $plan_interest){
        $daily_interest = $plan_interest / 365;
        $interest = ($amount * $daily_interest) / 100;
        return $interest * self::getTenor($tenor);
    }

    public static function getWitholdingTax($plan_tax, $interest){
        $tax = ($interest * $plan_tax) / 100;
        return $tax;
    }

    public static function getTenor($param){
        $tenor = explode(" ", $param);
        $response = '';
        if($tenor[1] == "days" || $tenor[1] == "day"){
            $response = $tenor[0];
        }elseif($tenor[1] == "years" || $tenor[1] == "year"){
            $response = $tenor[0]*365;
        }
        return $response;
    }

    public static function getTenorArray($param){
        $tenor = explode(" ", $param);
        return $tenor;
    }

    public static function convertToMonth($param){
        $month = $param / 30;
        $month = floor($month);
        return $month;
    }

    public static function getRemainInterestPay($days, $pay_type){
        $months = self::convertToMonth($days);
        $return = 0;
        if($pay_type == "Monthly"){
            $return += $months;
        }else if($pay_type == "Quarterly"){
            $return += $months / 3;
        }else if($pay_type == "Semi Annually"){
            $return += $months / 6;
        }else if($pay_type == "Maturity"){
            $return += $months / $months;
        }
        return $return;
    }

    public static function addMonths($pay_type){
        $return = 0;
        if($pay_type == "Monthly"){
            $return += 1;
        }else if($pay_type == "Quarterly"){
            $return += 3;
        }else if($pay_type == "Semi Annually"){
            $return += 6;
        }
        return $return;
    }

    public static function getInterestPayout($investment){
        $months = self::convertToMonth(self::getTenor($investment->tenor." ".$investment->tenor_type));
        $divisor = $months / self::addMonths($investment->payment_type);
        $interests = self::getInterests($investment->tenor." ".$investment->tenor_type, $investment->amount, $investment->interest);
        return $interests / $divisor;
    }

    public static function randomId($table, $column){
        $id = \random_int(100000, 999999);
        $validator = \Validator::make([$column=>$id],[$column=>'unique:'.$table]);
        if($validator->fails()){
            return $this->randomId();
        }
        return $id;
    }


}
