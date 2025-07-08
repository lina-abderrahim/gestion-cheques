<?php

use App\Http\Controllers\ChequeEntrantController;
use App\Http\Controllers\ChequeSortantController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TraiteController;
use App\Http\Controllers\LogController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});
Route::middleware('auth')->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
use App\Http\Controllers\DashboardController;

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

});
// Pour les chèques entrants
Route::get('/cheques/entrants/recherche', [App\Http\Controllers\ChequeEntrantController::class, 'search'])->name('cheques.entrants.search');

// Pour les chèques sortants
Route::get('/cheques/sortants/recherche', [App\Http\Controllers\ChequeSortantController::class, 'search'])->name('cheques.sortants.search');

// Pour les entrants
Route::resource('cheques/entrants', ChequeEntrantController::class)->names('cheques.entrants');

// Pour les sortants
Route::resource('cheques/sortants', ChequeSortantController::class)->names('cheques.sortants');

Route::get('/cheques/{cheque}/traite', [TraiteController::class, 'imprimer'])
    ->name('cheques.traite')
    ->middleware(['auth']);

Route::get('/cheques/{cheque}/impression-directe', [TraiteController::class, 'printView'])
    ->name('cheques.impression_directe');

  

    Route::get('/logs', [LogController::class, 'index'])
        ->name('logs.index')
        ->middleware(['auth', 'is_admin']);


    
require __DIR__.'/auth.php';

