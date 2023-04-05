<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('welcome');
});
Route::middleware('auth')->group(function () {
    Route::controller(MainController::class)->group(function () {
        Route::get('/', 'showDashboard')->name('dashboard');
        Route::get('/profile','showProfile')->name('show-profile');
        Route::post('/','storePainting')->name('store-painting');
        Route::post('/edit','editPainting')->name('edit-painting');
        Route::get('/hide/{id}','hidePainting')->name('hide-painting');
        Route::get('/sell/{id}','sellPainting')->name('sell-painting');
        Route::get('/delete/{id}','deletePainting')->name('delete-painting');
        Route::get('/restore/{id}','restorePainting')->name('restore-painting');
    });
    Route::controller(MessageController::class)->group(function () {
        Route::prefix('/messages')->group(function () {
           Route::get('','showMessages')->name('show-messages');
           Route::get('read/{id}','readMessage')->name('read-message');
           Route::get('unread/{id}','unreadMessage')->name('unread-message');
        });
    });
    Route::controller(UserController::class)->group(function () {
        Route::prefix('/users')->group(function () {
            Route::get('','showUsers')->name('show-users');
            Route::post('','newUser')->name('new-user');
            Route::get('status/activate/{user}','activateUser')->name('activate-user');
            Route::get('status/deactivate/{user}','deactivateUser')->name('deactivate-user');
            Route::get('access_level/promote/{user}','promoteUser')->name('promote-user');
            Route::get('access_level/demote/{user}','demoteUser')->name('demote-user');
        });
    });
    Route::controller(PaymentsController::class)->group(function () {
        Route::prefix('/payments')->group(function () {
            Route::get('','showPayments')->name('show-payments');

        });
    });

    Route::controller(OrderController::class)->group(function () {
        Route::prefix('/order')->group(function () {
            Route::get('/deliver/{order}','markDelivered')->name('mark-delivered');
            Route::get('/undeliver/{order}','markUndelivered')->name('mark-undelivered');
        });
    });
});


Route::controller(AuthController::class)->group(function () {
    Route::get('/login','showLogin')->name('show-login')->middleware('guest');
    Route::post('/login','login')->name('login')->middleware('guest');;
    Route::get('/logout','logout')->name('logout')->middleware('auth');
});
