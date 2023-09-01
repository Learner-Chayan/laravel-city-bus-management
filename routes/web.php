<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\FareController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CalculationController;
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
Route::group(['prefix' => 'admin','middleware' => ['auth']], function () {

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

    Route::resource('driver','DriverController');
    Route::post('driver-update', ['as' => 'driver-update', 'uses' => 'DriverController@update']);

    Route::resource('trip','TripController');

    Route::post('trip-update', ['as' => 'trip-update', 'uses' => 'TripController@update']);

    Route::resource('ticket-checker','TicketCheckerController');
    Route::post('ticket-checker-update', ['as' => 'ticket-checker-update', 'uses' => 'TicketCheckerController@update']);

    Route::resource('helper','HelperController');
    Route::post('helper-update', ['as' => 'helper-update', 'uses' => 'HelperController@update']);

    Route::resource('customer','CustomerController');
    Route::post('customer-update', ['as' => 'customer-update', 'uses' => 'CustomerController@update']);

    Route::resource('bus','BusController');
    Route::post('bus-update', ['as' => 'bus-update', 'uses' => 'BusController@update']);

    Route::resource('route','RouteController');
    Route::post('route-update', ['as' => 'route-update', 'uses' => 'RouteController@update']);

    //fare
    Route::get('/fare', [FareController::class, 'index'])->name('fare.index');
    Route::post('/fare', [FareController::class, 'pricing'])->name('fare.update');


    //ticket
    Route::get('/ticket',[TicketController::class, 'index'])->name('ticket');
    Route::get('/ticket-pdf/{id}',[TicketController::class, 'ticketPdf'])->name('ticket-pdf');
    Route::get('/search-trip',[TicketController::class, 'searchTrip'])->name('search.trip');
    Route::post('/ticket-confirmation', [TicketController::class, 'ticketConfirmation'])->name('ticket.confirm');
    Route::get('/purchase-history',[TicketController::class , 'purchaseHistory'])->name('purchase.history');

    //ticket validation
    Route::get('/ticketValidation', [TicketController::class, 'ticketValidation'])->name('ticket.validate');
    Route::get('/checkTicket', [TicketController::class, 'ticketValidation'])->name('ticket.check.back');
    Route::post('/checkTicket', [TicketController::class, 'checkTicket'])->name('ticket.check');

    //bkash payment for user
    //Route::post('/bkash/create', [PaymentController::class, 'createPayment'])->name('url-create');
    Route::get('/bkash/create/{fare_amount}/{ticket_id}', [PaymentController::class, 'createPayment'])->name('url-create');
    Route::get('/bkash/callback', [PaymentController::class, 'callback'])->name('url-callback');

    //serve ticket - conductor
    Route::get('/serve-ticket/{route}',[TicketController::class, 'ticketOptions'])->name('serve.ticket');
    Route::get('/trip-tickets/{tripId}', [TicketController::class, 'showTripTickets'])->name('trip.ticketsList');
    Route::get('/status-update/{ticketId}', [TicketController::class, 'ticketStatusUpdate'])->name('ticket.status.update');

    //get amount and list by trip
    Route::get('/trip-receipts/{tripId}', [CalculationController::class, 'showTripReceipts'])->name('trip.receipts');
});

//tickets
// Route::group(['prefix'=>'ticket'],function(){
//     Route::get('/',[TicketController::class, 'index'])->name('ticket');
// });


