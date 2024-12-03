<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LicensePlateController;
use App\Models\City;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if(empty(Auth::user())){
        return redirect()->route('user.infor');
    }
    $cities = City::all();
    return view('welcome', compact('cities'));
});
Route::prefix('plate')->group(function(){
    Route::post('/create',  [
        'as' => 'plate.create',
        'uses' => 'App\Http\Controllers\LicensePlateController@create',
    ]);
    Route::post('/store',  [
        'as' => 'plate.store',
        'uses' => 'App\Http\Controllers\LicensePlateController@store',
    ]);
    Route::get('/check', [
        'as' => 'plate.check',
        'uses' => 'App\Http\Controllers\LicensePlateController@check',
    ]);
    Route::get('/quotesLicensePlate/{licensePlate}', [
        'as' => 'plate.quotesLicensePlate',
        'uses' => 'App\Http\Controllers\LicensePlateController@quotesLicensePlate',
    ]);
});
Route::prefix('user')->group(function(){
    Route::get('/infor', [
        'as' => 'user.infor',
        'uses' => 'App\Http\Controllers\InforController@infor',
    ]);
    Route::post('/infor', [
        'as' => 'user.infor',
        'uses' => 'App\Http\Controllers\InforController@postInfor',
    ]);
    Route::get('/verifyOtp', [
        'as' => 'user.verifyOtp',
        'uses' => 'App\Http\Controllers\InforController@verifyOtp',
    ]);
    Route::post('/verifyOtp', [
        'as' => 'user.verifyOtp',
        'uses' => 'App\Http\Controllers\InforController@postVerifyOtp',
    ]);
    Route::get('/changeOtp', [
        'as' => 'user.changeOtp',
        'uses' => 'App\Http\Controllers\InforController@changeOtp',
    ]);
});
Route::prefix('admin')->group(function(){
    Route::get('/', [
        'as' => 'admin',
        'uses' => 'App\Http\Controllers\AdminController@login',
    ]);
    Route::post('/', [
        'as' => 'admin.login',
        'uses' => 'App\Http\Controllers\AdminController@postLogin',
    ]);
    Route::get('/dashboard', [
        'as' => 'admin.dashboard',
        'uses' => 'App\Http\Controllers\AdminController@dashboard',
        'middleware' => 'can:dashboard',
    ]);
    Route::get('/logout', [
        'as' => 'admin.logout',
        'uses' => '\App\Http\Controllers\AdminController@logout'
    ]);
    Route::prefix('type-cars')->group(function(){
        Route::get('/', [
            'as' => 'type-cars',
            'uses' => 'App\Http\Controllers\AdminTypeCarController@index',
            'middleware' => 'can:typecar_list',
        ]);
        Route::get('/create', [
            'as' => 'type-cars.create',
            'uses' => 'App\Http\Controllers\AdminTypeCarController@create',
            'middleware' => 'can:typecar_add',
        ]);
        Route::post('/store', [
            'as' => 'type-cars.store',
            'uses' => 'App\Http\Controllers\AdminTypeCarController@store',
            'middleware' => 'can:typecar_add',
        ]);
        Route::post('/edit', [
            'as' => 'type-cars.edit',
            'uses' => 'App\Http\Controllers\AdminTypeCarController@edit',
            'middleware' => 'can:typecar_edit',
        ]);
        Route::get('/delete/{id}', [
            'as' => 'type-cars.delete',
            'uses' => 'App\Http\Controllers\AdminTypeCarController@delete',
            'middleware' => 'can:typecar_delete',
        ]);
        Route::post('/multiDelete', [
            'as' => 'type-cars.multiDelete',
            'uses' => 'App\Http\Controllers\AdminTypeCarController@multiDelete',
            'middleware' => 'can:typecar_delete',
        ]);
        Route::get('/export', [
            'as' => 'type-cars.export',
            'uses' => 'App\Http\Controllers\AdminTypeCarController@export',
            'middleware' => 'can:typecar_list',
        ]);
        Route::post('/import', [
            'as' => 'type-cars.import',
            'uses' => 'App\Http\Controllers\AdminTypeCarController@import',
            'middleware' => 'can:typecar_add',
        ]);
        Route::get('/{query}', [
            'as' => 'type-cars.query',
            'uses' => 'App\Http\Controllers\AdminTypeCarController@indexQuery',
            'middleware' => 'can:typecar_list',
        ]);
    });
    Route::prefix('cars')->group(function(){
        Route::get('/', [
            'as' => 'cars',
            'uses' => 'App\Http\Controllers\AdminCarController@index',
            'middleware' => 'can:car_list',
        ]);
        Route::get('/create', [
            'as' => 'cars.create',
            'uses' => 'App\Http\Controllers\AdminCarController@create',
            'middleware' => 'can:car_add',
        ]);
        Route::post('/store', [
            'as' => 'cars.store',
            'uses' => 'App\Http\Controllers\AdminCarController@store',
            'middleware' => 'can:car_add',
        ]);
        Route::post('/edit', [
            'as' => 'cars.edit',
            'uses' => 'App\Http\Controllers\AdminCarController@edit',
            'middleware' => 'can:car_edit',
        ]);
        Route::get('/delete/{id}', [
            'as' => 'cars.delete',
            'uses' => 'App\Http\Controllers\AdminCarController@delete',
            'middleware' => 'can:car_delete',
        ]);
        Route::post('/multiDelete', [
            'as' => 'cars.multiDelete',
            'uses' => 'App\Http\Controllers\AdminCarController@multiDelete',
            'middleware' => 'can:car_delete',
        ]);
        Route::get('/export', [
            'as' => 'cars.export',
            'uses' => 'App\Http\Controllers\AdminCarController@export',
            'middleware' => 'can:car_list',
        ]);
        Route::post('/import', [
            'as' => 'cars.import',
            'uses' => 'App\Http\Controllers\AdminCarController@import',
            'middleware' => 'can:car_add',
        ]);
        Route::get('/{query}', [
            'as' => 'cars.query',
            'uses' => 'App\Http\Controllers\AdminCarController@indexQuery',
            'middleware' => 'can:car_list',
        ]);
    });
    Route::prefix('license-plates')->group(function(){
        Route::get('/', [
            'as' => 'license-plates',
            'uses' => 'App\Http\Controllers\AdminLicensePlateController@index',
            'middleware' => 'can:licenseplate_list',
        ]);
        Route::get('/export', [
            'as' => 'license-plates.export',
            'uses' => 'App\Http\Controllers\AdminLicensePlateController@export',
            'middleware' => 'can:licenseplate_list',
        ]);
        Route::get('/{query}', [
            'as' => 'license-plates.query',
            'uses' => 'App\Http\Controllers\AdminLicensePlateController@indexQuery',
            'middleware' => 'can:licenseplate_list',
        ]);
    });
    Route::prefix('admin-users')->group(function(){
        Route::get('/', [
            'as' => 'admin-users',
            'uses' => 'App\Http\Controllers\AdminUserController@index',
            'middleware' => 'can:user_list',
        ]);
        Route::get('/create', [
            'as' => 'admin-users.create',
            'uses' => 'App\Http\Controllers\AdminUserController@create',
            'middleware' => 'can:user_add',
        ]);
        Route::post('/store', [
            'as' => 'admin-users.store',
            'uses' => 'App\Http\Controllers\AdminUserController@store',
            'middleware' => 'can:user_add',
        ]);
        Route::post('/edit', [
            'as' => 'admin-users.edit',
            'uses' => 'App\Http\Controllers\AdminUserController@edit',
            'middleware' => 'can:user_edit',
        ]);
        Route::get('/delete/{id}', [
            'as' => 'admin-users.delete',
            'uses' => 'App\Http\Controllers\AdminUserController@delete',
            'middleware' => 'can:user_delete',
        ]);
        Route::post('/multiDelete', [
            'as' => 'admin-users.multiDelete',
            'uses' => 'App\Http\Controllers\AdminUserController@multiDelete',
            'middleware' => 'can:user_delete',
        ]);
        Route::get('/export', [
            'as' => 'admin-users.export',
            'uses' => 'App\Http\Controllers\AdminUserController@export',
            'middleware' => 'can:user_list',
        ]);
        Route::get('/{query}', [
            'as' => 'admin-users.query',
            'uses' => 'App\Http\Controllers\AdminUserController@indexQuery',
            'middleware' => 'can:user_list',
        ]);
    });
});
