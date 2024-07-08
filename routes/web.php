<?php

use App\Http\Controllers\FormController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TracerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});

Route::get('/form/tracer-study/{id}', [FormController::class, 'tracerStudy'])->name('form.tracerStudy');
Route::get('/form/user-satisfaction/{id}', [FormController::class, 'tracerStudy'])->name('form.tracerStudy');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('dashboard')->group(function () {

        Route::get('/', function () {
            return view('dashboard.index', ['title' => 'Dashboard']);
        })->middleware(['auth', 'verified'])->name('dashboard');
        
        Route::get('tracers/datatable', [TracerController::class, 'datatable'])->name('tracers.datatable');
        Route::resource('tracers', TracerController::class);

    });
});

require __DIR__.'/auth.php';
