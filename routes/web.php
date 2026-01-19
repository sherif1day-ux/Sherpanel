<?php

use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\FileManagerController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\TerminalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Sites
    Route::resource('sites', SiteController::class);

    // Files
    Route::get('/files', [FileManagerController::class, 'index'])->name('files.index');
    Route::post('/files/upload', [FileManagerController::class, 'upload'])->name('files.upload');

    // Databases
    Route::resource('databases', DatabaseController::class);

    // Terminal
    Route::get('/terminal', [TerminalController::class, 'index'])->name('terminal.index');
    Route::post('/terminal/execute', [TerminalController::class, 'execute'])->name('terminal.execute');

    // System Stats API (internal)
    Route::get('/api/stats', [DashboardController::class, 'stats']);

    // User Management (Admin only)
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});
