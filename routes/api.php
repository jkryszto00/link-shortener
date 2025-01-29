<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('', function (Request $request) {
    return [
        'app' => app()->Loca
    ];
});

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

