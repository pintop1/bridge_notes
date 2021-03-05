<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Investment;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserData;
use App\Models\Notification;
use App\Http\Controllers\Globals as Utils;
use Mail;
use App\Mail\UserMail;
use PDF;
use Auth;

class HomeController extends Controller
{
    public function investments(){
        $user = Auth::user();
        $data['entities'] = $user->investments()->latest()->get();
    	return view('user.investments', $data);
    }

    public function viewInvestment($id){
    	$investment = Investment::where('id', $id)->first();
    	return view('user.single_investment', compact('investment'));
    }

    public function payoutNow($id){
    	$investment = Investment::find($id);
    	$user = $investment->user;
    	if($investment->status != 'matured'){
    		return redirect()->back()->with('message', '<div class="alert alert-danger alert-dismissible alert-has-icon show fade"><div class="alert-icon"><i class="fas fa-exclamation-triangle"></i></div><div class="alert-body"><button class="close" data-dismiss="alert"><span>&times;</span></button>This investment is not yet matured for cashout.</div></div>');
    	}elseif($investment->payout == 'requested') {
    		return redirect()->back()->with('message', '<div class="alert alert-danger alert-dismissible alert-has-icon show fade"><div class="alert-icon"><i class="fas fa-exclamation-triangle"></i></div><div class="alert-body"><button class="close" data-dismiss="alert"><span>&times;</span></button>You have already requested a cash out on this investment. Please wait while admin attend to.</div></div>');
    	}elseif($investment->payout == 'paid') {
    		return redirect()->back()->with('message', '<div class="alert alert-danger alert-dismissible alert-has-icon show fade"><div class="alert-icon"><i class="fas fa-exclamation-triangle"></i></div><div class="alert-body"><button class="close" data-dismiss="alert"><span>&times;</span></button>You have already been paid for this investment.</div></div>');
    	}else{
    		$investment->update([
    			'payout'=>'requested',
    		]);
    		$my_msg = [
                'name'=>$user->fullname(),
                'subject'=>'CASHOUT REQUEST',
                'message_1'=>'You have requested a cashout on your investment of <strong>₦'.number_format($investment->amount,2).'</strong> and tenor of <strong>'.$investment->tenor.' '.strtoupper($investment->tenor_type).'</strong>. Your payout will be processed shortly.',
                'message_2'=>'Please click on the button above or copy the link below into a browser to view.<br/><br/><br/>'.url('/dashboard/investments/view/'.$investment->id),
                'action'=>true,
                'action_link'=>url('/dashboard/investments/view/'.$investment->id),
                'action_title'=>'View Investment',
            ];
            Mail::to($user->email)->send(new UserMail($my_msg));
    		return redirect()->back()->with('message', '<div class="alert alert-success alert-dismissible alert-has-icon show fade"><div class="alert-icon"><i class="fas fa-check-double"></i></div><div class="alert-body"><button class="close" data-dismiss="alert"><span>&times;</span></button>Your investment has been booked for payout.</div></div>');
    	}
    }

    public function previewInvest($id){
        $user = Utils::getUser();
        $investment = Investment::where('id', $id)->first();
        $saveName = 'generated/'.uniqid().'_'.time().'_'.mt_rand(000000,999999).'.pdf';
        $pdf = PDF::loadView('user.certificate', compact('investment'))->save($saveName);
        $header = Utils::previewer($saveName);
        return view('previewer', ['file'=>$header]);
    }

    
}
