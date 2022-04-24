<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\dateChangeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\offlineTicketController;
use App\Http\Controllers\paymentController;
use App\Http\Controllers\refundController;
use App\Http\Controllers\voidController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\ledgerController;
use App\Http\Controllers\userProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('password/reset', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPassword'])->name('forget.password.post');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

Route::get('/', [LoginController::class, 'showLoginForm']);
Auth::routes();

//Route::get('/', [HomeController::class, 'index'])->middleware('role:0');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('role:0');

Route::get('offlineticket', [offlineTicketController::class, 'create'])->middleware('role:0');
Route::post('offlineticket', [offlineTicketController::class, 'store'])->middleware('role:0');

Route::get('refund', [refundController::class, 'create'])->middleware('role:0');
Route::post('refund', [refundController::class, 'store'])->middleware('role:0');

Route::get('void', [voidController::class, 'create'])->middleware('role:0');
Route::post('void', [voidController::class, 'store'])->middleware('role:0');

Route::get('payment', [paymentController::class, 'index'])->middleware('role:0');
Route::get('addPayment', [paymentController::class, 'create'])->middleware('role:0');
Route::post('addPayment', [paymentController::class, 'store'])->middleware('role:0');

Route::get('datechange', [dateChangeController::class, 'create'])->middleware('role:0');
Route::post('datechange', [dateChangeController::class, 'store'])->middleware('role:0');

Route::get('/deletePayment/{id}', [paymentController::class, 'deletePayment']);

// Route::get('ledger', [ledgerController::class, 'index'])->middleware('role:0');

Route::get('UserProfile', [userProfileController::class, 'create']);
Route::post('updateUserProfile/{id}', [userProfileController::class, 'store']);

Route::view('forgot_password', 'auth.forgot_password');
Route::post('forgot_password', [ForgotPasswordController::class, 'store']);




Route::get('ledger_new', [ledgerController::class, 'showLedger']);
Route::get('details/{id}', [HomeController::class, 'showDetailPage']);

//admin pages

Route::get('admin', [adminController::class, 'index'])->middleware('role:1');
Route::get('admin/dashboard', [adminController::class, 'index'])->middleware('role:1');


Route::get('admin/addNewCustomer', [adminController::class, 'create'])->middleware('role:1');
Route::post('admin/addNewCustomer', [adminController::class, 'store'])->middleware('role:1');
Route::get('admin/editCustomer/{id}', [adminController::class, 'editCustomer'])->middleware('role:1');
Route::post('admin/editCustomer/{id}', [adminController::class, 'updateCustomer'])->middleware('role:1');
Route::get('admin/customers', [adminController::class, 'customerList'])->middleware('role:1');
Route::get('admin/custUpdate/{id}', [adminController::class, 'custUpdate'])->middleware('role:1');
Route::get('admin/custApprove/{id}', [adminController::class, 'custApprove'])->middleware('role:1');
Route::get('admin/custDisapprove/{id}', [adminController::class, 'custDisapprove'])->middleware('role:1');
Route::get('admin/custDelete/{id}', [adminController::class, 'custDelete'])->middleware('role:1');

Route::get('admin/refund', [adminController::class, 'refundList'])->middleware('role:1');
Route::get('admin/void', [adminController::class, 'voidList'])->middleware('role:1');
Route::get('admin/datechange', [adminController::class, 'dateChangeList'])->middleware('role:1');
Route::get('admin/payment', [adminController::class, 'paymentList'])->middleware('role:1');
Route::get('admin/ticketing', [adminController::class, 'ticketingList'])->middleware('role:1');

Route::get('admin/ticketingStatusSubmitted/{id}', [adminController::class, 'ticketingSubmitted'])->middleware('role:1');
Route::get('admin/ticketingStatusPosted/{id}', [adminController::class, 'ticketingPosted'])->middleware('role:1');
Route::get('admin/ticketingStatusProcessing/{id}', [adminController::class, 'ticketingProcessing'])->middleware('role:1');
Route::get('admin/ticketingStatusCompleted/{id}', [adminController::class, 'ticketingCompleted'])->middleware('role:1');
Route::get('admin/ticketingStatusRejected/{id}', [adminController::class, 'ticketingRejected'])->middleware('role:1');

Route::get('admin/refundStatusSubmitted/{id}', [adminController::class, 'refundSubmitted'])->middleware('role:1');
Route::get('admin/refundStatusPosted/{id}', [adminController::class, 'refundPosted'])->middleware('role:1');
Route::get('admin/refundStatusProcessing/{id}', [adminController::class, 'refundProcessing'])->middleware('role:1');
Route::get('admin/refundStatusCompleted/{id}', [adminController::class, 'refundCompleted'])->middleware('role:1');
Route::get('admin/refundStatusRejected/{id}', [adminController::class, 'refundRejected'])->middleware('role:1');

Route::get('admin/voidStatusSubmitted/{id}', [adminController::class, 'voidSubmitted'])->middleware('role:1');
Route::get('admin/voidStatusPosted/{id}', [adminController::class, 'voidPosted'])->middleware('role:1');
Route::get('admin/voidStatusProcessing/{id}', [adminController::class, 'voidProcessing'])->middleware('role:1');
Route::get('admin/voidStatusCompleted/{id}', [adminController::class, 'voidCompleted'])->middleware('role:1');
Route::get('admin/voidStatusRejected/{id}', [adminController::class, 'voidRejected'])->middleware('role:1');

Route::get('admin/dateChangeStatusSubmitted/{id}', [adminController::class, 'dateChangeSubmitted'])->middleware('role:1');
Route::get('admin/dateChangeStatusPosted/{id}', [adminController::class, 'dateChangePosted'])->middleware('role:1');
Route::get('admin/dateChangeStatusProcessing/{id}', [adminController::class, 'dateChangeProcessing'])->middleware('role:1');
Route::get('admin/dateChangeStatusCompleted/{id}', [adminController::class, 'dateChangeCompleted'])->middleware('role:1');
Route::get('admin/dateChangeStatusRejected/{id}', [adminController::class, 'dateChangeRejected'])->middleware('role:1');

Route::get('admin/paymentStatusSubmitted/{id}', [adminController::class, 'paymentSubmitted'])->middleware('role:1');
Route::get('admin/paymentStatusPosted/{id}', [adminController::class, 'paymentPosted'])->middleware('role:1');
Route::get('admin/paymentStatusProcessing/{id}', [adminController::class, 'paymentProcessing'])->middleware('role:1');
Route::get('admin/paymentStatusCompleted/{id}', [adminController::class, 'paymentCompleted'])->middleware('role:1');
Route::get('admin/paymentStatusRejected/{id}', [adminController::class, 'paymentRejected'])->middleware('role:1');

Route::post('admin/ticketingStatus/{id}', [adminController::class, 'adminTicketingStatus'])->middleware('role:1');
Route::post('admin/refundStatus/{id}', [adminController::class, 'adminRefundStatus'])->middleware('role:1');
Route::post('admin/voidStatus/{id}', [adminController::class, 'adminVoidStatus'])->middleware('role:1');
Route::post('admin/dateChangeStatus/{id}', [adminController::class, 'adminDateChangeStatus'])->middleware('role:1');
Route::post('admin/paymentStatus/{id}', [adminController::class, 'adminPaymentStatus'])->middleware('role:1');

Route::get('admin/airline', [adminController::class, 'add_airline']);
Route::post('admin/add_airline', [adminController::class, 'airline_name']);

Route::get('admin/booking_source', [adminController::class, 'booking_source']);
Route::post('admin/add_booking_source', [adminController::class, 'add_booking_source']);

Route::get('admin/bank', [adminController::class, 'bank']);
Route::post('admin/add_bank', [adminController::class, 'add_bank']);

Route::get('admin/vendor_source', [adminController::class, 'vendorSource']);
Route::post('admin/vendor_source', [adminController::class, 'addVendorSource']);

Route::get('admin/delete_vendor_source/{id}', [adminController::class, 'deleteVendorSource']);
Route::get('admin/disable_vendor_source/{id}', [adminController::class, 'disableVendorSource']);
Route::get('admin/enable_vendor_source/{id}', [adminController::class, 'enableVendorSource']);



Route::get('admin/deleteAirline/{id}', [adminController::class, 'delete_airline']);
Route::get('admin/deleteBank/{id}', [adminController::class, 'delete_bank']);
Route::get('admin/deleteBooking_source/{id}', [adminController::class, 'delete_booking_source']);

Route::get('admin/deleteRecord/{id}', [adminController::class, 'delete_record']);

Route::get('admin/enableAirline/{id}', [adminController::class, 'enableAirline']);
Route::get('admin/disableAirline/{id}', [adminController::class, 'disableAirline']);

Route::get('admin/enableBooking/{id}', [adminController::class, 'enableBooking']);
Route::get('admin/disableBooking/{id}', [adminController::class, 'disableBooking']);

Route::get('admin/enableBank/{id}', [adminController::class, 'enableBank']);
Route::get('admin/disableBank/{id}', [adminController::class, 'disableBank']);

Route::view('admin/details', 'admin.detail');


Route::get('admin/add_admin', function () {
    return view('admin.add_admin');
});
Route::get('admin/update_admin', function () {  //test
    return view('admin.update_admin');
});

Route::post('admin/add_admin', [adminController::class, 'addAdmin']);
Route::post('admin/update_admin/{id}', [adminController::class, 'updateAdmin']);  // test
Route::get('/admin/edit_admin/{id}', [adminController::class, 'editAdmin']); //test edit
Route::post('admin/update-post', [adminController::class, 'updateAdmi']); //test edit updTEE

Route::get('/admin/delete_admin/{id}', [adminController::class, 'removeAdmin']);

Route::get('admin/manual_request', [adminController::class, 'loadManualRequestForm']);
Route::post('admin/manual_request', [adminController::class, 'saveManualRequest']);
Route::get('admin/details/{id}', [adminController::class, 'showDetailPage']);
Route::post('admin/ledger/{id}', [adminController::class, 'addLedger']);
Route::post('admin/update_ledger/{id}', [adminController::class, 'updateLedger']);

Route::post('admin/add_passenger_info/{id}', [adminController::class, 'SavePassengerInfo']);
Route::post('admin/update_passenger_info/{id}', [adminController::class, 'UpdatePassengerInfo']);


Route::get('ledger', [ledgerController::class, 'showLedger'])->middleware('role:0');


Route::get('admin/delete_payment/{id}', [adminController::class, 'delete_payment']);

Route::get('/admin/getVendor', [adminController::class, 'getVendor']);


Route::view('det', 'admin.det');
