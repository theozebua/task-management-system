<?php

use App\Http\Controllers\Api\Auth\{LoginController, RegisterController, LogoutController};
use App\Http\Controllers\Api\Rest\TaskController;
use App\Http\Controllers\Api\User\{ChangePasswordController, ProfileController};
use Illuminate\Http\{Request, Response};
use Illuminate\Support\Facades\Route;

$missing = fn (Request $request) => response()->json([
    'status'  => false,
    'message' => "Data with id {$request->segment(3)} is not found."
], Response::HTTP_NOT_FOUND);

Route::middleware('guest')->group(function () {
    Route::post('/login', LoginController::class);
    Route::post('/register', RegisterController::class);
});

Route::middleware('auth:sanctum')->group(function () use ($missing) {
    Route::post('/logout', LogoutController::class);

    Route::get('/profile', ProfileController::class);
    Route::put('/change-password', ChangePasswordController::class);

    Route::apiResource('/tasks', TaskController::class)->missing($missing);
});
