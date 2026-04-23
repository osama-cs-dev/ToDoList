<?php

use App\Http\Controllers\UseController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('welcome',[WelcomeController::class,'welcome']);
Route::get('user/{id}',[UseController::class,'checkUser']);
Route::get('admin',[UseController::class,'admin']);



