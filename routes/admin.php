<?php

if (App::environment('production')) {
    URL::forceScheme('https');
}

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\ContactMailController; 
use App\Http\Controllers\Admin\GalleryController; 
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Agent\AgentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\MasterController;



/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::group(['prefix' =>'admin/', 'middleware' => ['auth', 'is_admin']], function(){
  
    Route::get('/dashboard', [HomeController::class, 'adminHome'])->name('admin.dashboard');
    //admin registration
    Route::get('register','App\Http\Controllers\Admin\AdminController@adminindex')->name('admin.registration');
    Route::post('register','App\Http\Controllers\Admin\AdminController@adminstore');
    Route::get('register/{id}/edit','App\Http\Controllers\Admin\AdminController@adminedit');
    Route::put('register/{id}','App\Http\Controllers\Admin\AdminController@adminupdate');
    Route::get('register/{id}', 'App\Http\Controllers\Admin\AdminController@admindestroy');
    //admin registration end
    //agent registration
    Route::get('agent-register','App\Http\Controllers\Admin\AdminController@agentindex')->name('allfirm');;
    Route::post('agent-register','App\Http\Controllers\Admin\AdminController@agentstore');
    Route::get('agent-register/{id}/edit','App\Http\Controllers\Admin\AdminController@agentedit');
    Route::put('agent-register/{id}','App\Http\Controllers\Admin\AdminController@agentupdate');
    Route::get('agent-register/{id}', 'App\Http\Controllers\Admin\AdminController@agentdestroy');
    Route::get('active-firm','App\Http\Controllers\Admin\AdminController@activeagent');
    //agent registration end
    //company details
    Route::resource('company-detail','App\Http\Controllers\Admin\CompanyDetailController');

    // photo
    Route::get('/photo', [ImageController::class, 'index'])->name('admin.photo');
    Route::post('/photo', [ImageController::class, 'store']);
    Route::get('/photo/{id}/edit', [ImageController::class, 'edit']);
    Route::put('/photo/{id}', [ImageController::class, 'update']);
    Route::get('/photo/{id}', [ImageController::class, 'delete']);

    // contact mail 
    Route::get('/contact-mail', [ContactMailController::class, 'index'])->name('admin.contact-mail');
    Route::get('/contact-mail/{id}/edit', [ContactMailController::class, 'edit']);
    Route::put('/contact-mail/{id}', [ContactMailController::class, 'update'])->name('admin.contact.update');
    
    Route::get('new-customer', [UserController::class, 'getNotAssignCustomer'])->name('notassigncustomer');
    // notification
    Route::post('newusernoti', [DashboardController::class, 'closeNewUserNotif']);

    // work
    Route::get('/work', [WorkController::class, 'index'])->name('admin.work');
    Route::post('/work', [WorkController::class, 'store']);
    Route::get('/work/{id}/edit', [WorkController::class, 'edit']);
    Route::put('/work/{id}', [WorkController::class, 'update']);
    Route::get('/work/{id}', [WorkController::class, 'delete']);

    // option
    Route::get('/option', [OptionController::class, 'index'])->name('admin.option');
    Route::post('/option', [OptionController::class, 'store']);
    Route::get('/option/{id}/edit', [OptionController::class, 'edit']);
    Route::put('/option/{id}', [OptionController::class, 'update']);
    Route::get('/option/{id}', [OptionController::class, 'delete']);

    // master
    Route::get('/master', [MasterController::class, 'index'])->name('admin.master');
    Route::post('/master', [MasterController::class, 'store']);
    Route::get('/master/{id}/edit', [MasterController::class, 'edit']);
    Route::put('/master/{id}', [MasterController::class, 'update']);
    Route::get('/master/{id}', [MasterController::class, 'delete']);
});
//admin part end