<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChequeEntrantController;

Route::middleware(['auth'])->group(function () {
    Route::get('/cheques-entrants', [ChequeEntrantController::class, 'index'])->name('cheques.entrants.index');
    Route::get('/cheques-entrants/create', [ChequeEntrantController::class, 'create'])->name('cheques.entrants.create');
    Route::post('/cheques-entrants', [ChequeEntrantController::class, 'store'])->name('cheques.entrants.store');
});
