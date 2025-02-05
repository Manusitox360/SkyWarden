<?php

use App\Http\Controllers\Api\PlaneApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/planes',[PlaneApiController::class,'index'])->name('ApiIndexPlanes');
Route::post('/planes',[PlaneApiController::class, 'store'])->name('ApiStorePlanes');
Route::get('/planes/{id}',[PlaneApiController::class, 'show'])->name('ApiShowPlanes');
Route::put('/planes/{id}',[PlaneApiController::class, 'update'])->name('ApiUpdatePlanes');
Route::delete('/planes/{id}',[PlaneApiController::class, 'destroy'])->name('ApiDestroyPlanes');

