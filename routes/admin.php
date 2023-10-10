<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SeatController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\CityController;
use App\Http\Controllers\StationController;



/*
|--------------------------------------------------------------------------
| admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function(){



    // ======================  Admin ======================
    Route::group(['prefix' => 'branches'], function ()
    {
        Route::get('register/admin/view', [AdminController::class, 'registerView'])->name('registerView');
        Route::post('register/test', [AdminController::class, 'registerTest'])->name('registerTest');
        Route::get('/admin/dashboard', function (){ return view('admin.dashboard'); })->name('admin.dashboard');
    });



}); //end of routes
