<?php

use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Panel\ProfileController;
use App\Http\Controllers\RedirectLinkController;
use App\Http\Middleware\LinkRateLimitMiddleware;
use Illuminate\Support\Facades\Route;

Route::patch('/profile', [ProfileController::class, 'update']);
Route::put('/profile', [PasswordController::class, 'update']);
Route::delete('/profile', [ProfileController::class, 'destroy']);

require __DIR__.'/auth.php';

Route::get('/r/{shortCode}', RedirectLinkController::class)->middleware(LinkRateLimitMiddleware::class)->where('shortCode', '[A-Za-z0-9]+')->name('links.redirect');

Route::get('/{vue_capture?}', IndexController::class)
    ->where('vue_capture', '[\/\w\.-]*');

