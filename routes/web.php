<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\BlokController;
use App\Http\Controllers\SubBlokController;
use App\Http\Controllers\AssemblyCodeController;
use App\Http\Controllers\ItpDataController;

// Redirect root to login
Route::get('/', function () {
    return redirect('/login');
});

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [UserManagementController::class, 'index'])->name('admin.users.index');
    Route::get('/users/create', [UserManagementController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [UserManagementController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{id}/edit', [UserManagementController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{id}', [UserManagementController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{id}', [UserManagementController::class, 'destroy'])->name('admin.users.destroy');
    Route::post('/project/start', [ProjectController::class, 'start'])->name('admin.project.start');
});

// Non-admin routes
Route::middleware(['auth', 'nonadmin'])->group(function () {
    Route::get('/dashboard', [ModulController::class, 'index'])->name('dashboard');
    Route::get('/modul/{id}/blok', [BlokController::class, 'index'])->name('blok.index');
    Route::get('/blok/{id}/subblok', [SubBlokController::class, 'index'])->name('subblok.index');
    Route::get('/subblok/{id}/assembly', [AssemblyCodeController::class, 'index'])->name('assembly.index');
    Route::get('/itp-data/{id}', [ItpDataController::class, 'show'])->name('itp.show');
    Route::post('/itp-data/{id}', [ItpDataController::class, 'update'])->name('itp.update');
});
