<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackendController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;


Auth::routes();
/*
|--------------------------------------------------------------------------
| Frontend
|--------------------------------------------------------------------------
|
*/

Route::get('/', [FrontendController::class, 'blank']);
//Route::get('/login', [FrontendController::class,'login']);
//Route::get('/register', [FrontendController::class,'register']);
//Route::get('/forgotpass', [FrontendController::class,'forgotpass']);
/*
|--------------------------------------------------------------------------
| Backend
|--------------------------------------------------------------------------
|
*/
// *** USER ****//
Route::group([
    'prefix' => 'backend',
    'middleware'=>'auth'
], function(){

Route::get('/',[BackendController::class,'dashboard']);
Route::get('/dashboard',[BackendController::class,'dashboard']);
Route::get('/logout',[BackendController::class,'logout']);
//Blank page
Route::get('/blank',[BackendController::class,'blank']);
Route::get('/nopermission', [BackendController::class,'nopermission']);
//routing Resource
Route::resource('/products',ProductController::class);
//พยามเข้าหน้าadmin

});

// *** admin ****//
Route::group([
    'prefix' => 'backend',
    'middleware' => 'admin'
], function(){

    Route::get('/reports',[BackendController::class,'reports']);
    Route::get('/users',[BackendController::class,'users']);
    Route::get('/settings',[BackendController::class,'settings']);
});



//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
