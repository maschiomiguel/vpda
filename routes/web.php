<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['languages'])->group(function () {
    Route::get('/', [Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/politica-de-privacidade', [Controllers\PrivacyController::class, 'index'])->name('privacy');

    Route::get('/en', [Controllers\HomeController::class, 'index'])->name('en.home');
    Route::get('/en/privacy-policy', [Controllers\PrivacyController::class, 'index'])->name('en.privacy');

    Route::get('/es', [Controllers\HomeController::class, 'index'])->name('es.home');
    Route::get('/es/politica-de-privacidad', [Controllers\PrivacyController::class, 'index'])->name('es.privacy');
});

// Rotas do painel que ficam sem o middleware de autorização
Route::match(['get', 'post'], '/panel/password/send-recovery', [Controllers\Restrita\PasswordRecoveryController::class, 'sendRecovery'])
    ->name('platform.password.send-recovery');

Route::match(['get', 'post'], '/panel/password/recover-password/{id}', [Controllers\Restrita\PasswordRecoveryController::class, 'recoverPassword'])
    ->name('platform.password.recover-password');

Route::get('/storage', function () {
    Artisan::call("storage:link");
});
