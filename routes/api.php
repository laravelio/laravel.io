<?php

// Articles
use App\Http\Controllers\Articles\ArticlesController;

Route::prefix('articles')->group(function () {
    Route::post('/', [ArticlesController::class, 'store'])->name('api.articles.store');
});
