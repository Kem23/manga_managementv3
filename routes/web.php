<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MangaController;
use App\Http\Controllers\CustomerController; // Added this controller
use Illuminate\Support\Facades\Route;

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
    
    // Manga routes
    // routes/web.php
    Route::resource('manga', \App\Http\Controllers\MangaController::class)
     ->parameters(['manga' => 'manga:slug']);

    Route::get('/profile/show', [ProfileController::class, 'edit'])->name('profile.show');
    
    // Customer routes
    Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('/customer/create', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('/customer', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('/customer/{customer}/edit', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::put('/customer/{customer}', [CustomerController::class, 'update'])->name('customer.update');
    Route::delete('/customer/{customer}', [CustomerController::class, 'destroy'])->name('customer.destroy');

});

// Removed duplicate dashboard route

require __DIR__.'/auth.php';