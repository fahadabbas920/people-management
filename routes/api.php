<?php

use App\Http\Controllers\PeopleController;
use App\Http\Middleware\CorsMiddleware; // Import your CORS middleware
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ApiAuthenticatedSessionController;



// API routes for authentication
Route::middleware('guest')->prefix('api')->group(function () {
    Route::post('login', [ApiAuthenticatedSessionController::class, 'apiLogin']);
   
});

 Route::middleware('auth:sanctum')->prefix('api')->group(function () {
    Route::post('logout', [ApiAuthenticatedSessionController::class, 'apiLogout']);
    });
    
// Apply CORS middleware globally or within this group
Route::middleware(['auth:sanctum'])->prefix('api')->group(function () {
    Route::get('/people', [PeopleController::class, 'index'])->name('api.people.index');
    Route::post('/people', [PeopleController::class, 'store'])->name('api.people.store');
    Route::get('/people/{id}', [PeopleController::class, 'show'])->name('api.people.show');
    Route::put('/people/{id}', [PeopleController::class, 'update'])->name('api.people.update');
    Route::delete('/people/{id}', [PeopleController::class, 'destroy'])->name('api.people.destroy');
});