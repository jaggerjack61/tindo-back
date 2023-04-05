<?php

use App\Http\Controllers\APIController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaynowController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::middleware('guest')->group(function () {
    Route::controller(APIController::class)->group(function () {
        Route::get('/gallery', 'showAllPaintings');
        Route::post('/message', 'saveMessage');
        Route::post('/login', 'login');
        Route::post('/register', 'register');
    });
    Route::controller(PaynowController::class)->group(function () {
        Route::post('/paynow/result', 'handleResult');
    });


});

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(APIController::class)->group(function () {
        Route::get('/user', 'getUser');
    });
    Route::controller(PaynowController::class)->group(function () {
        Route::post('/paynow/bank', 'bankPayment');
        Route::post('/paynow/mobile', 'mobilePayment');
        Route::post('/paynow/status', 'paymentStatus');
    });
    Route::controller(OrderController::class)->group(function () {
        Route::get('/order', 'getOrders');
    });
});
Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);
    return ['token' => $token->plainTextToken];
});
