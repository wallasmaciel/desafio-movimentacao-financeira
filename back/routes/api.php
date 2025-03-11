<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Middleware\AuthToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    return response()->json([
        'id' => 1,
        'name' => 'João Silva',
        'email' => 'joao@example.com',
    ]);
});

Route::prefix("/users")->group(function() {
    Route::post("/login", [UserController::class, "login"]);
});

Route::middleware(AuthToken::class)->group(function() {
    Route::prefix("/categories")->group(function() {
        Route::get("", [CategoryController::class, "index"]);
        Route::get("/{id}", [CategoryController::class, "show"]);
        Route::post("", [CategoryController::class, "create"]);
        Route::put("/{id}", [CategoryController::class, "update"]);
        Route::delete("/{id}", [CategoryController::class, "remove"]);
    });

    Route::prefix("/transactions")->group(function() {
        Route::get("", [TransactionController::class, "index"]);
        Route::get("/{id}", [TransactionController::class, "show"]);
        Route::post("", [TransactionController::class, "create"]);
        Route::put("/{id}", [TransactionController::class, "update"]);
        Route::delete("/{id}", [TransactionController::class, "remove"]);
    });
});
