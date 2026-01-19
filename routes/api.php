<?php

use App\Http\Controllers\Api\PasswordController;
use App\Http\Controllers\Api\VerificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:api');

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::get('user', [AuthController::class, 'user'])->middleware('auth:api');

Route::post('password/forgot', [PasswordController::class, 'sendResetLinkEmail']);
Route::post('password/reset', [PasswordController::class, 'reset']);

Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify'); // email link
Route::post('email/resend', [VerificationController::class, 'resend'])->middleware('auth:api');
