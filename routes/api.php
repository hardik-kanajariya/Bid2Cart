<?php

use App\Http\Controllers\Api;
use App\Http\Controllers\Authentication as ControllersAuthentication;
use App\Http\Controllers\MailController;
use App\Http\Controllers\SocialController;
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

// Default Route
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Social Login Routes
Route::get('/social/authentication', [SocialController::class, 'apiSocialLogin']);

// Route for Registering new User
Route::post('auth/register', [ControllersAuthentication::class, 'register']);

// Route for Login and generate OAuth Token
Route::post('auth/login', [ControllersAuthentication::class, 'login']);
Route::get('/auth/verify', [MailController::class, 'verifyMail']);
Route::get('/auth/reset/password', [MailController::class, 'resetPassword']);
Route::post('/auth/change/password', [MailController::class, 'changePassword']);
// Protected Routes
Route::middleware('auth:api')->group(function () {
    Route::get('data', [ControllersAuthentication::class, 'index']); // This Route is for Testing
    Route::get('/user', [Api::class, 'getUser']);
    Route::post('/user/update', [Api::class, 'updateUserProfile']);
    Route::get('/watchlist', [Api::class, 'getWatchList']);
    Route::post('/add/watchlist', [Api::class, 'addWatchList']);
    Route::post('/watchlist/remove', [Api::class, 'removeWatchList']);
    Route::get('/datas', [Api::class, 'dashboardData']);
    Route::post('/bid', [Api::class, 'placeProxyBid']);
    Route::get('/mybids', [Api::class, 'getMyBids']);
    Route::post('/request-pickup', [Api::class, 'requestPickup']);
    Route::post('/request-support', [Api::class, 'requestSupport']);
    Route::get('/notification', [Api::class, 'getNotification']);
    Route::get('/get-invoice', [Api::class, 'getInvoice']);
});

 
// Unprotected Routes
Route::get('/bidhistory', [Api::class, 'getBidHistory']);
Route::get('/app-data', [Api::class, 'getAppData']);
Route::post('/contact', [Api::class, 'storeContact']);
Route::get('/categories', [Api::class, 'getAllCategory']);
Route::get('/products/all', [Api::class, 'getAllProducts']);
Route::get('/products/latest', [Api::class, 'getLatestProducts']);
Route::get('/products/filter', [Api::class, 'getFilteredProducts']);
Route::get('/products', [Api::class, 'getProductById']);
Route::get('/category/product', [Api::class, 'getProductByCategory']);
Route::get('/search', [Api::class, 'searchProduct']);
Route::get('/invoice/{number}', [Api::class, 'approveAcknowledgement']);

