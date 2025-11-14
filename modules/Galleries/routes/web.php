<?php

use Illuminate\Support\Facades\Route;

use Modules\Galleries\Http\Controllers;

Route::middleware(['languages', 'web'])->group(function () {
    Route::get('/posts/{category?}', [Controllers\GalleriesController::class, 'index'])->name('galleries');
    Route::get('/galeria/{slug}', [Controllers\GalleriesController::class, 'details'])->name('galleries.details');

    Route::get('/en/galleries/{category?}', [Controllers\GalleriesController::class, 'index'])->name('en.galleries');
    Route::get('/en/gallery/{slug}', [Controllers\GalleriesController::class, 'details'])->name('en.galleries.details');

    Route::get('/es/posts/{category?}', [Controllers\GalleriesController::class, 'index'])->name('es.galleries');
    Route::get('/es/galeria/{slug}', [Controllers\GalleriesController::class, 'details'])->name('es.galleries.details');
});
