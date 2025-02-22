<?php

use App\Http\Controllers\V1\DishController;
use App\Http\Controllers\V1\ImageController;
use App\Http\Controllers\V1\RestaurantController;
use App\Http\Controllers\V1\TagController;
use App\Http\Controllers\V1\VisitController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/restaurants', RestaurantController::class);
    Route::get('/restaurants/{restaurant}/dishes', [RestaurantController::class, 'dishes']);
    Route::get('/restaurants/{restaurant}/visits', [RestaurantController::class, 'visits']);

    Route::apiResource('/dishes', DishController::class);

    Route::apiResource('/visits', VisitController::class);
    Route::get('/visits/{visit}/dishes', [VisitController::class, 'dishes']);

    Route::apiResource('/tags', TagController::class);

    Route::apiResource('/images', ImageController::class)->except(['index', 'update']);
});
