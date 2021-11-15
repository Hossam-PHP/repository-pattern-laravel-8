<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;

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

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::group([
    'middleware' => 'auth:api',
], function ($router) {            
        Route::prefix('auth')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::post('/refresh', [AuthController::class, 'refresh']);
            Route::get('/user-profile', [AuthController::class, 'userProfile']);
        });

        //Orders
        Route::group([
            'prefix' => 'orders',
            'middleware' => 'can:isAdmin'
        ],function () {
            Route::get('all', [OrderController::class, 'index']);
            Route::get('get/{id}', [OrderController::class, 'show']);
            Route::post('add', [OrderController::class, 'store']);
            Route::post('update/{id}', [OrderController::class, 'update']);
            Route::delete('delete/{id}', [OrderController::class, 'destroy']);
        });

});

