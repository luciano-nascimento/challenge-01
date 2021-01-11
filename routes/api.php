<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShiporderController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\AuthController;

Route::group(['prefix' => 'shiporder', 'middleware' => ['jwt.auth']], function () {
    Route::get('', [ShiporderController::class, 'index']);
    Route::get('/{id}', [ShiporderController::class, 'show']);
});

Route::group(['prefix' => 'people', 'middleware' => ['jwt.auth']],function () {
    Route::get('', [PeopleController::class, 'index']);
    Route::get('/{id}', [PeopleController::class, 'show']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [Auth::class, 'logout']);
    Route::post('/refresh', [Auth::class, 'refresh']);
    Route::get('/user-profile', [Auth::class, 'userProfile']);    
});