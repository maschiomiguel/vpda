<?php

use Illuminate\Support\Facades\Route;

use Modules\Videos\Http\Controllers;

Route::middleware(['languages', 'web'])->group(function () {
    Route::get('/videos/{category?}', [Controllers\VideosController::class, 'index'])->name('videos');
    Route::get('/galeria/{slug}', [Controllers\VideosController::class, 'details'])->name('videos.details');

    Route::get('/en/videos/{category?}', [Controllers\VideosController::class, 'index'])->name('en.videos');
    Route::get('/en/video/{slug}', [Controllers\VideosController::class, 'details'])->name('en.videos.details');

    Route::get('/es/videos/{category?}', [Controllers\VideosController::class, 'index'])->name('es.videos');
    Route::get('/es/galeria/{slug}', [Controllers\VideosController::class, 'details'])->name('es.videos.details');
});
