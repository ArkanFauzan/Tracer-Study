<?php

use App\Http\Controllers\FormController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TracerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});

Route::get('/form/tracer-study/{id}', [FormController::class, 'tracerStudy'])->name('form.tracerStudy');
Route::post('/form/tracer-study', [FormController::class, 'tracerStudyStore'])->name('form.tracerStudyStore');
Route::get('/form/user-satisfaction/{id}', [FormController::class, 'userSatisfaction'])->name('form.userSatisfaction');
Route::post('/form/user-satisfaction', [FormController::class, 'userSatisfactionStore'])->name('form.userSatisfactionStore');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('dashboard')->group(function () {

        Route::get('/', function () {
            return view('dashboard.index', ['title' => 'Dashboard']);
        })->name('dashboard');

        Route::get('tracer-study', [FormController::class, 'tracerStudyResult'])->name('tracerStudy.index');
        Route::get('tracer-study/export', [FormController::class, 'tracerStudyResultExport'])->name('tracerStudy.export');
        Route::get('user-satisfaction', [FormController::class, 'userSatisfactionResult'])->name('userSatisfaction.index');
        Route::get('user-satisfaction/export-excel', [FormController::class, 'userSatisfactionResultExportExcel'])->name('userSatisfaction.exportExcel');
        Route::get('user-satisfaction/export-pdf', [FormController::class, 'userSatisfactionResultExportPdf'])->name('userSatisfaction.exportPdf');
        
        Route::get('tracers/datatable', [TracerController::class, 'datatable'])->name('tracers.datatable');
        Route::resource('tracers', TracerController::class);

    });
});

require __DIR__.'/auth.php';
