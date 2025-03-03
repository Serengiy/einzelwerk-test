<?php

use App\Http\Controllers\ContragentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [ContragentController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/contragents', [ContragentController::class, 'store'])
    ->middleware(['auth'])->name('contragents.store');

require __DIR__.'/auth.php';
