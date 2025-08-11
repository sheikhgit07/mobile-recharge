<?php

use Illuminate\Support\Facades\Route;
use App\Models\Page;

Route::get('/pages/{slug}', function (string $slug) {
    $page = Page::query()->where('slug', $slug)->with('sections')->firstOrFail();
    return response()->json($page);
});