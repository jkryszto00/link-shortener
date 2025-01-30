<?php

use App\Http\Controllers\Panel\LinkController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(LinkController::class)->group(function () {
    Route::get('/links', 'index');
    Route::get('/links/{id}', 'show');
    Route::post('/links', 'store');
    Route::patch('/links/{id}', 'update');
    Route::delete('/links/{id}', 'destroy');
})->withoutMiddleware(['auth:sanctum']);
