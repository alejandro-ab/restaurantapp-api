<?php

use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\DishController;
use App\Http\Controllers\V1\ImageController;
use App\Http\Controllers\V1\RestaurantController;
use App\Http\Controllers\V1\TagController;
use App\Http\Controllers\V1\VisitController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.forgot');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');

    Route::get('/redirect/{provider}', [AuthController::class, 'redirectToProvider'])->name('social.redirect');
    Route::get('/callback/{provider}', [AuthController::class, 'handleProviderCallback'])->name('social.callback');

});

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
