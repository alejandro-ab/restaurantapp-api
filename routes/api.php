<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\VisitController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [AuthController::class, 'register'])->name('register');
Route::post('/auth/login', [AuthController::class, 'login'])->name('login');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('/restaurants', RestaurantController::class)->except(['create', 'edit']);

    Route::resource('/dishes', DishController::class)->except(['create', 'edit']);

    Route::resource('/visits', VisitController::class)->except(['create', 'edit']);

    Route::resource('/tags', TagController::class)->except(['create', 'edit']);

    Route::resource('/images', ImageController::class)->only(['show', 'store', 'destroy']);
});
