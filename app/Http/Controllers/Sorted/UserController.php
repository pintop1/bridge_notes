<?php

namespace App\Http\Controllers\Sorted;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kin;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Investment;
use App\Models\Transaction;
use App\Http\Controllers\Globals as Utils;
use PDF;
use Auth;
use App\Traits\FileUploadManager;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    use FileUploadManager;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = User::find($request->user);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function dashboard(){
        $user = User::find($request->user);
        $data['activeInvests'] = $user->investments()->where('status', 'active')->sum('amount');
        $data['totalInvests'] = $user->investments()->sum('amount');
        $data['totalPay'] = $user->investments()->where('payout','paid')->sum('amount');
        $data['pendingPay'] = $user->investments()->where('payout', 'requested')->sum('amount');
        return view('user.dashboard', $data);
    }

    public function updateInfo(Request $request){
        $user = User::find($request->user);
        $data = $request->except('_token');
        $user->update(['user_data'=>$data]);
        return redirect()->back()->with('message', '<div class="alert alert-success alert-dismissible alert-has-icon show fade"><div class="alert-icon"><i class="fas fa-check-double"></i></div><div class="alert-body"><button class="close" data-dismiss="alert"><span>&times;</span></button>Your update was successful.</div></div>');
    }

    public function updateKin(Request $req){
        $user = User::find($req->user);
        $data = $req->except(['_token', 'user']);
        if($user->kin) $user->kin()->update($data);
        else $user->kin()->save(new Kin($data));
        return redirect()->back()->with('message', '<div class="alert alert-success alert-dismissible alert-has-icon show fade"><div class="alert-icon"><i class="fas fa-check-double"></i></div><div class="alert-body"><button class="close" data-dismiss="alert"><span>&times;</span></button>Your update was successful.</div></div>');
    }

    /*public function updatePassword(Request $request){
        $user = Auth::user();
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
    }*/
}
