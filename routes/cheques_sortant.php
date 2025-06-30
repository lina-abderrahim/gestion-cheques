<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChequeSortantController;

Route::middleware(['auth'])->group(function () {
    Route::get('/cheques-sortants', [ChequeSortantController::class, 'index'])->name('cheques.sortants.index');
    Route::get('/cheques-sortants/create', [ChequeSortantController::class, 'create'])->name('cheques.sortants.create');
    Route::post('/cheques-sortants', [ChequeSortantController::class, 'store'])->name('cheques.sortants.store');
});
