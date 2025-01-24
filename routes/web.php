<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\Panel\LinkController;
use App\Http\Controllers\Panel\ProfileController;
use App\Http\Controllers\RedirectLinkController;
use App\Http\Middleware\LinkRateLimitMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', IndexController::class);

Route::middleware('auth')->group(function () {
    Route::get('links', [LinkController::class, 'index'])->name('links.index');
    Route::get('links/create', [LinkController::class, 'create'])->name('links.create');
    Route::post('links', [LinkController::class, 'store'])->name('links.store');
    Route::get('links/{id}', [LinkController::class, 'show'])->name('links.show');
    Route::get('links/{id}/edit', [LinkController::class, 'edit'])->name('links.edit');
    Route::patch('links/{id}', [LinkController::class, 'update'])->name('links.update');
    Route::delete('links/{id}', [LinkController::class, 'destroy'])->name('links.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/{code}', RedirectLinkController::class)->name('links.redirect')->middleware(LinkRateLimitMiddleware::class);
