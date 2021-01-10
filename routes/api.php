<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShiporderController;
use App\Http\Controllers\PeopleController;

Route::prefix('shiporder')->group(function () {
    Route::get('', [ShiporderController::class, 'index']);
    Route::get('/{id}', [ShiporderController::class, 'show']);
});

Route::prefix('people')->group(function () {
    Route::get('', [PeopleController::class, 'index']);
    Route::get('/{id}', [PeopleController::class, 'show']);
});