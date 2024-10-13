<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PeopleController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// People API routes
Route::prefix('api')->group(function () {
    Route::get('/people', [PeopleController::class, 'index'])->name('api.people.index');
    Route::post('/people', [PeopleController::class, 'store'])->name('api.people.store');
    Route::get('/people/{id}', [PeopleController::class, 'show'])->name('api.people.show');
    Route::put('/people/{id}', [PeopleController::class, 'update'])->name('api.people.update');
    Route::delete('/people/{id}', [PeopleController::class, 'destroy'])->name('api.people.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

