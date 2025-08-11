<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\MessageController;

Route::get('/', [PageController::class, 'home'])->name('home');

Route::post('/contact', [MessageController::class, 'store'])->name('contact.store');

Route::get('/{slug}', [PageController::class, 'show'])
    ->where('slug', '^[A-Za-z0-9\-\/]+$')
    ->name('page.show');