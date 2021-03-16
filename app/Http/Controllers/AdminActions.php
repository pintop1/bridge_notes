<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Investment;
use App\Models\Transaction;
use App\Models\Admin;
use App\Models\User;
use App\Models\UserData;
use App\Models\Kin;
use App\Models\Payout;
use App\Http\Controllers\Globals as Utils;
use Mail;
use App\Mail\UserMail;
use DateTime;
use Validator;
use Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exports\ReportExports;
use Excel;
use App\Traits\FileUploadManager;

class AdminActions extends Controller
{
    use FileUploadManager;

    public function dashboard(){
        $data['investments'] = Investment::sum('amount');
        $data['active_investments'] = Investment::where('status', 'active')->sum('amount');
        $data['users'] = User::where('is_admin', false)->count();
        $data['payouts'] = Investment::where('payout', 'paid')->sum('amount');
        return view('admin.dashboard', $data);
    }

    public function create_user()
    {
        return view('admin.add_user');
    }

    public function store_user(Request $request)
    {
        Validator::make($request->all(), [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'type' => ['required', 'string', 'max:255'],
        ])->validate();

        User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'email_verified_at'=>now(),
            'password' => Hash::make('notes@2021'),
            'account_type' => $request->type,
        ]);
        return redirect('/admin/users')->with('message', '<div class="alert alert-success alert-dismissible alert-has-icon show fade"><div class="alert-icon"><i class="fas fa-check-double"></i></div><div class="alert-body"><button class="close" data-dismiss="alert"><span>&times;</span></button>User entries successfully created</div></div>');
    }

    public function active_users(){
        $data['users'] = User::where('email_verified_at', '!=', null)->where('is_admin', false)->latest()->get();
        return view('admin.active_users', $data);
    }

    public function userDeleteContent($id){
        $url = url('/admin/users/delete/'.$id);
        $action = "<script>swal({ title: 'Are you sure?', text: 'Please note that this action cannot be reverted!', icon: 'warning', buttons: true, dangerMode: true,}).then((willDelete) => { if (willDelete) { window.location = '".$url."' } else {swal('Your action has been cancelled');}});</script>";
        echo $action;
    }

    public function deleteUser($id){
        $user = User::find($id);
        $user->investments()->delete();
        $user->kin()->delete();
        $user->transactions()->delete();
        return redirect()->back()->with('message', '<div class="alert alert-success alert-dismissible alert-has-icon show fade"><div class="alert-icon"><i class="fas fa-check-double"></i></div><div class="alert-body"><button class="close" data-dismiss="alert"><span>&times;</span></button>User entries successfully deleted</div></div>');
    }

    public function viewUser($id){
        $data['user'] = User::find($id);
        return view('admin.viewUser', $data);
    }

    public function multipleDelete(Request $req){
        foreach($req->selection as $id){
            $user = User::find($id);
            $user->investments()->delete();
            $user->kin()->delete();
            $user->transactions()->delete();
        }
        return redirect()->back()->with('message', '<div class="alert alert-success alert-dismissible alert-has-icon show fade"><div class="alert-icon"><i class="fas fa-check-double"></i></div><div class="alert-body"><button class="close" data-dismiss="alert"><span>&times;</span></button>All selected entries successfully deleted</div></div>');
    }


    public function update(Request $req){
        $user = User::find($req->user);
        $data = $request->only(['firstname', 'lastname', 'othername', 'mobile']);
        if($user->account_type == "Cooperate") $data['company'] = $request->only(['company_name', 'rc_number', 'tin', 'c_address']);
        if($request->hasFile('photo')){
            if($user->profile_photo_path != null)
                $this->deleteSingle($user->profile_photo_path);
            $data['profile_photo_path'] = $this->uploadSingle($request->photo, 'profile-photos');
        }
        $user->update($data);
        return redirect()->back()->with('message', '<div class="alert alert-success alert-dismissible alert-has-icon show fade"><div class="alert-icon"><i class="fas fa-check-double"></i></div><div class="alert-body"><button class="close" data-dismiss="alert"><span>&times;</span></button>Your update was successful.</div></div>');
    }

    public function updateInfo(Request $req){
        $user = User::find($req->user);
        $data = $request->except(['_token', 'user']);
        $user->update(['user_data'=>$data]);
        return redirect()->back()->with('message', '<div class="alert alert-success alert-dismissible alert-has-icon show fade"><div class="alert-icon"><i class="fas fa-check-double"></i></div><div class="alert-body"><button class="close" data-dismiss="alert"><span>&times;</span></button>Your update was successful.</div></div>');
    }

    public function updateKin(Request $req){
        $user = User::find($req->user);
        $data = $request->except(['_token', 'user']);
        if($user->kin) $user->kin()->update($data);
        else $user->kin()->save(new Kin($data));
        return redirect()->back()->with('message', '<div class="alert alert-success alert-dismissible alert-has-icon show fade"><div class="alert-icon"><i class="fas fa-check-double"></i></div><div class="alert-body"><button class="close" data-dismiss="alert"><span>&times;</span></button>Your update was successful.</div></div>');
    }

    public function updatePassword(Request $req){
        $user = User::find($req->user);
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'confirmed', 'string'],
        ])->after(function ($validator) use ($user, $request) {
            if (! \Hash::check($request->current_password, $user->password)) {
                $validator->errors()->add('current_password', __('The provided password does not match your current password.'));
            }
        });
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user->update([
            'password' => \Hash::make($request->password),
        ]);
        return redirect()->back()->with('message', '<div class="alert alert-success alert-dismissible alert-has-icon show fade"><div class="alert-icon"><i class="fas fa-check-double"></i></div><div class="alert-body"><button class="close" data-dismiss="alert"><span>&times;</span></button>Your update was successful.</div></div>');
    }

    public function activeInvestment(){
        $data['entities'] = Investment::where('status', 'active')->latest()->get();
        return view('admin.activeInvestments', $data);
    }

    public function allInvestments(){
        $data['entities'] = Investment::latest()->get();
        return view('admin.allInvestments', $data);
    }

    public function maturedInvestments(){
        $data['entities'] = Investment::where('status', 'matured')->latest()->get();
        return view('admin.maturedInvestments', $data);
    }

    public function declinedInvestments(){
        $data['entities'] = Investment::where('status', 'declined')->latest()->get();
        return view('admin.declinedInvestments', $data);
    }

    public function pendingInvestments(){
        $data['entities'] = Investment::where('status', 'pending')->latest()->get();
        return view('admin.pendingInvestments', $data);
    }

    public function viewInvestment($id){
        $investment = Investment::where('id', $id)->first();
        return view('admin.single_investment', compact('investment'));
    }

    public function previewInvest($id){
        $investment = Investment::where('id', $id)->first();
        $user = User::where('email', $investment->user)->first();
        $saveName = 'generated/'.uniqid().'_'.time().'_'.mt_rand(000000,999999).'.pdf';
        $pdf = PDF::loadView('user.certificate', compact('investment'))->save($saveName);
        $header = Utils::previewer($saveName);
        return view('previewer', ['file'=>$header]);
    } 

    public function pendingPayouts(){
        $payouts = Investment::where([['status', 'matured'], ['payout', 'requested']])->orderBy('updated_at', 'desc')->get();
        return view('admin.pendingPay', compact('payouts'));
    }

    public function payTrans($id){
        $investment = Investment::find($id);
        $user = $investment->user;
        $investment->update([
            'payout'=>'paid',
        ]);
        $my_msg = [
            'name'=>$user->fullname(),
            'subject'=>'INVESTMENT PAID',
            'message_1'=>'Your investment of <strong>₦'.number_format($investment->amount,2).'</strong> and tenor of <strong>'.$investment->tenor.' '.strtoupper($investment->tenor_type).'</strong> has been Paid successfully.',
            'message_2'=>'Please click on the button above or copy the link below into a browser to view.<br/><br/><br/>'.url('/dashboard/investments/view/'.$investment->id),
            'action'=>true,
            'action_link'=>url('/dashboard/investments/view/'.$investment->id),
            'action_title'=>'View Investment',
        ];
        Mail::to($user->email)->send(new UserMail($my_msg));
        return redirect()->back()->with('message', '<div class="alert alert-success alert-dismissible alert-has-icon show fade"><div class="alert-icon"><i class="fas fa-check-double"></i></div><div class="alert-body"><button class="close" data-dismiss="alert"><span>&times;</span></button>Investment successfully declined.</div></div>');
    }

    public function paidTrans(){
        $data['entities'] = Investment::where('payout', 'paid')->latest()->get();
        return view('admin.paidInvests', $data);
    }

    public function profile(){
        $user = Utils::getAdmin();
        return view('admin.profile', compact('user'));
    }

    public function updateMy(Request $req){
        $user = Utils::getUser();
        if ($files = $req->file('photo')) {
            $destinationPath = 'uploads/profile-photo'; 
            $dimagename = $files->getClientOriginalName();
            $filename = pathinfo($dimagename, PATHINFO_FILENAME);
            $extension = pathinfo($dimagename, PATHINFO_EXTENSION);
            $dfile = uniqid().'_'.time().'_'.mt_rand(000000,999999).'_'.Utils::removeSpaces($filename).'.'.$extension;
            $files->move($destinationPath, $dfile);
            Admin::where('email', $user->email)->update([
                'profile_photo_path'=>$destinationPath.'/'.$dfile,
            ]);
        }
        Admin::where('email', $user->email)->update([
            'firstname'=>$req->firstname,
            'lastname'=>$req->lastname, 
            'othername'=>$req->othername, 
            'mobile'=>$req->mobile,
        ]);
        return redirect()->back()->with('message', '<div class="alert alert-success alert-dismissible alert-has-icon show fade"><div class="alert-icon"><i class="fas fa-check-double"></i></div><div class="alert-body"><button class="close" data-dismiss="alert"><span>&times;</span></button>Your update was successful.</div></div>');
    }

    public function updatePasswordMy(Request $req){
        $user = Utils::getAdmin();
        $input = $req->toArray();
        Validator::make($input, [
            'password' => ['required', 'confirmed', 'string'],
        ]);
        Admin::where('email', $user->email)->update([
            'password' => Hash::make($input['password']),
        ]);
        return redirect()->back()->with('message', '<div class="alert alert-success alert-dismissible alert-has-icon show fade"><div class="alert-icon"><i class="fas fa-check-double"></i></div><div class="alert-body"><button class="close" data-dismiss="alert"><span>&times;</span></button>Your update was successful.</div></div>');
    }

    public function pendingInterest(){
        $payouts = Payout::where('status', 'pending')->orderBy('id', 'asc')->get();
        return view('admin.pendingInterest', compact('payouts'));
    }

    public function reports(){
        return view('admin.reports');
    }

    public function reportPost(Request $req){
        $saveName = date('Generated_on_F_Y_').'Investments_Report.xlsx';
        return Excel::download(new ReportExports, $saveName);
    }

    public function payInterests($id){
        $payout = Payout::find($id);
        $investment = $payout->investment;
        $user = $investment->user;
        $payout->update([
            'status'=>'paid',
        ]);
        $my_msg = [
            'name'=>ucwords($user->firstname.' '.$user->lastname),
            'subject'=>'INTEREST PAID',
            'message_1'=>'Interest on your investment of <strong>₦'.number_format($investment->amount,2).'</strong> and tenor of <strong>'.$investment->tenor.' '.strtoupper($investment->tenor_type).'</strong> has been Paid successfully.',
            'message_2'=>'Please click on the button above or copy the link below into a browser to view.<br/><br/><br/>'.url('/dashboard/investments/view/'.$investment->id),
            'action'=>true,
            'action_link'=>url('/dashboard/investments/view/'.$investment->id),
            'action_title'=>'View Investment',
        ];
        Mail::to($user->email)->send(new UserMail($my_msg));
        return redirect()->back()->with('message', '<div class="alert alert-success alert-dismissible alert-has-icon show fade"><div class="alert-icon"><i class="fas fa-check-double"></i></div><div class="alert-body"><button class="close" data-dismiss="alert"><span>&times;</span></button>Interest successfully declined.</div></div>');
    }

    public function paidInterest(){
        $payouts = Payout::where('status', 'paid')->orderBy('id', 'asc')->get();
        return view('admin.paidInterest', compact('payouts'));
    }

    public function addInvestment(){
        $users = User::where('is_admin', false)->where('email_verified_at', '!=', null)->latest()->get();
        return view('admin.invest', compact('users'));
    }

    public function addInvestmentPost(Request $request){
        $data = $request->except(['_token', 'user', 'witholding_tax']);
        $user = User::find($request->user);
        $tenor = Utils::getTenor($request->tenor);
        $tenorType = Utils::getTenorArray($request->tenor);
        $interest = Utils::getInterests($request->tenor, $request->amount, $request->interest);
        $tax = Utils::getWitholdingTax($request->witholding_tax, $interest);
        $approved = Carbon::parse($request->approved_date);
        $data['tenor'] = $tenorType[0];
        $data['witholding_tax'] = $tax;
        $data['tenor_type'] = $tenorType[1];
        $data['maturity_date'] = $approved->addDays(Utils::getTenor($tenorType[0]." ".$tenorType[1]))->format('Y-m-d H:i:s');
        $data['note_number'] = Utils::randomId('investments', 'note_number');
        $data['status'] = 'active';
        $investment = $user->investments()->save(new Investment($data));
        $my_msg = [
            'name'=>ucwords($user->firstname.' '.$user->lastname),
            'subject'=>'INVESTMENT APPROVED',
            'message_1'=>'Your investment of <strong>₦'.number_format($investment->amount,2).'</strong> and tenor of <strong>'.$investment->tenor.' '.$investment->tenor_type.'(s)</strong> has been approved by system administrator.',
            'message_2'=>'Please click on the button above or copy the link below into a browser to view.<br/><br/><br/>'.url('/dashboard/investments/view/'.$investment->id),
            'action'=>true,
            'action_link'=>url('/dashboard/investments/view/'.$investment->id),
            'action_title'=>'View Investment',
        ];
        Mail::to($user->email)->send(new UserMail($my_msg));
        return redirect('/admin/investments')->with('message', '<div class="alert alert-success alert-dismissible alert-has-icon show fade"><div class="alert-icon"><i class="fas fa-check-double"></i></div><div class="alert-body"><button class="close" data-dismiss="alert"><span>&times;</span></button>Your investment has been booked for administrative approval.</div></div>');
    }


}
