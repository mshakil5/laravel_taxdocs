<?php

if (App::environment('production')) {
    URL::forceScheme('https');
}

use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\AdminController;

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

// cache clear
Route::get('/clear', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return "Cleared!";
});
//  cache clear

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', [FrontendController::class, 'index'])->name('homepage');
Route::get('/about', [FrontendController::class, 'about'])->name('frontend.about');
Route::get('/privacy', [FrontendController::class, 'privacy'])->name('frontend.privacy');
Route::get('/terms', [FrontendController::class, 'terms'])->name('frontend.terms');
Route::get('/contact', [FrontendController::class, 'contact'])->name('frontend.contact');
Route::get('/how-we-work/{id}', [FrontendController::class, 'getWorkDetails'])->name('frontend.workDetails');

/*------------------------------------------
--------------------------------------------
All Normal Users Routes List
--------------------------------------------
--------------------------------------------*/
Route::group(['prefix' =>'user/', 'middleware' => ['auth', 'is_user']], function(){
  
    Route::get('user-dashboard', [HomeController::class, 'userHome'])->name('user.dashboard');
    //profile
    Route::get('profile', [UserController::class, 'profile'])->name('user.profile');
    Route::post('profile-update', [UserController::class, 'userProfileUpdate']);
    Route::post('changepassword', [UserController::class, 'changeUserPassword']);
    Route::post('image', [UserController::class, 'userImageUpload']);
    //profile end

    // photo
    Route::get('/photo', [ImageController::class, 'getUserImage'])->name('user.photo');
    Route::post('/photo', [ImageController::class, 'userImageStore']);
    Route::get('/photo/{id}/edit', [ImageController::class, 'edit']);
    Route::put('/photo/{id}', [ImageController::class, 'update']);
    Route::get('/photo/{id}', [ImageController::class, 'delete']);
    // bank account store
    Route::post('bank-account', [UserController::class, 'bankaccountstore'])->name('bankaccountstore');
    Route::get('active-account', [UserController::class, 'activeAccount']);
    Route::get('delete-account/{id}', [UserController::class, 'accountDelete']);


    
    // payroll
    Route::get('/payroll', [PayrollController::class, 'index'])->name('user.payroll');
    Route::get('/payroll-details/{id}', [PayrollController::class, 'payrollDetails'])->name('user.payrolldtl');
    Route::post('/payroll', [PayrollController::class, 'payrollStore']);
    Route::post('/payroll-update', [PayrollController::class, 'payrollUpdate']);

    // new user
    Route::get('/new-user', [UserController::class, 'getNewUser'])->name('user.newuser');
    Route::post('/new-user', [UserController::class, 'newUserStore']);
    Route::post('/get-new-users', [UserController::class, 'getUserDetails']);
    Route::get('/new-user/{id}', [UserController::class, 'newUserDelete']);

    
    // invoice
    Route::get('/invoice', [InvoiceController::class, 'getInvoice'])->name('user.invoice');
    Route::post('/invoice', [InvoiceController::class, 'invoiceStore']);
    Route::post('/invoice-pdf', [InvoiceController::class, 'invoicePdfStore']);
    Route::get('invoice/{id}', [InvoiceController::class, 'invoice_download'])->name('invoice.download');

    //paid invoice
    Route::get('invoice-paid-status', [InvoiceController::class, 'paidInvoice']);
    Route::get('/paid-invoice', [InvoiceController::class, 'getPaidInvoice'])->name('user.paidinvoice');

    
    Route::get('/invoice-sent-email', [InvoiceController::class, 'invoiceSendEmail'])->name('user.invoicesendemail');
    Route::get('/invoice-edit/{id}', [InvoiceController::class, 'invoiceEdit'])->name('user.invoiceedit');
    
    Route::post('/invoice-update', [InvoiceController::class, 'invoiceUpdate']);
    Route::get('/invoice-delete/{id}', [InvoiceController::class, 'delete']);

    
    Route::get('/all-invoice', [InvoiceController::class, 'getAllInvoice'])->name('user.allinvoice');
    Route::get('/invoice-details/{id}', [InvoiceController::class, 'getInvoiceDetails'])->name('user.invoicedtl');


});
  
/*------------------------------------------
--------------------------------------------
All Agent Routes List
--------------------------------------------
--------------------------------------------*/
Route::group(['prefix' =>'agent/', 'middleware' => ['auth', 'is_agent']], function(){
  
    Route::get('agent-dashboard', [HomeController::class, 'agentHome'])->name('agent.dashboard');
    // notification
    Route::post('newusernoti', [DashboardController::class, 'closeNewNotification']);
});
  
/*------------------------------------------
--------------------------------------------
All Accountant firm and admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::group(['middleware' => ['auth', 'adminagentaccess']], function(){
    Route::get('customer/{id}', [UserController::class, 'getCustomerByAgent'])->name('allcustomer');

    //profile
    Route::get('admin/profile', [AdminController::class, 'profile'])->name('profile');
    Route::put('admin/profile/{id}', [AdminController::class, 'adminProfileUpdate']);
    Route::post('admin/changepassword', [AdminController::class, 'changeAdminPassword']);
    Route::put('admin/image/{id}', [AdminController::class, 'adminImageUpload']);
    //profile end
    Route::get('customer-detais/{id}', [UserController::class, 'getCustomerDetails'])->name('show.userdtl');
    
    //user registration
    Route::get('admin/user-register','App\Http\Controllers\Admin\AdminController@userindex')->name('alluser');;
    Route::post('admin/user-register','App\Http\Controllers\Admin\AdminController@userstore');
    Route::get('admin/user-register/{id}/edit','App\Http\Controllers\Admin\AdminController@useredit');
    Route::put('admin/user-register/{id}','App\Http\Controllers\Admin\AdminController@userupdate');
    Route::get('admin/user-register/{id}', 'App\Http\Controllers\Admin\AdminController@userdestroy');
    //user registration end
    Route::get('active-user','App\Http\Controllers\Admin\AdminController@activeuser');
    // payroll 
    Route::get('admin/payroll/{id}', [PayrollController::class, 'showPayroll'])->name('payroll');
    Route::get('admin/payroll-details/{id}', [PayrollController::class, 'showPayrollDetails'])->name('admin.payrolldtl');
    
    Route::get('admin/show-images/{id}', [ImageController::class, 'showImage'])->name('showimg');
    Route::post('/new-account', [AccountController::class, 'newTranStore']);

    //accounts
    Route::post('admin/account', [AccountController::class, 'store']);
    Route::get('admin/account/{id}/edit', [AccountController::class, 'edit']);
    Route::post('admin/account-update', [AccountController::class, 'update']);
    Route::get('admin/account/{id}', [AccountController::class, 'delete']);
    //accounts end
});
