<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\QRCodeController;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/store-qr-code', [QRCodeController::class, 'store']);

Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'index']);
