<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FloorController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('pages.login');
    })->name('login');

    Route::get('/register', function () {
        return view('pages.register');
    });
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'authenticate']);
});

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::resource('users', UserController::class)->except('show');
    Route::resource('floors', FloorController::class)->only(['index', 'store', 'destroy']);
    Route::resource('reports', ReportController::class)->withoutMiddleware('is_admin');
    Route::get('my-reports', [ReportController::class, 'myReports'])->withoutMiddleware('is_admin')->name('reports.my-reports');
    Route::post('/logout', [AuthController::class, 'logout'])->withoutMiddleware('is_admin');
    Route::get('/', function () {
        return view('pages.dashboard.index');
    });
});
