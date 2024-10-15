<?php

use App\Http\Controllers\PeopleController;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);
// People API routes
Route::middleware(['auth:sanctum', 'cors'])->prefix('api')->group(function () {
    Route::get('/people', [PeopleController::class, 'index'])->name('api.people.index');
    Route::post('/people', [PeopleController::class, 'store'])->name('api.people.store');
    Route::get('/people/{id}', [PeopleController::class, 'show'])->name('api.people.show');
    Route::put('/people/{id}', [PeopleController::class, 'update'])->name('api.people.update');
    Route::delete('/people/{id}', [PeopleController::class, 'destroy'])->name('api.people.destroy');
});