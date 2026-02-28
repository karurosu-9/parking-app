<?php

use App\Http\Controllers\Api\v1\PlaceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('places', [PlaceController::class, 'index']);
