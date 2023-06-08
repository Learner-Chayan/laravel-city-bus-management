<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/clear', function() {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('route:clear');
    return "All Clear";
//    return redirect()->route('dashboard');
});

//Route::get('/',function(){
//   return view('welcome');
//});
Route::get('/', 'Auth\LoginController@showLoginForm');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

Auth::routes();
Route::get('admin', 'Auth\LoginController@showLoginForm');
Route::get('dashboard',['as' => 'dashboard' , 'uses' => 'HomeController@dashboard'])->middleware('auth');

Route::get('auth/google', 'Auth\LoginController@redirectToGoogle');
Route::get('auth/google/callback', 'Auth\LoginController@handleGoogleCallback');
Route::group(['prefix' => 'admin','middleware' => 'auth'], function () {

    Route::get('edit-profile', ['as' => 'edit-profile', 'uses' => 'HomeController@editProfile']);
    Route::post('edit-profile', ['as' => 'update-profile', 'uses' => 'HomeController@updateProfile']);

    Route::get('password',['as' => 'password','uses'=> 'HomeController@changePassword']);
    Route::post('change-password',['as' => 'change-password','uses'=> 'HomeController@updatePassword']);

    Route::get('get-basic', ['as' => 'get-basic', 'uses' => 'BasicController@index']);
    Route::post('get-basic-update', ['as' => 'get-basic-update', 'uses' => 'BasicController@update']);
    Route::get('get-copy-right', ['as' => 'get-copy-right', 'uses' => 'BasicController@indexCopy']);
    Route::post('get-copy-right-update', ['as' => 'get-copy-right-update', 'uses' => 'BasicController@updateCopy']);

    Route::resource('roles','RoleController');
    Route::resource('permissions','PermissionController');
    Route::resource('users','UserController');
    Route::resource('sliders','Controllers\SliderController');
    Route::resource('socials','Controllers\SocialController');
    Route::resource('faqs','Controllers\FaqController');
    Route::resource('stoppage','StopageController');
    Route::resource('owner','OwnerController');
    Route::post('owner-update', ['as' => 'owner-update', 'uses' => 'OwnerController@update']);

    Route::resource('bus','BusController');
    Route::post('bus-update', ['as' => 'bus-update', 'uses' => 'BusController@update']);

    Route::resource('route','RouteController');
    Route::post('route-update', ['as' => 'route-update', 'uses' => 'RouteController@update']);


});
