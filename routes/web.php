<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoaningFormController;
use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('locations', LocationController::class);
    Route::post('locations/{location}/toggle-ac', [LocationController::class, 'toggleAc'])->name('locations.toggle-ac');
    Route::post('locations/{location}/toggle-dehumidifier', [LocationController::class, 'toggleDehumidifier'])->name('locations.toggle-dehumidifier');
    
    Route::resource('items', ItemController::class);
    Route::get('items-import', [ItemController::class, 'import'])->name('items.import');
    Route::post('items-import', [ItemController::class, 'processImport'])->name('items.import.process');
    Route::post('items/qrcodes', [ItemController::class, 'qrCodes'])->name('items.qrcodes');
    
    Route::resource('loaning-forms', LoaningFormController::class);
    Route::post('loaning-forms/{loaningForm}/approve', [LoaningFormController::class, 'approve'])->name('loaning-forms.approve');
    Route::post('loaning-forms/{loaningForm}/reject', [LoaningFormController::class, 'reject'])->name('loaning-forms.reject');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
