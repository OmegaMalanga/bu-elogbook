<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/log-entries/create', [App\Http\Controllers\LogEntryController::class, 'create'])->name('log-entries.create');
    Route::post('/log-entries', [App\Http\Controllers\LogEntryController::class, 'store'])->name('log-entries.store');
    Route::get('/log-entries/{logEntry}/edit', [App\Http\Controllers\LogEntryController::class, 'edit'])->name('log-entries.edit');
    Route::patch('/log-entries/{logEntry}', [App\Http\Controllers\LogEntryController::class, 'update'])->name('log-entries.update');
    Route::get('/reports', [App\Http\Controllers\LogEntryController::class, 'myReports'])->name('log-entries.my-reports');
    Route::get('/reports/export-pdf', [App\Http\Controllers\LogEntryController::class, 'exportPdf'])->name('log-entries.export-pdf');
    Route::post('/weekly-diagrams', [App\Http\Controllers\WeeklyDiagramController::class, 'store'])->name('weekly-diagrams.store');
    Route::get('/reviews', [App\Http\Controllers\ReviewController::class, 'index'])->name('reviews.index');
    Route::get('/reviews/{logEntry}', [App\Http\Controllers\ReviewController::class, 'show'])->name('reviews.show');
    Route::post('/reviews/{logEntry}', [App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/evaluations/{internship}', [App\Http\Controllers\EvaluationController::class, 'edit'])->name('evaluations.edit');
    Route::post('/evaluations/{internship}', [App\Http\Controllers\EvaluationController::class, 'update'])->name('evaluations.update');
    Route::get('/evaluations/{internship}/grade', [App\Http\Controllers\EvaluationController::class, 'editGrade'])->name('evaluations.grade');
    Route::post('/evaluations/{internship}/grade', [App\Http\Controllers\EvaluationController::class, 'updateGrade'])->name('evaluations.update-grade');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('admin.users.updateRole');
    Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/internships', [App\Http\Controllers\Admin\InternshipController::class, 'index'])->name('admin.internships.index');
    Route::patch('/internships/{internship}', [App\Http\Controllers\Admin\InternshipController::class, 'update'])->name('admin.internships.update');    
});
