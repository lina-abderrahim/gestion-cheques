<?php

use App\Http\Controllers\{
    ChequeEntrantController,
    ChequeSortantController,
    DashboardController,
    ProfileController,
    TraiteController,
    LogController
};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Routes d'authentification
require __DIR__.'/auth.php';

// Routes protégées par authentification
Route::middleware(['auth', 'verified'])->group(function () {
    // Route dashboard unique
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Routes de profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes pour les chèques entrants
    Route::prefix('cheques/entrants')->group(function () {
        Route::get('/recherche', [ChequeEntrantController::class, 'search'])->name('cheques.entrants.search');
        Route::resource('/', ChequeEntrantController::class)
            ->names('cheques.entrants')
            ->parameters(['' => 'cheque']);
    });

    // Routes pour les chèques sortants
    Route::prefix('cheques/sortants')->group(function () {
        Route::get('/recherche', [ChequeSortantController::class, 'search'])->name('cheques.sortants.search');
        Route::resource('/', ChequeSortantController::class)
            ->names('cheques.sortants')
            ->parameters(['' => 'cheque']);
    });

    // Routes pour les traites
    Route::prefix('cheques')->group(function () {
        Route::get('/{cheque}/traite', [TraiteController::class, 'imprimer'])
            ->name('cheques.traite');
        Route::get('/{cheque}/impression-directe', [TraiteController::class, 'printView'])
            ->name('cheques.impression_directe');
    });

    // Routes d'administration
    Route::middleware('is_admin')->group(function () {
        Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
    });
});