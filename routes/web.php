<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AdminActions;
use App\Http\Controllers\Loader;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileUpdate;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;


use App\Http\Controllers\Sorted\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function(){
	return redirect('/dashboard');
});
Route::group(['prefix' => 'loader'], function(){
	Route::post('/loadActiveUsers', [Loader::class, 'loadActiveUsers'])->name('admin.users.active');
	Route::post('/loadMyInvestments', [Loader::class, 'loadMyInvestments'])->name('my_investments');
	Route::post('/loadActiveInvestments', [Loader::class, 'loadActiveInvestments'])->name('active.invests');
	Route::post('/loadPendingInvestments', [Loader::class, 'loadPendingInvestments'])->name('pending.invests');
	Route::post('/loadMaturedInvestments', [Loader::class, 'loadMaturedInvestments'])->name('matured.invests');
	Route::post('/loadDeclinedInvestments', [Loader::class, 'loadDeclinedInvestments'])->name('declined.invests');
	Route::post('/loadAllInvestments', [Loader::class, 'loadAllInvestments'])->name('all.invests');
	Route::post('/loadPaidInvestment', [Loader::class, 'loadPaidInvestment'])->name('paid.invests');
});


Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum,web', 'verified', 'admin:admin']], function(){
	Route::get('/login', [AdminController::class, 'loginForm']);
	Route::post('/login', [AdminController::class, 'store'])->name('admin.login');
});
Route::post('/admin/logout', [AdminController::class, 'destroy'])->name('admin.logout')->middleware('auth:admin');
Route::group(['prefix'=>'admin', 'middleware'=>['is_admin']], function(){
	Route::get('/dashboard', [AdminActions::class, 'dashboard'])->name('admin.dashboard');
	Route::get('/reports', [AdminActions::class, 'reports']);
	Route::get('/reports/create', [AdminActions::class, 'reportPost'])->name('admin.reports');
	Route::group(['prefix'=>'/users'], function() {
		Route::get('/', [AdminActions::class, 'active_users']);
		Route::get('/tdelete/{id}', [AdminActions::class, 'userDeleteContent']);
		Route::get('/delete/{id}', [AdminActions::class, 'deleteUser']);
		Route::post('/delete/multiple', [AdminActions::class, 'multipleDelete'])->name('admin.user.multiple.delete');
		Route::get('/view/{id}', [AdminActions::class, 'viewUser']);
	});
	Route::group(['prefix'=>'investments'], function() {
		Route::get('/add', [AdminActions::class, 'addInvestment']);
		Route::post('/add', [AdminActions::class, 'addInvestmentPost'])->name('admin.invest');
		Route::get('/active', [AdminActions::class, 'activeInvestment']);
		Route::get('/', [AdminActions::class, 'allInvestments']);
		Route::get('/matured', [AdminActions::class, 'maturedInvestments']);
		Route::get('/pending', [AdminActions::class, 'pendingInvestments']);
		Route::get('/declined', [AdminActions::class, 'declinedInvestments']);
		Route::get('/view/{id}', [AdminActions::class, 'viewInvestment']);
		Route::get('/dapprove/{id}', [AdminActions::class, 'dapprove']);
		Route::get('/ddecline/{id}', [AdminActions::class, 'ddecline']);
		Route::post('/decline', [AdminActions::class, 'declineInvestment'])->name('declineInvestment');
		Route::post('/approve', [AdminActions::class, 'approveInvestment'])->name('approveInvestment');
		Route::get('/certificate/{id}', [HomeController::class, 'previewInvest']);
	});
	Route::post('/updateProfileInfo', [AdminActions::class, 'update'])->name('admin.updateProfileInfo');
	Route::post('/updateInfo', [AdminActions::class, 'updateInfo'])->name('admin.updateInfo');
	Route::post('/updateKin', [AdminActions::class, 'updateKin'])->name('admin.updateKin');
	Route::post('/updatePassword', [AdminActions::class, 'updatePassword'])->name('admin.updatePassword');
	Route::group(['prefix'=>'transactions'], function() {
		Route::get('/pending', [AdminActions::class, 'pendingPayouts']);
		Route::get('/paid/{id}', [AdminActions::class, 'payTrans']);
		Route::get('/paid', [AdminActions::class, 'paidTrans']);
		Route::get('/interests/pending', [AdminActions::class, 'pendingInterest']);
		Route::get('/interests/paid', [AdminActions::class, 'paidInterest']);
	});
	Route::get('/profile', [AdminActions::class, 'profile'])->name('admin.profile.show');
	Route::post('/my/updateProfileInfo', [AdminActions::class, 'updateMy'])->name('admin.my.updateProfileInfo');
	Route::post('/my/updatePassword', [AdminActions::class, 'updatePasswordMy'])->name('admin.my.updatePassword');
	Route::get('/investments/interests/pay/{id}', [AdminActions::class, 'payInterests']);
});


Route::group(['prefix' => 'dashboard', 'middleware' => ['auth:sanctum,web', 'verified']], function() {
	Route::group(['middleware'=>['is_user', 'is_complete']], function(){
		Route::get('/', [UserController::class, 'dashboard'])->name('dashboard');
		Route::get('/plans', [HomeController::class, 'plans']);
		Route::get('/plans/invest/{id}', [HomeController::class, 'invest']);
		Route::post('/plans/invest', [HomeController::class, 'investPost'])->name('plans.invest');
		Route::get('/investments', [HomeController::class, 'investments']);
		Route::get('/investments/view/{id}', [HomeController::class, 'viewInvestment']);
		Route::get('/investments/{id}/payout', [HomeController::class, 'payoutNow']);
		Route::get('/investments/certificate/{id}', [HomeController::class, 'previewInvest']);
		Route::get('/error', [HomeController::class, 'error']);
	});
	Route::post('/updateProfileInfo', [UserController::class, 'update'])->name('updateProfile');
	Route::post('/updateInfo', [UserController::class, 'updateInfo'])->name('updateInfo');
	Route::post('/updateKin', [UserController::class, 'updateKin'])->name('updateKin');
	Route::post('/updatePassword', [UserController::class, 'updatePassword'])->name('updatePassword');
	Route::post('/updateCompany', [UserController::class, 'updateCompany'])->name('updateCompany');
});

Route::post('/logout', LogoutController::class)->name('logout')->middleware('auth:web');
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware(['auth'])->name('verification.notice');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');