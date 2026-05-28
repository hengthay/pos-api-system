<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Cashier, Admin, Manager
Route::middleware(['jwt.cookie', 'role:admin,manager,cashier'])->group(function (){
    Route::controller(CategoriesController::class)->prefix('categories')->group(function() {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
    });

    Route::controller(ProductsController::class)->prefix('products')->group(function (){
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
    });
});

// Admin route and manager
Route::middleware(['jwt.cookie', 'role:admin,manager'])->group(function (){

    Route::controller(UserController::class)->prefix('users')->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'delete');
    });

    Route::controller(CategoriesController::class)->prefix('categories')->group(function (){
        Route::post('/', 'create');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'delete');
    });

    Route::controller(ProductsController::class)->prefix('products')->group(function (){
        Route::post('/', 'create');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'delete');
    });

    Route::controller(SuppliersController::class)->prefix('suppliers')->group(function (){
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/', 'create');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'delete');
    });
});


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);
