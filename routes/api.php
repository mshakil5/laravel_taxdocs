<?php

if (App::environment('production')) {
    URL::forceScheme('https');
}


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PayrollController;
  
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
  
Route::post('signup', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);

Route::group(['middleware' => ['auth:api']], function () {

    // user information
    Route::get('/user/profileinfo',[UserController::class,'profileInfo']);
    Route::post('/profile-image',[UserController::class,'profileImageUpdate']);
    Route::post('/user/profile/update',[UserController::class,'profileUpdate']);
    Route::post('/user/password/update',[UserController::class,'passwordUpdate']);
    Route::get('/logout',[UserController::class,'logout']);
    // user information end

    // image 
    Route::get('image', [ImageController::class, 'index']);
    Route::post('image', [ImageController::class, 'store']);
    Route::get('image-delete/{id}', [ImageController::class, 'delete']);

    // user 
    Route::get('user/bank-account', [UserController::class, 'bankAccountDetails']);
    Route::post('user/bank-account', [UserController::class, 'bankAccountStore']);
    Route::get('user/delete-bank-account/{id}', [UserController::class, 'deleteBankAccount']);
    // account active
    Route::post('active-account', [UserController::class, 'activeAccount']);

    // new user
    Route::get('/new-user', [UserController::class, 'getNewUser'])->name('user.newuser');
    Route::post('/new-user', [UserController::class, 'newUserStore']);
    Route::post('/get-new-users', [UserController::class, 'getUserDetails']);
    Route::get('/new-user/{id}', [UserController::class, 'newUserDelete']);


    // payroll
    Route::get('/payroll', [PayrollController::class, 'index'])->name('user.payroll');
    Route::get('/payroll-details/{id}', [PayrollController::class, 'payrollDetails'])->name('user.payrolldtl');
    Route::post('/payroll', [PayrollController::class, 'payrollStore']);
    Route::post('/payroll-update', [PayrollController::class, 'payrollUpdate']);

});
     
