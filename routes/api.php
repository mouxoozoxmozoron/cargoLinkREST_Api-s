<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\Registration_controller;
use App\Http\Controllers\API\transport_agent\transportation_agent_controller;
use App\Http\Controllers\API\User\driver_controller;
use App\Http\Controllers\API\User\home_controller;
use App\Http\Controllers\API\User\user_controller;
use App\Http\Controllers\Order\order_tracking;
use App\Http\Controllers\Order\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::post('register', [Registration_controller::class, 'register']);
Route::POST('register', [Registration_controller::class, 'register']);
Route::get('testing', [Registration_controller::class, 'testing']);
Route::get('home', [home_controller::class, 'home']);

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout/{userId}', [AuthController::class, 'logout']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('Order', OrderController::class);
    Route::resource('driver', driver_controller::class);
    Route::resource('user', user_controller::class);
    Route::POST('Confirm_order/{order_id}', [order_tracking::class, 'Confirm_order']);
    Route::POST('verify_payment/{order_id}', [order_tracking::class, 'verify_payment']);
    Route::POST('position_order/{order_id}', [order_tracking::class, 'position_order']);
    Route::resource('agent', transportation_agent_controller::class);
    // Route::resource('Comments', CommentController::class);
    // Route::resource('Replies', ReplieController::class);
    // Route::resource('Likes', LIkesController::class);
});

// Route::middleware(['auth', 'user.type'])->group(function () {
//     // Routes accessible only to users with user_type_id == 1
// Route::POST('Confirm_order/{order_id}', [order_tracking::class, 'Confirm_order']);
// });

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// }
// );

// Route::POST('Confirm_order/{order_id}', [order_tracking::class, 'Confirm_order']);
