<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('/restaurants', RestaurantController::class)->except(['create', 'edit']);

    Route::resource('/tags', TagController::class)->except(['create', 'edit', 'index', 'show']);

    Route::resource('/images', ImageController::class)->only(['show', 'store', 'destroy']);
});
