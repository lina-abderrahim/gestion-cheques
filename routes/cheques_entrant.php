<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChequeEntrantController;

Route::middleware(['auth'])->group(function () {
    Route::get('/cheques-entrants', [ChequeEntrantController::class, 'index'])->name('cheques.entrants.index');
    Route::get('/cheques-entrants/create', [ChequeEntrantController::class, 'create'])->name('cheques.entrants.create');
    Route::post('/cheques-entrants', [ChequeEntrantController::class, 'store'])->name('cheques.entrants.store');

    Route::get('/cheques-entrants/{cheque}/edit', [ChequeEntrantController::class, 'edit'])->name('cheques.entrants.edit');
    Route::put('/cheques-entrants/{cheque}', [ChequeEntrantController::class, 'update'])->name('cheques.entrants.update');
    Route::delete('/cheques-entrants/{cheque}', [ChequeEntrantController::class, 'destroy'])->name('cheques.entrants.destroy');
});
