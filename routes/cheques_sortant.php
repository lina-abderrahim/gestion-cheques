<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChequeSortantController;

Route::middleware(['auth'])->group(function () {
    Route::get('/cheques-sortants', [ChequeSortantController::class, 'index'])->name('cheques.sortants.index');
    Route::get('/cheques-sortants/create', [ChequeSortantController::class, 'create'])->name('cheques.sortants.create');
    Route::post('/cheques-sortants', [ChequeSortantController::class, 'store'])->name('cheques.sortants.store');
    Route::get('/cheques-sortants/{cheque}/edit', [ChequeSortantController::class, 'edit'])->name('cheques.sortants.edit');
    Route::put('/cheques-sortants/{cheque}', [ChequeSortantController::class, 'update'])->name('cheques.sortants.update');
    Route::delete('/cheques-sortants/{cheque}', [ChequeSortantController::class, 'destroy'])->name('cheques.sortants.destroy');
    Route::get('/cheques/{cheque}/impression-directe', [ChequeSortantController::class, 'printView'])
    ->name('cheques.impression_directe');

});
