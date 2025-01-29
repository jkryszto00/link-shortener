<?php

use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Panel\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/{vue_capture?}', IndexController::class)
    ->where('vue_capture', '[\/\w\.-]*');

Route::patch('/profile', [ProfileController::class, 'update']);
Route::put('/profile', [PasswordController::class, 'update']);
Route::delete('/profile', [ProfileController::class, 'destroy']);

require __DIR__.'/auth.php';
